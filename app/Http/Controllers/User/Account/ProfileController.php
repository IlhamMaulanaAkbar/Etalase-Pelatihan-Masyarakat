<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingUser;
use App\Models\User;
use App\Models\PreTestUsersAnswers;
use App\Models\PreTestQuestions;
use App\Models\PostTestQuestions;
use App\Models\PostTestUsersAnswers;
use App\Models\TrainingEvaluationQuestions;
use App\Models\TrainingEvaluationUsersAnswers;
use App\Models\InstructorEvaluationQuestions;
use App\Models\InstructorEvaluationUsersAnswers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $trainingUser = $user->training_users()
            ->with(['training', 'training.category'])->orderBy('created_at', 'desc')
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
                $answeredCount = PreTestUsersAnswers::where('users_id', $user->id)
                    ->whereIn('pre_test_questions_id', $preTestQuestions->pluck('id'))
                    ->whereNotNull('answer')
                    ->count();


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

                $item->show_certificate = $item->status === 'LULUS' && optional($item->training->end_date)->isPast();

                return $item;
            });

        $assistanceUser = $user->assistance_users()
            ->with(['assistance', 'assistance.training'])->orderBy('created_at', 'desc')
            ->get();

        $trainingStats = [
            'total' => $trainingUser->count(),
            'lulus' => $trainingUser->where('status', 'LULUS')
                ->filter(fn($t) => optional($t->training->end_date)->isPast())
                ->count(),
            'tidak_lulus' => $trainingUser->where('status', 'BATAL')->count(),
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
            'assistanceUser' => $assistanceUser,
            'trainingStats' => $trainingStats,
            'assistanceStats' => $assistanceStats,
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

        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:128',
            'city' => 'nullable|string|max:128',
            'district' => 'nullable|string|max:128',
            'village' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:128',
            'education' => 'nullable|string|max:128',
            'education_institutions' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:128',
            'photo' => 'nullable|image|max:2048',
            'cropped_avatar' => 'nullable|string',
        ]);

        unset($validated['photo'], $validated['cropped_avatar']);

        if ($request->filled('cropped_avatar')) {
            $validated['photo'] = $this->storeCroppedAvatar($request->cropped_avatar, $user);
        }

        // Update user
        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
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
}
