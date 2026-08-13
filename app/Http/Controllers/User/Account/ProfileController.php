<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingUser;
use App\Models\User;
use App\Models\PreTestAnswers;
use App\Models\PreTestUsersAnswers;
use App\Models\PreTestQuestions;
use App\Models\PostTestAnswers;
use App\Models\PostTestQuestions;
use App\Models\PostTestUsersAnswers;
use App\Models\TrainingEvaluationQuestions;
use App\Models\TrainingEvaluationUsersAnswers;
use App\Models\InstructorEvaluationQuestions;
use App\Models\InstructorEvaluationUsersAnswers;
use Creasi\Nusa\Models\District;
use Creasi\Nusa\Models\Province;
use Creasi\Nusa\Models\Regency;
use Creasi\Nusa\Models\Village;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->loadMissing(['nusaProvince', 'nusaRegency', 'nusaDistrict', 'nusaVillage']);
        $trainingSort = $request->query('training_sort', 'latest') === 'oldest' ? 'oldest' : 'latest';
        $assistanceSort = $request->query('assistance_sort', 'latest') === 'oldest' ? 'oldest' : 'latest';
        $assessmentSort = $request->query('assessment_sort', 'latest') === 'oldest' ? 'oldest' : 'latest';
        $evaluationSort = $request->query('evaluation_sort', 'latest') === 'oldest' ? 'oldest' : 'latest';
        $profilePerPage = 3;

        $trainingUser = $user->training_users()
            ->with(['training', 'training.category'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) use ($user) {
                // Cek apakah sudah mengerjakan pre-test


                $trainingUserRow = $user->training_users()->where('training_id', $item->training_id)->first();
                // Ambil pertanyaan evaluasi pelatihan
                $evaluationQuestions = TrainingEvaluationQuestions::where('training_id', $item->training_id)->get();
                $item->evaluation_questions = $evaluationQuestions->count();

                // Tampilkan tombol evaluasi jika sudah LULUS dan pelatihan selesai
                $item->show_evaluation = $item->status === 'LULUS' && optional($item->training->end_date)->isPast();

                // Cek apakah user sudah mengisi evaluasi
                $evaluationAnswered = TrainingEvaluationUsersAnswers::where('users_id', $user->id)
                    ->whereIn('teq_id', $evaluationQuestions->pluck('id'))
                    ->orderBy('created_at', 'desc')
                    ->value('created_at');

                $item->has_filled_evaluation = $evaluationAnswered;
                $item->evaluation_finished_at = $evaluationAnswered
                    ? $evaluationAnswered->toIso8601String()
                    : ($trainingUserRow && $trainingUserRow->started_training_evaluation ? optional($trainingUserRow->updated_at)->toIso8601String() : null);

                // Ambil pertanyaan evaluasi instruktur
                $instructorEvaluationQuestions = InstructorEvaluationQuestions::where('training_id', $item->training_id)->get();
                $item->instructor_evaluation_questions = $instructorEvaluationQuestions->count();

                // Tampilkan tombol evaluasi instruktur jika sudah LULUS dan pelatihan selesai
                $item->show_instructor_evaluation = $item->status === 'LULUS' && optional($item->training->end_date)->isPast();

                // Cek apakah user sudah mengisi evaluasi instruktur
                $instructorEvaluationAnswered = InstructorEvaluationUsersAnswers::where('users_id', $user->id)
                    ->whereIn('ieq_id', $instructorEvaluationQuestions->pluck('id'))
                    ->orderBy('created_at', 'desc')
                    ->value('created_at');

                $item->has_filled_instructor_evaluation = $instructorEvaluationAnswered;
                $item->instructor_evaluation_finished_at = $instructorEvaluationAnswered
                    ? $instructorEvaluationAnswered->toIso8601String()
                    : ($trainingUserRow && $trainingUserRow->started_instructor_evaluation ? optional($trainingUserRow->updated_at)->toIso8601String() : null);


                $preTestQuestions = PreTestQuestions::where('training_id', $item->training_id)->get();
                $item->has_pretest_answered = $trainingUserRow && $trainingUserRow->started_pretest;

                $latestAnsweredAt = PreTestUsersAnswers::where('users_id', $user->id)
                    ->whereIn('pre_test_questions_id', $preTestQuestions->pluck('id'))
                    ->orderBy('created_at', 'desc')
                    ->value('created_at');

                $item->finished_at = $latestAnsweredAt
                    ? $latestAnsweredAt->toIso8601String()
                    : ($trainingUserRow && $trainingUserRow->started_pretest ? optional($trainingUserRow->updated_at)->toIso8601String() : null);


                $item->questions = $preTestQuestions->count();
                $item->duration = 15;
                $item->pretest_score = $this->calculatePreTestScore($user->id, $preTestQuestions->pluck('id'));

                $postTestQuestions = PostTestQuestions::where('training_id', $item->training_id)->get();

                $item->show_posttest = $item->status === 'LULUS' &&
                    $item->has_pretest_answered &&
                    optional($item->training->end_date)->isPast();


                $item->has_posttest_answered = $trainingUserRow && $trainingUserRow->started_posttest;

                $latestPostAnsweredAt = PostTestUsersAnswers::where('users_id', $user->id)
                    ->whereIn('post_test_questions_id', $postTestQuestions->pluck('id'))
                    ->orderBy('created_at', 'desc')
                    ->value('created_at');

                $item->posttest_finished_at = $latestPostAnsweredAt
                    ? $latestPostAnsweredAt->toIso8601String()
                    : ($item->has_posttest_answered ? optional($trainingUserRow->updated_at)->toIso8601String() : null);

                $item->posttest_questions = $postTestQuestions->count();
                $item->posttest_duration = 15;
                $item->posttest_score = $this->calculatePostTestScore($user->id, $postTestQuestions->pluck('id'));
                $item->assessment_total_score = $item->pretest_score !== null && $item->posttest_score !== null
                    ? $item->pretest_score + $item->posttest_score
                    : null;
                $item->final_assessment_score = $item->assessment_total_score !== null
                    ? round($item->assessment_total_score / 2)
                    : null;

                $item->show_certificate = $item->status === 'LULUS' && optional($item->training->end_date)->isPast();

                return $item;
            });

        $sortedTrainingUser = $this->sortCollectionByCreatedAt($trainingUser, $trainingSort);
        $trainingHistory = $this->paginateCollection($sortedTrainingUser, $request, 'training_page', $profilePerPage);
        $assessmentHistory = $this->paginateCollection(
            $this->sortCollectionByCreatedAt($trainingUser, $assessmentSort),
            $request,
            'assessment_page',
            $profilePerPage
        );
        $evaluationTraining = $this->paginateCollection(
            $this->sortCollectionByCreatedAt($trainingUser->filter(fn ($item) => $item->show_evaluation), $evaluationSort),
            $request,
            'evaluation_training_page',
            $profilePerPage
        );
        $evaluationInstructor = $this->paginateCollection(
            $this->sortCollectionByCreatedAt($trainingUser->filter(fn ($item) => $item->show_instructor_evaluation), $evaluationSort),
            $request,
            'evaluation_instructor_page',
            $profilePerPage
        );

        $assistanceUser = $user->assistance_users()
            ->with(['assistance', 'assistance.training'])->orderBy('created_at', 'desc')
            ->get();
        $assistanceHistory = $this->paginateCollection(
            $this->sortCollectionByCreatedAt($assistanceUser, $assistanceSort),
            $request,
            'assistance_page',
            $profilePerPage
        );

        $trainingStats = [
            'total' => $trainingUser->count(),
            'lulus' => $trainingUser->where('status', 'LULUS')
                ->filter(fn($t) => optional($t->training->end_date)->isPast())
                ->count(),
            'tidak_lulus' => $trainingUser->whereIn('status', ['TIDAK_LULUS', 'tidak_lulus', 'BATAL'])->count(),
        ];

        $assistanceStats = [
            'total' => $assistanceUser->count(),
            'lulus' => $assistanceUser->where('status', 'LULUS')
                ->filter(fn($a) => optional($a->assistance->training->end_date)->isPast())
                ->count(),
            'tidak_lulus' => $assistanceUser->where('status', 'BATAL')->count(),
        ];

        return view('public.account.profile.index', [
            'user' => $user,
            'trainingUser' => $trainingUser,
            'trainingHistory' => $trainingHistory,
            'trainingSort' => $trainingSort,
            'assistanceUser' => $assistanceUser,
            'assistanceHistory' => $assistanceHistory,
            'assistanceSort' => $assistanceSort,
            'assessmentHistory' => $assessmentHistory,
            'assessmentSort' => $assessmentSort,
            'evaluationTraining' => $evaluationTraining,
            'evaluationInstructor' => $evaluationInstructor,
            'evaluationSort' => $evaluationSort,
            'trainingStats' => $trainingStats,
            'assistanceStats' => $assistanceStats,
            'provinceOptions' => Province::orderBy('name')->get(['code', 'name']),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Kunci agar field hanya bisa diisi sekali
        $request->merge([
            'name' => $user->name ?? $request->name,
            'email' => $user->email ?? $request->email,
            'phone' => $user->phone ?? $request->phone,
            'gender' => $user->gender ?? $request->gender,
            'date_of_birth' => $user->date_of_birth ?? $request->date_of_birth,
            'place_of_birth' => $user->place_of_birth ?? $request->place_of_birth,
        ]);

        $this->mergeNusaParentCodes($request);

        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'province_code' => [
                'nullable',
                'required_with:regency_code,district_code,village_code',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value && ! Province::whereKey($value)->exists()) {
                        $fail('Provinsi yang dipilih tidak valid.');
                    }
                },
            ],
            'regency_code' => [
                'nullable',
                'required_with:district_code,village_code',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (! $value) {
                        return;
                    }

                    $regency = Regency::find($value);
                    if (! $regency || $regency->province_code !== $request->input('province_code')) {
                        $fail('Kota/Kabupaten yang dipilih tidak valid.');
                    }
                },
            ],
            'district_code' => [
                'nullable',
                'required_with:village_code',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (! $value) {
                        return;
                    }

                    $district = District::find($value);
                    if (! $district || $district->regency_code !== $request->input('regency_code')) {
                        $fail('Kecamatan yang dipilih tidak valid.');
                    }
                },
            ],
            'village_code' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (! $value) {
                        return;
                    }

                    $village = Village::find($value);
                    if (! $village || $village->district_code !== $request->input('district_code')) {
                        $fail('Desa/Kelurahan yang dipilih tidak valid.');
                    }
                },
            ],
            'job' => 'nullable|string|max:128',
            'education' => 'nullable|string|max:128',
            'education_institutions' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:128',
            'photo' => 'nullable|image|max:2048',
            'cropped_avatar' => 'nullable|string',
        ]);

        unset($validated['photo'], $validated['cropped_avatar']);
        $validated = $this->normalizeNusaRegionCodes($validated);

        if ($request->filled('cropped_avatar')) {
            $validated['photo'] = $this->storeCroppedAvatar($request->cropped_avatar, $user);
        }

        // Update user
        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    private function mergeNusaParentCodes(Request $request): void
    {
        $codes = $this->normalizeNusaRegionCodes([
            'province_code' => $request->input('province_code'),
            'regency_code' => $request->input('regency_code'),
            'district_code' => $request->input('district_code'),
            'village_code' => $request->input('village_code'),
        ]);

        $request->merge($codes);
    }

    private function normalizeNusaRegionCodes(array $data): array
    {
        if (! empty($data['village_code'])) {
            $village = Village::find($data['village_code']);

            if ($village) {
                $data['district_code'] = $village->district_code;
                $data['regency_code'] = $village->regency_code;
                $data['province_code'] = $village->province_code;

                return $data;
            }
        }

        if (! empty($data['district_code'])) {
            $district = District::find($data['district_code']);

            if ($district) {
                $data['regency_code'] = $district->regency_code;
                $data['province_code'] = $district->province_code;

                return $data;
            }
        }

        if (! empty($data['regency_code'])) {
            $regency = Regency::find($data['regency_code']);

            if ($regency) {
                $data['province_code'] = $regency->province_code;
            }
        }

        return $data;
    }

    private function storeCroppedAvatar(string $croppedAvatar, User $user): string
    {
        if (!preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,/', $croppedAvatar, $matches)) {
            throw ValidationException::withMessages([
                'cropped_avatar' => 'Format foto profil tidak valid.',
            ]);
        }

        $imageData = substr($croppedAvatar, strpos($croppedAvatar, ',') + 1);
        $imageData = base64_decode($imageData, true);

        if ($imageData === false) {
            throw ValidationException::withMessages([
                'cropped_avatar' => 'Foto profil gagal diproses.',
            ]);
        }

        if (strlen($imageData) > 2 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'cropped_avatar' => 'Ukuran foto profil maksimal 2MB.',
            ]);
        }

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = 'profile-photos/' . $user->id . '-' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($path, $imageData);

        return $path;
    }

    private function sortCollectionByCreatedAt($items, string $sort)
    {
        return $sort === 'oldest'
            ? $items->sortBy('created_at')->values()
            : $items->sortByDesc('created_at')->values();
    }

    private function calculatePreTestScore(int $userId, $questionIds): ?int
    {
        if ($questionIds->isEmpty()) {
            return null;
        }

        $userAnswers = PreTestUsersAnswers::where('users_id', $userId)
            ->whereIn('pre_test_questions_id', $questionIds)
            ->whereNotNull('answer')
            ->get();

        if ($userAnswers->isEmpty()) {
            return null;
        }

        $correct = 0;
        foreach ($userAnswers as $answer) {
            $isCorrect = PreTestAnswers::where('pre_test_questions_id', $answer->pre_test_questions_id)
                ->where('answer', $answer->answer)
                ->where('is_correct', true)
                ->exists();

            if ($isCorrect) {
                $correct++;
            }
        }

        return round(($correct / $questionIds->count()) * 100);
    }

    private function calculatePostTestScore(int $userId, $questionIds): ?int
    {
        if ($questionIds->isEmpty()) {
            return null;
        }

        $userAnswers = PostTestUsersAnswers::where('users_id', $userId)
            ->whereIn('post_test_questions_id', $questionIds)
            ->whereNotNull('answer')
            ->get();

        if ($userAnswers->isEmpty()) {
            return null;
        }

        $correct = 0;
        foreach ($userAnswers as $answer) {
            $isCorrect = PostTestAnswers::where('post_test_questions_id', $answer->post_test_questions_id)
                ->where('answer', $answer->answer)
                ->where('is_correct', true)
                ->exists();

            if ($isCorrect) {
                $correct++;
            }
        }

        return round(($correct / $questionIds->count()) * 100);
    }

    private function paginateCollection($items, Request $request, string $pageName, int $perPage): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);
        $page = min($page, max(1, (int) ceil($items->count() / $perPage)));

        $paginator = new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'pageName' => $pageName,
            ]
        );

        return $paginator->appends($request->except($pageName));
    }
}
