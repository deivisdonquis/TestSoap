<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Wallet extends Model
{
	protected $table = 'wallet';
    protected $fillable = ['documento','nombre', 'email','celular','saldo' ];
    protected $hidden = ['created_at', 'updated_at'];

    public  static function registro($dat)
    {
    	try
    	{
	        return Wallet::create(
	        [
	            'documento' =>  $dat['documento'],
	            'celular'=>  $dat['celular'],
	            'nombre'=>  $dat['nombre'],
	            'email'=>  $dat['email'],
	            'saldo'=>  $dat['saldo']
	        ] );
	       
	    }
	    catch(QueryException $e) { return 0; }
    
    }

    public static function recargar($dat)
	{
		try
    	{
			$Obj = Wallet::where('documento', $dat['documento'] )->where('celular', $dat['celular'])->first();
			if( $Obj )
			{
				$Obj->saldo = $Obj->saldo + $dat['saldo'];
				if($Obj->save())
					return $Obj;
				else
					return 0;
			}
			else
			{
				return 0;
			}
		}
	    catch(QueryException $e) { return 0; }

	}

	public static function consultar($dat)
	{
		try
    	{
			return Wallet::where('documento', $dat['documento'] )->where('celular', $dat['celular']   )->first();
		}
	    catch(QueryException $e) { return 0; }
	}

    public static function confirmar($dat)
	{
		try
    	{
			$Obj = Wallet::where('documento', $dat['documento'] )->where('celular', $dat['celular'])->first();
			if( $Obj )
			{
				if( $Obj->saldo >= $dat['monto'] )
				{
					$Obj->saldo = $Obj->saldo - $dat['monto'];
					
					if($Obj->save())
						return [1,$Obj];
					else
						return [-2,''];
				}
				else
					return [-1,''];
			}
			else
				return [0,''];

		}
	    catch(QueryException $e) { return [0,'']; }
		
	}

    
}
