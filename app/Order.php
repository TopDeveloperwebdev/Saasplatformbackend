<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = ['orderId','orderMedications','pharmacy', 'patient', 'doctor', 'date', 'note' , 'user_id'];

    protected $table = 'orders';
}
