<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderModel extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    /** Order lifecycle. Every booking starts as 'pending'. */
    public const STATUSES = ['pending', 'processing', 'completed', 'delivered', 'cancelled'];
}
