<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldFrutas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('frutas', function(Blueprint $table) {
            $table->string('pais', 255)->after('temporada');
            $table->renameColumn('nombre_fruta', 'nombre');
        });*/
        DB::statement('
            CREATE TABLE probandosql(
            id INT(255) AUTO_INCREMENT NOT NULL,
            publication INT(255) NULL,
            PRIMARY KEY(id)
            );
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
