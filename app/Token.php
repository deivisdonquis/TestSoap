<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
	protected $table = 'token';
    protected $fillable = ['token','idsesion','documento','celular','monto','procesado','validez' ];
   
   public  static function add($dat)
   {
        $token = new Token([
        	'token' =>  $dat['token']
        	,'idsesion' =>  $dat['idsesion']
            ,'documento' =>  $dat['documento']
            ,'celular'=>  $dat['celular']
            ,'monto'=>  $dat['monto']
            ,'validez'=> $dat['validez']
            ,'procesado'=> 0
        ]);
 
        return $token->save();
    }

    public static function procesar($dat)
	{
		return Token::where('token', $dat['token'])
						->where('documento', $dat['documento'])
						->where('celular', $dat['celular'])
						->update([ 'procesado' => 1 ]);
	}

	public static function get($token,$idsesion,$documento)
	{
		return Token::where('token', $token )
					->where('idsesion', $idsesion)
					->where('documento', $documento)
					->where('procesado', 0)->first();
	}

}
