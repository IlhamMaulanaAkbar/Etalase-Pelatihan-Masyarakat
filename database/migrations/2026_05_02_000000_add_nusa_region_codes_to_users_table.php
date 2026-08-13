<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hasLegacyRegionColumns = Schema::hasColumn('users', 'province')
            || Schema::hasColumn('users', 'city')
            || Schema::hasColumn('users', 'district')
            || Schema::hasColumn('users', 'village');

        if (! $hasLegacyRegionColumns) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'province_code')) {
                $table->string('province_code', 2)->nullable()->index()->after('gender');
            }

            if (! Schema::hasColumn('users', 'regency_code')) {
                $table->string('regency_code', 5)->nullable()->index()->after('province_code');
            }

            if (! Schema::hasColumn('users', 'district_code')) {
                $table->string('district_code', 8)->nullable()->index()->after('regency_code');
            }

            if (! Schema::hasColumn('users', 'village_code')) {
                $table->string('village_code', 13)->nullable()->index()->after('district_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $hasLegacyRegionColumns = Schema::hasColumn('users', 'province')
            || Schema::hasColumn('users', 'city')
            || Schema::hasColumn('users', 'district')
            || Schema::hasColumn('users', 'village');

        if (! $hasLegacyRegionColumns) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            foreach (['village_code', 'district_code', 'regency_code', 'province_code'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
