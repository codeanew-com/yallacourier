<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLogModel extends Model
{
    use SoftDeletes;

    protected $table = 'order_log';
}
