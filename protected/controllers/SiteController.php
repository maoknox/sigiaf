<?php
///!  SiteController.  
/**
	Clase que se ejecuta inicialmente al lanzar la aplicación.  Se generan las acciones de login y las validaciones.
*/

class SiteController extends Controller 
{
	/**
	 * Declares class-based actions.
	 */ 
	public function actionPrincipal(){
		 
	}
	 
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
			'quote'=>array(
                'class'=>'CWebServiceAction',
            ),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}


	/** Método actionLoginExt.       
	*  Acción que se ejecuta si se ingresa por la página de la secretaría de integración instanciando el sistema de información de los centros forjar..  
	*/		
	public function actionLoginExt(){
/*		define('SDIS_WS_LOGIN', 'http://aplicativos.sdis.gov.co/login_sdis');
		try {
            $config = new stdClass();
            $config->apiKey = $_GET["apiKey"];
            $cliente = new SoapClient(SDIS_WS_LOGIN . '/service/', array("trace" => 1, "exception" => 0));
            $header = new SoapHeader(SDIS_WS_LOGIN . '/service/', "MyHeader", $config, false);
            $response = json_decode($cliente->__soapCall("login", array(1), NULL, $header));
            if (!$response->error) {
                if (is_array($response->permisos) && count($response->permisos) > 0) {
                 	$model=new LoginForm;
					$respuesta=(object)$response;
*/					//echo $respuesta->usuario->Login;
					//$respuesta->usuario->Login="erika";
					//$model->nombreusuario=$respuesta->usuario->Login;					
					 //print_r($response);
					// if it is ajax validation request
					
			
					// collect user input data
						$model=new LoginForm;
						//$model->attributes=$_POST['LoginForm'];
						$respuesta->usuario->Login="erika.zamudio";
						$model->nombreusuario=$respuesta->usuario->Login;	
						$model->claveusr="1234";
						// validate user input and redirect to the previous page if valid
						if($model->validate() && $model->login()){				
							Yii::app()->user->returnUrl = array("controlAp/index"); 
							$this->redirect(Yii::app()->user->returnUrl);
						}
					// display the login form
					//$key=$_GET["apiKey"];
					//$config = new stdClass();
					//$config->apiKey = $_GET["apiKey"];
					$this->render('login',array('model'=>$model,'respuesta'=>$respuesta)); 
/*                }
            }
        } catch (Exception $e) {
            echo "Ha ocurrido un error en el login [" . $e->getMessage() . "]";
        }						
*/			
	}


	/** Método actionLogin.       
	*  Muestar la página de logueo.  Si hay datos realiza la validación de datos de usuario y su estado frente al sistema.  En el caso que el usuario no tenga inconvenientes
	*  al ingreso por causa de alguna invalidez, el sistema registra el acceso en un log de acceso.
	*/		
	public function actionLogin(){
		//print_r(Yii::app()->input->post());
		$model=new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				if (getenv('HTTP_CLIENT_IP'))
					$ipaddress = getenv('HTTP_CLIENT_IP');
				else if(getenv('HTTP_X_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
				else if(getenv('HTTP_X_FORWARDED'))
					$ipaddress = getenv('HTTP_X_FORWARDED');
				else if(getenv('HTTP_FORWARDED_FOR'))
					$ipaddress = getenv('HTTP_FORWARDED_FOR');
				else if(getenv('HTTP_FORWARDED'))
					$ipaddress = getenv('HTTP_FORWARDED');
				else if(getenv('REMOTE_ADDR'))
					$ipaddress = getenv('REMOTE_ADDR');
				else
				$ipaddress = 'UNKNOWN';
				$ip=$ipaddress;
				$modeloLogAcceso=new LogAcceso();
				$modeloLogAcceso->ip_acceso=$ipaddress;
				$modeloLogAcceso->id_tipoacceso=1;
				$modeloLogAcceso->fecha_logacceso=date("Y-m-d H:i:s");
				$modeloLogAcceso->id_cedula=Yii::app()->user->getState('cedula');								
				$modeloLogAcceso->registraAcceso();
				Yii::app()->user->returnUrl = array("controlAp/index"); 
				//$this->redirect(Yii::app()->user->returnUrl);
				/*Yii::import('application.extensions.yii-mail-master.YiiMailMessage');
				 $message = new YiiMailMessage;
				 $message->setBody('<h1><strong>Message content here with HTML</strong></h1>', 'text');
				 $message->subject = 'My Subject';
				 $message->addTo('femauro@gmail.com');
				 $message->from = Yii::app()->params['adminEmail'];
				 Yii::app()->mail->send($message);*/
				
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}	 
	public function actionSalir(){
		
		$this->render('salida'); 
	}
		
	/** Método actionLogout.       
	*  Acción que se ejecuta cuando el usuario sale del aplicativo, en este método también se realiza registro en el log de acceso.  se registra la hora en que terminó sesión.
	*/			 
	public function actionLogout()
	{
		if (isset($_SERVER)) {
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
				$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
			if (isset($_SERVER["HTTP_CLIENT_IP"]))
				$ip=$_SERVER["HTTP_CLIENT_IP"];
			$ip=$_SERVER["REMOTE_ADDR"];
		}
		else{
			if (getenv('HTTP_X_FORWARDED_FOR'))
				$ip=getenv('HTTP_X_FORWARDED_FOR');
			if (getenv('HTTP_CLIENT_IP'))
				$ip=getenv('HTTP_CLIENT_IP');
			$ip=getenv('REMOTE_ADDR');
		}
		$modeloLogAcceso=new LogAcceso();
		$modeloLogAcceso->ip_acceso=$ip;
		$modeloLogAcceso->id_tipoacceso=2;
		$modeloLogAcceso->fecha_logacceso=date("Y-m-d H:i:s");
		$modeloLogAcceso->id_cedula=Yii::app()->user->getState('cedula');								
		$modeloLogAcceso->registraAcceso();	
		Yii::app()->user->logout();
		$this->redirect(array("site/salir"));
	}
	public function actionConfirmaAlertas(){
		echo CJSON::encode(array("alertaMenu"=>"glyphicon glyphicon-ok",'resultado'=>CJavaScript::encode(CJavaScript::quote($modeloValPsicol->msnValPsicol)),'idcasodelito'=>CHtml::encode($modeloValPsicol->idCasoDelito)));
	}
}