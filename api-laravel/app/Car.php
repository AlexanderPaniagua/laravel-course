<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    
    protected $table = 'cars';

    //relacion de muchos a uno
    public function User() {
    	//modelo a utilizar y modelo de la entidad
    	return $this->belongsTo('App\User', 'user_id');
    }

}
