<?php
///!  Clase controlador del módulo Identificación y registro.  
/**
 * @author Félix Mauricio Vargas Hincapié <femauro@gmail.com>
 * @copyright Copyright &copy; Félix Mauricio Vargas Hincapié 2015
 */

class IdentificacionRegistroController extends Controller
{
	public $_formAdol; /**< ## */
	
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
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}
	
	/**
	 * renderiza vista index
	 */
	public function actionIndex(){
		$this->render('index');
	}
	/**
	 *	Acción que renderiza la vista que contiene los formularios para registrar los datos básicos del adolescente.
	 *
	 *	Vista a renderizar:
	 *		- registrarDatos.
	 *
	 *	Formularios contenidos:
	 *		- _formAdolescente				formulario de datos básicos del adolescente
	 *		- _formLocalizacion				formulario par diligenciar datos de localización
	 *		- _formVerificacionDerCespa 	formulario para diligenciar la verificación de derechos enviada por el defensor de familia
	 *		- _formAdolDocsCespa			formulario para hacer check de los documentos enviados por el cespa
	 *		- _formAcudiente				formulario para diligenciar datos básicos del acudiente.
	 *
	 *	Modelos instanciados:
	 *		- Adolescente
	 * 		- LocalizacionViv
	 * 		- DerechoAdol
	 * 		- Telefono
	 * 		- DocumentoCespa
	 * 		- Familiar
	 * 		- ConsultasGenerales.
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param int $tipoDocBd,
	 *	@param array $departamento,
	 *	@param array $sexo,
	 *	@param array $etnia,
	 *	@param array $psicologo,
	 *	@param array $trabSocial,
	 *	@param array $modeloLocalizacion,
	 *	@param array $localidad,
	 *	@param array $estrato,
	 *	@param object $modeloTelefono,
	 *	@param object array $modeloDocCespa,
	 *	@param object $docsCespa,
	 *	@param object $modeloAcudiente,
	 *	@param array $parentesco,
	 *	@param object $modeloVerifDerechos,
	 *	@param array $derechos,
	 *	@param array $participacion,
	 *	@param array $proteccion,					
	 */		
	public function actionCreaRegAdolForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="creaRegAdolForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			if(Yii::app()->getSession()->get('numDocAdol')){
				Yii::app()->getSession()->remove('numDocAdol');		
			}
			$formAdol=new Adolescente();
			$modeloLocalizacion=new LocalizacionViv();
			$modeloVerifDerechos=new DerechoAdol();
			$modeloTelefono=new Telefono();
			$modeloDocCespa=new DocumentoCespa();
			$modeloAcudiente=new Familiar();
			//clase para realizar consultas a entidades generales.  Pej: tipo de documento
			$consGen=new ConsultasGenerales();	
			//Consulta para tipo de documento
			$tipoDocBd=$consGen->consultaTipoDocumento();
			//Consulta para departamento
			$departamento=$consGen->consultaDepartamento();
			//Consulta sexo
			$sexo=$consGen->consultaSexo();
			//consulta etnia
			$etnia=$consGen->consultaEtnia();
			//consulta localidad
			$localidad=$consGen->consultaLocalidad();
			//consulta estrato
			$estrato=$consGen->consultaEstrato();
			//Consulta psicologo y trabajador social
			$psicologo=$consGen->consultaProfesional(4);
			$trabSocial=$consGen->consultaProfesional(5);
			//consulta documentos remitidos
			$docsCespa=$consGen->consultaDocCespa();
			//Consulta parentesco
			$parentesco=$consGen->consultaParentesco();
			//Consulta derechos
			$derechos=$consGen->consultaDerechos();
			//consulta Participación
			$participacion=$consGen->consultaParticipacion();
			//consulta Protección
			$proteccion=$consGen->consultaProteccion();
			$this->render('registrarDatos',
				array('formAdol'=>$formAdol,
					'modeloInfJudAdmon'=>$modeloInfJudAdmon,
					'tipoDocBd'=>$tipoDocBd,
					'departamento'=>$departamento,
					'sexo'=>$sexo,
					'etnia'=>$etnia,
					'psicologo'=>$psicologo,
					'trabSocial'=>$trabSocial,
					'modeloLocalizacion'=>$modeloLocalizacion,
					'localidad'=>$localidad,
					'estrato'=>$estrato,
					'modeloTelefono'=>$modeloTelefono,
					'modeloDocCespa'=>$modeloDocCespa,
					'docsCespa'=>$docsCespa,
					'modeloAcudiente'=>$modeloAcudiente,
					'parentesco'=>$parentesco,
					'modeloVerifDerechos'=>$modeloVerifDerechos,
					'derechos'=>$derechos,
					'participacion'=>$participacion,
					'proteccion'=>$proteccion,
					'numDocAdol'=>''
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}	

	/**
	 *	Recibe datos del formulario de registro del adolescente e instancia a modelo para registrar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- Adolescente
	 *
	 *	@param array $_POST["Adolescente"] array de datos del formulario de datos básicos del adolescente
	 *	@param int $formPr->numeroCarpeta número de carpeta asignada por el sistema
	 *	@param string $formPr->mensajeErrorProf mensaje de error si hay inconvenientes en el registro del equipo piscosocial asignado al adolescente.
	 *	@param string $formPr->mensajeError mensaje de error si hay algún problema en el registro de datos básicos del adolescente.
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaRegAdol(){		
		$formPr=new Adolescente();             
		//$this->performAjaxValidation($formPr);  
		$formPr->mensajeErrorProf="";
		if(isset($_POST["Adolescente"])){
			$datosInput=Yii::app()->input->post();
			$formPr->attributes=$_POST["Adolescente"];
			//$valido=$formPr->validate();   
			if($formPr->validate()){
				$formPr->sedeForjar=Yii::app()->user->getState('sedeForjar');
				//print_r($formPr->attributes);
				$resultado=$formPr->creaRegistroAdol();
				if(isset($formPr->psicologos) && !empty($formPr->psicologos) && isset($formPr->trabSocials) && !empty($formPr->trabSocials)){
					$respPsicol=false;
					$respTrabSocial=false;
					($formPr->responsableAdol==1)?$respPsicol=true:$respTrabSocial=true;
					$formPr->registraEquipoPsic($formPr->psicologos,$respPsicol);
					$formPr->registraEquipoPsic($formPr->trabSocials,$respTrabSocial);
				}
				echo CJSON::encode(array("estadoComu"=>"exito",
				'resultado'=>CJavaScript::encode($resultado),
				'msnError'=>CJavaScript::encode($formPr->mensajeError),
				'msnErrorProf'=>CJavaScript::encode($formPr->mensajeErrorProf),
				'num_carpeta'=>CJavaScript::encode($formPr->numeroCarpeta)));
			}else{
				echo CActiveForm::validate($formPr);
			}
		}
	}
	/**
	 *	Recibe datos del formulario de localización del adolescente e instancia a modelo para registrar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- LocalizacionViv
	 *		- Telefono.
	 *
	 *	@param string $modeloLocAdol->mensajeErrorLoc mensaje de error si hay inconveniente en el registro localización del adolescente.
	 *	@param string $modeloTelAdol->mensajeErrorTel mensaje de error si hay inconveniente en el registro de teléfonos del adolescente. 
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaLocAdol(){
		$resultado='';
		$modeloLocAdol=new LocalizacionViv();
		$modeloTelAdol=new Telefono();
		if(isset($_POST["LocalizacionViv"]) && isset($_POST["Telefono"])){
			$modeloLocAdol->attributes=$_POST["LocalizacionViv"];
			$modeloTelAdol->attributes=$_POST["Telefono"];
			if($modeloLocAdol->validate() && $modeloTelAdol->validate()){
				if($modeloLocAdol->registraLocAdol()){
					$resultado='exito';
					$modeloTelAdol->num_doc=$modeloLocAdol->num_doc;
					if(!empty($modeloTelAdol->telefono)){$modeloTelAdol->registraTelefono(1,$modeloTelAdol->telefono);}
					if(!empty($modeloTelAdol->tel_sec)){$modeloTelAdol->registraTelefono(2,$modeloTelAdol->tel_sec);
						$modeloTelAdol->mensajeErrorTel.=$modeloTelAdol->mensajeErrorTel;}
					if(!empty($modeloTelAdol->celular)){$modeloTelAdol->registraTelefono(3,$modeloTelAdol->celular);
						$modeloTelAdol->mensajeErrorTel.=$modeloTelAdol->mensajeErrorTel;}
				}
				$modeloTelAdol->mensajeErrorTel="exito";
				echo CJSON::encode(array("estadoComu"=>"exito",
				'resultado'=>$resultado,
				'msnError'=>CJavaScript::encode($modeloLocAdol->mensajeErrorLoc),
				'msnErrorTel'=>CJavaScript::encode($modeloTelAdol->mensajeErrorTel)));
			}
			else{
				echo CActiveForm::validate(array($modeloLocAdol,$modeloTelAdol));
			}
		}
		else{
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>'error','msnError'=>'Ha habido un error en el envío del formulario, comuníquese con el área encargada del Sistema de información'));
		}
	}
	/**
	 *	Recibe datos del formulario de datos básicos del acudiente e instancia a modelo para registrar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- Familiar
	 *		- LocalizacionViv.
	 *		- Telefono.
	 *
	 *	@param string $modeloAcudiente->mensajeErrorAcud mensaje de error si hay inconveniente en el registro datos del acudiente.
	 *	@param string $modeloTelefono->mensajeErrorTel mensaje de error si hay inconveniente en el registro de teléfonos del acudiente. 
	 *	@param string $modeloLocalizacion->mensajeErrorLocAcud mensaje de error si hay inconveniente en el localización datos del acudiente. 
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaRegAcudiente(){
		$resultado='';
		$modeloAcudiente=new Familiar();
		$modeloLocalizacion=new LocalizacionViv();
		$modeloTelefono=new Telefono();
		if(isset($_POST["Familiar"]) && isset($_POST["LocalizacionViv"]) && isset($_POST["Telefono"]) ){
			$modeloAcudiente->attributes=$_POST["Familiar"];
			$modeloLocalizacion->attributes=$_POST["LocalizacionViv"];
			$modeloTelefono->attributes=$_POST["Telefono"];
			if($modeloAcudiente->validate() && $modeloLocalizacion->validate() && $modeloTelefono->validate()){
				$modeloAcudiente->num_docAdolFam=$modeloLocalizacion->num_doc;
				if($modeloAcudiente->registraAcudiente()){
					$resultado='exito';
					$modeloLocalizacion->id_doc_familiar=$modeloAcudiente->id_doc_familiar;
					$modeloTelefono->id_doc_familiar=$modeloAcudiente->id_doc_familiar;
					$modeloLocalizacion->registraLocAcudiente();
					if(!empty($modeloTelefono->telefono)){$modeloTelefono->registraTelefonoAcud(1,$modeloTelefono->telefono);}
					if(!empty($modeloTelefono->tel_sec)){$modeloTelefono->registraTelefonoAcud(2,$modeloTelefono->tel_sec);
						$modeloTelefono->mensajeErrorTel.=$modeloTelefono->mensajeErrorTel;}
					if(!empty($modeloTelefono->celular)){$modeloTelefono->registraTelefonoAcud(3,$modeloTelefono->celular);
						$modeloTelefono->mensajeErrorTel.=$modeloTelefono->mensajeErrorTel;}
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado,'msnError'=>$modeloAcudiente->mensajeErrorAcud,'mensajeErrorTel'=>$modeloTelefono->mensajeErrorTel,'mensajeErrorLocAcud'=>$modeloLocalizacion->mensajeErrorLocAcud));
			}else{
				echo CActiveForm::validate(array($modeloAcudiente,$modeloLocalizacion,$modeloTelefono));
			}
		}
		else{
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>'error','msnError'=>'Ha habido un error en el envío del formulario, comuníquese con el área encargada del Sistema de información'));
		}
	}
	/**
	 *	Recibe datos del formulario de verificación de derechos remitidos por el defensor de familia e instancia a modelo para registrar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- DerechoAdol
	 *
	 *	@param string $modeloVerifDerechos->msnErrorDerecho.
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaVerifDerAdol(){
		$modeloVerifDerechos=new DerechoAdol();
		$this->performAjaxValidation('formularioVerifDer',$modeloVerifDerechos);
		
		if(isset($_POST["DerechoAdol"]) && !empty($_POST["DerechoAdol"])){  
			$modeloVerifDerechos->attributes=$_POST["DerechoAdol"];
			if($modeloVerifDerechos->validate()){
				$modeloVerifDerechos->atributos=$_POST["DerechoAdol"];
				$resultado=$modeloVerifDerechos->registraDerechos();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>'exito','msnError'=>$modeloVerifDerechos->msnErrorDerecho));
			}
			else{
				echo CActiveForm::validate($modeloVerifDerechos);
			}
		}
		
	}
	/**
	 *	Recibe datos del formulario de documentos remitidos por el CESPA e instancia a modelo para registrar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- DocumentoCespa
	 *
	 *	@param string $modeloVerifDerechos->msnErrorDerecho.
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaRegDocCespa(){
		$modeloDocCespa=new DocumentoCespa();
		//$this->performAjaxValidationDocs($modeloDocCespa);  
		if(isset($_POST["DocumentoCespa"])){
			$modeloDocCespa->attributes=$_POST["DocumentoCespa"];
			//$valido=$modeloDocCespa->validate();   
			if($modeloDocCespa->validate()){
				//echo $modeloDocCespa->numDocAdol;
				$modDocsRevision=$modeloDocCespa->findAllBySql("select * from documento_cespa order by id_doccespa asc");
				foreach($modDocsRevision as $documentoRevision){
					$presentado=false;
					foreach($modeloDocCespa->id_doccespa as $docRemitido){
						if($docRemitido==$documentoRevision->id_doccespa){
							$presentado=true;
						}
					}
					$modeloDocCespa->registraDocAdol($presentado,$documentoRevision->id_doccespa);
					$presentado=false;
				}
				(empty($modeloDocCespa->mensajeErrorDocAdol))?$resultado="exito":$resultado="exito";
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>"exito",'msnError'=>$modeloDocCespa->mensajeErrorDocAdol));
			}else{
				echo CActiveForm::validate($modeloDocCespa);
			}
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
	
	
	/**
	 *	llamada de ajax, consulta listado de departamentos
	 *
	 *	Modelos instanciados:
	 *		- ConsultasGenerales
	 *
	 *	@return CHtml::tag listado de municipios.
	 */		
	public function actionConsDepto(){
		if(isset($_POST["id_deptoNacimiento"]) && !empty($_POST["id_deptoNacimiento"])){
			$consGen=new ConsultasGenerales();
			$consMunicipio=$consGen->consultaMunicipio(CHtml::encode($_POST["id_deptoNacimiento"]));
			echo CHtml::tag('option',array('value'=>''),CHtml::encode('Seleccione un Municipio'),true);
			foreach($consMunicipio as $municipio){
				echo CHtml::tag('option',array('value'=>$municipio["id_municipio"]),CHtml::encode($municipio["municipio"]),true);
    		}
		}
	}
	
	/**
	 *	Acción que renderiza la vista que contiene el formulario para diligenciar la información judicial administrativa.
	 *
	 *	Vista a renderizar:
	 *		- _formRegInfJudicialAdmtva.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 * 		- ForjarAdol
	 * 		- Telefono
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param object $modeloDatosForjarAdol,
	 *	@param string $numDocAdol,
	 *	@param array $instanciaRem,
	 *	@param array $delito,
	 *	@param array $estadoProceso,
	 *	@param array $datosAdol,
	 *	@param int $edad,
	 *	@param array $telefono,
	 */		
	public function actionCreaRegInfJudicialAdmtvaForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="creaRegInfJudicialAdmtvaForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloInfJudAdmon=new InformacionJudicial();
			$modeloDatosForjarAdol=new ForjarAdol();
			$modeloDatosTelefono=new Telefono();
			$consGen=new ConsultasGenerales();	
			$operaciones=new OperacionesGenerales();
			$datosAdol="";
			$edad="";
			$telefono="";
			if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
				$numDocAdol=htmlspecialchars(strip_tags(trim($_POST["numDocAdol"])));
				Yii::app()->getSession()->add('numDocAdol',htmlspecialchars(strip_tags(trim($_POST["numDocAdol"]))));
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$datosAdol=$consGen->consultaDatosAdol($numDocAdol);
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);
				$modeloDatosForjarAdol->num_doc=$numDocAdol;
				$modeloDatosForjarAdol->attributes=$modeloDatosForjarAdol->consultaDatosForjarAdol();			
			}
			
			//consulta Instancia remisora
			$instanciaRem=$consGen->consutlaInstanciaRem();
			//consulta delitos
			$delito=$consGen->consutlaDelito();
			//consulta estado del proceso
			$estadoProceso=$consGen->consutlaEstadoProceso();
			//consulta sanción
			//$sancion=$consGen->consutlaSancion();
			$this->render('_formRegInfJudicialAdmtva',
				array(
					'modeloInfJudAdmon'=>$modeloInfJudAdmon,
					'modeloDatosForjarAdol'=>$modeloDatosForjarAdol,
					'numDocAdol'=>$numDocAdol,
					'instanciaRem'=>$instanciaRem,
					'delito'=>$delito,
					'estadoProceso'=>$estadoProceso,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
		
	}	
	/**
	 *	Recibe datos del formulario de información judicial administrativa e instancia a modelo para registrar en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 *		- ForjarAdol
	 *
	 *	@param arrya $dataClean $_POST	de datos del formulario de información judicial administrativa.
	 *	@param string $modeloInfJudAdmon->mensajeErrorInfJud.
	 *	@return json resultado de la transacción.
	 */		
	public function actionCreaRegInfJudAdmon(){	
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="creaRegInfJudicialAdmtvaForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){		
			$modeloInfJudAdmon=new InformacionJudicial(); 
			$modeloDatosForjarAdol=new ForjarAdol();
			  
			//$this->performAjaxValidation($modeloInfJudAdmon);  
			if(isset($_POST["InformacionJudicial"]) && isset($_POST["ForjarAdol"])){
				$dataClean=Yii::app()->input->post();
				$modeloInfJudAdmon->attributes=$dataClean["InformacionJudicial"];
				$modeloDatosForjarAdol->attributes=$dataClean["ForjarAdol"];
				if($modeloInfJudAdmon->validate() && $modeloDatosForjarAdol->validate()){
					$modeloInfJudAdmon->novedad_infjud='false';
					$resultado=$modeloInfJudAdmon->registraInfJudAdminAdol();
					$resultado=$modeloDatosForjarAdol->actualizaDatosForjarAdol();
					echo CJSON::encode(array("estadoComu"=>"exito",
					'resultado'=>$resultado,
					'msnError'=>CJavaScript::encode(CJavaScript::quote($modeloInfJudAdmon->mensajeErrorInfJud))));
				}else{
					echo CActiveForm::validate(array($modeloInfJudAdmon,$modeloDatosForjarAdol));
				}
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista que contiene realiza consulta y listado de las o la información judicial impuesta al adolescente para seleccionar y realizar modificaciones.
	 *
	 *	Vista a renderizar:
	 *		- _consultaInfJudAdmon.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 * 		- ForjarAdol
	 * 		- Telefono
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param object $modeloDatosForjarAdol,
	 *	@param string $numDocAdol,
	 *	@param array $infJudicial, listado de informaciones judiciales registradas en el proceso actual del adolescente, es decir respecto al pai actual.
	 *	@param array $delito,
	 *	@param array $estadoProceso,
	 *	@param array $datosAdol,
	 *	@param int $edad,
	 *	@param array $telefono,
	 */		
	public function actionModRegInfJudicialAdmtvaForm(){
		$modeloInfJudAdmon=new InformacionJudicial();
		$modeloDatosForjarAdol=new ForjarAdol();
		$modeloDatosTelefono=new Telefono();
		$consGen=new ConsultasGenerales();	
		$operaciones=new OperacionesGenerales();
		$datosAdol="";
		$edad="";
		$telefono="";
		$dataInput=Yii::app()->input->post();
		if(isset($dataInput["offset"]) && !empty($dataInput["offset"])){
			$offset=$dataInput["offset"];
		}
		else{
			$offset=0;
		}
		if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
			$numDocAdol=htmlspecialchars(strip_tags(trim($_POST["numDocAdol"])));
			Yii::app()->getSession()->add('numDocAdol',htmlspecialchars(strip_tags(trim($_POST["numDocAdol"]))));
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		if(!empty($numDocAdol)){
			
			$datosAdol=$consGen->consultaDatosAdol($numDocAdol);
			$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);
			$modeloInfJudAdmon->num_doc=$numDocAdol;
			$infJudicial=$modeloInfJudAdmon->consultaInfJudOffset($offset);
			if(!empty($infJudicial)){
				foreach($infJudicial as $pk=>$infJudicialNov){
					$infJud=$modeloInfJudAdmon->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
					if(!empty($infJud)){
						$infJudicial[$pk]=$infJud;
					}			
				}
			}
		}
		//consulta Instancia remisora
		$instanciaRem=$consGen->consutlaInstanciaRem();
		//consulta delitos
		$delito=$consGen->consutlaDelito();
		//consulta estado del proceso
		$estadoProceso=$consGen->consutlaEstadoProceso();
		//consulta sanción
		//$sancion=$consGen->consutlaSancion();
		$this->render('_consultaInfJudAdmon',
			array(
				'modeloInfJudAdmon'=>$modeloInfJudAdmon,
				'modeloDatosForjarAdol'=>$modeloDatosForjarAdol,
				'numDocAdol'=>$numDocAdol,
				'instanciaRem'=>$instanciaRem,
				'delito'=>$delito,
				'estadoProceso'=>$estadoProceso,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'telefono'=>$telefono,
				'accion'=>'modificar',
				'infJudicial'=>$infJudicial,
				'offset'=>$offset
			)
		);		
	}
	/**
	 *	Acción que renderiza la vista que contiene realiza consulta y listado de las o la información judicial impuesta al adolescente para seleccionar y registrar novedades.
	 *
	 *	Vista a renderizar:
	 *		- _consultaInfJudAdmon.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 * 		- ForjarAdol
	 * 		- Telefono
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param object $modeloDatosForjarAdol,
	 *	@param string $numDocAdol,
	 *	@param array $infJudicial, listado de informaciones judiciales registradas en el proceso actual del adolescente, es decir respecto al pai actual.
	 *	@param array $delito,
	 *	@param array $estadoProceso,
	 *	@param array $datosAdol,
	 *	@param int $edad,
	 *	@param array $telefono,
	 */		
	public function actionNovRegInfJudicialAdmtvaForm(){
		$modeloInfJudAdmon=new InformacionJudicial();
		$modeloDatosForjarAdol=new ForjarAdol();
		$modeloDatosTelefono=new Telefono();
		$consGen=new ConsultasGenerales();	
		$operaciones=new OperacionesGenerales();
		$datosAdol="";
		$edad="";
		$telefono="";
		$dataInput=Yii::app()->input->post();
		if(isset($dataInput["offset"]) && !empty($dataInput["offset"])){
			$offset=$dataInput["offset"];
		}
		else{
			$offset=0;
		}
		if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
			$numDocAdol=htmlspecialchars(strip_tags(trim($_POST["numDocAdol"])));
			Yii::app()->getSession()->add('numDocAdol',htmlspecialchars(strip_tags(trim($_POST["numDocAdol"]))));
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		if(!empty($numDocAdol)){
			
			$datosAdol=$consGen->consultaDatosAdol($numDocAdol);
			$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);
			$modeloInfJudAdmon->num_doc=$numDocAdol;
			$infJudicial=$modeloInfJudAdmon->consultaInfJudOffset($offset);
			if(!empty($infJudicial)){
				foreach($infJudicial as $pk=>$infJudicialAct){
					$infJud=$modeloInfJudAdmon->consultaInfJudNov($infJudicialAct["id_inf_judicial"]);
					if(!empty($infJud)){
						$infJudicial[$pk]=$infJud;
					}			
				}
			}
		}
		//consulta Instancia remisora
		$instanciaRem=$consGen->consutlaInstanciaRem();
		//consulta delitos
		$delito=$consGen->consutlaDelito();
		//consulta estado del proceso
		$estadoProceso=$consGen->consutlaEstadoProceso();
		//consulta sanción
		//$sancion=$consGen->consutlaSancion();
		$this->render('_consultaInfJudAdmon',
			array(
				'modeloInfJudAdmon'=>$modeloInfJudAdmon,
				'modeloDatosForjarAdol'=>$modeloDatosForjarAdol,
				'numDocAdol'=>$numDocAdol,
				'instanciaRem'=>$instanciaRem,
				'delito'=>$delito,
				'estadoProceso'=>$estadoProceso,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'telefono'=>$telefono,
				'accion'=>'regNovedad',
				'infJudicial'=>$infJudicial,
				'offset'=>$offset
			)
		);		
	}

	public function actionBuscaAdolGen(){
		$datos=Yii::app()->input->post();
		$consAdol=new ConsultasGenerales();
		$consAdol->searchTerm=$datos["search_term"];
		if(!empty($datos["search_term"])){
			$res=$consAdol->buscaAdolGen();
		}
		else{
			//$res[]=array( "numDocAdol" =>0, "nombre"=>'');
		}
		 echo CJSON::encode($res);
	}	//Consulta Municipio segun departamento
	
	/**
	 *	Acción que renderiza la vista que contiene los formularios para modificar los datos básicos del adolescente.
	 *	En el caso que haya un formulario que no tenga un registro principal realiza un rendePartial del formulario de creación de registro, en caso contrato renderiza.
	 *	el formulario para modificar datos de formulario correspondiente.
	 *
	 *	Vista a renderizar:
	 *		- modificarDatosForm.
	 *
	 *	Formularios contenidos:
	 *		- _formAdolescente				formulario de datos básicos del adolescente
	 *		- _formLocalizacion				formulario par diligenciar datos de localización
	 *		- _formVerificacionDerCespa 	formulario para diligenciar la verificación de derechos enviada por el defensor de familia
	 *		- _formAdolDocsCespa			formulario para hacer check de los documentos enviados por el cespa
	 *		- _formAcudiente				formulario para diligenciar datos básicos del acudiente.
	 *		- _formAdolescenteMod			formulario de datos básicos del adolescente a modificar
	 *		- _formLocalizacionMod			formulario par diligenciar datos de localización a modificar
	 *		- _formVerificacionDerCespaMod 	formulario para diligenciar la verificación de derechos enviada por el defensor de familia a modificar
	 *		- _formAdolDocsCespaMod			formulario para hacer check de los documentos enviados por el cespa a modificar
	 *		- _formAcudienteMod				formulario para diligenciar datos básicos del acudiente a modificar. 
	 *
	 *	Modelos instanciados:
	 *		- Adolescente
	 * 		- LocalizacionViv
	 * 		- DerechoAdol
	 * 		- Telefono
	 * 		- DocumentoCespa
	 * 		- Familiar
	 * 		- ConsultasGenerales.
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param int $tipoDocBd,
	 *	@param array $departamento,
	 *	@param array $sexo,
	 *	@param array $etnia,
	 *	@param array $psicologo,
	 *	@param array $trabSocial,
	 *	@param array $modeloLocalizacion,
	 *	@param array $localidad,
	 *	@param array $estrato,
	 *	@param object $modeloTelefono,
	 *	@param object array $modeloDocCespa,
	 *	@param object $docsCespa,
	 *	@param object $modeloAcudiente,
	 *	@param array $parentesco,
	 *	@param object $modeloVerifDerechos,
	 *	@param array $derechos,
	 *	@param array $participacion,
	 *	@param array $proteccion,					
	 */		
	public function actionModificarDatosForm(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
			$numDocAdol=$datosInput["numDocAdol"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		if(!empty($numDocAdol)){	
			$formAdol=new Adolescente();
			$modeloLocalizacion=new LocalizacionViv();
			$modeloLocalizacionAcud=new LocalizacionViv();
			$modeloTelefono=new Telefono();
			$modeloTelefonoAcud=new Telefono();
			$consGen=new ConsultasGenerales();
			$operaciones= new OperacionesGenerales();
			$modeloDatosTelefono=new Telefono();
			$modeloVerifDerechos=new DerechoAdol();
			$modeloDocCespa=new DocumentoCespa();
			$modeloAcudiente=new Familiar();
			$tipoDocBd=$consGen->consultaTipoDocumento();
			//Consulta para departamento
			$departamento=$consGen->consultaDepartamento();
			//Consulta sexo
			$sexo=$consGen->consultaSexo();
			//consulta etnia
			$etnia=$consGen->consultaEtnia();
			//consulta localidad
			$localidad=$consGen->consultaLocalidad();
			//consulta estrato
			$estrato=$consGen->consultaEstrato();
			//$derechos=$consGen->consultaDerechos();
			//consulta Participación
			$participacion=$consGen->consultaParticipacion();
			//consulta Protección
			$proteccion=$consGen->consultaProteccion();
			//Consulta parentesco
			$parentesco=$consGen->consultaParentesco();
			$departamento=$consGen->consultaDepartamento();
			$derechos=$consGen->consultaDerechos();
			$datosAdol=$formAdol->consultaDatosAdol($numDocAdol);
			$formAdol->num_doc=$numDocAdol;
			$formAdol->nombres=$datosAdol["nombres"];
			$formAdol->apellido_1=$datosAdol["apellido_1"];
			$formAdol->apellido_2=$datosAdol["apellido_2"];
			$formAdol->id_tipo_doc=$datosAdol["id_tipo_doc"];
			$formAdol->fecha_nacimiento=$datosAdol["fecha_nacimiento"];
			$idDepartamento=$datosAdol["id_departamento"];
			//$formAdol->id_municipio=$datosAdol["id_municipio"];
			$municipio=$consGen->consultaMunicipio($idDepartamento);
			$formAdol->id_municipio=$datosAdol["id_municipio"];
			$formAdol->id_sexo=$datosAdol["id_sexo"];
			$formAdol->id_etnia=$datosAdol["id_etnia"];
			if($datosAdol["estado_escol"]=="t"){$formAdol->escIngEgrs="true";}else{$formAdol->escIngEgrs="false";}
			$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			$telefonoAdol=$modeloDatosTelefono->consultaTelefono($numDocAdol);
			$consultaAdolLoc=$modeloLocalizacion->find('num_doc=:numDoc',
				array(
				':numDoc'=>$numDocAdol
				)
			);
			if(!$consultaAdolLoc){
				$formularioCarga="_formLocalizacion";
			}
			else{
				$formularioCarga="_formLocalizacionMod";
				$modeloLocalizacion->attributes=$modeloLocalizacion->consultaLocVivadol($numDocAdol);
			}
			//consulta si tiene registro de derechos cespa
			$consultaAdolLoc=$modeloLocalizacion->find('num_doc=:numDoc',
				array(
				':numDoc'=>$numDocAdol
				)
			);
			if(!$consultaAdolLoc){
				$formularioCarga="_formLocalizacion";
			}
			else{
				$formularioCarga="_formLocalizacionMod";
				$modeloLocalizacion->attributes=$modeloLocalizacion->consultaLocVivadol($numDocAdol);
			}
			$idInstanciaDer=2;
			$consultaDerechoAdol=$modeloVerifDerechos->findAll('num_doc=:numDoc and id_instanciader=:id_instanciader',
				array(
				':numDoc'=>$numDocAdol,
				':id_instanciader'=>$idInstanciaDer
				)
			);		
				
			if(!$consultaDerechoAdol){
				$formularioCargaDerechos="_formVerificacionDerCespa";
			}
			else{
				$formularioCargaDerechos="_formVerificacionDerCespaMod";
			}
			$docsCespa=$modeloDocCespa->consDocAdolCespa($numDocAdol);
			if(empty($docsCespa)){
				$formularioCargaDocsCespa="_formAdolDocsCespa";
			}
			else{
				$formularioCargaDocsCespa="_formAdolDocsCespaMod";
			}
			$acudiente=$modeloAcudiente->consultaAcudiente($numDocAdol);
			if(empty($acudiente)){
				$formularioCargaAcud="_formAcudiente";
			}
			else{
				$formularioCargaAcud="_formAcudienteMod";
				$modeloAcudiente->attributes=$modeloAcudiente->consultaFamiliar($acudiente["id_doc_familiar"]);
				$modeloLocalizacionAcud->attributes=$modeloLocalizacionAcud->consultaLocVivFam($acudiente["id_doc_familiar"]);
				$telefonoAcud=$modeloTelefonoAcud->consultaTelefonosAcud($acudiente["id_doc_familiar"]);
			}
		}		
		$this->render('modificarDatosForm',array(
			'formAdol'=>$formAdol,
			'tipoDocBd'=>$tipoDocBd,
			'departamento'=>$departamento,
			'sexo'=>$sexo,
			'etnia'=>$etnia,
			'numDocAdol'=>$numDocAdol,
			'datosAdol'=>$datosAdol,
			'edad'=>$edad,
			'telefonoAdol'=>$telefonoAdol,
			'municipio'=>$municipio,
			'departamento'=>$departamento,
			'idDepartamento'=>$idDepartamento,
			'formularioCarga'=>$formularioCarga,
			'modeloLocalizacion'=>$modeloLocalizacion,
			'modeloTelefono'=>$modeloTelefono,
			'localidad'=>$localidad,
			'estrato'=>$estrato,
			'formularioCargaDerechos'=>$formularioCargaDerechos,
			'modeloVerifDerechos'=>$modeloVerifDerechos,
			'derechos'=>$derechos,
			'participacion'=>$participacion,
			'proteccion'=>$proteccion,	
			'docsCespa'=>$docsCespa,
			'formularioCargaDocsCespa'=>$formularioCargaDocsCespa,
			'modeloDocCespa'=>$modeloDocCespa,
			'formularioCargaAcud'=>$formularioCargaAcud,
			'modeloAcudiente'=>$modeloAcudiente,
			'modeloLocalizacionAcud'=>$modeloLocalizacionAcud,
			'telefonoAcud'=>$telefonoAcud,
			'modeloTelefonoAcud'=>$modeloTelefonoAcud,
			'parentesco'=>$parentesco,
			'acudiente'=>$acudiente
		));		
	}
	/**
	 *	Recibe datos del formulario de datos básicos del acudiente e instancia a modelo para modificar en base de datos
	 *	Consulta en primera instancia si el valor recibido es diferente del valor registrado, si es así procede a la modificación en caso contratio pasa al siguiente dato
	 *	para continuar con la verificación
	 *
	 *	Modelos instanciados:
	 *		- Familiar
	 *		- LocalizacionViv.
	 *		- Telefono.
	 *
	 *	@param string $modeloAcudiente->mensajeErrorAcud mensaje de error si hay inconveniente en el registro datos del acudiente.
	 *	@param string $modeloTelefono->mensajeErrorTel mensaje de error si hay inconveniente en el registro de teléfonos del acudiente. 
	 *	@param string $modeloLocalizacion->mensajeErrorLocAcud mensaje de error si hay inconveniente en el localización datos del acudiente. 
	 *	@return json resultado de la transacción.
	 */		
	public function actionModAcudiente(){
		$resultado="exito";
		$datosAcudiente=Yii::app()->input->post();		
		$modeloAcudiente=new Familiar();
		$modeloLocalizacion=new LocalizacionViv();		
		$modeloTelefono=new Telefono();
		$modeloAcudiente->mensajeErrorAcud="";
		$modeloTelefono->mensajeErrorTel="";
		$modeloLocalizacion->mensajeErrorLocAcud="";
		if(isset($_POST["Familiar"]) && isset($_POST["LocalizacionViv"]) && isset($_POST["Telefono"])){			
			$modeloAcudiente->attributes=$datosAcudiente["Familiar"];	
			$modeloLocalizacion->attributes=$datosAcudiente["LocalizacionViv"];
			$modeloTelefono->attributes=$datosAcudiente["Telefono"];
			if($modeloAcudiente->validate() && $modeloLocalizacion->validate() && $modeloTelefono->validate()){
				$modeloAcudiente->num_docAdolFam=$modeloLocalizacion->num_doc;
				//modifica datos de acudiente
				$datosActAcudiente=$modeloAcudiente->consultaFamiliar($modeloAcudiente->id_doc_familiar);			
				if($modeloAcudiente->nombres_familiar!==$datosActAcudiente["nombres_familiar"]){
					$tipoDato=PDO::PARAM_STR;
					$modeloAcudiente->modificaDatosAcudiente("nombres_familiar","familiar",$datosActAcudiente["nombres_familiar"],$modeloAcudiente->nombres_familiar,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				if($modeloAcudiente->apellidos_familiar!==$datosActAcudiente["apellidos_familiar"]){
					$tipoDato=PDO::PARAM_STR;
					$modeloAcudiente->modificaDatosAcudiente("apellidos_familiar","familiar",$datosActAcudiente["apellidos_familiar"],$modeloAcudiente->apellidos_familiar,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				if($modeloAcudiente->id_tipo_doc!==$datosActAcudiente["id_tipo_doc"]){
					$tipoDato=PDO::PARAM_INT;
					$modeloAcudiente->modificaDatosAcudiente("id_tipo_doc","familiar",$datosActAcudiente["id_tipo_doc"],$modeloAcudiente->id_tipo_doc,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				if($modeloAcudiente->num_doc_fam!==$datosActAcudiente["num_doc_fam"]){
					$tipoDato=PDO::PARAM_NULL;
					$modeloAcudiente->modificaDatosAcudiente("num_doc_fam","familiar",$datosActAcudiente["num_doc_fam"],$modeloAcudiente->num_doc_fam,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				if($modeloAcudiente->id_parentesco!==$datosActAcudiente["id_parentesco"]){
					$tipoDato=PDO::PARAM_INT;
					$modeloAcudiente->modificaDatosAcudiente("id_parentesco","familiar",$datosActAcudiente["id_parentesco"],$modeloAcudiente->id_parentesco,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				//modifica datos de localización
				$datosLocAcudAct=$modeloLocalizacion->consultaLocVivFam($acudiente["id_doc_familiar"]);
				if($modeloLocalizacion->id_localidad!==$datosLocAcudAct["id_localidad"]){
					$tipoDato=PDO::PARAM_NULL;
					$modeloLocalizacion->modificaDatosLocAcud("id_localidad","localizacion_viv",$datosLocAcudAct["id_localidad"],$modeloLocalizacion->id_localidad,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				if($modeloLocalizacion->barrio!==$datosLocAcudAct["barrio"]){
					$tipoDato=PDO::PARAM_STR;
					$modeloLocalizacion->modificaDatosLocAcud("barrio","localizacion_viv",$datosLocAcudAct["barrio"],$modeloLocalizacion->barrio,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				if($modeloLocalizacion->direccion!==$datosLocAcudAct["direccion"]){
					$tipoDato=PDO::PARAM_NULL;
					$modeloLocalizacion->modificaDatosLocAcud("direccion","localizacion_viv",$datosLocAcudAct["direccion"],$modeloLocalizacion->direccion,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				if($modeloLocalizacion->id_estrato!==$datosLocAcudAct["id_estrato"]){
					$tipoDato=PDO::PARAM_NULL;
					if(empty($modeloLocalizacion->id_estrato)){$modeloLocalizacion->id_estrato=null;}
					$modeloLocalizacion->modificaDatosLocAcud("id_estrato","localizacion_viv",$datosLocAcudAct["id_estrato"],$modeloLocalizacion->id_estrato,$modeloAcudiente->id_doc_familiar,$tipoDato);
				}
				//actualiza teléfonos de acudiente
				$modeloTelefono->id_doc_familiar=$modeloAcudiente->id_doc_familiar;
				$telefonoPr=$modeloTelefono->consultaTelefonoAcud($modeloAcudiente->id_doc_familiar,1);
				if($modeloTelefono->telefono!=$telefonoPr["telefono"]){
						$tipoDato=PDO::PARAM_STR;
						$camposComp=array(
							array('id_campo'=>'id_doc_familiar','contenido'=>$modeloAcudiente->id_doc_familiar,'tipoDato'=>PDO::PARAM_STR),
							array('id_campo'=>'id_tipo_telefono','contenido'=>1,'tipoDato'=>PDO::PARAM_INT)
						);
						$modeloTelefono->modificaDatosTelAdolMany('telefono','telefono',$telefonoPr["telefono"],$modeloTelefono->telefono,$camposComp,$tipoDato);
				}
				$telefonoSec=$modeloTelefono->consultaTelefonoAcud($modeloAcudiente->id_doc_familiar,2);
				if(empty($telefonoSec)){				  
					if(!empty($modeloTelefono->tel_sec)){$modeloTelefono->registraTelefonoAcud(2,$modeloTelefono->tel_sec);
						$modeloTelefono->mensajeErrorTel=$modeloTelefono->mensajeErrorTel;
					}
				}
				else{
					if($modeloTelefono->tel_sec!=$telefonoSec["telefono"]){
						$tipoDato=PDO::PARAM_STR;
						$camposComp=array(
							array('id_campo'=>'id_doc_familiar','contenido'=>$modeloAcudiente->id_doc_familiar,'tipoDato'=>PDO::PARAM_STR),
							array('id_campo'=>'id_tipo_telefono','contenido'=>2,'tipoDato'=>PDO::PARAM_INT)
						);
						$modeloTelefono->modificaDatosTelAdolMany('telefono','telefono',$telefonoSec["telefono"],$modeloTelefono->tel_sec,$camposComp,$tipoDato);
					}
				}
				$telefonoCel=$modeloTelefono->consultaTelefonoAcud($modeloAcudiente->id_doc_familiar,3);
				if(empty($telefonoCel)){
					if(!empty($modeloTelefono->celular)){$modeloTelefono->registraTelefonoAcud(3,$modeloTelefono->celular);
							$modeloTelefono->mensajeErrorTel=$modeloTelefono->mensajeErrorTel;}
				}
				else{
					if($modeloTelefono->celular!=$telefonoCel["telefono"]){
						$tipoDato=PDO::PARAM_STR;
						$camposComp=array(
							array('id_campo'=>'id_doc_familiar','contenido'=>$modeloAcudiente->id_doc_familiar,'tipoDato'=>PDO::PARAM_STR),
							array('id_campo'=>'id_tipo_telefono','contenido'=>3,'tipoDato'=>PDO::PARAM_INT)
						);
						$modeloTelefono->modificaDatosTelAdolMany('telefono','telefono',$telefonoCel["telefono"],$modeloTelefono->celular,$camposComp,$tipoDato);
					}
				}
				//modifica telefonos
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado,'msnError'=>$modeloAcudiente->mensajeErrorAcud,'mensajeErrorTel'=>$modeloTelefono->mensajeErrorTel,'mensajeErrorLocAcud'=>$modeloLocalizacion->mensajeErrorLocAcud));
			}
			else{
				echo CActiveForm::validate(array($modeloAcudiente,$modeloLocalizacion,$modeloTelefono));
			}
		}
		
	}
	
	/**
	 *	Recibe datos del formulario de registro del adolescente e instancia a modelo para modificar en base de datos
	 *	Consulta en primera instancia si el valor recibido es diferente del valor registrado, si es así procede a la modificación en caso contratio pasa al siguiente dato
	 *	para continuar con la verificación
	 *
	 *	Modelos instanciados:
	 *		- Adolescente
	 *
	 *	@param array $datosInput=$_POST array de datos del formulario de datos básicos del adolescente
	 *	@param int $formPr->numeroCarpeta número de carpeta asignada por el sistema
	 *	@param string $formPr->mensajeErrorProf mensaje de error si hay inconvenientes en el registro del equipo piscosocial asignado al adolescente.
	 *	@param string $formPr->mensajeError mensaje de error si hay algún problema en el registro de datos básicos del adolescente.
	 *	@return json resultado de la transacción.
	 */		
	public function actionModifRegAdol(){
		$datosInput=Yii::app()->input->post();
		$formPr=new Adolescente();          
		$consGen=new ConsultasGenerales();
		$operaciones= new OperacionesGenerales();  
		//$this->performAjaxValidation($formPr);  
		$numDocAdol=$datosInput["Adolescente"]["numDocAdol"];
		if(isset($_POST["Adolescente"])){
			$formPr->attributes=$datosInput["Adolescente"];
			if($formPr->validate()){
				$datosAdol==$formPr->consultaDatosAdol($numDocAdol);
				if($formPr->num_doc!=$datosAdol["num_doc"]){
					$tipoDato=PDO::PARAM_STR;
					$formPr->modificaDatosAdol('num_doc','adolescente',$datosInput["Adolescente"]["numDocAdol"],$formPr->num_doc,$numDocAdol,$tipoDato);
					$datosInput["Adolescente"]["numDocAdol"]=$formPr->num_doc;
					$numDocAdol=$formPr->num_doc;
					Yii::app()->getSession()->remove('numDocAdol');
					Yii::app()->getSession()->add('numDocAdol',$formPr->num_doc);
				}
				if($formPr->nombres!=$datosAdol["nombres"]){
					$tipoDato=PDO::PARAM_STR;
					$formPr->nombres=mb_strtoupper($formPr->nombres,"UTF-8");
					$formPr->modificaDatosAdol('nombres','adolescente',$datosAdol["nombres"],$formPr->nombres,$numDocAdol,$tipoDato);
				}
				if($formPr->apellido_1!=$datosAdol["apellido_1"]){
					$tipoDato=PDO::PARAM_STR;
					$formPr->apellido_1=mb_strtoupper($formPr->apellido_1,"UTF-8");
					$formPr->modificaDatosAdol('apellido_1','adolescente',$datosAdol["apellido_1"],$formPr->apellido_1,$numDocAdol,$tipoDato);
				}
				if($formPr->apellido_2!=$datosAdol["apellido_2"]){
					$tipoDato=PDO::PARAM_NULL;
					$formPr->apellido_2=mb_strtoupper($formPr->apellido_2,"UTF-8");
					$formPr->modificaDatosAdol('apellido_2','adolescente',$datosAdol["apellido_2"],$formPr->apellido_2,$numDocAdol,$tipoDato);
				}
				if($formPr->id_tipo_doc!=$datosAdol["id_tipo_doc"]){
					$tipoDato=PDO::PARAM_INT;
					$formPr->modificaDatosAdol('id_tipo_doc','adolescente',$datosAdol["id_tipo_doc"],$formPr->id_tipo_doc,$numDocAdol,$tipoDato);
				}
				if($formPr->id_tipo_doc!=$datosAdol["fecha_nacimiento"]){
					$tipoDato=PDO::PARAM_STR;
					$formPr->modificaDatosAdol('fecha_nacimiento','adolescente',$datosAdol["fecha_nacimiento"],$formPr->fecha_nacimiento,$numDocAdol,$tipoDato);
				}
				if($formPr->id_municipio!=$datosAdol["id_municipio"]){
					$tipoDato=PDO::PARAM_INT;
					$formPr->modificaDatosAdol('id_municipio','adolescente',$datosAdol["id_municipio"],$formPr->id_municipio,$numDocAdol,$tipoDato);
				}
				if($formPr->id_sexo!=$datosAdol["id_sexo"]){
					$tipoDato=PDO::PARAM_INT;
					$formPr->modificaDatosAdol('id_sexo','adolescente',$datosAdol["id_sexo"],$formPr->id_sexo,$numDocAdol,$tipoDato);
				}
				if($formPr->id_etnia!=$datosAdol["id_etnia"]){
					$tipoDato=PDO::PARAM_NULL;
					if(empty($formPr->id_etnia)){$formPr->id_etnia=NULL;}
					$formPr->modificaDatosAdol('id_etnia','adolescente',$datosAdol["id_etnia"],$formPr->id_etnia,$numDocAdol,$tipoDato);
				}
				if($datosAdol["estado_escol"]=="t"){$datosAdol["estado_escol"]="true";}else{$datosAdol["estado_escol"]="false";}
				if($formPr->escIngEgrs!=$datosAdol["estado_escol"]){
					$tipoDato=PDO::PARAM_BOOL;
					$camposComp=array(
						array('id_campo'=>'num_doc','contenido'=>$numDocAdol,'tipoDato'=>PDO::PARAM_STR),
						array('id_campo'=>'id_escingegr','contenido'=>1,'tipoDato'=>PDO::PARAM_INT)
					);
					$formPr->modificaDatosAdolMany('estado_escol','escadol_ingr_egr',$datosAdol["estado_escol"],$formPr->escIngEgrs,$camposComp,$tipoDato);
				}
				
				/*$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);*/
				if(empty($formPr->mensajeError)){
					$resultado="exito";
				}else{
					$resultado="error";
				}
				echo CJSON::encode(array("estadoComu"=>"exito","resultado"=>CJavaScript::encode($resultado),"msnError"=>CJavaScript::encode(CJavaScript::quote($formPr->mensajeError))));
			}
			else{
				echo CActiveForm::validate($formPr);
			}
		}
	}
	/**
	 *	Recibe datos del formulario de localización del adolescente e instancia a modelo para modificar en base de datos
	 *	Consulta en primera instancia si el valor recibido es diferente del valor registrado, si es así procede a la modificación en caso contratio pasa al siguiente dato
	 *	para continuar con la verificación
	 *
	 *	Modelos instanciados:
	 *		- LocalizacionViv
	 *		- Telefono.
	 *
	 *	@param string $modeloLocAdol->mensajeErrorLoc mensaje de error si hay inconveniente en el registro localización del adolescente.
	 *	@param string $modeloTelAdol->mensajeErrorTel mensaje de error si hay inconveniente en el registro de teléfonos del adolescente. 
	 *	@return json resultado de la transacción.
	 */		
	public function actionModificaLocAdol(){
		$datosInput=Yii::app()->input->post();
		$modeloLocalizacion=new LocalizacionViv();
		$modeloTelefono=new Telefono();
		$modeloLocalizacion->attributes=$datosInput["LocalizacionViv"];
		$modeloTelefono->attributes=$datosInput["Telefono"];
		$modeloTelefono->num_doc=$modeloLocalizacion->num_doc;
		
		if($modeloLocalizacion->validate()&&$modeloTelefono->validate()){
			$consGen=new ConsultasGenerales();
			$operaciones= new OperacionesGenerales();  
			$numDocAdol=$modeloLocalizacion->num_doc;
			//$telefonoAdol=$modeloTelefono->consultaTelefono($numDocAdol);
			$datosLoc=$modeloLocalizacion->consultaLocVivadol($numDocAdol);
			//Modifica datos de localizacion
			if($modeloLocalizacion->id_localidad!=$datosLoc["id_localidad"]){
				$tipoDato=PDO::PARAM_NULL;
				if(empty($modeloLocalizacion->id_localidad)){$modeloLocalizacion->id_localidad=null;}
				$modeloLocalizacion->modificaDatosLocAdol('id_localidad','localizacion_viv',$datosLoc["id_localidad"],$modeloLocalizacion->id_localidad,$numDocAdol,$tipoDato);
			}
			if($modeloLocalizacion->barrio!=$datosLoc["barrio"]){
				$tipoDato=PDO::PARAM_STR;
				$modeloLocalizacion->modificaDatosLocAdol('barrio','localizacion_viv',$datosLoc["barrio"],$modeloLocalizacion->barrio,$numDocAdol,$tipoDato);
			}
			if($modeloLocalizacion->direccion!=$datosLoc["direccion"]){
				$tipoDato=PDO::PARAM_NULL;
				if(empty($modeloLocalizacion->direccion)){$modeloLocalizacion->direccion=null;}
				$modeloLocalizacion->modificaDatosLocAdol('direccion','localizacion_viv',$datosLoc["direccion"],$modeloLocalizacion->direccion,$numDocAdol,$tipoDato);
			}
			if($modeloLocalizacion->direccion!=$datosLoc["id_estrato"]){
				$tipoDato=PDO::PARAM_NULL;
				if(empty($modeloLocalizacion->id_estrato)){$modeloLocalizacion->id_estrato=null;}
				$modeloLocalizacion->modificaDatosLocAdol('id_estrato','localizacion_viv',$datosLoc["id_estrato"],$modeloLocalizacion->id_estrato,$numDocAdol,$tipoDato);
			}
			$telefonoPr=$modeloTelefono->consultaTelefonoAdol($numDocAdol,1);
			if($modeloTelefono->telefono!=$telefonoPr["telefono"]){
					$tipoDato=PDO::PARAM_STR;
					$camposComp=array(
						array('id_campo'=>'num_doc','contenido'=>$numDocAdol,'tipoDato'=>PDO::PARAM_STR),
						array('id_campo'=>'id_tipo_telefono','contenido'=>1,'tipoDato'=>PDO::PARAM_INT)
					);
					$modeloTelefono->modificaDatosTelAdolMany('telefono','telefono',$telefonoPr["telefono"],$modeloTelefono->telefono,$camposComp,$tipoDato);
			}
			$telefonoSec=$modeloTelefono->consultaTelefonoAdol($numDocAdol,2);
			if(empty($telefonoSec)){
				if(!empty($modeloTelefono->tel_sec)){$modeloTelefono->registraTelefono(2,$modeloTelefono->tel_sec);
						$modeloTelefono->mensajeErrorTel.=$modeloTelefono->mensajeErrorTel;}
			}
			else{
				if($modeloTelefono->tel_sec!=$telefonoSec["telefono"]){
					$tipoDato=PDO::PARAM_STR;
					$camposComp=array(
						array('id_campo'=>'num_doc','contenido'=>$numDocAdol,'tipoDato'=>PDO::PARAM_STR),
						array('id_campo'=>'id_tipo_telefono','contenido'=>2,'tipoDato'=>PDO::PARAM_INT)
					);
					$modeloTelefono->modificaDatosTelAdolMany('telefono','telefono',$telefonoSec["telefono"],$modeloTelefono->tel_sec,$camposComp,$tipoDato);
				}
			}
			$telefonoCel=$modeloTelefono->consultaTelefonoAdol($numDocAdol,3);
			if(empty($telefonoCel)){
				if(!empty($modeloTelefono->celular)){$modeloTelefono->registraTelefono(3,$modeloTelefono->celular);
						$modeloTelefono->mensajeErrorTel.=$modeloTelefono->mensajeErrorTel;}
			}
			else{
				if($modeloTelefono->celular!=$telefonoCel["telefono"]){
					$tipoDato=PDO::PARAM_STR;
					$camposComp=array(
						array('id_campo'=>'num_doc','contenido'=>$numDocAdol,'tipoDato'=>PDO::PARAM_STR),
						array('id_campo'=>'id_tipo_telefono','contenido'=>3,'tipoDato'=>PDO::PARAM_INT)
					);
					$modeloTelefono->modificaDatosTelAdolMany('telefono','telefono',$telefonoCel["telefono"],$modeloTelefono->celular,$camposComp,$tipoDato);
				}
			}
			$resultado="exito";
			if(empty($modeloTelefono->mensajeErrorTel))$modeloTelefono->mensajeErrorTel="exito";
			echo CJSON::encode(
				array(
					"estadoComu"=>"exito",
					"resultado"=>$resultado,
					"msnError"=>CJavaScript::encode(CJavaScript::quote($modeloLocalizacion->mensajeErrorLocAcud)),
					"msnErrorTel"=>CJavaScript::encode(CJavaScript::quote($modeloTelefono->mensajeErrorTel))
					)
				);
					
		}
		else{
			echo CActiveForm::validate(array($modeloLocalizacion,$modeloTelefono));
		}
	}
	
	/**
	 *	Recibe datos del formulario de verificación de derechos remitidos por el defensor de familia e instancia a modelo para modificar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- DerechoAdol
	 *
	 *	@param string $modeloVerifDerechos->msnErrorDerecho.
	 *	@return json resultado de la transacción.
	 */		
	public function actionModVerifDerAdol(){
		$modeloVerifDerechos=new DerechoAdol();
		$derechosAdol=Yii::app()->input->post();
		if(isset($_POST["DerechoAdol"]) && !empty($_POST["DerechoAdol"])){  
			$modeloVerifDerechos->attributes=$derechosAdol["DerechoAdol"];
			if($modeloVerifDerechos->validate()){
				$modeloVerifDerechos->atributos=$derechosAdol["DerechoAdol"];
				$resultado=$modeloVerifDerechos->modVerifDerAdol();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>'exito','msnError'=>$modeloVerifDerechos->msnErrorDerecho));
			}
			else{
				echo CActiveForm::validate($modeloVerifDerechos);
			}
		}
	}
	
	/**
	 *	Recibe datos del formulario de documentos remitidos por el CESPA e instancia a modelo para modificar en base de datos
	 *
	 *	Modelos instanciados:
	 *		- DocumentoCespa
	 *
	 *	@param string $modeloVerifDerechos->msnErrorDerecho.
	 *	@return json resultado de la transacción.
	 */		
	public function actionModDocCespa(){
		$modeloDocCespa=new DocumentoCespa();
		$docCespaAdol=Yii::app()->input->post();
		if(isset($_POST["DocumentoCespa"]) && !empty($_POST["DocumentoCespa"])){
			$modeloDocCespa->attributes=$docCespaAdol["DocumentoCespa"];
			$modDocsRevision=$modeloDocCespa->findAllBySql("select * from documento_cespa order by id_doccespa asc");
			foreach($modDocsRevision as $documentoRevision){
				$presentado=false;
				foreach($modeloDocCespa->id_doccespa as $docRemitido){
					if($docRemitido==$documentoRevision->id_doccespa){
						$presentado=true;
					}
				}
				$resultado=$modeloDocCespa->modDocCespa($presentado,$documentoRevision->id_doccespa);
				$presentado=false;
			}		
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado)),'msnError'=>$modeloDocCespa->mensajeErrorDocAdol));
		}
	}

	/**
	 *	Acción que renderiza la vista que contiene el formulario para asignar o reasignar equipo psicosocial y responsable del adolescente.
	 *
	 *	Vista a renderizar:
	 *		- _formAsignarBina.
	 *
	 *	Modelos instanciados:
	 *		- HistPersonalAdol
	 * 		- Telefono
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *
	 *	@param object $modeloHistPersAdol,
	 *	@param string $numDocAdol,
	 *	@param array $datosAdol,
	 *	@param int $edad,
	 *	@param array $psicologo,
	 *	@param array $trabSocial,
	 *	@param array $equipoPsicoSoc,
	 */		
	public function actionAsignarBina(){	
		if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
			$numDocAdol=htmlspecialchars(strip_tags(trim($_POST["numDocAdol"])));
			Yii::app()->getSession()->add('numDocAdol',htmlspecialchars(strip_tags(trim($_POST["numDocAdol"]))));
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		if(!empty($numDocAdol)){
			$modeloHistPersAdol= new HistPersonalAdol();
			$modeloTelefono=new Telefono();
			$consultasGenerales=new ConsultasGenerales();
			$operaciones= new OperacionesGenerales();  
			$consultasGenerales->numDocAdol=$numDocAdol;
			$datosAdol=$consultasGenerales->consultaDatosAdol($numDocAdol);
			$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			$telefono=$modeloTelefono->consultaTelefono($numDocAdol);
			$psicologo=$consultasGenerales->consultaProfesional(4);
			$trabSocial=$consultasGenerales->consultaProfesional(5);
			$equipoPsicoSoc=$consultasGenerales->consultaEquipoPsicosocial();
		}
		$this->render('_formAsignarBina',array(
			'modeloHistPersAdol'=>$modeloHistPersAdol,
			'numDocAdol'=>$numDocAdol,
			'datosAdol'=>$datosAdol,
			'edad'=>$edad,
			'psicologo'=>$psicologo,
			'trabSocial'=>$trabSocial,
			'equipoPsicoSoc'=>$equipoPsicoSoc,		
		));
	}
	
	/**
	 *	Recibe datos del formulario de asignación de bina e instancia a modelo para modificar en base de datos
	 *	En el caso que sea reasignar bina, se verifica que si no cambia uno de los integrantes del equipo psicosocial no realice una inserción.
	 *
	 *	Modelos instanciados:
	 *		- HistPersonalAdol
	 *		- ConsultasGenerales.
	 *
	 *	@param string $modeloVerifDerechos->msnErrorDerecho.
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegistraEquipoPsic(){
		$dataInput=Yii::app()->input->post();
		$modeloHistPersAdol= new HistPersonalAdol();
		$consultasGenerales=new ConsultasGenerales();
		$modeloHistPersAdol->attributes=$dataInput["HistPersonalAdol"];
		//print_r($dataInput);exit;
		if($modeloHistPersAdol->validate()){				
			$respPsicol=false;
			$respTrabSocial=false;
			$consultasGenerales->numDocAdol=$modeloHistPersAdol->num_doc;
			$equipoPsicoSoc=$consultasGenerales->consultaEquipoPsicosocial();
			($modeloHistPersAdol->responsable_caso==1)?$respPsicol=true:$respTrabSocial=true;
			foreach($equipoPsicoSoc as $profesional){
				if($profesional["id_rol"]==4){
					if($profesional["id_cedula"]==$modeloHistPersAdol->psicologosHist){
						$resultado=$modeloHistPersAdol->modificaPersAdol($modeloHistPersAdol->psicologosHist,$respPsicol,true);
					}
					else{
						$resultado=$modeloHistPersAdol->modificaPersAdol($profesional["id_cedula"],false,false);						
						$consultasGenerales->idCedula=$modeloHistPersAdol->psicologosHist;
						$consultaHistPersona=$consultasGenerales->consultaProfesionalAdolHistorial();
						if(empty($consultaHistPersona)){
							$modeloHistPersAdol->registraEquipoPsic($modeloHistPersAdol->psicologosHist,$respPsicol);
						}
						else{
							$resultado=$modeloHistPersAdol->modificaPersAdol($modeloHistPersAdol->psicologosHist,$respPsicol,true);
						}
					}
				}
				else{
					if($profesional["id_cedula"]==$modeloHistPersAdol->trabSocialsHist){
						$resultado=$modeloHistPersAdol->modificaPersAdol($modeloHistPersAdol->trabSocialsHist,$respTrabSocial,true);
					}
					else{
						$resultado=$modeloHistPersAdol->modificaPersAdol($profesional["id_cedula"],false,false);
						$consultasGenerales->idCedula=$modeloHistPersAdol->trabSocialsHist;
						$consultaHistPersona=$consultasGenerales->consultaProfesionalAdolHistorial();	
						if(empty($consultaHistPersona)){					
							$modeloHistPersAdol->registraEquipoPsic($modeloHistPersAdol->trabSocialsHist,$respTrabSocial);
						}
						else{
							$resultado=$modeloHistPersAdol->modificaPersAdol($modeloHistPersAdol->trabSocialsHist,$respTrabSocial,true);
						}
						
					}
				}					
			}
			if($modeloHistPersAdol->mensajeErrorProf!=" "){
				$resultado="exito";
			}
			echo CJSON::encode(
			array(
				"estadoComu"=>"exito",
				"resultado"=>CJavaScript::encode(CJavaScript::quote($resultado)),
				"msnError"=>CJavaScript::encode(CJavaScript::quote($modeloHistPersAdol->mensajeErrorProf))
				)
			);

		}
		else{
			echo CActiveForm::validate($modeloHistPersAdol);
		}
	}
	
	/**
	 *	Acción que renderiza la vista que contiene realiza consulta y listado de las o la información judicial impuesta al adolescente para seleccionar y registrar modificaiones.
	 *
	 *	Vista a renderizar:
	 *		- _consultaInfJudAdmon.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 * 		- ForjarAdol
	 * 		- Telefono
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param object $modeloDatosForjarAdol,
	 *	@param string $numDocAdol,
	 *	@param array $infJudicial, listado de informaciones judiciales registradas en el proceso actual del adolescente, es decir respecto al pai actual.
	 *	@param array $delito,
	 *	@param array $estadoProceso,
	 *	@param array $datosAdol,
	 *	@param int $edad,
	 *	@param array $telefono,
	 */		
	public function actionConsInfJudMod(){
		$modeloInfJudAdmon=new InformacionJudicial();
		$modeloDatosForjarAdol=new ForjarAdol();
		$modeloDatosTelefono=new Telefono();
		$consGen=new ConsultasGenerales();	
		$operaciones=new OperacionesGenerales();
		$datosAdol="";
		$edad="";
		$telefono="";
		$datosInput=Yii::app()->input->post();
		$modeloInfJudAdmon->num_doc=$datosInput["InformacionJudicial"]["num_doc"];
		$modeloDatosForjarAdol->num_doc=$datosInput["InformacionJudicial"]["num_doc"];
		$modeloInfJudAdmon->id_inf_judicial=$datosInput["InformacionJudicial"]["id_inf_judicial"];
		$modeloInfJudAdmon->attributes=$modeloInfJudAdmon->consultaInfJudModNov();
		$modeloDatosForjarAdol->attributes=$modeloDatosForjarAdol->consultaDatosForjarAdol();
		$datosAdol=$consGen->consultaDatosAdol($modeloInfJudAdmon->num_doc);
		$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
		$telefono=$modeloDatosTelefono->consultaTelefono($modeloInfJudAdmon->num_doc);
		//consulta Instancia remisora
		$instanciaRem=$consGen->consutlaInstanciaRem();
		//consulta delitos
		$delito=$consGen->consutlaDelito();
		//consulta estado del proceso
		$estadoProceso=$consGen->consutlaEstadoProceso();
		//consulta sanción
		//$sancion=$consGen->consutlaSancion();
		$this->render('_formRegModNovInfJudicialAdmtva',
			array(
				'modeloInfJudAdmon'=>$modeloInfJudAdmon,
				'modeloDatosForjarAdol'=>$modeloDatosForjarAdol,
				'numDocAdol'=>$modeloInfJudAdmon->num_doc,
				'instanciaRem'=>$instanciaRem,
				'delito'=>$delito,
				'estadoProceso'=>$estadoProceso,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'telefono'=>$telefono,
				'accion'=>'modificar',
				'id_inf_jud_primaria'=>$modeloInfJudAdmon->id_inf_judicial
			)
		);
	}
	/**
	 *	Acción que renderiza la vista que contiene realiza consulta y listado de las o la información judicial impuesta al adolescente para seleccionar y registrar novedades.
	 *
	 *	Vista a renderizar:
	 *		- _consultaInfJudAdmon.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 * 		- ForjarAdol
	 * 		- Telefono
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param object $modeloDatosForjarAdol,
	 *	@param string $numDocAdol,
	 *	@param array $infJudicial, listado de informaciones judiciales registradas en el proceso actual del adolescente, es decir respecto al pai actual.
	 *	@param array $delito,
	 *	@param array $estadoProceso,
	 *	@param array $datosAdol,
	 *	@param int $edad,
	 *	@param array $telefono,
	 */		
	public function actionConsInfJudRegNov(){
		$modeloInfJudAdmon=new InformacionJudicial();
		$modeloDatosForjarAdol=new ForjarAdol();
		$modeloDatosTelefono=new Telefono();
		$consGen=new ConsultasGenerales();	
		$operaciones=new OperacionesGenerales();
		$datosAdol="";
		$edad="";
		$telefono="";
		$datosInput=Yii::app()->input->post();
		$modeloInfJudAdmon->num_doc=$datosInput["InformacionJudicial"]["num_doc"];
		$modeloDatosForjarAdol->num_doc=$datosInput["InformacionJudicial"]["num_doc"];

		$modeloInfJudAdmon->id_inf_judicial=$datosInput["InformacionJudicial"]["id_inf_judicial"];
		$modeloInfJudAdmon->attributes=$modeloInfJudAdmon->consultaInfJudModNov();
		$modeloDatosForjarAdol->attributes=$modeloDatosForjarAdol->consultaDatosForjarAdol();
		$datosAdol=$consGen->consultaDatosAdol($modeloInfJudAdmon->num_doc);
		$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
		$telefono=$modeloDatosTelefono->consultaTelefono($modeloInfJudAdmon->num_doc);
		//consulta Instancia remisora
		$instanciaRem=$consGen->consutlaInstanciaRem();
		//consulta delitos
		$delito=$consGen->consutlaDelito();
		//consulta estado del proceso
		$estadoProceso=$consGen->consutlaEstadoProceso();
		//consulta sanción
		//$sancion=$consGen->consutlaSancion();
		$this->render('_formRegModNovInfJudicialAdmtva',
			array(
				'modeloInfJudAdmon'=>$modeloInfJudAdmon,
				'modeloDatosForjarAdol'=>$modeloDatosForjarAdol,
				'numDocAdol'=>$modeloInfJudAdmon->num_doc,
				'instanciaRem'=>$instanciaRem,
				'delito'=>$delito,
				'estadoProceso'=>$estadoProceso,
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'telefono'=>$telefono,
				'id_inf_jud_primaria'=>$datosInput["id_inf_jud_primaria"],
				'accion'=>'regNovedad'
			)
		);
	}
	
	
	/**
	 *	Recibe datos del formulario de información judicial administrativa e instancia a modelo para registrar en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 *		- ForjarAdol
	 *
	 *	@param arrya $dataClean $_POST	de datos del formulario de información judicial administrativa.
	 *	@param string $modeloInfJudAdmon->mensajeErrorInfJud.
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegistraModifInfJud(){
		$modeloInfJudAdmon=new InformacionJudicial(); 
		$modeloDatosForjarAdol=new ForjarAdol();
		//$this->performAjaxValidation($modeloInfJudAdmon);  
		if(isset($_POST["InformacionJudicial"])){
			$dataInput=Yii::app()->input->post();
		 	$modeloInfJudAdmon->attributes=$dataInput["InformacionJudicial"];
			$modeloInfJudAdmon->id_inf_judicial=$dataInput["InformacionJudicial"]["id_inf_judicial"];
			if($modeloInfJudAdmon->validate()){
				$infActual=$modeloInfJudAdmon->consultaInfJudInd();
				if($modeloInfJudAdmon->fecha_remision!=$infActual["fecha_remision"]){
					if(empty($modeloInfJudAdmon->fecha_remision)){
						$modeloInfJudAdmon->fecha_remision=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_STR;
					}
					$modeloInfJudAdmon->modifInfJudicial("fecha_remision",$modeloInfJudAdmon->fecha_remision,$parametro);
				}
				if($modeloInfJudAdmon->id_instancia_rem!=$infActual["id_instancia_rem"]){
					if(empty($modeloInfJudAdmon->id_instancia_rem)){
						$modeloInfJudAdmon->id_instancia_rem=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_INT;
					}
					$modeloInfJudAdmon->modifInfJudicial("id_instancia_rem",$modeloInfJudAdmon->id_instancia_rem,$parametro);
				}
				if($modeloInfJudAdmon->defensor!=$infActual["defensor"]){
					if(empty($modeloInfJudAdmon->defensor)){
						$modeloInfJudAdmon->defensor=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_STR;
					}
					$modeloInfJudAdmon->modifInfJudicial("defensor",$modeloInfJudAdmon->defensor,$parametro);
				}
				if($modeloInfJudAdmon->defensor_publico!=$infActual["defensor_publico"]){
					if(empty($modeloInfJudAdmon->defensor_publico)){
						$modeloInfJudAdmon->defensor_publico=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_STR;
					}
					$modeloInfJudAdmon->modifInfJudicial("defensor_publico",$modeloInfJudAdmon->defensor_publico,$parametro);
				}
				if($modeloInfJudAdmon->juez!=$infActual["juez"]){
					if(empty($modeloInfJudAdmon->juez)){
						$modeloInfJudAdmon->juez=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_STR;
					}
					$modeloInfJudAdmon->modifInfJudicial("juez",$modeloInfJudAdmon->juez,$parametro);
				}
				if($modeloInfJudAdmon->fecha_aprehension!=$infActual["fecha_aprehension"]){
					if(empty($modeloInfJudAdmon->fecha_aprehension)){
						$modeloInfJudAdmon->fecha_aprehension=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_STR;
					}
					$modeloInfJudAdmon->modifInfJudicial("fecha_aprehension",$modeloInfJudAdmon->fecha_aprehension,$parametro);
				}
				if($modeloInfJudAdmon->id_proc_jud!=$infActual["id_proc_jud"]){
					if(empty($modeloInfJudAdmon->id_proc_jud)){
						$modeloInfJudAdmon->id_proc_jud=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_INT;
					}
					$modeloInfJudAdmon->modifInfJudicial("id_proc_jud",$modeloInfJudAdmon->id_proc_jud,$parametro);
				}
				if($modeloInfJudAdmon->id_tipo_sancion!=$infActual["id_tipo_sancion"]){
					if(empty($modeloInfJudAdmon->id_tipo_sancion)){
						$modeloInfJudAdmon->id_tipo_sancion=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_INT;
					}
					$modeloInfJudAdmon->modifInfJudicial("id_tipo_sancion",$modeloInfJudAdmon->id_tipo_sancion,$parametro);
				}
				if($modeloInfJudAdmon->pard!=$infActual["pard"]){
					if(empty($modeloInfJudAdmon->pard)){
						$modeloInfJudAdmon->pard=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_BOOL;
					}
					$modeloInfJudAdmon->modifInfJudicial("pard",$modeloInfJudAdmon->pard,$parametro);
				}
				if($modeloInfJudAdmon->mec_sust_lib!=$infActual["mec_sust_lib"]){
					if(empty($modeloInfJudAdmon->mec_sust_lib)){
						$modeloInfJudAdmon->mec_sust_lib=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_BOOL;
					}
					$modeloInfJudAdmon->modifInfJudicial("mec_sust_lib",$modeloInfJudAdmon->mec_sust_lib,$parametro);
				}
				if($modeloInfJudAdmon->fecha_imposicion!=$infActual["fecha_imposicion"]){
					if(empty($modeloInfJudAdmon->fecha_imposicion)){
						$modeloInfJudAdmon->fecha_imposicion=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_STR;
					}
					$modeloInfJudAdmon->modifInfJudicial("fecha_imposicion",$modeloInfJudAdmon->fecha_imposicion,$parametro);
				}
				if($modeloInfJudAdmon->tiempo_sancion!=$infActual["tiempo_sancion"]){
					if(empty($modeloInfJudAdmon->tiempo_sancion)){
						$modeloInfJudAdmon->tiempo_sancion=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_INT;
					}
					$modeloInfJudAdmon->modifInfJudicial("tiempo_sancion",$modeloInfJudAdmon->tiempo_sancion,$parametro);
				}
				if($modeloInfJudAdmon->tiempo_sancion_dias!=$infActual["tiempo_sancion_dias"]){
					if(empty($modeloInfJudAdmon->tiempo_sancion_dias)){
						$modeloInfJudAdmon->tiempo_sancion_dias=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_INT;
					}
					$modeloInfJudAdmon->modifInfJudicial("tiempo_sancion_dias",$modeloInfJudAdmon->tiempo_sancion_dias,$parametro);
				}
				if($modeloInfJudAdmon->observaciones_sancion!=$infActual["observaciones_sancion"]){
					if(empty($modeloInfJudAdmon->observaciones_sancion)){
						$modeloInfJudAdmon->observaciones_sancion=null;
						$parametro=PDO::PARAM_NULL;
					}
					else{
						$parametro=PDO::PARAM_STR;
					}
					$modeloInfJudAdmon->modifInfJudicial("observaciones_sancion",$modeloInfJudAdmon->observaciones_sancion,$parametro);
				}
				
				//$resultado=$modeloInfJudAdmon->registraInfJudAdminAdol();
				echo CJSON::encode(array("estadoComu"=>"exito",
				'resultado'=>$resultado,
				'msnError'=>CJavaScript::encode(CJavaScript::quote($modeloInfJudAdmon->mensajeErrorInfJud))));
			}else{
				echo CActiveForm::validate($modeloInfJudAdmon);
			}
		}		
	}
	/**
	 *	Recibe datos del formulario de información judicial administrativa e instancia a modelo para registrar en base de datos.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 *		- ForjarAdol
	 *
	 *	@param arrya $dataClean $_POST	de datos del formulario de información judicial administrativa.
	 *	@param string $modeloInfJudAdmon->mensajeErrorInfJud.
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegistraNovInfJud(){
		$datosInput=Yii::app()->input->post();
		$modeloInfJudAdmon=new InformacionJudicial(); 
		//$modeloNovedadInfJud=new NovedadInfJudicial();
		//$this->performAjaxValidation($modeloInfJudAdmon);  
		if(isset($_POST["InformacionJudicial"])){
		 	$modeloInfJudAdmon->attributes=$datosInput["InformacionJudicial"];			
			if($modeloInfJudAdmon->validate()){
				$modeloInfJudAdmon->id_inf_judicial=$datosInput["InformacionJudicial"]["id_inf_judicial"];
				$modeloInfJudAdmon->id_inf_actual=$datosInput["InformacionJudicial"]["id_inf_actual"];
				$modeloInfJudAdmon->novedad_infjud='true';
				$resultado=$modeloInfJudAdmon->registraInfJudAdminAdol();
				if($resultado=="exito"){
					//$modeloInfJudAdmon->id_inf_actual;
					//$modeloInfJudAdmon->id_inf_nueva;
					$modeloInfJudAdmon->actualizaCompSancionInfJud();		
				}
				echo CJSON::encode(array("estadoComu"=>"exito",
				'resultado'=>$resultado,
				'msnError'=>CJavaScript::encode(CJavaScript::quote($modeloInfJudAdmon->mensajeErrorInfJud))));
			}else{
				echo CActiveForm::validate($modeloInfJudAdmon);
			}
		}		
	}
	
	/**
	 *	Acción que renderiza la vista que contiene los datos básicos del adolescente.
	 *
	 *	Vista a renderizar:
	 *		- consultarDatos.
	 *
	 *	Formularios contenidos:
	 *		- _formAdolescenteCons			formulario de datos básicos del adolescente a modificar
	 *		- _formLocalizacionCons			formulario par diligenciar datos de localización a modificar
	 *		- _formVerificacionDerCespaCons formulario para diligenciar la verificación de derechos enviada por el defensor de familia a modificar
	 *		- _formAdolDocsCespaCons		formulario para hacer check de los documentos enviados por el cespa a modificar
	 *		- _formAcudienteCons			formulario para diligenciar datos básicos del acudiente a modificar. 
	 *
	 *	Modelos instanciados:
	 *		- Adolescente
	 * 		- LocalizacionViv
	 * 		- DerechoAdol
	 * 		- Telefono
	 * 		- DocumentoCespa
	 * 		- Familiar
	 * 		- ConsultasGenerales.
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param int $tipoDocBd,
	 *	@param array $departamento,
	 *	@param array $sexo,
	 *	@param array $etnia,
	 *	@param array $psicologo,
	 *	@param array $trabSocial,
	 *	@param array $modeloLocalizacion,
	 *	@param array $localidad,
	 *	@param array $estrato,
	 *	@param object $modeloTelefono,
	 *	@param object array $modeloDocCespa,
	 *	@param object $docsCespa,
	 *	@param object $modeloAcudiente,
	 *	@param array $parentesco,
	 *	@param object $modeloVerifDerechos,
	 *	@param array $derechos,
	 *	@param array $participacion,
	 *	@param array $proteccion,					
	 */		
	public function actionConsultarDatos(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
			$numDocAdol=$datosInput["numDocAdol"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		if(!empty($numDocAdol)){	
			$formAdol=new Adolescente();
			$modeloLocalizacion=new LocalizacionViv();
			$modeloLocalizacionAcud=new LocalizacionViv();
			$modeloTelefono=new Telefono();
			$modeloTelefonoAcud=new Telefono();
			$modeloVerifDerechos=new DerechoAdol();
			$consGen=new ConsultasGenerales();
			$operaciones= new OperacionesGenerales();
			$modeloDatosTelefono=new Telefono();
			$modeloVerifDerechos=new DerechoAdol();
			$modeloDocCespa=new DocumentoCespa();
			$modeloAcudiente=new Familiar();
			$tipoDocBd=$consGen->consultaTipoDocumento();
			//Consulta para departamento
			$departamento=$consGen->consultaDepartamento();
			//Consulta sexo
			$sexo=$consGen->consultaSexo();
			//consulta etnia
			$etnia=$consGen->consultaEtnia();
			//consulta localidad
			$localidad=$consGen->consultaLocalidad();
			//consulta estrato
			$estrato=$consGen->consultaEstrato();
			$derechos=$consGen->consultaDerechos();
			
			//consulta Participación
			$participacion=$consGen->consultaParticipacion();
			//consulta Protección
			$proteccion=$consGen->consultaProteccion();
			//Consulta parentesco
			$parentesco=$consGen->consultaParentesco();
			$departamento=$consGen->consultaDepartamento();
			$datosAdol=$formAdol->consultaDatosAdol($numDocAdol);
			$formAdol->num_doc=$numDocAdol;
			$formAdol->nombres=$datosAdol["nombres"];
			$formAdol->apellido_1=$datosAdol["apellido_1"];
			$formAdol->apellido_2=$datosAdol["apellido_2"];
			$formAdol->id_tipo_doc=$datosAdol["id_tipo_doc"];
			$formAdol->fecha_nacimiento=$datosAdol["fecha_nacimiento"];
			$idDepartamento=$datosAdol["id_departamento"];
			//$formAdol->id_municipio=$datosAdol["id_municipio"];
			$municipio=$consGen->consultaMunicipio($idDepartamento);
			$formAdol->id_municipio=$datosAdol["id_municipio"];
			$formAdol->id_sexo=$datosAdol["id_sexo"];
			$formAdol->id_etnia=$datosAdol["id_etnia"];
			if($datosAdol["estado_escol"]=="t"){$formAdol->escIngEgrs="true";}else{$formAdol->escIngEgrs="false";}
			$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			$telefonoAdol=$modeloDatosTelefono->consultaTelefono($numDocAdol);
			$consultaAdolLoc=$modeloLocalizacion->find('num_doc=:numDoc',
				array(
				':numDoc'=>$numDocAdol
				)
			);
			if(!$consultaAdolLoc){
				$formularioCarga="_formLocalizacion";
			}
			else{
				$formularioCarga="_formLocalizacionMod";
				$modeloLocalizacion->attributes=$modeloLocalizacion->consultaLocVivadol($numDocAdol);
			}
			//consulta si tiene registro de derechos cespa
			$consultaAdolLoc=$modeloLocalizacion->find('num_doc=:numDoc',
				array(
				':numDoc'=>$numDocAdol
				)
			);
			if(!$consultaAdolLoc){
				$formularioCarga="_formLocalizacion";
			}
			else{
				$formularioCarga="_formLocalizacionMod";
				$modeloLocalizacion->attributes=$modeloLocalizacion->consultaLocVivadol($numDocAdol);
			}
			$consultaDerechoAdol=$modeloVerifDerechos->findAll('num_doc=:numDoc',
				array(
				':numDoc'=>$numDocAdol
				)
			);
			if(!$consultaDerechoAdol){
				$formularioCargaDerechos="_formVerificacionDerCespa";
			}
			else{
				$formularioCargaDerechos="_formVerificacionDerCespaMod";
			}
			$docsCespa=$modeloDocCespa->consDocAdolCespa($numDocAdol);
			if(empty($docsCespa)){
				$formularioCargaDocsCespa="_formAdolDocsCespa";
			}
			else{
				$formularioCargaDocsCespa="_formAdolDocsCespaMod";
			}
			$acudiente=$modeloAcudiente->consultaAcudiente($numDocAdol);
			if(empty($acudiente)){
				$formularioCargaAcud="_formAcudiente";
			}
			else{
				$formularioCargaAcud="_formAcudienteMod";
				$modeloAcudiente->attributes=$modeloAcudiente->consultaFamiliar($acudiente["id_doc_familiar"]);
				$modeloLocalizacionAcud->attributes=$modeloLocalizacionAcud->consultaLocVivFam($acudiente["id_doc_familiar"]);
				$telefonoAcud=$modeloTelefonoAcud->consultaTelefonosAcud($acudiente["id_doc_familiar"]);
			}
		}		
		$this->render('consultarDatos',array(
			'formAdol'=>$formAdol,
			'tipoDocBd'=>$tipoDocBd,
			'departamento'=>$departamento,
			'sexo'=>$sexo,
			'etnia'=>$etnia,
			'numDocAdol'=>$numDocAdol,
			'datosAdol'=>$datosAdol,
			'edad'=>$edad,
			'telefonoAdol'=>$telefonoAdol,
			'municipio'=>$municipio,
			'departamento'=>$departamento,
			'idDepartamento'=>$idDepartamento,
			'formularioCarga'=>$formularioCarga,
			'modeloLocalizacion'=>$modeloLocalizacion,
			'modeloTelefono'=>$modeloTelefono,
			'localidad'=>$localidad,
			'estrato'=>$estrato,
			'formularioCargaDerechos'=>$formularioCargaDerechos,
			'modeloVerifDerechos'=>$modeloVerifDerechos,
			'derechos'=>$derechos,
			'participacion'=>$participacion,
			'proteccion'=>$proteccion,	
			'docsCespa'=>$docsCespa,
			'formularioCargaDocsCespa'=>$formularioCargaDocsCespa,
			'modeloDocCespa'=>$modeloDocCespa,
			'formularioCargaAcud'=>$formularioCargaAcud,
			'modeloAcudiente'=>$modeloAcudiente,
			'modeloLocalizacionAcud'=>$modeloLocalizacionAcud,
			'telefonoAcud'=>$telefonoAcud,
			'modeloTelefonoAcud'=>$modeloTelefonoAcud,
			'parentesco'=>$parentesco,
			'acudiente'=>$acudiente
		));	
	}
	
	/**
	 *	Acción que renderiza la vista que consulta el listado de las o la información judicial impuesta al adolescente para seleccionar y registrar novedades.
	 *
	 *	Vista a renderizar:
	 *		- _consultaInfJudTab.
	 *
	 *	Modelos instanciados:
	 *		- InformacionJudicial
	 * 		- ForjarAdol
	 * 		- Telefono
	 * 		- ConsultasGenerales
	 * 		- OperacionesGenerales
	 *
	 *	@param object $modeloInfJudAdmon,
	 *	@param object $modeloDatosForjarAdol,
	 *	@param string $numDocAdol,
	 *	@param array $infJudicial, listado de informaciones judiciales registradas en el proceso actual del adolescente, es decir respecto al pai actual.
	 *	@param array $delito,
	 *	@param array $estadoProceso,
	 *	@param array $datosAdol,
	 *	@param int $edad,
	 *	@param array $telefono,
	 */		
	public function actionConsultarInfJudAdmon(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
			$numDocAdol=$datosInput["numDocAdol"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}	
		if(!empty($numDocAdol)){
			$modeloInfJud=new InformacionJudicial();
			$operaciones=new OperacionesGenerales();
			$consultaGeneral=new ConsultasGenerales();
			$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
			$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));			
			$consultaGeneral->numDocAdol=$numDocAdol;
			$instanciaRem=$consultaGeneral->consultaEntidades('instancia_remisora','id_instancia_rem');
			$espProcJud=$consultaGeneral->consultaEntidades('estado_proc_judicial','id_proc_jud');
			$tipoSancion=$consultaGeneral->consultaEntidades('tipo_sancion','id_tipo_sancion');
			$delitoRem=$consultaGeneral->consultaEntidades('delito_rem_cespa','id_del_rc');
			$modeloInfJud->num_doc=$numDocAdol;
			$infJudicial=$modeloInfJud->consultaInfJud();
			$infJudicialPai=$modeloInfJud->consultaInfJud();
			if(!empty($infJudicial)){
				foreach($infJudicial as $pk=>$infJudicialNov){
					$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
					if(!empty($infJud)){
						$infJudicial[$pk]=$infJud;
					}			
				}
			}
		}
		$this->render('_consultaInfJudTab',array(
			'numDocAdol'=>$numDocAdol,	
			'datosAdol'=>$datosAdol,
			'edad'=>$edad,
			'instanciaRem'=>$instanciaRem,
			'espProcJud'=>$espProcJud,
			'delitoRem'=>$delitoRem,
			'modeloInfJud'=>$modeloInfJud,
			'infJudicial'=>$infJudicial,
			'tipoSancion'=>$tipoSancion,
		));
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