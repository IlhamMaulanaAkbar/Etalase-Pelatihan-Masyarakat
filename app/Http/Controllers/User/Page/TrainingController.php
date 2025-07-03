<?php

namespace App\Http\Controllers\User\Page;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\TrainingUser;
use App\Services\Supports\Alert;
use Illuminate\Support\Facades\Auth;


class TrainingController extends Controller
{
    public function index(Request $request)
    {

        $query = Training::with('category');

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('start_date', $request->date); // ganti 'start_date' sesuai kolom di DB-mu
        }

        // Filter berdasarkan kata kunci
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('training_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('location', 'like', '%' . $request->keyword . '%');
            });
        }

        // Ambil data terfilter dan paginate
        $trainings = $query->paginate(9)->withQueryString(); // withQueryString agar paginasi tetap membawa parameter filter

        // Ambil data kategori untuk dropdown
        $categorys = Category::select('id', 'name')->get();


        return view(
            'public.training.index',
            [
                'trainings' => $trainings,
                'categorys' => $categorys,
            ]
        );
    }

    public function show(Training $training)
    {
        $training->load('category'); // load relasi langsung

        $sessionKey = 'viewed_training_' . $training->id;

        if (!session()->has($sessionKey)) {
            $training->increment('views');
            session()->put($sessionKey, true);
        }

        return view('public.training.show', [
            'training' => $training,
        ]);
    }

    public function register(Training $training)
    {
        $user = Auth::user();

        // Cek apakah user sudah mendaftar
        if (TrainingUser::where('user_id', $user->id)->where('training_id', $training->id)->exists()) {
            return back()->with(Alert::error('Anda sudah mendaftar pelatihan ini.'));
        }

        $requiredFields = [
            'date_of_birth',
            'place_of_birth',
            'phone',
            'gender',
            'province',
            'city',
            'district',
            'village',
            'job',
            'education',
            'education_institutions',
            'religion',
            'photo'
        ];

        foreach ($requiredFields as $field) {
            if (empty($user->{$field})) {
                return response()->json([
                    'incomplete_profile' => true,
                    'redirect' => route('public.account.profile.index', ['tab' => 'data-diri-edit']),
                ]);
            }
        }

        $training_id_padded = str_pad($training->id, 8, '1', STR_PAD_LEFT); // 8 digit
        $user_id_padded = str_pad($user->id, 4, '0', STR_PAD_LEFT);         // 4 digit

        $no_reg = 'UID-' . $training_id_padded . '-' . $user_id_padded;


        // Simpan ke pivot table
        TrainingUser::create([
            'user_id' => $user->id,
            'training_id' => $training->id,
            'no_registrasi' => $no_reg,
            'status' => 'DAFTAR',
            'is_approved' => false,
        ]);

        return back()->with('success', 'Berhasil mendaftar pelatihan.');
    }
}
