<?php

use Creasi\Nusa\Models\District;
use Creasi\Nusa\Models\Province;
use Creasi\Nusa\Models\Regency;
use Creasi\Nusa\Models\Village;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! $this->hasLegacyAndNusaColumns()) {
            return;
        }

        DB::table('users')
            ->select(['id', 'province', 'city', 'district', 'village'])
            ->orderBy('id')
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $province = $this->findProvince($user->province);
                    $regency = $this->findRegency($user->city, $province?->code);
                    $district = $this->findDistrict($user->district, $regency?->code);
                    $village = $this->findVillage($user->village, $district?->code);

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'province_code' => $province?->code,
                            'regency_code' => $regency?->code,
                            'district_code' => $district?->code,
                            'village_code' => $village?->code,
                        ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! $this->hasLegacyAndNusaColumns()) {
            return;
        }

        DB::table('users')->update([
            'province_code' => null,
            'regency_code' => null,
            'district_code' => null,
            'village_code' => null,
        ]);
    }

    private function hasLegacyAndNusaColumns(): bool
    {
        return Schema::hasColumn('users', 'province')
            && Schema::hasColumn('users', 'city')
            && Schema::hasColumn('users', 'district')
            && Schema::hasColumn('users', 'village')
            && Schema::hasColumn('users', 'province_code')
            && Schema::hasColumn('users', 'regency_code')
            && Schema::hasColumn('users', 'district_code')
            && Schema::hasColumn('users', 'village_code');
    }

    private function findProvince(?string $value): ?Province
    {
        $value = $this->normalizeLegacyValue($value);

        if ($value === null) {
            return null;
        }

        return Province::find($value) ?? Province::where('name', $value)->first();
    }

    private function findRegency(?string $value, ?string $provinceCode): ?Regency
    {
        $value = $this->normalizeLegacyValue($value);

        if ($value === null) {
            return null;
        }

        $query = Regency::query();
        if ($provinceCode) {
            $query->where('province_code', $provinceCode);
        }

        return Regency::find($value) ?? $query->where('name', $value)->first();
    }

    private function findDistrict(?string $value, ?string $regencyCode): ?District
    {
        $value = $this->normalizeLegacyValue($value);

        if ($value === null) {
            return null;
        }

        $query = District::query();
        if ($regencyCode) {
            $query->where('regency_code', $regencyCode);
        }

        return District::find($value) ?? $query->where('name', $value)->first();
    }

    private function findVillage(?string $value, ?string $districtCode): ?Village
    {
        $value = $this->normalizeLegacyValue($value);

        if ($value === null) {
            return null;
        }

        $query = Village::query();
        if ($districtCode) {
            $query->where('district_code', $districtCode);
        }

        return Village::find($value) ?? $query->where('name', $value)->first();
    }

    private function normalizeLegacyValue(?string $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
};
