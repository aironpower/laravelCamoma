<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    protected $primaryKey='id';
    protected $table='post';

    public function comments() {
    	return $this->hasMany('App\Comment');
    }

    public function user() {
 		return $this->belongsTo('App\User');
 	}
}
