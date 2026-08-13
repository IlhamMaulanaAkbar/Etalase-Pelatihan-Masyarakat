<?php

use Creasi\Nusa\Models\District;
use Creasi\Nusa\Models\Province;
use Creasi\Nusa\Models\Regency;
use Creasi\Nusa\Models\Village;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! $this->hasNusaColumns()) {
            return;
        }

        DB::table('users')
            ->select($this->selectColumns())
            ->orderBy('id')
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $province = $this->findProvince($user->province_code, $user->province);
                    $regency = $this->findRegency($user->regency_code, $user->city, $province?->code);
                    $district = $this->findDistrict($user->district_code, $user->district, $regency?->code, $province?->code);
                    $village = $this->findVillage($user->village_code, $user->village, $district?->code);

                    if ($village) {
                        $district = $village->district;
                        $regency = $village->regency;
                        $province = $village->province;
                    } elseif ($district) {
                        $regency = $district->regency;
                        $province = $district->province;
                    } elseif ($regency) {
                        $province = $regency->province;
                    }

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
        //
    }

    private function hasNusaColumns(): bool
    {
        return Schema::hasColumn('users', 'province_code')
            && Schema::hasColumn('users', 'regency_code')
            && Schema::hasColumn('users', 'district_code')
            && Schema::hasColumn('users', 'village_code');
    }

    private function selectColumns(): array
    {
        return [
            'id',
            Schema::hasColumn('users', 'province') ? 'province' : DB::raw('null as province'),
            Schema::hasColumn('users', 'city') ? 'city' : DB::raw('null as city'),
            Schema::hasColumn('users', 'district') ? 'district' : DB::raw('null as district'),
            Schema::hasColumn('users', 'village') ? 'village' : DB::raw('null as village'),
            'province_code',
            'regency_code',
            'district_code',
            'village_code',
        ];
    }

    private function findProvince(?string $code, ?string $name): ?Province
    {
        return ($code ? Province::find($code) : null)
            ?? $this->findByLegacyName(Province::query(), $name, []);
    }

    private function findRegency(?string $code, ?string $name, ?string $provinceCode): ?Regency
    {
        $regency = $code ? Regency::find($code) : null;

        if ($regency) {
            return $regency;
        }

        $query = Regency::query();
        if ($provinceCode) {
            $query->where('province_code', $provinceCode);
        }

        return $this->findByLegacyName($query, $name, ['Kabupaten', 'Kota']);
    }

    private function findDistrict(?string $code, ?string $name, ?string $regencyCode, ?string $provinceCode): ?District
    {
        $district = $code ? District::find($code) : null;

        if ($district && (! $regencyCode || $district->regency_code === $regencyCode)) {
            return $district;
        }

        $query = District::query();
        if ($regencyCode) {
            $query->where('regency_code', $regencyCode);
        } elseif ($provinceCode) {
            $query->where('province_code', $provinceCode);
        }

        return $this->findByLegacyName($query, $name, []);
    }

    private function findVillage(?string $code, ?string $name, ?string $districtCode): ?Village
    {
        $village = $code ? Village::find($code) : null;

        if ($village && (! $districtCode || $village->district_code === $districtCode)) {
            return $village;
        }

        $query = Village::query();
        if ($districtCode) {
            $query->where('district_code', $districtCode);
        }

        return $this->findByLegacyName($query, $this->removeRtSuffix($name), ['Desa', 'Kelurahan']);
    }

    private function findByLegacyName(Builder $query, ?string $name, array $prefixes)
    {
        $name = $this->normalizeLegacyValue($name);

        if ($name === null) {
            return null;
        }

        $candidates = [$name];
        foreach ($prefixes as $prefix) {
            $candidates[] = "{$prefix} {$name}";
        }

        return $query->whereIn('name', array_unique($candidates))->first();
    }

    private function normalizeLegacyValue(?string $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function removeRtSuffix(?string $value): ?string
    {
        $value = $this->normalizeLegacyValue($value);

        if ($value === null) {
            return null;
        }

        return trim((string) preg_replace('/\s+RT\.?\s*\d+.*/i', '', $value));
    }
};
