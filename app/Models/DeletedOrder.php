<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'room_name',
        'room_no',
        'customer_name',
        'check_in',
        'check_out',
        'total_price',
        'booked_on',
    ];
}
