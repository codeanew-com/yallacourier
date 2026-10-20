<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDimensionModel extends Model
{
    use SoftDeletes;

    protected $table = 'order_dimensions';
}
