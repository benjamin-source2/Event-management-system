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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('id');
            $table->string('first_name')->after('name');
            $table->string('last_name')->after('first_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('profile_photo')->nullable()->after('phone');
            $table->enum('role', ['super_admin', 'event_manager', 'user'])->default('user')->after('profile_photo');
            $table->string('language', 10)->default('en')->after('role');
            $table->string('theme_preference', 10)->default('light')->after('language');
            $table->enum('status', ['active', 'suspended', 'pending'])->default('active')->after('theme_preference');
            $table->string('otp_code', 6)->nullable()->after('status');
            $table->boolean('two_factor_enabled')->default(false)->after('otp_code');
            $table->text('two_factor_secret')->nullable()->after('two_factor_enabled');
            $table->timestamp('otp_expires_at')->nullable()->after('otp_code');
            $table->timestamp('last_login_at')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username', 'first_name', 'last_name', 'phone', 'profile_photo',
                'role', 'language', 'theme_preference', 'status', 'otp_code',
                'two_factor_enabled', 'two_factor_secret', 'otp_expires_at', 'last_login_at',
            ]);
        });
    }
};
