<?php

namespace App;

class Client 
{

    protected $instance;

    public function __construct() 
    {
        try 
        {
            $params = array( 'uri'      => 'urn://localhost/soap/public/server',
                             'location' => 'http://localhost/soap/public/server',
                             'trace' => 1
                            );

            $this->instance = new \SoapClient( null, $params );

        } 
        catch (Exception $ex) 
        {
            exit("soap error: " . $ex->getMessage());
        }

    }

    public function getDate() 
    {
        try 
        { return $this->instance->getDate();    } 
        catch (Exception $ex) 
        {  exit("soap error: " . $ex->getMessage()); }
    }

    public function registro($documento, $celular, $nombre, $email)
    {
        try 
        { 
            return $this->instance->registro($documento, $celular, $nombre, $email);    
        } 
        catch (Exception $ex) 
        {  exit("soap error: " . $ex->getMessage()); }
    }

    public function recargar($documento, $celular, $saldo)
    {
        try 
        { 
            return $this->instance->recargar($documento, $celular, $saldo);    
        } 
        catch (Exception $ex) 
        {  exit("soap error: " . $ex->getMessage()); }
    }

    public function pagar($documento, $celular, $monto)
    {
        try 
        { 
            return $this->instance->pagar($documento, $celular, $monto);    
        } 
        catch (Exception $ex) 
        {  exit("soap error: " . $ex->getMessage()); }
    }

    public function confirmar( $documento, $token, $idsesion )
    {
        try 
        { 
            return $this->instance->confirmar($documento, $token, $idsesion );
        } 
        catch (Exception $ex) 
        {  exit("soap error: " . $ex->getMessage()); }
    }

    public function consultar($documento, $celular ) 
    {
        try 
        { 
            return $this->instance->consultar($documento,$celular);    
        } 
        catch (Exception $ex) 
        {  exit("soap error: " . $ex->getMessage()); }
    }

}