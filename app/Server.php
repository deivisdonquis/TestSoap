<?php

namespace App;

use App\Wallet;
use App\Token;
use App\Respuesta;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Validator;
use App\Mail\EmailPagoNotificacion;



class Server 
{
  
    public function registro($documento, $celular, $nombre, $email)
    {
        $valid = Validator::make( 
        [
          'documento' => $documento
          ,'celular'=> $celular 
          ,'nombre'=> $nombre 
          ,'email'=> $email 
        ]
       ,[
            'documento' => 'required'
           ,'celular' => 'required'
           ,'nombre'=> 'required'
           ,'email'=> 'required|email'
        ] );   

      
        if($valid->fails())
            return new Respuesta( false, 401, $valid->errors()  , [] );
      
        $dat = array(
            'documento' => $documento,
            'celular'=> $celular,
            'nombre'=> $nombre,
            'email'=> $email,
            'saldo'=> 0
        );

        $W=Wallet::registro($dat);
        if($W)
             return new Respuesta( true, 00, 'Creado con exito', json_decode( json_encode( $W ), true ) );
        else
            return new Respuesta( false, 503, 'Error al guadar los Datos', [] );
    }


    public function consultar($documento, $celular )
    {
        $valid = Validator::make( 
        [
           'documento' => $documento
           ,'celular'=> $celular ]
       ,[
            'documento' => 'required'
            ,'celular' => 'required'
        ] );   

      
        if($valid->fails())
            return new Respuesta( false, 401, $valid->errors()  , [] );
        
        $wallet= Wallet::consultar( ['documento' => $documento,'celular'=> $celular ] );
        if($wallet)
            return new Respuesta( true, 00, 'ok', json_decode( json_encode( $wallet ), true ) );
        else
            return new Respuesta( false, 404, 'Documento no encontrado', [] );
    }


    public function recargar($documento, $celular, $saldo)
    {
        $valid = Validator::make( 
        [
           'documento' => $documento
           ,'celular'=> $celular 
           ,'saldo'=> $saldo 
        ]
       ,[
            'documento' => 'required'
            ,'celular' => 'required'
            ,'saldo' => 'required'
        ] );   

      
        if($valid->fails())
            return new Respuesta( false, 401, $valid->errors()  , [] );

        $dat = array('documento' => $documento,
                     'celular'=> $celular,
                     'saldo'=> $saldo
                 ); 
        
        $wallet=Wallet::recargar($dat); 
        if($wallet)
              return new Respuesta( true, 00, 'ok', json_decode( json_encode( $wallet ), true ) );
        else
            return new Respuesta( false, 304, 'Error al recargar saldo', [] );
    }


    public function pagar($documento, $celular, $monto)
    {
        $valid = Validator::make( 
        [
           'documento' => $documento
           ,'celular'=> $celular 
           ,'monto'=> $monto 
        ]
       ,[
            'documento' => 'required'
            ,'celular' => 'required'
            ,'monto' => 'required'
        ] );   

        if($valid->fails())
            return new Respuesta( false, 401, $valid->errors()  , [] );


        $wallet= Wallet::consultar( ['documento' => $documento,'celular'=> $celular ] );
        if($wallet)
        {
            if($wallet->saldo >= $monto)
            {
                //configuro 10 minutos para el vencimiento del token
                
                $validez = time()+(60*10);
                $token   = mt_rand(100001,999999); //token de 6 digitos
                $idsesion = session()->token();

                //guardado innformacion del token y datos necesarios para el pago
                $dat = array(
                      'token' => $token
                     ,'idsesion' => $idsesion
                     ,'documento' => $documento
                     ,'celular'=> $celular
                     ,'monto'=> $monto
                     ,'validez'=> $validez
                 ); 
                 Token::add($dat);

                 
                 //envio el correo
                  \Mail::to('deivis.don@gmail.com')->send( new \App\Mail\EmailPagoNotificacion( $idsesion, $token, $monto ) );  
              
                return new Respuesta(
                true, 00, '', 
                [ 'mensaje'=>'Usted a realizado un pago de:'.$monto.', Se envio un token ('.$token.') y el id de session ('.$idsesion.') a su correo para confirmar el pago'] 
                );

            }
            else
                return new Respuesta( false, 401, 'Saldo Insuficiente', [] );

        }
        else
            return new Respuesta( false, 406, 'Documento no encontrado', [] );
      
    }


    public function confirmar( $documento, $token, $idsesion )
    {

        $valid = Validator::make( 
        [
           'documento'  => $documento
           ,'token'     => $token 
           ,'idsesion'  => $idsesion 
        ]
       ,[
            'documento' => 'required'
            ,'token'    => 'required'
            ,'idsesion' => 'required'
        ] );   

        if($valid->fails())
            return new Respuesta( false, 401, $valid->errors()  , [] );


        //buscando el token enviado por el cliente
        $ObjToken = Token::get($token, $idsesion, $documento);
        if($ObjToken)
        {
           //verificando que el token no alla expirado
            if( time() < $ObjToken->validez  )
            {
                //tomos los datos del pago guardado para procesarlo
                $dat = array( 'documento'=> $ObjToken->documento,
                         'celular'=> $ObjToken->celular,
                         'monto'=> $ObjToken->monto
                     ); 

                $R = Wallet::confirmar($dat);

                //marco el token como procesado para no ser usado en otra oportunidad
                Token::procesar([ 'token'=> $ObjToken->token ,'documento'=> $ObjToken->documento,'celular'=> $ObjToken->celular ] );

                if($R[0]==1)
                     return new Respuesta( true, 00, '', json_decode( json_encode( $R[1] ), true ) );
                elseif($R[0]==0)
                     return new Respuesta( false, 406, 'Documento no encontrado', [] );
                elseif($R[0]==-1)
                     return new Respuesta( false, 401, 'Saldo Insuficiente', [] );
                elseif($R[0]==-2) 
                     return new Respuesta( false, 503, 'Error al guardar los datos', [] );  
                
            }
            else
            {
                //marco el token como procesado para no ser usado en otra oportunidad
                Token::procesar([ 'token'=> $ObjToken->token ,'documento'=> $ObjToken->documento ,'celular'=> $ObjToken->celular ] );                
                
                return new Respuesta( false, 401, 'Transaccion rechazada Token Expirado', [] );     
            }
        }
        else
            return new Respuesta( false, 401, 'Documento o Token incorrecto', [] ); 
      
    }


}



