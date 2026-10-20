<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Admin-only customer onboarding and customer password resets (2026-10-20).
     *
     * customers.created_by          admin (users.id) who created the account; NULL = created by the
     *                               old public registration form, which is now closed
     * customers.must_change_password set when an admin issues a temporary password
     * customers.password_changed_at  last time the customer set their own password
     *
     * Two token tables so the two kinds of link have their own lifetime and can't be
     * swapped: a self-service reset link lasts 60 minutes, an account-setup link sent
     * to a newly created customer lasts 3 days (see config/auth.php "passwords").
     * Tokens are stored hashed by Laravel's DatabaseTokenRepository.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('last_login_ip');
            $table->boolean('must_change_password')->default(false)->after('created_by');
            $table->timestamp('password_changed_at')->nullable()->after('must_change_password');
        });

        foreach (['customer_password_reset_tokens', 'customer_setup_tokens'] as $name) {
            Schema::create($name, function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_setup_tokens');
        Schema::dropIfExists('customer_password_reset_tokens');
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'must_change_password', 'password_changed_at']);
        });
    }
};
