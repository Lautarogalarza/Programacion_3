<?php

use Illuminate\Database\Eloquent\SoftDeletes;
class Alumno extends Illuminate\Database\Eloquent\Model{//hereda de eloquent model y mapea la tabla a esta clase

    //use SoftDeletes;bajas logicas

    //public $timestamps = false; no me crea los time stamps

   /* const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update'; sobreEscribo los nombres de los timeStamps en la db*/

}

?>