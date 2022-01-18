<?php

namespace App;

class Respuesta 
{
    public $success, $cod_error,$datos;
    public function __construct($success, $cod_error, $message_error, $datos) 
    {
        $this->success = $success;
        $this->cod_error = $cod_error;
        $this->message_error = $message_error;
        $this->datos = $datos;
    }
}



