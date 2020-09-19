<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['orderId', 'user_id' ,'comment'];

    protected $table = 'comments';
}
