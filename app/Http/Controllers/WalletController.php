<?php

//////////////////////////////////////////////////////////////
//Controlador de pruebas de metodos para deteccion de errores
//este controlador lo use para probar los metodos de la calse 
//y el modelo sin la intervension del servidor soap
//////////////////////////////////////////////////////////////     

namespace App\Http\Controllers;

use App\Wallet;
use App\Respuesta;
use App\Server;
use Illuminate\Http\Request;
use App\Http\Controllers\Mail;
use App\Mail\EmailPagoNotificacion;

class WalletController extends Controller
{
    
    public function index()
    {
        echo "Estas el el controlador de pruebas";
    }

    public function probaremail(Request $request)
    {
       \Mail::to('deivis.don@gmail.com')->send( new \App\Mail\EmailPagoNotificacion('idsesion2334','token12344','12345.99') );
       dd('enviado');
    }

    
    public function registro(Request $request)
    {
       $S= new Server();
       return json_encode( $S->registro($request->documento, $request->celular, $request->nombre, $request->email)    );

    }

    public function recargar(Request $request)
    {
         $S= new Server();
         return json_encode( $S->recargar($request->documento, $request->celular, $request->saldo ) );
    }

    public function consultar(Request $request)
    {
         $S= new Server();
         return json_encode( $S->consultar($request->documento, $request->celular ) );
    }

    public function pagar(Request $request)
    {
      $S= new Server();
      return json_encode( $S->pagar($request->documento, $request->celular, $request->monto) );
    }

    public function confirmar(Request $request)
    {

        $S= new Server();
        return json_encode( $S->confirmar($request->documento, $request->token, $request->idsesion  ) );
    }


  

}
