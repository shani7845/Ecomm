<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // add guest_token if missing
        if (!Schema::hasColumn('carts', 'guest_token')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->string('guest_token')->nullable()->after('user_id');
            });
        }

        // attempt to make user_id nullable (MySQL raw statement avoids dbal requirement)
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            try {
                DB::statement('ALTER TABLE `carts` MODIFY `user_id` BIGINT UNSIGNED NULL');
            } catch (\Throwable $e) {
                // ignore - best effort (migration should be idempotent)
            }
        } else {
            try {
                Schema::table('carts', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable()->change();
                });
            } catch (\Throwable $e) {
                // ignore
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('carts', 'guest_token')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropColumn('guest_token');
            });
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            try {
                DB::statement('ALTER TABLE `carts` MODIFY `user_id` BIGINT UNSIGNED NOT NULL');
            } catch (\Throwable $e) {
                // ignore
            }
        } else {
            try {
                Schema::table('carts', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable(false)->change();
                });
            } catch (\Throwable $e) {
                // ignore
            }
        }
    }
};
