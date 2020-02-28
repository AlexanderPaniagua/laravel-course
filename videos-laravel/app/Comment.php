<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    //Relacion de uno a uno
    public function user() {
    	return $this->belongsTo('App\User', 'user_id');
    }

    //para sacar video adjnto al comentario
    public function video() {
    	return $this->belongsTo('App\Video', 'video_id');
    }
    
}
