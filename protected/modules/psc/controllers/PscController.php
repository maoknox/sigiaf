<?php

class PscController extends Controller{
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	public function filters(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
			$numDocAdol=$datosInput["numDocAdol"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}
		return array(
			'enforcelogin',
			array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()),
			array('application.filters.ActionVerifEstadoFilter + creaPsc consultarPsc actEstadoPscForm','num_doc'=>Yii::app()->getSession()->get('numDocAdol'))
		);
	}
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionCreaPsc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="creaPsc";
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
				$modeloPsc= new Psc();
				$modeloInfJud=new InformacionJudicial();
				$modeloDiaHora=new DiaHora();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$sectorPsc=$consultaGeneral->consultaEntidades('sector_psc','id_sector_psc');
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloPsc->num_doc=$numDocAdol;
				$pscSinCulm=$modeloPsc->consultaPscSinCulm();			
				$modeloInfJud->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}		
			}
			$this->render('_pscForm',array(
				'modeloPsc'=>$modeloPsc,
				'modeloDiaHora'=>$modeloDiaHora,
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'sectorPsc'=>$sectorPsc,
				'infJudicial'=>$infJudicial,
				'modeloInfJud'=>$modeloInfJud,
				'pscSinCulm'=>$pscSinCulm
				
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionConsInstitutoPsc(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["Psc"]["id_sector_psc"]) && !empty($datosInput["Psc"]["id_sector_psc"])){
			$consultaGeneral=new ConsultasGenerales();
			$consultaGeneral->searchTerm=$datosInput["Psc"]["id_sector_psc"];
			$consInstituto=$consultaGeneral->consultaInstPsc();
			if(!empty($consInstituto)){
				$opciones=array(array('valor'=>'','contenido'=>'Seleccione una organización'));
				array_push($opciones,array('valor'=>(int)'0','contenido'=>'Agregar una organización'));
				foreach($consInstituto as $instituto){
					array_push($opciones,array('valor'=>(int)strip_tags($instituto["id_institucionpsc"]),'contenido'=>CJavaScript::quote(strip_tags($instituto["institucionpsc"]))));
				}
				echo CJSON::encode($opciones);
			}
			else{
				$opciones=array(array('valor'=>'','contenido'=>'Sector sin organizaciones relacionadas'));
				array_push($opciones,array('valor'=>(int)'0','contenido'=>'Agregar una organización'));
				echo CJSON::encode($opciones);
			}
			
		}
	}
	public function actionRegPsc(){
		$datosInput=Yii::app()->input->post();	
		//print_r($datosInput);
		$numDias=$datosInput["Psc"]["num_dias_psc"];
		$modeloPsc=new Psc();
		$modeloPsc->attributes=$datosInput["Psc"];
		$modeloDiaHora=new DiaHora();
		//$modeloDiaHora->attributes=$datosInput["DiaHora"];
		for($i=1;$i<=$numDias;$i++){
				$modeloDiaHora->id_dia=$datosInput["DiaHora"]["dia".$i];
				$modeloDiaHora->hora_inicio=$datosInput["DiaHora"]["horaIniDia".$i];
				$modeloDiaHora->hora_fin=$datosInput["DiaHora"]["horaFinDia".$i];
				$modeloDiaHora->hora_inicio_m=$datosInput["DiaHora"]["meridHI".$i];
				$modeloDiaHora->hora_fin_m=$datosInput["DiaHora"]["meridHF".$i];
				$modeloDiaHora->horas_dia=$datosInput["DiaHora"]["horas".$i];
				$modeloPsc->diasPrestacion[$i]=array(
					'dia'=>$datosInput["DiaHora"]["dia".$i],
					'horaIniDia'=>$datosInput["DiaHora"]["horaIniDia".$i],
					'hora_fin'=>$datosInput["DiaHora"]["horaFinDia".$i],
					'hora_inicio_m'=>$datosInput["DiaHora"]["meridHI".$i],
					'hora_fin_m'=>$datosInput["DiaHora"]["meridHF".$i],
					'hora_dia'=>$datosInput["DiaHora"]["horas".$i],					
				);
				//$modeloDiaHora->dia=$datosInput["DiaHora"]["meridHF".$i];
		}
		//echo $modeloDiaHora->dia;
		if($modeloDiaHora->validate()&&$modeloPsc->validate()){
			if($modeloPsc->id_institucionpsc==0){
				$modeloPsc->nueva_institucionpsc;
				$modeloPsc->registraOrganizacion();
			}
			if(!empty($modeloPsc->id_institucionpsc)){
				$resultado=$modeloPsc->creaPsc();
			}
			else{
				$resultado="error al realizar la creación del registro de la PSC";
			}				
			echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
		}
		else{
			echo CActiveForm::validate(array($modeloPsc,$modeloDiaHora));		
		}
	}
	
	public function actionConsultarPsc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultarPsc";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloPsc=new Psc();
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
				$modeloPsc->num_doc=$numDocAdol;
				$pscDes=$modeloPsc->consultaPscOff($offset);
			}
			//consulta Instancia remisora
			$this->render('_consultaPSC',
				array(
					'modeloPsc'=>$modeloPsc,
					'pscDes'=>$pscDes,
					'numDocAdol'=>$numDocAdol,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset
				)
			);		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}

	public function actionConsultarPscCoord(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consultarPscCoord";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloPsc=new Psc();
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
				$modeloPsc->num_doc=$numDocAdol;
				$pscDes=$modeloPsc->consultaPscOff($offset);
			}
			//consulta Instancia remisora
			$this->render('_consultaPSCCoord',
				array(
					'modeloPsc'=>$modeloPsc,
					'pscDes'=>$pscDes,
					'numDocAdol'=>$numDocAdol,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset
				)
			);		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	public function actionConsultaPscForm(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["Psc"]["num_doc"]) && !empty($datosInput["Psc"]["num_doc"])&&($datosInput["Psc"]["id_psc"]) && !empty($datosInput["Psc"]["id_psc"])){
			$numDocAdol=$datosInput["Psc"]["num_doc"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}		
		if(!empty($numDocAdol)){
			$modeloPsc= new Psc();
			$modeloDiaHora=new DiaHora();
			$operaciones=new OperacionesGenerales();
			$consultaGeneral=new ConsultasGenerales();
			$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
			$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			$estadoPsc=$consultaGeneral->consultaEntidades('estado_psc','id_estadopsc');
			$modeloPsc->num_doc=$numDocAdol;
			$modeloPsc->id_psc=$datosInput["Psc"]["id_psc"];
			$infPsc=$modeloPsc->consultaPsc();
			$modeloPsc->attributes=$infPsc;			
		}
		$this->render('_consultaPscForm',array(
			'modeloPsc'=>$modeloPsc,
			'modeloDiaHora'=>$modeloDiaHora,
			'numDocAdol'=>$numDocAdol,	
			'datosAdol'=>$datosAdol,
			'edad'=>$edad,	
			'infPsc'=>$infPsc,
			'estadoPsc'=>$estadoPsc		
		));
	}

	public function actionActEstadoPscForm(){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["Psc"]["num_doc"]) && !empty($datosInput["Psc"]["num_doc"])&&($datosInput["Psc"]["id_psc"]) && !empty($datosInput["Psc"]["id_psc"])){
			$numDocAdol=$datosInput["Psc"]["num_doc"];
			Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
		}
		else{
			$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
		}		
		if(!empty($numDocAdol)){
			$modeloPsc= new Psc();
			$modeloDiaHora=new DiaHora();
			$operaciones=new OperacionesGenerales();
			$consultaGeneral=new ConsultasGenerales();
			$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
			$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
			$estadoPsc=$consultaGeneral->consultaEntidades('estado_psc','id_estadopsc');
			$modeloPsc->num_doc=$numDocAdol;
			$modeloPsc->id_psc=$datosInput["Psc"]["id_psc"];
			$infPsc=$modeloPsc->consultaPsc();
			$modeloPsc->attributes=$infPsc;			
		}
		$this->render('_actEstpscForm',array(
			'modeloPsc'=>$modeloPsc,
			'modeloDiaHora'=>$modeloDiaHora,
			'numDocAdol'=>$numDocAdol,	
			'datosAdol'=>$datosAdol,
			'edad'=>$edad,	
			'infPsc'=>$infPsc,
			'estadoPsc'=>$estadoPsc		
		));
	}
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
	*/
}