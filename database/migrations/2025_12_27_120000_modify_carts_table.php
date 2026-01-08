<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // make user_id nullable and add guest_token column
        if (!Schema::hasColumn('carts', 'guest_token')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->string('guest_token')->nullable()->after('user_id');
            });
        }

        // modify user_id to be nullable using raw statement (avoids requiring doctrine/dbal)
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `carts` MODIFY `user_id` BIGINT UNSIGNED NULL');
        } else {
            Schema::table('carts', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop guest_token if exists and make user_id NOT NULL
        if (Schema::hasColumn('carts', 'guest_token')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropColumn('guest_token');
            });
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `carts` MODIFY `user_id` BIGINT UNSIGNED NOT NULL');
        } else {
            Schema::table('carts', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
            });
        }
    }
};