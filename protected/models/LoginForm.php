<?php
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
Yii::import('application.modules.administracion.models.DatosContrato');	
 
class LoginForm extends CFormModel
{
	public $nombreusuario;
	public $claveusr;
	//public $rememberMe;
	public $cedulaUsr;
	private $_identity;
	public $id_forjar;
	public $pers_habilitado;
	public $contrato;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('id_forjar,nombreusuario, claveusr', 'required'),
			// password needs to be authenticated
			//array('nombreusuario','verifPerHab','nombreusuario'=>$this->nombreusuario),
			array('claveusr', 'authenticate','claveusr'=>$this->claveusr,'nombreusuario'=>$this->nombreusuario),
			array('id_forjar','consultaSedeForjar'),
			array('contrato','confirmaContrato')
		);
	}
/*	public function verifPerHab($attribute,$params){
		if(!$this->hasErrors()){
			$persHab=true;
			if(!$persHab){
				$this->addError('nombreusuario','El usuario no está activo en el sistema, comuníquese con la persona lider administrativa');
			}
		}
	}
*/	
	
	public function consultaSedeForjar($attribute,$params){
		if(!$this->hasErrors()){		
			if(empty($this->_identity->_sedeForjar))
				$this->addError('id_forjar','En el sistema SIGIAF, el profesional no se encuentra relacionado en una sede de Forjar');
		}
	}
	public function confirmaContrato($attribute,$params){
		if(!$this->hasErrors()){		
			if(empty($this->_identity->_datosContrato)){
				$this->addError('nombreusuario','No se ha asignado un contrato al usuario');
			}
			else{
				$dias	= (strtotime($this->_identity->_datosContrato['fecha_fin'])-strtotime(date("Y-m-d")))/86400;
				$dias = floor($dias);			
				if($dias<0){
					if(!empty($this->_identity->_datosContrato['fecha_extension'])){
						$diasExt	= (strtotime($this->_identity->_datosContrato['fecha_extension'])-strtotime(date("Y-m-d")))/86400;
						$diasExt = floor($diasExt);			
						if($diasExt<0){
							$this->addError('nombreusuario','Contrato fuera de vigencia'); 
						}						
					}
					else{
						$this->addError('nombreusuario','Contrato fuera de vigencia'); 												
					}
				}							
			}
		}
	}

	
	
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'id_forjar'=>'Sede Forjar',
			'nombreusuario'=>'Nombre usuario',
			'claveusr'=>'Clave usuario'
		);
	}
	
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors()){
			$operGenerales=new OperacionesGenerales();
			$this->claveusr=$operGenerales->encriptaClaveHMAC($this->claveusr);
			$this->_identity=new UserIdentity($this->nombreusuario,$this->claveusr);
			if(!$this->_identity->authenticate()){
				$this->addError('claveusr','Nombre o clave de usuario incorrecta.');
			}else{
				if(empty($this->_identity->_sedeForjar)){
					$this->addError('claveusr','En el sistema SIGIAF, el profesional no se encuentra relacionado en una sede de Forjar');
				}
				else{
					$modeloUsuario=new Usuario();
					$modeloUsuario->nombre_usuario=$this->nombreusuario;
					$persHab=$modeloUsuario->consultaEstadoUsuarioNombUsr();
					if($persHab["pers_habilitado"]!='t'){
						$this->addError('claveusr','El usuario no está activo en el sistema, comuníquese con la persona lider administrativa');
					}
				}
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{	
			$operGenerales=new OperacionesGenerales();
			$this->claveusr=$operGenerales->encriptaClaveHMAC($this->claveusr);
			$this->_identity=new UserIdentity($this->nombreusuario,$this->claveusr);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{	
			//Yii::app()->getSession()->add('cedula',$this->_identity->cedula);
			//$duration=30; // 30 segs
			Yii::app()->user->login($this->_identity);
			
			return true;
		}
		else
			return false;
	}
}
