<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountriesModel extends Model
{
    use SoftDeletes;

    protected $table = 'countries';

    protected $fillable = [
        'title',
        'slug',
        'shipment_to_country',
        'banner_title',
        'sec_one_title',
        'sec_one_content',
        'sec_two_title',
        'sec_two_subheading_1',
        'sec_two_subheading_2',
        'sec_two_subheading_3',
        'sec_two_subheading_4',
        'sec_three_title',
        'sec_three_subheading_1',
        'sec_three_subheading_2',
        'sec_three_subheading_3',
        'sec_three_subheading_4',
        'sec_three_content_1',
        'sec_three_content_2',
        'sec_three_content_3',
        'sec_three_content_4',
        'sec_four_title',
        'sec_four_subheading_1',
        'sec_four_subheading_2',
        'sec_four_subheading_3',
        'sec_four_content_1',
        'sec_four_content_2',
        'sec_four_content_3',
        'sec_five_title',
        'sec_six_title',
        'sec_seven_title',
        'sec_seven_content',
    ];
}
