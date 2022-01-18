<?php
////////////////////////////////////////////////////////////////////
//CONTROLADOR DE PRUEBAS PARA UN CLIENTE SOAP
//este controlador lo use para probar los metodos de la clase Cliente SOAP
/////////////////////////////////////////////////////////////////////


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class SoapClientController extends Controller
{
    public function getDate() 
    {
        $client = new Client;
        return $client->getDate();
    }

    public function registro(Request $request ) 
    {
    	
        $client = new Client;
        return json_encode( $client->registro($request->documento, $request->celular, $request->nombre, $request->email)    );
        
    }

    public function recargar(Request $request ) 
    {
    	
        $client = new Client;
        return json_encode( $client->recargar($request->documento, $request->celular, $request->saldo )  );
        
    }

    public function pagar(Request $request ) 
    {
    	
        $client = new Client;
        return json_encode( $client->pagar($request->documento, $request->celular, $request->monto )  );
        
    }

     public function confirmar(Request $request ) 
    {
    	
        $client = new Client;
        return json_encode( $client->confirmar($request->documento, $request->token, $request->idsesion  ) );
        
    }

    public function consultar() 
    {
        $client = new Client;
        return json_encode($client->consultar($request->documento, $request->celular));
     
    }
}