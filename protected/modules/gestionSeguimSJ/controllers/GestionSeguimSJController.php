<?php
///!  Clase controlador del módulo gestión y seguimiento del ámbito socio jurídico.  
/**
 * @author Félix Mauricio Vargas Hincapié <femauro@gmail.com>
 * @copyright Copyright &copy; Félix Mauricio Vargas Hincapié 2015
 */

class GestionSeguimSJController extends Controller
{
	
	/**
	 * Acción que se ejecuta en segunda instancia para verificar si el usuario tiene sesión activa.
	 * En caso contrario no podrá acceder a los módulos del aplicativo y generará error de acceso.
	 */
	public function filterEnforcelogin($filterChain){		
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}			
	/**
	 * Acción que se ejecuta en primera instancia que llama a verificar la sesión de usuario y llama a los filtros secundarios
	 * Los filtros no se ejecutan cuando se llaman a las acciones que van seguidas del guión.
	 */
	public function filters(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
			$numDocAdol=$datosInput["numDocAdol"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		return array(//ActionVerifEstadoFilter
			'enforcelogin',
			array('application.filters.ActionLogFilter','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()),
			array('application.filters.ActionVerifEstadoFilter +registrarAsesoriaSJForm realizarSeguimientoSJ muestraFormSegGSJ muestraAsesoriasSJ modificarDatosContactoSJForm','num_doc'=>Yii::app()->getSession()->get('numDocAdol'))
		);
	}

	public function actionIndex()
	{
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="index";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$this->render('index');
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	}
	/**
	 *	Acción que renderiza el formulario para registrar el tipo de asesoría jurídica al cual el adolescente es remitido.
	 *
	 *	Vista a renderizar:
	 *		- _registrarAsesoriaSJForm.
	 *
	 *	Modelos instanciados:
	 *		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 * 		- GestionSociojuridica.
	 * 
	 *	@param string $numDocAdol número de documento del adolescnete
	 *	@param array $datosAdol datos básicos del adolescente
	 *	@param int $edad edad del adolescente
	 *	@param array $motivoAsesoria 
	 *	@param array $remisionA 
	 *	@param array $tipoGestion 
	 *	@param object $modeloGestionSJ 
	 */		
	public function actionRegistrarAsesoriaSJForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="registrarAsesoriaSJForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$motivoAsesoria=$consultaGeneral->consultaEntidades("motivo_asesoriasj","id_motivoasesoriasj");
				$remisionA=$consultaGeneral->consultaEntidades("remision_gestionsj","id_remisionsj");
				$tipoGestion=$consultaGeneral->consultaEntidades("tipo_gestionsj","id_tipogestionsj");							
			}
			$this->render('_registrarAsesoriaSJForm',array(
					'numDocAdol'=>$numDocAdol,	
					'datosAdol'=>$datosAdol,
					'modeloGestionSJ'=>$modeloGestionSJ,
					'edad'=>$edad,
					'motivoAsesoria'=>$motivoAsesoria,
					'remisionA'=>$remisionA,
					'tipoGestion'=>$tipoGestion
				)
			);
			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	}
	
	/**
	 *	Registra la asesoría que se diligencia en la vista _registrarAsesoriaSJForm e instancia a modelo
	 *
	 *	Modelos instanciados:
	 * 		- GestionSociojuridica.
	 *
	 *	@param array $sedes. objeto $modeloTelForjar, $modeloCForjar.
	 */		
	public function actionRegistrarAsesoriaSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="registrarAsesoriaSJForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloGestionSJ=new GestionSociojuridica();
			$modeloGestionSJ->attributes=$datosInput["GestionSociojuridica"];
			
