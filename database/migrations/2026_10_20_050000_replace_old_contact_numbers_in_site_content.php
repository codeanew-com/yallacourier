<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Company WhatsApp/contact number → 052 660 7133 (+971 52 660 7133), 2026-10-20.
     *
     * The live site still showed three older numbers (058 661 1932, 058 580 0119,
     * 056 864 9187) in CMS content such as page titles ("… | WhatsApp us 056 864 9187")
     * and page sections. Template code was already updated; this fixes the data.
     *
     * Only website content tables are touched. Customer and order data
     * (customers.phone, order_meta, form leads) are deliberately left alone:
     * those are other people's numbers. Idempotent: running it again changes nothing.
     */
    private const NEW = [
        'local' => '052 660 7133',
        'intl' => '+971 52 660 7133',
        'digits' => '971526607133',
        'e164' => '+971526607133',
    ];

    /** Old number → its local 9 significant digits after the country code (without leading 0). */
    private const OLD = ['586611932', '585800119', '568649187'];

    /** table => text columns holding site content */
    private const COLUMNS = [
        'pages' => ['title', 'page_title', 'meta_description'],
        'pages_meta' => ['value'],
        'countries' => null, // all text columns (country landing pages)
        'faqs' => ['question', 'answer'],
        'reviews' => ['review'],
    ];

    public function up(): void
    {
        $pairs = $this->replacements();
        $total = 0;

        foreach (self::COLUMNS as $table => $columns) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            $columns ??= collect(Schema::getColumns($table))
                ->filter(fn ($c) => preg_match('/char|text/i', $c['type_name']))
                ->pluck('name')->all();

            foreach ($columns as $col) {
                // Only rows that mention one of the old numbers (by digits, any formatting).
                $rows = DB::table($table)->select('id', $col)->where(function ($w) use ($col) {
                    // Each old number by its digits, plus the truncated "+971058661193" typo.
                    foreach (array_merge(self::OLD, ['971058661193']) as $d) {
                        $w->orWhereRaw("REPLACE(REPLACE(REPLACE(REPLACE(`$col`, ' ', ''), '-', ''), '(', ''), ')', '') LIKE ?", ['%'.$d.'%']);
                    }
                })->get();

                foreach ($rows as $row) {
                    $new = strtr((string) $row->$col, $pairs);
                    if ($new !== $row->$col) {
                        DB::table($table)->where('id', $row->id)->update([$col => $new]);
                        $total++;
                    }
                }
            }
        }

        Log::info('Contact number migration: '.$total.' content field(s) updated to '.self::NEW['local']);
    }

    public function down(): void
    {
        // Not reversible: the old numbers are no longer in use.
    }

    /** Every formatting of the old numbers seen on the site, longest first (strtr prefers the longest match). */
    private function replacements(): array
    {
        $pairs = [];
        foreach (self::OLD as $d) {
            [$a, $b, $c] = [substr($d, 0, 2), substr($d, 2, 3), substr($d, 5)];
            $map = [
                // international, with/without the (wrong) leading 0, spaced or not
                "+971 0$a $b $c" => self::NEW['intl'], "+971 $a $b $c" => self::NEW['intl'],
                "+971-$a-$b-$c" => self::NEW['intl'], "00971 $a $b $c" => self::NEW['intl'],
                "+9710$d" => self::NEW['e164'], "+971$d" => self::NEW['e164'], "00971$d" => self::NEW['e164'],
                // digits only (wa.me/…, api.whatsapp.com/send?phone=…)
                "9710$d" => self::NEW['digits'], "971$d" => self::NEW['digits'],
                // local formats
                "0$a $b $c" => self::NEW['local'], "0$a-$b-$c" => self::NEW['local'], "0$a$b$c" => self::NEW['local'],
            ];
            $pairs += $map;
        }
        // Truncated typo seen in a live tel: link ("+971058661193", one digit missing).
        $pairs['+971058661193'] = self::NEW['e164'];

        return $pairs;
    }
};
