<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The business form used to post option numbers 1–5 for "Parcels per month",
 * so the admin showed e.g. "1 parcels". The form now posts the range itself;
 * this converts the leads saved before, using the form's own mapping.
 * Only exact old codes are touched; anything else is left as it is.
 */
return new class extends Migration
{
    private const MAP = ['1' => '7-10', '2' => '10-12', '3' => '20-50', '4' => '50-100', '5' => '100+'];

    public function up(): void
    {
        // (string): PHP turns the array keys into integers, and comparing the varchar
        // column with an integer would make MySQL compare numerically.
        foreach (self::MAP as $code => $range) {
            DB::table('form')->where('number_of_parcel', (string) $code)->update(['number_of_parcel' => $range]);
        }
    }

    public function down(): void
    {
        foreach (self::MAP as $code => $range) {
            DB::table('form')->where('number_of_parcel', $range)->update(['number_of_parcel' => (string) $code]);
        }
    }
};
