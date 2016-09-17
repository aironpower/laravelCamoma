<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey='id';
    protected $table='message';

    public function user() {
 		return $this->belongsTo('App\User');
 	}
}
