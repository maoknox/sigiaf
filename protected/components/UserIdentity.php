<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
Yii::import('application.modules.administracion.models.DatosContrato');	
 
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	 private $cedulaUsr;
	 public $_sedeForjar;
	 public $_datosContrato;
	 
	public function authenticate()
	{
		//$usuario=Personal::model()->find('nombreusuario=?',array($this->username));
		$persona=new Persona();
		$persona->_nombreusuario=$this->username;
		if($persona->consultaUsuario()===false)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($this->password!==$persona->_clave)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->errorCode=self::ERROR_NONE;
			$this->setState('cedula',$persona->_cedula);
			$this->_sedeForjar=$persona->consultaSedeForjar();
			$this->setState('sedesForjar',$this->_sedeForjar);
			$numSedesForjar=count($this->_sedeForjar);
			$this->setState('numSedes',$numSedesForjar);
			//$this->_sedeForjar=$persona->_idSedeForjar;
			//$this->setState('sedeForjar',$persona->_idSedeForjar);
			//$this->setState('nombreSedeForjar',$persona->_nombreSede);
			$this->cedulaUsr=$persona->_cedula;
			$this->setState('rol',$persona->_id_rol);
			$this->setState('nombre',$persona->_nombre_profes.' '.$persona->_apellido_prof);
			$modeloDatosContrato= new DatosContrato();
			$modeloDatosContrato->id_cedula=$this->cedulaUsr;
			$this->_datosContrato=$modeloDatosContrato->consultaContratoAct();			
			//Yii::app()->getSession()->add('cedula',$cedula);
		}
		return !$this->errorCode;
	}
	public function getId()
    {
        return $this->cedulaUsr;
    }
	public function getSedeForjar(){
		 return $this->_sedeForjar;
	}
}