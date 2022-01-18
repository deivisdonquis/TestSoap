<?php

////////////////////////////////////////////////////////////////////
//CONTROLADOR DEL SERVIDOR SOAP LEVANTA EL SERVICIO Y EL OYENTE SOAP
/////////////////////////////////////////////////////////////////////

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class SoapServerController extends Controller
{
    public function index() 
    {
        $params = array('uri' => 'http://localhost/soap/public/server');
        $server = new \SoapServer( null, $params );

        $SC = new App\Server();
        $server->setObject( $SC );
        
        $server->handle();

    /*      $response = new Response();
        $response->headers->set("Content-Type","text/xml; charset=utf-8"); 
        //  $response->headers->set("Content-Type","application/soap+xml; charset=utf-8"); 

        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());

        return $response;*/
    }

}

