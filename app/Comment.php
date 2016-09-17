<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey='id';
    protected $table='comment';

 	public function post() {
 		return $this->belongsTo('App\Post');
 	}
}