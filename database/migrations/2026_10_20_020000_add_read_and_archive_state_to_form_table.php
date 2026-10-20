<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Business leads (`form` table) get a read/unread and an archived state.
     * Both are nullable timestamps, so "unread" = read_at IS NULL and
     * "archived" = archived_at IS NOT NULL — no status strings to keep in sync.
     */
    public function up(): void
    {
        // The legacy `created_at` column defaults to '0000-00-00 00:00:00', which
        // strict mode rejects on any ALTER of this table. Relax it for this
        // session only rather than altering that existing column.
        $mode = DB::selectOne('SELECT @@SESSION.sql_mode AS m')->m;
        DB::statement("SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'NO_ZERO_DATE', ''), 'NO_ZERO_IN_DATE', '')");

        Schema::table('form', function (Blueprint $table) {
            $table->timestamp('read_at')->nullable()->after('current_delivery_partner');
            $table->timestamp('archived_at')->nullable()->after('read_at');
            $table->index(['archived_at', 'read_at']);
        });

        // Leads that existed before this feature were already visible to admins
        // in the old table, so they start as read; only new leads raise the badge.
        DB::table('form')->whereNull('read_at')->update(['read_at' => DB::raw('COALESCE(NULLIF(created_at, \'0000-00-00 00:00:00\'), CURRENT_TIMESTAMP)')]);

        DB::statement('SET SESSION sql_mode = ?', [$mode]);
    }

    public function down(): void
    {
        DB::statement("SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'NO_ZERO_DATE', ''), 'NO_ZERO_IN_DATE', '')");
        Schema::table('form', function (Blueprint $table) {
            $table->dropIndex(['archived_at', 'read_at']);
            $table->dropColumn(['read_at', 'archived_at']);
        });
    }
};
