<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewModel extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = [
        'review',
        'author_name',
        'author_designation',
        'show_on_home',
        'status',
    ];
}
