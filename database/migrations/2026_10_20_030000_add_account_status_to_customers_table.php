<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Account access controls for customers (2026-10-20).
     *   account_status: active | suspended | banned | disabled  (anything but active blocks login)
     *   suspended_until: optional end of a suspension; once passed the account counts as active again
     * Only additive columns — orders, payments and wallet history are untouched.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('account_status', 20)->default('active')->after('balance');
            $table->text('status_reason')->nullable()->after('account_status');
            $table->timestamp('suspended_until')->nullable()->after('status_reason');
            $table->timestamp('status_changed_at')->nullable()->after('suspended_until');
            $table->unsignedBigInteger('status_changed_by')->nullable()->after('status_changed_at');
            $table->timestamp('last_login_at')->nullable()->after('status_changed_by');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            $table->index('account_status');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['account_status']);
            $table->dropColumn(['account_status', 'status_reason', 'suspended_until', 'status_changed_at', 'status_changed_by', 'last_login_at', 'last_login_ip']);
        });
    }
};
