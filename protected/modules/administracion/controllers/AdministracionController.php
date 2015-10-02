<?php	
Yii::import('application.models.Usuario');	
Yii::import('application.models.Persona');	
Yii::import('application.modules.modIdenReg.models.ForjarAdol');	
class AdministracionController extends Controller{
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(302,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	public function filters(){
		return array('enforcelogin -restablecerClaveForm restablecerClave',array('application.filters.ActionLogFilter - buscaAdolGen restablecerClaveForm restablecerClave','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}
	public function actionCambiarClaveForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="cambiarClaveForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){	
			$modeloUsuario=new Usuario();
			$datosUsuario=$modeloUsuario->consultaUsuarioCedula();
			$this->render('cambiarClaveForm',array('modeloUsuario'=>$modeloUsuario,'datosUsuario'=>$datosUsuario));		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionCambiarClave(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="cambiarClaveForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){	
			$datosInput=Yii::app()->input->post();
			$modeloUsuario=new Usuario();
			$modeloUsuario->attributes=$datosInput["Usuario"];			
			if($modeloUsuario->validate()){
				$modeloOperacionesGenerales=new OperacionesGenerales();
				$modeloUsuario->clave=$modeloOperacionesGenerales->encriptaClaveHMAC($modeloUsuario->clave);
				$resultado=$modeloUsuario->cambiaClave();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado));
			}
			else{
				echo CActiveForm::validate($modeloUsuario);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
/*	public function actionIndex(){
		throw new CHttpException("","Módulo Administración");
		$modeloCForjar=new CentroForjar();
		$contenido=$this->renderPartial("vistaIndex",array('modeloCForjar'=>$modeloCForjar),true);	
		Yii::app()->request->sendFile("test.xls",$contenido);
	}*/
	public function actionConsCreaSede(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consCreaSede";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
		
			$modeloCForjar=new CentroForjar();
			$sedes=$modeloCForjar->consultaSedesCreadas();
			$modeloTelForjar=new TelefonoForjar();
			
			$this->render("_consCreaSedeTab",array('modeloCForjar'=>$modeloCForjar,'sedes'=>$sedes,'modeloTelForjar'=>$modeloTelForjar));	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionCreaSedeForjar(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consCreaSede";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloCForjar=new CentroForjar();
			$sedes=$modeloCForjar->consultaSedes();
			$modeloTelForjar=new TelefonoForjar();
			$datosInput=Yii::app()->input->post();
			$modeloCForjar->attributes=$datosInput["CentroForjar"];
			$modeloTelForjar->attributes=$datosInput["TelefonoForjar"];
			if($modeloCForjar->validate() && $modeloTelForjar->validate()){
				
			}
			else{
				echo CActiveForm::validate(array($modeloCForjar,$modeloTelForjar));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	
	public function actionCambioSedeAdol(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="cambioSedeAdol";
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
				$modeloCForjar=new CentroForjar();
				
				$modeloCambioSede=new CambioSede();
				$modeloDocSoporte=new DocumentoSoporte();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$sedeActual=$consultaGeneral->consultaSedeActual($numDocAdol);
				$sedes=$modeloCForjar->consultaSedes($sedeActual["id_forjar"]);
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$infoSolicitud=$modeloCambioSede->consultaSolCambioSede($numDocAdol);
			}
			$this->render("_cambioSedeForm",
				array(
					'numDocAdol'=>$numDocAdol,
					'modeloCambioSede'=>$modeloCambioSede,
					'modeloDocSoporte'=>$modeloDocSoporte,
					'sedes'=>$sedes,
					'edad'=>$edad,
					'datosAdol'=>$datosAdol,
					'sedeActual'=>$sedeActual,
					'infoSolicitud'=>$infoSolicitud
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	
	public function actionSolicitarCambioSede(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="cambioSedeAdol";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloCambioSede=new CambioSede();
			$modeloDocSoporte=new DocumentoSoporte();
			$datosInput=Yii::app()->input->post();
			//print_r($datosInput);
			$modeloCambioSede->attributes=$datosInput["CambioSede"];
			$modeloDocSoporte->attributes=$datosInput["DocumentoSoporte"];
			//print_r($_POST);
			$file = CUploadedFile::getInstance($modeloDocSoporte,'nombre_doc_ds');
			if($file){
				$modeloDocSoporte->nombre_doc_ds=$file->name;
				
				$modeloDocSoporte->ruta_acceso_ds=Yii::app()->params["subirArchivos"];
			}
			if($file && $modeloCambioSede->validate() && $modeloDocSoporte->validate()){
				
				$rnd = rand(0,999999999);
				$modeloDocSoporte->nombre_doc_ds="{".$rnd."-".date("Y-m-d")."-".$modeloCambioSede->num_doc."}-".$modeloDocSoporte->nombre_doc_ds;
				$modeloDocSoporte->ruta_acceso_ds=Yii::app()->params["subirArchivos"].$modeloDocSoporte->nombre_doc_ds;
				$file->saveAs($modeloDocSoporte->ruta_acceso_ds);
				$msnSolicitud=$modeloCambioSede->registraSolCambioSede($modeloDocSoporte);
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($msnSolicitud))));

			}
			else{
				echo CActiveForm::validate(array($modeloCambioSede,$modeloDocSoporte));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}

	  }
	  
	public function actionResolverSolicitudCambioSede(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="resolverSolicitudCambioSede";
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
				$modeloCForjar=new CentroForjar();
				
				$modeloCambioSede=new CambioSede();
				$modeloCambioSede->num_doc=$numDocAdol;
				$modeloDocSoporte=new DocumentoSoporte();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$sedeActual=$consultaGeneral->consultaSedeActual($numDocAdol);
				$sedes=$modeloCForjar->consultaSedes($sedeActual["id_forjar"]);
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$infoSolicitud=$modeloCambioSede->consultaCambioSede($numDocAdol);
				
			}
			//$modeloDocSoporte->ruta_acceso_ds='{677368164-2015-03-25-1003558897}-ebrcmdr.pdf';
			//echo CHtml::link(CHtml::encode(Yii::app()->params["subirArchivos"]), Yii::app()->params["verArchivos"].$modeloDocSoporte->ruta_acceso_ds,array('target'=>'_blank'))
			$this->render("_resolverSolCambioSede",
				array(
					'numDocAdol'=>$numDocAdol,
					'modeloCambioSede'=>$modeloCambioSede,
					'modeloDocSoporte'=>$modeloDocSoporte,
					'sedes'=>$sedes,
					'edad'=>$edad,
					'datosAdol'=>$datosAdol,
					'sedeActual'=>$sedeActual,
					'infoSolicitud'=>$infoSolicitud
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	public function actionProcedeCambioSede(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="resolverSolicitudCambioSede";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloCambioSede=new CambioSede();
			$modeloDocSoporte=new DocumentoSoporte();
			$datosInput=Yii::app()->input->post();
			$modeloCambioSede->attributes=$datosInput["CambioSede"];
			$modeloDocSoporte->attributes=$datosInput["DocumentoSoporte"];
			$modeloCambioSede->id_cambio_sede=$datosInput["CambioSede"]["id_cambio_sede"];
			if($modeloCambioSede->validate()){				
				$msnRegistro=$modeloCambioSede->registraDecCambioSede();
				echo CJSON::encode(array(
					"estadoComu"=>"exito",
					'resultado'=>CJavaScript::encode(CJavaScript::quote($msnRegistro)),
					'vbno'=>$modeloCambioSede->vbno_coord,
					'numerocarpeta'=>$modeloCambioSede->numeroCarpeta
				));

			}
			else{
				echo CActiveForm::validate($modeloCambioSede);
			}

		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionHabilitarValoracionForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="habilitarValoracionForm";
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
				$modeloJustHabVal=new JustificacionHabVal();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$valoraciones=array(
					array('valoracion'=>'valoracion_psicologia::val_act_psicol::estado_valpsicol::val_hab_ps::id_valoracion_psicol','nombre_valoracion'=>'Valoración Psicología'),
					array('valoracion'=>'valoracion_trabajo_social::val_act_trsoc::estado_val_tsoc::val_hab_ts::id_valtsoc','nombre_valoracion'=>'Valoración Trabajo Social'),
					array('valoracion'=>'valoracion_teo::val_act_to::estado_val_teo::val_hab_ts::id_valor_teo','nombre_valoracion'=>'Valoración Terapia Ocupacional'),
					array('valoracion'=>'valoracion_enfermeria::val_act_enf::estado_venf::val_hab_enf::id_valor_enf','nombre_valoracion'=>'Valoración Enfermería'),
					array('valoracion'=>'valoracion_psiquiatria::val_act_psiq::estado_vpsiq::val_hab_psq::id_val_psiquiatria','nombre_valoracion'=>'Valoración Psiquiatría'),
					array('valoracion'=>'valoracion_nutricional::val_act_nutr::estado_val_nutr::val_hab_nutr::id_val_nutricion','nombre_valoracion'=>'Valoración Nutricional'),

				);
			}
			$this->render("_habilitaValoracion",
				array(
					'valoraciones'=>$valoraciones,
					'modeloJustHabVal'=>$modeloJustHabVal,
					'numDocAdol'=>$numDocAdol,
					'edad'=>$edad,
					'datosAdol'=>$datosAdol,
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');			
		}
	}
	public function actionHabilitarValoracion(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="habilitarValoracionForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloJustHabVal=new JustificacionHabVal();
			$modeloJustHabVal->attributes=$datosInput["JustificacionHabVal"];
			$datosValoracion=split("::",$modeloJustHabVal->valoracion_hab);			
			if($modeloJustHabVal->validate()){
				$modeloJustHabVal->numDoc=$datosInput["JustificacionHabVal"]["numDoc"];
				$mensaje=$modeloJustHabVal->habilitaValoracion($modeloJustHabVal->numDoc,$datosValoracion[0],$datosValoracion[3],$datosValoracion[4]);
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($mensaje))));
			}
			else{
				echo CActiveForm::validate($modeloJustHabVal);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}		
	}
	
	public function actionCargaCedulas(){
		$datosInput=Yii::app()->input->post();
		$consultaGeneral=new ConsultasGenerales();
		$operaciones=new OperacionesGenerales();
		$modeloJustHabVal=new JustificacionHabVal();
		if(!empty($datosInput["valoracion"])){	
			$datosValoracion=split("::",$datosInput["valoracion"]);
			$compruebaHab=$modeloJustHabVal->compruebaValHab($datosInput["num_doc"],$datosValoracion[0],$datosValoracion[1]);
			$nombreSinTildes=$operaciones->quitar_tildes($datosValoracion[0]);
			if(!empty($compruebaHab)){
				if($compruebaHab[$datosValoracion[2]]==1){
					$resultado="habilitada";	
				}
				elseif($compruebaHab[$datosValoracion[2]]==""){
					$resultado="deshabilitada";	
					$consultaProfesionales=$modeloJustHabVal->consultaProfesionales($datosInput["num_doc"],$datosValoracion[0]);
				}
			}
			else{
				$resultado="noexiste";			
			}
		}
		else{
			$resultado="";
		}
		echo CJSON::encode(array("estadoVal"=>CJavaScript::encode(CJavaScript::quote($resultado)),'cedulas'=>$consultaProfesionales,'resultado'=>CJavaScript::encode(CJavaScript::quote($operaciones->quitar_tildes($datosValoracion[0]))),'idvaloracion'=>CJavaScript::encode(CJavaScript::quote($compruebaHab[$datosValoracion[4]]))));		
		
	}
	public function actionTrasladarFuncionarioForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="trasladarFuncionarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){	
			$modeloPersona=new Persona();
			$funcionarios=$modeloPersona->consultaFuncionario();
			$modeloCentroForjar=new CentroForjar();
			$modeloCforjarPersonal=new CforjarPersonal();
			$sedes=$modeloCentroForjar->consultaSedes(Yii::app()->user->getState('sedeForjar'));
	
			$this->render('_trasladoFuncionarioForm',
				array(
					'modeloAsistencia'=>$modeloAsistencia,
					'modeloCforjarPersonal'=>$modeloCforjarPersonal,
					'modeloCentroForjar'=>$modeloCentroForjar,
					'funcionarios'=>$funcionarios,
					'sedes'=>$sedes
				)
			);	
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
		
	}
	
/*	public function validarPrerequisitos(){
		
		$res=$modeloCforjarPersonal->validarAsocAdol();
		//echo CJSON::encode(array("resultado"=>CJavaScript::encode(CJavaScript::quote($datosInput["id_cedula"]))));	
		return true;	
	}
*/	
	public function actionTrasladoFuncionario(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="trasladarFuncionarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){	
			$datosInput=Yii::app()->input->post();
			$modeloCforjarPersonal=new CforjarPersonal();
			$modeloCforjarPersonal->attributes=$datosInput["CforjarPersonal"];
			if($modeloCforjarPersonal->validate()){
				$prereq=$modeloCforjarPersonal->validarAsocAdol();
				if($prereq==0){
					$resultado=$modeloCforjarPersonal->trasladarFuncionario();
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
				}
				else{				
					echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote("novalidado")),'adolsasoc'=>CJavaScript::encode(CJavaScript::quote($prereq))));
				}
			}
			else{
				echo CActiveForm::validate($modeloCforjarPersonal);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	public function actionCrearUsuarioForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="crearUsuarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloConsultaGeneral=new ConsultasGenerales();
			$rol=$modeloConsultaGeneral->consultarRol();
			$modeloUsuario= new Usuario();
			$modeloPersona=new Persona();
			$this->render("_crearUsuarioForm",
				array(
					'modeloUsuario'=>$modeloUsuario,
					'modeloPersona'=>$modeloPersona,
					'rol'=>$rol
				),false,true
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	public function actionCrearUsuario(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="crearUsuarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloUsuario= new Usuario();
			$modeloPersona=new Persona();
			$modeloUsuario->attributes=$dataInput["Usuario"];
			$modeloPersona->attributes=$dataInput["Persona"];
			$modeloUsuario->id_cedula=$modeloPersona->id_cedula;
			$clave=$this->generaCadenaAleatoria();
			$operGenerales=new OperacionesGenerales();
			$modeloUsuario->clave=$operGenerales->encriptaClaveHMAC($clave);				
			$modeloUsuario->pers_habilitado=true;
			if($modeloPersona->validate()&&$modeloUsuario->validate()){	
				$resultado=$modeloPersona->creaPersona($modeloUsuario);
				if($resultado=="exito"){
					try{
						Yii::import('application.extensions.yii-mail-master.YiiMailMessage');
						$message            = new YiiMailMessage;
			   //this points to the file test.php inside the view path
			   			$message->view = "test";
						$params              = array('modeloUsuario'=>$modeloUsuario,'clave'=>$clave);
						$message->subject    = 'Datos Acceso';
						$message->setBody($params, 'text/html');                
						$message->addTo("femauro@gmail.com");
						$message->from = Yii::app()->params['adminEmail'];
						Yii::app()->mail->send($message);   
					}
					catch(Exception $e){
						throw new CHttpException(403,'Los datos no se pudieron enviar al correo, error: '.$e->getMessage());						
					}
				}	
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate(array($modeloPersona,$modeloUsuario));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	public function actionCambiarEstadoFuncionarioForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="cambiarEstadoFuncionarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloUsuario=new Usuario();
			$funcionarios=$modeloUsuario->consultaFuncionario();			
			$this->render("_cambiarEstadoUsuarioForm",
				array(
					'modeloUsuario'=>$modeloUsuario,
					'funcionarios'=>$funcionarios
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
		
	}
	public function actionCambiarEstadoFuncionario(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="cambiarEstadoFuncionarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloUsuario=new Usuario();
			$modeloUsuario->attributes=$datosInput["Usuario"];
			$modeloUsuario->id_rol="0";
			$modeloUsuario->nombre_usuario="default";
			$modeloUsuario->clave="default";
			if($modeloUsuario->validate()){				
				$resultado=$modeloUsuario->cambiarEstadoFuncionario();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloUsuario);				
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
		
	}
	public function actionConsultaEstadoUsuario(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="cambiarEstadoFuncionarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			$modeloUsuario=new Usuario();
			$modeloUsuario->id_cedula=$dataInput["id_cedula"];
			$estadoUsuario=$modeloUsuario->consultaEstadoUsuario();
			if($estadoUsuario["pers_habilitado"]=="t"){
				$estado="habilitado";
			}
			elseif($estadoUsuario["pers_habilitado"]=="f"){
				$estado="deshabilitado";
			}
			else{
				$estado="no definido";
			}
			echo CJSON::encode(array("estadousuario"=>CJavaScript::encode(CJavaScript::quote($estado))));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
		
	}
	public function generaCadenaAleatoria(){
		$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890$%_-/"; //posibles caracteres a usar
		$numerodeletras=10; //numero de letras para generar el texto
		$cadena = ""; //variable para almacenar la cadena generada
		for($i=0;$i<$numerodeletras;$i++){
			$cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
		entre el rango 0 a Numero de letras que tiene la cadena */
		}
		return $cadena;
	}
	public function actionCreaRolForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="creaRolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloRol= new Rol();
			$modeloMenu= new Menu();
			$modeloRolMenu= new RolMenu();
			$menu=$modeloMenu->consultaMenu();
			$nivelMenu=$modeloMenu->consultaNivelMenu();
			$this->render("_creaRolForm",array('modeloMenu'=>$modeloMenu,'modeloRol'=>$modeloRol,'modeloRolMenu'=>$modeloRolMenu,'menu'=>$menu,'nivelMenu'=>$nivelMenu));		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	public function actionCreaRol(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="creaRolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloRol= new Rol();
			$modeloMenu= new Menu();
			$modeloRolMenu= new RolMenu();
			$menu=$modeloMenu->consultaMenu();
			$nivelMenu=$modeloMenu->consultaNivelMenu();
			$dataInput=Yii::app()->input->post();
			if(!empty($dataInput["Menu"])){
				$modeloRolMenu->id_menu="id_aux";
				$modeloRolMenu->id_rol=0;
			}
			$modeloRol->attributes=$dataInput["Rol"];
			if($modeloRol->validate() && $modeloRolMenu->validate()){				
				$modeloRol->menu=$dataInput["Menu"];
				$resultado=$modeloRol->creaRolMenu();				
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));				
			}else{
				echo CActiveForm::validate(array($modeloRol,$modeloRolMenu));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	public function actionAsociarUsuarioSedeForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="asociarUsuarioSedeForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloPersona=new Persona();
			if(!empty($datosInput)){
				$this->render('_asociaUsuarioASedeForm');					
			}
			else{
				$personas=$modeloPersona->consultaPersonas();	
				$this->render('_asociaUsuarioASedeForm',
					array(
						'modeloPersona'=>$modeloPersona,
						'personas'=>$personas
					)
				);	
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	
	public function actionAsociarSedeUsuarioForm(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="asociarSedeUsuarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloPersona=new Persona();
			if(!empty($datosInput["Persona"]["id_cedula"])){
				$modeloCentroForjar=new CentroForjar();
				$sedesForjar=$modeloCentroForjar->consultaSedesCreadas();
				$modeloCForjarPersonal=new CforjarPersonal();
				$modeloCForjarPersonal->id_cedula=$datosInput["Persona"]["id_cedula"];
				$modeloPersona->id_cedula=$datosInput["Persona"]["id_cedula"];
				$sedesForjarUsuario=$modeloCForjarPersonal->consultarSedeFuncionario();
				$persona=$modeloPersona->consultaPersona();				
				$this->render('_asociaSedeAUsuarioForm',array(
						'modeloPersona'=>$modeloPersona,
						'modeloCForjarPersonal'=>$modeloCForjarPersonal,
						'persona'=>$persona,
						'id_cedula'=>$modeloPersona->id_cedula,
						'sedesForjarUsuario'=>$sedesForjarUsuario,
						'sedesForjar'=>$sedesForjar
					));					
			}
			else{
				$personas=$modeloPersona->consultaPersonas();	
				$this->render('_asociaSedeAUsuarioForm',
					array(
						'modeloPersona'=>$modeloPersona,
						'personas'=>$personas,
						'sedesForjar'=>$sedesForjar
					)
				);	
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	public function actionAsociarSedeUsuario(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="asociarSedeUsuarioForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloCForjarPersonal=new CforjarPersonal();
			$modeloCForjarPersonal->id_cedula=$datosInput["CforjarPersonal"]["id_cedula"];
			if(!empty($datosInput["CforjarPersonal"]["id_forjar"])){
				$modeloCForjarPersonal->id_forjar="aux";
			}
			if($modeloCForjarPersonal->validate()){
				$modeloCForjarPersonal->id_forjar=$datosInput["CforjarPersonal"]["id_forjar"];
				$resultado=$modeloCForjarPersonal->asociarSedeAUsuario();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));				
			}
			else{
				echo CActiveForm::validate($modeloCForjarPersonal);
			}			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}		
	}
	
	public function actionCreaAreaInteresForm(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="creaAreaInteresForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloAreaInscripcion=new AreaInscripcion();
			$modeloAreainscrCforjar=new AreainscrCforjar();
			$modeloCentroForjar=new CentroForjar();
			$sedesForjar=$modeloCentroForjar->consultaSedesCreadas();
			$this->render("_creaAreaInteresForm",array(
					'modeloAreaInscripcion'=>$modeloAreaInscripcion,
					'modeloAreainscrCforjar'=>$modeloAreainscrCforjar,
					'sedesForjar'=>$sedesForjar,
					'label'=>'Área de interés',
					'areaInscripcion'=>1
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	public function actionCreaDeporteForm(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="creaDeporteForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloAreaInscripcion=new AreaInscripcion();
			$modeloAreainscrCforjar=new AreainscrCforjar();
			$modeloCentroForjar=new CentroForjar();
			$sedesForjar=$modeloCentroForjar->consultaSedesCreadas();
			$this->render("_creaAreaInteresForm",array(
					'modeloAreaInscripcion'=>$modeloAreaInscripcion,
					'modeloAreainscrCforjar'=>$modeloAreainscrCforjar,
					'sedesForjar'=>$sedesForjar,
					'label'=>'Deporte',
					'areaInscripcion'=>2
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	
	public function actionCreaAreaInteresDeportes(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="creaAreaInteresForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloAreaInscripcion=new AreaInscripcion();
			$modeloAreainscrCforjar=new AreainscrCforjar();
			$modeloAreaInscripcion->attributes=$datosInput["AreaInscripcion"];
			$modeloAreainscrCforjar->attributes=$datosInput["AreainscrCforjar"];
			if(!empty($datosInput["AreainscrCforjar"]["id_forjar"])){
				$modeloAreainscrCforjar->id_forjar="aux";
			}			
			if($modeloAreaInscripcion->validate() && $modeloAreainscrCforjar->validate()){
				$modeloAreainscrCforjar->id_forjar=$datosInput["AreainscrCforjar"]["id_forjar"];
				$resultado=$modeloAreaInscripcion->creaAreaInteres();
				if($resultado=="exito"){
					$modeloAreainscrCforjar->id_areainteres=$modeloAreaInscripcion->id_areainteres;
					$resultado=$modeloAreainscrCforjar->asociaAIntForjar();
				}
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));				
			}
			else{
				echo CActiveForm::validate(array($modeloAreaInscripcion,$modeloAreainscrCforjar));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}

	public function actionCreaDelitoForm(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="creaDelitoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloDelitoRemCespa=new DelitoRemCespa();			
			$this->render("_creaDelitoForm",array(
					'modeloDelitoRemCespa'=>$modeloDelitoRemCespa,					
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}


	public function actionCreaDelito(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="creaDelitoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();			
			$modeloDelitoRemCespa=new DelitoRemCespa();
			$modeloDelitoRemCespa->attributes=$datosInput["DelitoRemCespa"];			
			if($modeloDelitoRemCespa->validate()){
				$resultado=$modeloDelitoRemCespa->creaDelito();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));				
			}
			else{
				echo CActiveForm::validate($modeloDelitoRemCespa);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	//activar caso adolescente
	
	public function actionActivarCasoAdolForm(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="activarCasoAdolForm";
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
				$modeloForjarAdol=new ForjarAdol();
				$modeloForjarAdol->num_doc=$numDocAdol;
				$datosForjarAdol=$modeloForjarAdol->consultaDatosForjarAdol();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);
				$operaciones=new OperacionesGenerales();
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			}
			$this->render("_activarCasoAdolForm",array(
				'modeloForjarAdol'=>$modeloForjarAdol,
				'numDocAdol'=>$numDocAdol,
				'edad'=>$edad,
				'datosAdol'=>$datosAdol,
				'datosForjarAdol'=>$datosForjarAdol		
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	public function actionActivarCasoAdol(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="activarCasoAdolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();			
			$modeloForjarAdol=new ForjarAdol();			
			$modeloForjarAdol->attributes=$datosInput["ForjarAdol"];			
			if($modeloForjarAdol->validate()){
				$resultado=$modeloForjarAdol->cambiaEstadoAdol();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));				
			}
			else{
				echo CActiveForm::validate($modeloDelitoRemCespa);
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	//asociación de contrato
	public function actionAsociarContratoForm(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="asociarContratoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloPersona=new Persona();
			$funcionarios=$modeloPersona->consultaFuncionario();
			$modeloDatosContrato=new DatosContrato();
			$this->render("_asociarContratoForm",array(
				'modeloPersona'=>$modeloPersona,
				'modeloDatosContrato'=>$modeloDatosContrato,
				'funcionarios'=>$funcionarios,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	public function actionAsociarContratoFuncionario(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="asociarContratoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloDatosContrato=new DatosContrato();
			$modeloDatosContrato->attributes=$datosInput["DatosContrato"];
			if($modeloDatosContrato->validate()){
				$resultado=$modeloDatosContrato->registraContratoFuncionario();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));				
			}
			else{
				echo CActiveForm::validate($modeloDatosContrato);
			}			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	public function actionModificarContratoForm(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="modificarContratoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloPersona=new Persona();
			$funcionarios=$modeloPersona->consultaFuncionario();
			$modeloDatosContrato=new DatosContrato();
			$this->render("_modificarContratoForm",array(
				'modeloPersona'=>$modeloPersona,
				'modeloDatosContrato'=>$modeloDatosContrato,
				'funcionarios'=>$funcionarios,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	public function actionConsultaContrato(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="modificarContratoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			//print_r($datosInput);
			if(!empty($datosInput["idCedula"])){
				$modeloDatosContrato=new DatosContrato();
				$modeloDatosContrato->id_cedula=$datosInput["idCedula"];
				$contratoActual=$modeloDatosContrato->consultaContratoAct();
				if(empty($contratoActual)){
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>"nocontrato"));				
				}
				elseif($modeloDatosContrato->contrato_actual=='false'){
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>"vencido"));				
				}
				else{
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$contratoActual));				
				}
			}
			else{
				echo CJSON::encode(array("estadoComu"=>"nodatos"));	
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	public function actionModificarContratoFuncionario(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="modificarContratoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloDatosContrato=new DatosContrato();
			$modeloDatosContrato->attributes=$datosInput["DatosContrato"];
			if($modeloDatosContrato->validate()){				
				$contratoActual=$modeloDatosContrato->consultaContratoAct();
				if(empty($contratoActual)){
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>"nocontrato"));				
				}
				elseif($modeloDatosContrato->contrato_actual=='false'){
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>"vencido"));				
				}
				else{
					$resultado=$modeloDatosContrato->modificaContratoAct();
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));				
				}

				//$resultado=$modeloDatosContrato->registraContratoFuncionario();
			}
			else{
				echo CActiveForm::validate($modeloDatosContrato);
			}			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}

	public function actionCrearExtContratoForm(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="crearExtContratoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloPersona=new Persona();
			$funcionarios=$modeloPersona->consultaFuncionario();
			$modeloDatosContrato=new DatosContrato();
			$this->render("_crearExtContratoForm",array(
				'modeloPersona'=>$modeloPersona,
				'modeloDatosContrato'=>$modeloDatosContrato,
				'funcionarios'=>$funcionarios,
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	public function actionConsultaContratoExt(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="crearExtContratoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			//print_r($datosInput);
			if(!empty($datosInput["idCedula"])){
				$modeloDatosContrato=new DatosContrato();
				$modeloDatosContrato->id_cedula=$datosInput["idCedula"];
				$contratoActual=$modeloDatosContrato->consultaContratoAct();
				if(empty($contratoActual)){
					$contratoExt=$modeloDatosContrato->consUltimoContrato();
					if(empty($contratoExt)){									
						echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>"nocontrato"));				
					}
					else{
						echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$contratoExt));				
					}
				}
				else{
					echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$contratoActual));				
				}
				
			}
			else{
				echo CJSON::encode(array("estadoComu"=>"nodatos"));	
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	public function actionRealizaExtContratoFuncionario(){
		$controlAcceso=new ControlAcceso();		
		$controlAcceso->accion="crearExtContratoForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloDatosContrato=new DatosContrato();
			$modeloDatosContrato->attributes=$datosInput["DatosContrato"];
			if($modeloDatosContrato->validate()){
				$modeloDatosContrato->fecha_extension=$datosInput["DatosContrato"]["fecha_extension"];	
				$modeloDatosContrato->contrato_actual='true';
				$resultado=$modeloDatosContrato->registraExtContrato();
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>$resultado));	
			}
			else{
				echo CActiveForm::validate($modeloDatosContrato);
			}			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');						
		}
	}
	
	public function actionRestablecerClaveForm(){
			$modeloUsuario=new Usuario();
			$datosUsuario=$modeloUsuario->consultaUsuarioCedula();
			$this->render('_restablecerClaveForm',array('modeloUsuario'=>$modeloUsuario,'datosUsuario'=>$datosUsuario));		
	}
	
	public function actionRestablecerClave(){
		$datosInput=Yii::app()->input->post();
		$modeloUsuario=new Usuario();
		$modeloUsuario->attributes=$datosInput["Usuario"];			
		if($modeloUsuario->validate()){
			$modeloPersona=new Persona();
			$modeloPersona->correo_electronico=$modeloUsuario->consultaCorreoFuncionario();
			if(!empty($modeloPersona->correo_electronico)){
				$cadenaAleatoria=$this->generaCadenaAleatoria();
				$modeloOperacionesGenerales=new OperacionesGenerales();
				$modeloUsuario->clave=$modeloOperacionesGenerales->encriptaClaveHMAC($cadenaAleatoria);
				$resultado=$modeloUsuario->restablecerClave();
				if($resultado=="exito"){	
					$cuerpoCorreo=split("@",$modeloPersona->correo_electronico);
					$correoOculto="";
					$correoSplit=str_split($modeloPersona->correo_electronico);
					for($i=0;$i<count(str_split($cuerpoCorreo[0]));$i++){
						if($i<2){
							$correoOculto.=$correoSplit[$i];
						}
						else{
							$correoOculto.="*";							
						}
					}
					$correoOculto.="@".$cuerpoCorreo[1];
					try{
						Yii::import('application.extensions.yii-mail-master.YiiMailMessage');
						$message            = new YiiMailMessage;
			   //this points to the file test.php inside the view path
						$message->view = "test";
						$params              = array('modeloUsuario'=>$modeloUsuario,'clave'=>$cadenaAleatoria);
						$message->subject    = 'Datos Acceso';
						$message->setBody($params, 'text/html');                
						$message->addTo($modeloPersona->correo_electronico);
						$message->from = Yii::app()->params['adminEmail'];
						Yii::app()->mail->send($message);   
					}
					catch(Exception $e){
						echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$e->getMessage()));
					}
				}
			}			
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado,'correo'=>$correoOculto));
		}
		else{
			echo CActiveForm::validate($modeloUsuario);
		}
	}
	//
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

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
	
	$contenidoArchivo=array();
		$chunksize = 5 * (1024 * 1024);
		$filename=Yii::app()->params["subirArchivos"]."bla.txt";
		$handle = fopen($filename, 'rb'); 

        while (!feof($handle))
        { 
          $contenidoArchivo[]=@fread($handle,$chunksize);

          ob_flush();
          flush();
        } 

        fclose($handle);
	*/
}
?>