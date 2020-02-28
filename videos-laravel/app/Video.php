<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';//Que tabla modificara este modelo

    //Relacion uno a muchos, dentro de video puede haber muchos comentarios
    public function comments() {
    	return $this->hasMany('\App\Comment')->orderBy('id', 'desc');
    }

    //Relacion de uno a uno
    public function user() {
    	return $this->belongsTo('App\User', 'user_id');
    }

}
