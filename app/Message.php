<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = ['title', 'body', 'delivered', 'date_string', 'send_date'];

    protected $table = 'messages';
}