			if($modeloGestionSJ->validate()){
				$resultado=$modeloGestionSJ->registraGestionSJ();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloGestionSJ);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	/**
	 *	Acción que renderiza el formulario para mostrar el listado de las asesorías sociojurídicas que se realizan al adolescente.
	 *
	 *	Vista a renderizar:
	 *		- _consultarAsesoriasSJForm.
	 *
	 *	Modelos instanciados:
	 *		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 * 		- GestionSociojuridica.
	 *
	 *	@param string $numDocAdol número de documento del adolescnete
	 *	@param array $consultaGestionesAdol gestiones realizdas al adolescente
	 *	@param array $datosAdol 
	 *	@param int $edad 
	 */		
	public function actionConsultarAsesoriasSJ()
	{
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultarAsesoriasSJ";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){		
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$consultaGestionesAdol=$modeloGestionSJ->consultaGestionesSJAdol();
			}						
			$this->render('_consultarAsesoriasSJForm',array(
				'modeloGestionSJ'=>$modeloGestionSJ,
				'consultaGestionesAdol'=>$consultaGestionesAdol,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,				
				'edad'=>$edad,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	}
	/**
	 *	Acción que renderiza el formulario donde muestra la información de una gestión sociojurídica en específco.
	 *
	 *	Vista a renderizar:
	 *		- _muestraAsesoriasSJ.
	 *
	 *	Modelos instanciados:
	 *		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 * 		- GestionSociojuridica.
	 *
	 *	@param string $numDocAdol número de documento del adolescnete
	 *	@param array $consultaGestionesAdol gestiones realizdas al adolescente
	 *	@param array $datosAdol 
	 *	@param int $edad 
	 *	@param object $modeloGestionSJ 
	 */		
	public function actionMuestraAsesoriasSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="muestraAsesoriasSJ";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){		
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$consultaGestionesAdol=$modeloGestionSJ->consultaGestionesSJAdol();
			}						
			$this->render('_muestraAsesoriasSJ',array(
				'modeloGestionSJ'=>$modeloGestionSJ,
				'consultaGestionesAdol'=>$consultaGestionesAdol,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,				
				'edad'=>$edad,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	/**
	 *	Acción que renderiza el formulario donde muestra la información de una gestión sociojurídica en específco.
	 *
	 *	Vista a renderizar:
	 *		- _segGSJForm.
	 *
	 *	Modelos instanciados:
	 *		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 * 		- GestionSociojuridica.
	 * 		- SeguimientoAsesoriasj.
	 *
	 *	@param	object	$modeloGestionSJ
	 *	@param	object	$modeloSegAsesoriasSJ
	 *	@param	array	$consultaGestionesAdol
	 *	@param	string	$numDocAdol
	 *	@param	array	$datosAdol				
	 *	@param	int		$edad
	 *	@param	array	$consultaGestionAdol
	 *	@param	array	$consultaHistSeg												 
	 */		
	public function actionMuestraFormSegGSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="muestraAsesoriasSJ";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){		
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloSegAsesoriasSJ=new SeguimientoAsesoriasj();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$modeloGestionSJ->id_gestionsj=$datosInput["id_gestionsj"];
				$consultaGestionAdol=$modeloGestionSJ->consultaGestionSJAdol();
				$consultaHistSeg=$modeloGestionSJ->consultaHistoricoSegGSJAdol();
				$this->render("_segGSJForm",array(
						'modeloGestionSJ'=>$modeloGestionSJ,
						'modeloSegAsesoriasSJ'=>$modeloSegAsesoriasSJ,
						'consultaGestionesAdol'=>$consultaGestionesAdol,
						'numDocAdol'=>$numDocAdol,	
						'datosAdol'=>$datosAdol,				
						'edad'=>$edad,
						'consultaGestionAdol'=>$consultaGestionAdol,
						'consultaHistSeg'=>$consultaHistSeg											
					)
				);
			}
			else{
				$this->actionMuestraAsesoriasSJ();
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	/**
	 *	Recibe datos diligenciados en formulario de seguimiento en vista _segGSJForm e instancia a modelo para registrarlo en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoAsesoriasj.
	 *
	 *	@param array $datosInput.
	 *	@param array $modeloSegAsesoriasSJ->attributes.
	 */		
	public function actionRealizarSeguimientoSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="muestraAsesoriasSJ";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloSegAsesoriasSJ=new SeguimientoAsesoriasj();
			$modeloSegAsesoriasSJ->attributes=$datosInput["SeguimientoAsesoriasj"];
			if($modeloSegAsesoriasSJ->validate()){
				$resultado=$modeloSegAsesoriasSJ->registraSegGSJAdol();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloSegAsesoriasSJ);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	}
	/**
	 *	Acción que renderiza el formulario para modificar los datos de contacto registrados en el formulario de gestión sociojurídica.
	 *
	 *	Vista a renderizar:
	 *		- _muestraAsesoriasSJMod.
	 *
	 *	Modelos instanciados:
	 *		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 * 		- GestionSociojuridica.
	 *
	 *	@param	object	$modeloGestionSJ
	 *	@param	array	$consultaGestionesAdolMod
	 *	@param	string	$numDocAdol
	 *	@param	array	$datosAdol				
	 *	@param	int		$edad
	 */		
	public function actionModificarDatosContactoSJForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="modificarDatosContactoSJForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$consultaGestionesAdolMod=$modeloGestionSJ->consultaGestionesSJAdolMod();

			}
			$this->render("_muestraAsesoriasSJMod",array(
				'modeloGestionSJ'=>$modeloGestionSJ,
				'consultaGestionesAdol'=>$consultaGestionesAdolMod,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,				
				'edad'=>$edad,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}	
	}
	/**
	 *	Acción que renderiza el formulario para modificar los datos de contacto registrados en el formulario de gestión sociojurídica.
	 *
	 *	Vista a renderizar:
	 *		- _muestraAsesoriasSJMod.
	 *
	 *	Modelos instanciados:
	 *		- OperacionesGenerales
	 * 		- ConsultasGenerales
	 * 		- SeguimientoAsesoriasj
	 * 		- GestionSociojuridica.
	 *
	 *	@param	object	$modeloGestionSJ
	 *	@param	object	$modeloSegAsesoriasSJ
	 *	@param	string	$numDocAdol
	 *	@param	array	$datosAdol				
	 *	@param	int		$edad
	 *	@param	array	$consultaGestionAdol
	 *	@param	array	$consultaGestionesAdol
	 *	@param	array	$consultaHistSeg
	 */		
	public function actionMuestraFormModGSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="modificarDatosContactoSJForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){		
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloGestionSJ=new GestionSociojuridica();
				$modeloSegAsesoriasSJ=new SeguimientoAsesoriasj();
				$modeloGestionSJ->num_doc=$numDocAdol;
				$modeloGestionSJ->id_gestionsj=$datosInput["id_gestionsj"];
				$consultaGestionAdol=$modeloGestionSJ->consultaGestionSJAdol();
				$consultaHistSeg=$modeloGestionSJ->consultaHistoricoSegGSJAdol();
				$this->render("_modGSJForm",array(
						'modeloGestionSJ'=>$modeloGestionSJ,
						'modeloSegAsesoriasSJ'=>$modeloSegAsesoriasSJ,
						'consultaGestionesAdol'=>$consultaGestionesAdol,
						'numDocAdol'=>$numDocAdol,	
						'datosAdol'=>$datosAdol,				
						'edad'=>$edad,
						'consultaGestionAdol'=>$consultaGestionAdol,
						'consultaHistSeg'=>$consultaHistSeg											
					)
				);
			}
			else{
				$this->actionMuestraFormModGSJ();
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	/**
	 *	Recibe datos diligenciados en formulario de gestión sociojurídica en vista _modGSJForm e instancia a modelo para registrarlo en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- GestionSociojuridica.
	 *
	 *	@param array $datosInput.
	 *	@param array $modeloGestionSJ->attributes.
	 */		
	public function actionModificaRegistroSJ(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="modificarDatosContactoSJForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloGestionSJ=new GestionSociojuridica();
			$modeloGestionSJ->attributes=$datosInput["GestionSociojuridica"];
			
			if($modeloGestionSJ->validate()){
				$modeloGestionSJ->id_gestionsj=$datosInput["GestionSociojuridica"]["id_gestionsj"];
				//echo $modeloGestionSJ->id_gestionsj;
				$resultado=$modeloGestionSJ->registraModGestionSJ();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloGestionSJ);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	public function performAjaxValidation($formId,$model){
		if(isset($_POST['ajax']) && $_POST['ajax']===$formId){
			if(Yii::app()->request->isAjaxRequest){
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
		}
	}

	

	// Uncomment the following methods and override them if needed
	/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}