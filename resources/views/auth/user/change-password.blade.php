@extends('layouts.base-public')

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    @include('layouts.partials.alert')

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-1">Ubah Password</h4>
                            <p class="text-muted mb-4">Gunakan password yang kuat dan belum pernah digunakan sebelumnya.</p>

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password saat ini</label>
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password" autocomplete="current-password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password baru</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi password baru</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" autocomplete="new-password">
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('public.account.profile.index') }}"
                                        class="btn btn-outline-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
