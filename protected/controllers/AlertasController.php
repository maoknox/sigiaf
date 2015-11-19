<?php
/** @addtogroup Principal */
/*@{*/


class AlertasController extends Controller{
	public $sedeForjar;			/**< sede o unidad operativa al cual accede el usuario al aplicativo */
	public $numCasos=0;			/**< Número de casos de alerta */
	public $numCasosIdReg=0;	/**< Número de casos de identificación y registro */
	public $numCasosAsist=0;	/**< Número de casos de asistencia*/
	public $numCasosSeguim=0;	/**< Número de casos de seguimiento*/
	public $numCasosValPsicol=0;/**< Número de casos de valoración en psicología*/
	public $numCasosConcInt=0;	/**< Número de casos de concepto integral*/
	public $numCasosPAI=0;		/**< Número de casos de concepto plan de atención integral*/
	public $numCasosValTrSoc=0;	/**< Número de casos de trabajo social*/
	public $numCasosValTO=0;	/**< Número de casos de terapia ocupacional*/
	public $numCasosValPsiq=0;	/**< Número de casos de psiquiatría*/
	public $numCasosValEnf=0;	/**< Número de casos de enfermería*/
	public $numCasosSeguimMD=0;	/**< Número de casos de segjimiento no psicosocial*/
	public $numCasosRef=0;		/**< Número de casos de segjimiento de referenciación*/
	public $icono;				/**< nombre icono de alerta*/
	
	/** Método de filtro.       
	*  Se ejecuta en segunda instancia para comprobar si el usuario está logueado o no.  
	*/		
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	/** Método de filtros, .       
	*  Se ejecuta primero esta acción para  
	*/		
	public function filters(){
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}
	
	
	/** Acción AsociaAlertas, .       
	*  Ejecuta funciones de búsqueda de alertas según el rol de usuario.
	*/		
	public function actionAsociaAlertas(){		
		$rolUsuario=Yii::app()->user->getState('rol');
		$this->sedeForjar=Yii::app()->user->getState('sedeForjar');
		$alertas=array();
		switch($rolUsuario){
			case 1:
			
			break;
			case 2:
				$arrayAlDB=$this->generaAlertaDatosBasicos();				
				$arrayAsist=$this->generaAlertaAsistencia();
				if($this->numCasosIdReg>0 || $this->numCasosAsist>0){
					$icono="glyphicon glyphicon-warning-sign";
				}
				else{
					$icono="glyphicon glyphicon-ok";
				}
				$alertas=array("alertaMenu"=>$icono);
				$alertas["alertaSlider"]=array();
				array_push($alertas["alertaSlider"],
					$arrayAlDB
				);
				array_push($alertas["alertaSlider"],
					$arrayAsist
				);
			break;
			case 3:
				$arrayAlDB=$this->generaAlertaDatosBasicos();				
				$arrayAsist=$this->generaAlertaAsistencia();
				if($this->numCasosIdReg>0 || $this->numCasosAsist>0){
					$icono="glyphicon glyphicon-warning-sign";
				}
				else{
					$icono="glyphicon glyphicon-ok";
				}
				$alertas=array("alertaMenu"=>$icono);
				$alertas["alertaSlider"]=array();
				array_push($alertas["alertaSlider"],
					$arrayAlDB
				);
				array_push($alertas["alertaSlider"],
					$arrayAsist
				);
			break;
			case 4:
				$arraySeguim=$this->generaAlertaSeguimiento();
				$arrayValPsicol=$this->generaAlertaValPsicol();	
				$arrayConcInt=$this->generaAlertaConcInt();
				$arrayPAI=$this->generaAlertaPAI();				
				if($this->numCasosSeguim>0 || $this->numCasosValPsicol>0 || $this->numCasosConcInt>0 || $this->numCasosPAI>0){
					$icono="glyphicon glyphicon-warning-sign";
				}
				else{
					$icono="glyphicon glyphicon-ok";
				}
				$alertas=array("alertaMenu"=>$icono);
				$alertas["alertaSlider"]=array();
				array_push($alertas["alertaSlider"],
					$arraySeguim					
				);
				array_push($alertas["alertaSlider"],
					$arrayValPsicol
				);
				array_push($alertas["alertaSlider"],
					$arrayConcInt
				);
				array_push($alertas["alertaSlider"],
					$arrayPAI
				);
			break;
			case 5:
				$arraySeguim=$this->generaAlertaSeguimiento();
				$arrayValTrSoc=$this->generaAlertaValTrSoc();	
				$arrayConcInt=$this->generaAlertaConcInt();
				$arrayPAI=$this->generaAlertaPAI();				
				if($this->numCasosSeguim>0 || $this->numCasosValPsicol>0 || $this->numCasosConcInt>0 || $this->numCasosPAI>0){
					$icono="glyphicon glyphicon-warning-sign";
				}
				else{
					$icono="glyphicon glyphicon-ok";
				}
				$alertas=array("alertaMenu"=>$icono);
				$alertas["alertaSlider"]=array();
				array_push($alertas["alertaSlider"],
					$arraySeguim					
				);
				array_push($alertas["alertaSlider"],
					$arrayValTrSoc
				);
				array_push($alertas["alertaSlider"],
					$arrayConcInt
				);
				array_push($alertas["alertaSlider"],
					$arrayPAI
				);
			break;
			case 6:
				$arraySeguim=$this->generaAlertaSeguimientoMD();
				$arrayValTo=$this->generaAlertaValTo();
				if($this->numCasosSeguimMD>0 || $this->numCasosValTO>0){
					$icono="glyphicon glyphicon-warning-sign";
				}
				else{
					$icono="glyphicon glyphicon-ok";
				}
				$alertas=array("alertaMenu"=>$icono);
				$alertas["alertaSlider"]=array();
				array_push($alertas["alertaSlider"],
					$arraySeguim					
				);
				array_push($alertas["alertaSlider"],
					$arrayValTo					
				);
			break;
			case 7:
				$arrayValPsiq=$this->generaAlertaValPsiq();
				if($this->numCasosValPsiq>0){
					$icono="glyphicon glyphicon-warning-sign";
				}
				else{
					$icono="glyphicon glyphicon-ok";
				}
				$alertas=array("alertaMenu"=>$icono);
				$alertas["alertaSlider"]=array();
				array_push($alertas["alertaSlider"],
					$arrayValPsiq					
				);
			break;
			case 9:
				$arraySeguim=$this->generaAlertaSeguimientoMD();
				$arrayValEnf=$this->generaAlertaEnfermeria();
				if($this->numCasosSeguim>0 || $this->numCasosValEnf>0){
					$icono="glyphicon glyphicon-warning-sign";
				}
				else{
					$icono="glyphicon glyphicon-ok";
				}
				$alertas=array("alertaMenu"=>$icono);
				$alertas["alertaSlider"]=array();
				array_push($alertas["alertaSlider"],
					$arraySeguim					
				);
				array_push($alertas["alertaSlider"],
					$arrayValEnf					
				);
			break;
			case 10:
				$arrayRef=$this->generaAlertaReferenciacion();
				if($this->numCasosRef>0){
					$icono="glyphicon glyphicon-warning-sign";
				}
				else{
					$icono="glyphicon glyphicon-ok";
				}
				$alertas=array("alertaMenu"=>$icono);
				$alertas["alertaSlider"]=array();
				array_push($alertas["alertaSlider"],
					$arrayRef					
				);
			break;
			case 11:
				
			break;
			default:
				$arraySeguim=$this->generaAlertaSeguimientoMD();
				if(!empty($arraySeguim)&& is_array($arraySeguim)){
					if($this->numCasosSeguimMD>0){
						$icono="glyphicon glyphicon-warning-sign";
					}
					else{
						$icono="glyphicon glyphicon-ok";
					}
					$alertas=array("alertaMenu"=>$icono);
					$alertas["alertaSlider"]=array();
					array_push($alertas["alertaSlider"],
						$arraySeguim					
					);
				}
			break;
		}		
		echo CJSON::encode($alertas);	
	}
	public function actionMuestraFaltantes(){
		$datos=Yii::app()->input->post();
		//llama a la función que permite mostrar los adolescentes a los cuales les hace falta diligenciar información
		//$this->$datos["nombreModulo"];
		echo $this->$datos["nombreModulo"];		
		//echo $datos["nombreModulo"];
		//$infFaltante=array();		
		
	}
	
	/** Método de actionAlertasIdRegistro.       
	*  Acción que crea un array con los adolescentes a los cuales les falta el diligenciamiento de datos básicos y nombra los datos que hacen falta diligencia.  
	*/			
	public function actionAlertasIdRegistro(){
		$this->sedeForjar=Yii::app()->user->getState('sedeForjar');
		$sedeForjar=$this->sedeForjar;
		$adols=$this->consultaAdol();
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Datos Localización"),
			"c3"=>CHtml::encode("Documentos Remitidos"),
			"c4"=>CHtml::encode("Datos Acudiente"))
		);
		$infFaltante["titulo"]=array("titulo"=>"Identificación y Registro");
		$adols=$this->consultaAdol();
		$infFaltante["infoFaltantes"]=array();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$identIngreso=false;
				$consLocAdol=$this->consultaLocAdol($adolescente["num_doc"]);
				$consDocsAdol=$this->consultaDocumentoAdol($adolescente["num_doc"]);
				$consAcudAdol=$this->consultaAcudienteAdol($adolescente["num_doc"]);
				if(empty($consLocAdol)){
					$localizacion="Falta Diligenciar";
					$identIngreso=true;
				}
				else{
					$localizacion="Diligenciado";
				}
				if(empty($consDocsAdol)){
					$identIngreso=true;
					$documentos="Falta Diligenciar";
				}
				else{
					$documentos="Diligenciado";
				}
				
				if(empty($consAcudAdol)){
					$identIngreso=true;
					$acudiente="Falta Diligenciar";
				}
				else{
					$acudiente="Diligenciado";
				}
				if($identIngreso==true){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"infoloc"=>$localizacion,
						"infoDoc"=>$documentos,
						"infoAcud"=>$documentos,
					));
				}
			}
		}		
		echo CJSON::encode($infFaltante);	
	}
	/** Método de actionAlertasAsistencia.       
	*  Acción que crea un array con los adolesccentes cuya asistencia no se ha registrado.  
	*/				
	public function actionAlertasAsistencia(){
		$this->sedeForjar=Yii::app()->user->getState('sedeForjar');
		$sedeForjar=$this->sedeForjar;
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Días sin registro"),
			"c3"=>CHtml::encode("Adolescente sin Asistencia")
		));
		$infFaltante["titulo"]=array("titulo"=>"Asistencia");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdol();
		foreach($adols as $adolescente){
			$paiAdol=array();
			$asistencia=array();
			$paiAdol=$this->consultaPai($adolescente["num_doc"]);
			$asistencia=$this->consultaAsistencia($adolescente["num_doc"]);
			$dias=0;
			$noRegAsist="";
			if(!empty($asistencia) && !empty($paiAdol)){
				$dias	= (strtotime($asistencia["fecha_asistencia"])-strtotime(date("Y-m-d")))/86400;
				$dias 	= abs($dias); $dias = floor($dias);		
				array_push($infFaltante["infoFaltantes"],array(
					"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
					"dSInf"=>$dias,
					"noAsist"=>"",
				));				
			}
			elseif(empty($asistencia) && !empty($paiAdol)){
				$noRegAsist="X";	
				array_push($infFaltante["infoFaltantes"],array(
					"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
					"dSInf"=>"",
					"noAsist"=>'X',
				));			
			}
			
		}
		echo CJSON::encode($infFaltante);	
	}
	
	/** Método de actionAlertasSeguimiento.       
	*  Acción que crea un array con los adolesccentes a los cuales no se les ha realizado un seguimiento según un rango de días.  
	*/					
	public function actionAlertasSeguimiento(){
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Días sin Seguimiento"),
		));
		$infFaltante["titulo"]=array("titulo"=>"Seguimiento");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdolProf();
		foreach($adols as $adolescente){
			$seguimiento=array();
			$seguimiento=$this->consultaSeguimiento($adolescente["num_doc"]);				
			if(!empty($seguimiento)){
				$dias	= (strtotime($seguimiento["fecha_seguimiento"])-strtotime(date("Y-m-d")))/86400;
				$dias 	= abs($dias); $dias = floor($dias);	
				//echo $dias."<br>";
				if($dias>60){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"dNoSeg"=>$dias,							
					));			
				}
			}
		}
		echo CJSON::encode($infFaltante);	
	}

	/** Método de actionAlertasSeguimientoMD.       
	*  Acción que crea un array con los adolesccentes a los cuales no se les ha realizado un seguimiento por parte de los equipos multidisciplinarios según un rango de días.  
	*/						
	public function actionAlertasSeguimientoMD(){
		$this->sedeForjar=Yii::app()->user->getState('sedeForjar');
		$sedeForjar=$this->sedeForjar;
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Días sin Seguimiento"),
		));
		$infFaltante["titulo"]=array("titulo"=>"Seguimiento");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdol();
		foreach($adols as $adolescente){
			$seguimiento=array();
			$seguimiento=$this->consultaSeguimiento($adolescente["num_doc"]);				
			if(!empty($seguimiento)){
				$dias	= (strtotime($seguimiento["fecha_seguimiento"])-strtotime(date("Y-m-d")))/86400;
				$dias 	= abs($dias); $dias = floor($dias);	
				//echo $dias."<br>";
				if($dias>60){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"dNoSeg"=>$dias,							
					));			
				}
			}
		}
		echo CJSON::encode($infFaltante);	
	}
	
	/** Método de actionAlertasValPsicol.       
	*  Acción que muestra los adolescentes que no tienen una valoración en psicología o que no tienen un estado de valoración.
	*/						
	public function actionAlertasValPsicol(){
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Sin Valoración"),
			"c3"=>CHtml::encode("Sin estado de valoración"),
		));
		$infFaltante["titulo"]=array("titulo"=>"Valoracón en Psicología");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valPsicolAdol=$this->consultaValPsicol($adolescente["num_doc"]);				
				if(empty($valPsicolAdol)){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"sinV"=>"X",
						"sinEst"=>"",								
					));	
				}
				else{
					$dias	= (strtotime($valPsicolAdol["fecha_iniciovalpsicol"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valPsicolAdol["id_estado_val"]) && $dias>15){
						array_push($infFaltante["infoFaltantes"],array(
							"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
							"sinV"=>"",
							"sinEst"=>"X",						
						));							
					}
				}
			}
		}
		echo CJSON::encode($infFaltante);	
	}
	
	
	/** Método de actionAlertasValPsicol.       
	*  Acción que muestra los adolescentes que no tienen una valoración en trabajo social o que no tienen un estado de valoración.
	*/						
	public function actionAlertasValTrSoc(){
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Sin Valoración"),
			"c3"=>CHtml::encode("Sin estado de valoración"),
		));
		$infFaltante["titulo"]=array("titulo"=>"Valoracón en Trabajo Social");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valTrSocAdol=$this->consultaValTrSoc($adolescente["num_doc"]);		
				if(empty($valTrSocAdol)){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"sinV"=>"",
						"sinEst"=>"X",						
					));	
				}
				else{
					$dias	= (strtotime($valTrSocAdol["fecha_inicio_valtsoc"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valTrSocAdol["id_estado_val"]) && $dias>15){
						array_push($infFaltante["infoFaltantes"],array(
							"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
							"sinV"=>"",
							"sinEst"=>"X",						
						));						
					}
				}
			}
		}
		echo CJSON::encode($infFaltante);	
	}
	
	/** Método de actionAlertaValTO.       
	*  Acción que muestra los adolescentes que no tienen una valoración en Terapia ocupacional o que no tienen un estado de valoración.
	*/						
	public function actionAlertaValTO(){
		$this->sedeForjar=Yii::app()->user->getState('sedeForjar');
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Sin Valoración"),
			"c3"=>CHtml::encode("Sin estado de valoración"),
		));
		$infFaltante["titulo"]=array("titulo"=>"Valoracón en Terapia Ocupacional");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valTOAdol=$this->consultaValTO($adolescente["num_doc"]);		
				if(empty($valTOAdol)){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"sinV"=>"X",
						"sinEst"=>"",						
					));	
				}
				else{
					$dias	= (strtotime($valTOAdol["fecha_inicio_valteo"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valTOAdol["id_estado_val"])&&$dias>15){
						array_push($infFaltante["infoFaltantes"],array(
							"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
							"sinV"=>"",
							"sinEst"=>"X",						
						));	
					}
				}
			}
		}
		echo CJSON::encode($infFaltante);	
	}

	/** Método de actionAlertaValPsiq.       
	*  Acción que muestra los adolescentes que no tienen una valoración en Psiquiatría o que no tienen un estado de valoración.
	*/							
	public function actionAlertaValPsiq(){
		$this->sedeForjar=Yii::app()->user->getState('sedeForjar');
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Sin Valoración"),
			"c3"=>CHtml::encode("Sin estado de valoración"),
		));
		$infFaltante["titulo"]=array("titulo"=>"Valoracón en Psiquiatría");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valPsiqAdol=$this->consultaValPsiq($adolescente["num_doc"]);		
				if(empty($valPsiqAdol)){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"sinV"=>"X",
						"sinEst"=>"",						
					));	
				}
				else{
					$dias	= (strtotime($valPsiqAdol["fecha_ini_vpsiq"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valPsiqAdol["id_estado_val"])&&$dias>15){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"sinV"=>"",
						"sinEst"=>"X",						
					));	
					}
				}
			}
		}
		echo CJSON::encode($infFaltante);	
	}
	
	/** Método de actionAlertaValEnf.       
	*  Acción que muestra los adolescentes que no tienen una valoración en Valoración en enfermería o que no tienen un estado de valoración.
	*/							
	public function actionAlertaValEnf(){
		$this->sedeForjar=Yii::app()->user->getState('sedeForjar');
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Sin Valoración"),
			"c3"=>CHtml::encode("Sin estado de valoración"),
		));
		$infFaltante["titulo"]=array("titulo"=>"Valoracón en Enfermería");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valEnfAdol=$this->consultaValEnf($adolescente["num_doc"]);		
				if(empty($valEnfAdol)){
					array_push($infFaltante["infoFaltantes"],array(
						"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
						"sinV"=>"X",
						"sinEst"=>"",						
					));	
				}
				else{
					$dias	= (strtotime($valEnfAdol["fecha_ini_venf"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valEnfAdol["id_estado_val"])&&$dias>15){
						array_push($infFaltante["infoFaltantes"],array(
							"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
							"sinV"=>"",
							"sinEst"=>"X",						
						));	
					}
				}
			}
		}
		echo CJSON::encode($infFaltante);	
	}
	
	
	/** Método de actionAlertaValEnf.       
	*  Acción que muestra los adolescentes que no tienen una concepto integral definido.
	*/							
	public function actionAlertasConcInt(){
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Sin Concepto Integral"),
			"c3"=>CHtml::encode("Concepto Integral no concertado"),
		));
		$infFaltante["titulo"]=array("titulo"=>"Concepto Integral");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valPsicolAdol=$this->consultaValPsicol($adolescente["num_doc"]);	
				$valTrSocAdol=$this->consultaValTrSoc($adolescente["num_doc"]);		
				if(!empty($valPsicolAdol) && !empty($valTrSocAdol)){
					if($valPsicolAdol["id_estado_val"]==1 && $valTrSocAdol["id_estado_val"]==1){
						$consultas= new ConsultasGenerales();
						$consultas->numDocAdol=$adolescente["num_doc"];
						$consConcInt=$consultas->consultaConcInt();
						if(empty($consConcInt)){
							array_push($infFaltante["infoFaltantes"],array(
								"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
								"sinCInt"=>"X",
								"sinCIntCons"=>"",								
							));	
						}	
						elseif(empty($consConcInt["aprueba_psicol"]) || empty($consConcInt["aprueba_tsocial"])){
							array_push($infFaltante["infoFaltantes"],array(
								"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],
								"sinCInt"=>"",
								"sinCIntCons"=>"X",								
							));	
						}
					}					
				}
			}			
		}	
		echo CJSON::encode($infFaltante);	
	}
	
	/** Método de actionAlertaValEnf.       
	*  Acción que muestra los adolescentes que no tienen una Plan de atención integral definido.
	*/							
	public function actionAlertasPAI(){
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Sin PAI"),
		));
		$infFaltante["titulo"]=array("titulo"=>"PAI (Proceso de Atención Integral)");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$consultas= new ConsultasGenerales();
				$consultas->numDocAdol=$adolescente["num_doc"];
				$consConcInt=$consultas->consultaConcInt();					
				if($consConcInt["aprueba_psicol"]==1 && $consConcInt["aprueba_tsocial"]==1){
					$pai=array();
					$pai=$this->consultaPAIAdol($adolescente["num_doc"]);
					if(empty($pai)){
						array_push($infFaltante["infoFaltantes"],array(
							"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],	
							"insPAI"=>"x"						
						));	
					}
				}						
			}
		}
		echo CJSON::encode($infFaltante);	
	}
	
	/** Método de actionAlertaValEnf.       
	*  Acción que muestra los adolescentes con referenciaciones cuya gestión esta en solicitud y en trámite luego de un periodo de tiempo.
	*/							
	public function actionAlertasRef(){
		$this->sedeForjar=Yii::app()->user->getState('sedeForjar');
		$infFaltante=array("cabezote"=>array(
			"c1"=>CHtml::encode("Nombre Adolescente"),
			"c2"=>CHtml::encode("Referenciación en Solicitud"),
			"c3"=>CHtml::encode("Referenciación en Trámite"),
			"c4"=>CHtml::encode("Días desde su creación")
		));
		$infFaltante["titulo"]=array("titulo"=>"Referenciación");
		$infFaltante["infoFaltantes"]=array();
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$consRefer=$this->consultaReferenciacion($adolescente["num_doc"]);
				if(!empty($consRefer)){
					$dias	= (strtotime($consRefer["fecha_referenciacion"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if($consRefer["id_estadoref"]==1){
						if($dias>10){
							array_push($infFaltante["infoFaltantes"],array(
								"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],	
								"refSol"=>"X",
								"refTram"=>"",
								"refDiasTransc"=>$dias,					
							));	
						}
					}
					elseif($consRefer["id_estadoref"]==2){
						if($dias>10){
							if($dias>20){
								array_push($infFaltante["infoFaltantes"],array(
									"nombre"=>$adolescente["nombres"]." ".$adolescente["apellido_1"]." ".$adolescente["apellido_2"],	
									"refSol"=>"",
									"refTram"=>"X",
									"refDiasTransc"=>$dias,					
								));	
							}
						}
					}
				}
			}
		}		
		echo CJSON::encode($infFaltante);	
	}
	
	/** Método de actionAlertaValEnf.       
	*  Acción prepara los datos a ser mostrados de alerta de datos basicos en la consulta ajax, se define el icono de alerta.
	*/							
	public function generaAlertaDatosBasicos(){
		$sedeForjar=$this->sedeForjar;
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$identIngreso=false;
				$consLocAdol=$this->consultaLocAdol($adolescente["num_doc"]);
				$consDocsAdol=$this->consultaDocumentoAdol($adolescente["num_doc"]);
				$consAcudAdol=$this->consultaAcudienteAdol($adolescente["num_doc"]);
				if(empty($consLocAdol)){
					$identIngreso=true;
				}
				if(empty($consDocsAdol)){
					$identIngreso=true;
				}
				if(empty($consAcudAdol)){
					$identIngreso=true;
				}
				if($identIngreso==true){
					$this->numCasosIdReg+=1;					
				}
			}
		}
		
		else{
			$iconoIdReg="glyphicon glyphicon-ok";
		}
			if($this->numCasosIdReg>0){
				$iconoIdReg="glyphicon glyphicon-warning-sign";
			}
			else{
				$iconoIdReg="glyphicon glyphicon-ok";
			}
			$arrayAdDB=array(
				'url'=>CHtml::encode('alertasIdRegistro'),
				'icono'=>CHtml::encode($iconoIdReg),
				'modulo'=>CHtml::encode('Identificación y registro'),
				'numCasos'=>CHtml::encode($this->numCasosIdReg)
			);			
		return $arrayAdDB;
	}
	
	/** Método de actionAlertaValEnf.       
	*  Acción prepara los datos a ser mostrados de alerta de Asistencia en la consulta ajax, se define el icono de alerta.
	*/							
	public function generaAlertaAsistencia(){
		$sedeForjar=$this->sedeForjar;
		$adols=$this->consultaAdol();
		foreach($adols as $adolescente){
			$paiAdol=array();
			$asistencia=array();
			$paiAdol=$this->consultaPai($adolescente["num_doc"]);
			$asistencia=$this->consultaAsistencia($adolescente["num_doc"]);
			if(!empty($asistencia) && !empty($paiAdol)){
				$dias	= (strtotime($asistencia["fecha_asistencia"])-strtotime(date("Y-m-d")))/86400;
				$dias 	= abs($dias); $dias = floor($dias);	
				if($dias>30){
					$this->numCasosAsist+=1;				
				}
			}
			elseif(empty($asistencia) && !empty($paiAdol)){
				$this->numCasosAsist+=1;				
			}
		}
		if($this->numCasosAsist==0){
			$iconoAsist="glyphicon glyphicon-ok";
		}
		else{
			$iconoAsist="glyphicon glyphicon-warning-sign";
		}
		$arrayAsist=array(
			'url'=>CHtml::encode('alertasAsistencia'),
			'icono'=>CHtml::encode($iconoAsist),
			'modulo'=>CHtml::encode('Asistencia'),
			'numCasos'=>CHtml::encode($this->numCasosAsist)
		);
		return 	$arrayAsist;		
	}
	
	/** Método de actionAlertaValEnf.       
	*  Acción prepara los datos a ser mostrados de alerta de seguimiento psicosocial en la consulta ajax, se define el icono de alerta.
	*/							
	public function generaAlertaSeguimiento(){		
		$sedeForjar=$this->sedeForjar;
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$seguimiento=array();
				$seguimiento=$this->consultaSeguimiento($adolescente["num_doc"]);				
				if(!empty($seguimiento)){
					$dias	= (strtotime($seguimiento["fecha_seguimiento"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					//echo $dias."<br>";
					if($dias>Yii::app()->params["tiempo_alertas"]){
						$this->numCasosSeguim+=1;
						//echo $this->numCasosSeguim."<br>";
					}
				}
			}
		}	
		if($this->numCasosSeguim==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arraySeguim=array(
			'url'=>CHtml::encode('alertasSeguimiento'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Seguimiento'),
			'numCasos'=>CHtml::encode($this->numCasosSeguim)
		);
		return 	$arraySeguim;	
	}
	
	
	/** Método de actionAlertaValEnf.       
	*  Acción prepara los datos a ser mostrados de alerta de seguimiento no psicosocial en la consulta ajax, se define el icono de alerta.
	*/							
	public function generaAlertaSeguimientoMD(){		
		$sedeForjar=$this->sedeForjar;
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$seguimiento=array();
				$seguimiento=$this->consultaSeguimiento($adolescente["num_doc"]);				
				if(!empty($seguimiento)){
					$dias	= (strtotime($seguimiento["fecha_seguimiento"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					//echo $dias."<br>";
					if($dias>60){
						$this->numCasosSeguimMD+=1;
						//echo $this->numCasosSeguim."<br>";
					}
				}
			}
		}	
		if($this->numCasosSeguimMD==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arraySeguimMD=array(
			'url'=>CHtml::encode('alertasSeguimientoMD'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Seguimiento'),
			'numCasos'=>CHtml::encode($this->numCasosSeguimMD)
		);
		return 	$arraySeguimMD;	
	}
	
	/** Método de generaAlertaValPsicol.       
	*  Acción prepara los datos a ser mostrados de alerta de valoración en psicología en la consulta ajax, se define el icono de alerta.
	*/								
	public function generaAlertaValPsicol(){
		$sedeForjar=$this->sedeForjar;
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valPsicolAdol=$this->consultaValPsicol($adolescente["num_doc"]);				
				if(empty($valPsicolAdol)){
					$this->numCasosValPsicol+=1;
				}
				else{
					$dias	= (strtotime($valPsicolAdol["fecha_iniciovalpsicol"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valPsicolAdol["id_estado_val"]) && $dias>15){
						$this->numCasosValPsicol+=1;						
					}
				}
			}
		}
		if($this->numCasosValPsicol==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arrayValPsicol=array(
			'url'=>CHtml::encode('alertasValPsicol'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Valoración Psicología'),
			'numCasos'=>CHtml::encode($this->numCasosValPsicol)
		);
		return $arrayValPsicol;
	}
	
	/** Método de generaAlertaValTrSoc.       
	*  Acción prepara los datos a ser mostrados de alerta de valoración en trabajo social en la consulta ajax, se define el icono de alerta.
	*/								
	public function generaAlertaValTrSoc(){
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valTrSocAdol=$this->consultaValTrSoc($adolescente["num_doc"]);		
				if(empty($valTrSocAdol)){
					$this->numCasosValTrSoc+=1;
				}
				else{
					$dias	= (strtotime($valTrSocAdol["fecha_inicio_valtsoc"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valTrSocAdol["id_estado_val"]) && $dias>15){
						$this->numCasosValTrSoc+=1;						
					}
				}
			}
		}
		if($this->numCasosValTrSoc==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arrayValTrSoc=array(
			'url'=>CHtml::encode('alertasValTrSoc'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Valoración Trabajo Social'),
			'numCasos'=>CHtml::encode($this->numCasosValTrSoc)
		);
		return $arrayValTrSoc;
	}

	/** Método de generaAlertaValTrSoc.       
	*  Acción prepara los datos a ser mostrados de alerta de valoración en terapia ocupacional en la consulta ajax, se define el icono de alerta.
	*/								
	public function generaAlertaValTo(){
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valTOAdol=$this->consultaValTO($adolescente["num_doc"]);		
				if(empty($valTOAdol)){
					$this->numCasosValTO+=1;
				}
				else{
					$dias	= (strtotime($valTOAdol["fecha_inicio_valteo"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valTOAdol["id_estado_val"])&&$dias>15){
						$this->numCasosValTO+=1;
					}
				}
			}
		}
		if($this->numCasosValTO==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arrayValTO=array(
			'url'=>CHtml::encode('alertaValTO'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Valoración Terapia Ocupacional'),
			'numCasos'=>CHtml::encode($this->numCasosValTO)
		);
		return $arrayValTO;
	}
	
	
	/** Método de generaAlertaValTrSoc.       
	*  Acción prepara los datos a ser mostrados de alerta de valoración en psiquiatría en la consulta ajax, se define el icono de alerta.
	*/								
	public function generaAlertaValPsiq(){
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valPsiqAdol=$this->consultaValPsiq($adolescente["num_doc"]);		
				if(empty($valPsiqAdol)){
					$this->numCasosValPsiq+=1;
				}
				else{
					$dias	= (strtotime($valPsiqAdol["fecha_ini_vpsiq"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valPsiqAdol["id_estado_val"])&&$dias>15){
						$this->numCasosValPsiq+=1;
					}
				}
			}
		}
		if($this->numCasosValPsiq==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arrayValPsiq=array(
			'url'=>CHtml::encode('alertaValPsiq'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Valoración Psiquiatría'),
			'numCasos'=>CHtml::encode($this->numCasosValPsiq)
		);
		return $arrayValPsiq;
	}
	
	/** Método de generaAlertaValTrSoc.       
	*  Acción prepara los datos a ser mostrados de alerta de valoración en enfermería en la consulta ajax, se define el icono de alerta.
	*/								
	public function generaAlertaEnfermeria(){
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valEnfAdol=$this->consultaValEnf($adolescente["num_doc"]);		
				if(empty($valEnfAdol)){
					$this->numCasosValEnf+=1;
				}
				else{
					$dias	= (strtotime($valEnfAdol["fecha_ini_venf"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if(empty($valEnfAdol["id_estado_val"])&&$dias>15){
						$this->numCasosValEnf+=1;
					}
				}
			}
		}
		if($this->numCasosValEnf==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arrayValEnf=array(
			'url'=>CHtml::encode('alertaValEnf'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Valoración Enfermería'),
			'numCasos'=>CHtml::encode($this->numCasosValEnf)
		);
		return $arrayValEnf;
	}
	
	/** Método de generaAlertaConcInt.       
	*  Acción prepara los datos a ser mostrados de alerta de valoración en concepto integral en la consulta ajax, se define el icono de alerta.
	*/								
	public function generaAlertaConcInt(){
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$valPsicolAdol=$this->consultaValPsicol($adolescente["num_doc"]);	
				$valTrSocAdol=$this->consultaValTrSoc($adolescente["num_doc"]);		
				if(!empty($valPsicolAdol) && !empty($valTrSocAdol)){
					if($valPsicolAdol["id_estado_val"]==1 && $valTrSocAdol["id_estado_val"]==1){
						$consultas= new ConsultasGenerales();
						$consultas->numDocAdol=$adolescente["num_doc"];
						$consConcInt=$consultas->consultaConcInt();
						if(empty($consConcInt)){
							$this->numCasosConcInt+=1;
						}	
						elseif(empty($consConcInt["aprueba_psicol"]) || empty($consConcInt["aprueba_tsocial"])){
							$this->numCasosConcInt+=1;	
						}						
					}					
				}
			}			
		}
		if($this->numCasosConcInt==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arrayConcInt=array(
			'url'=>CHtml::encode('alertasConcInt'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Concepto Integral'),
			'numCasos'=>CHtml::encode($this->numCasosConcInt)
		);
		return $arrayConcInt;
	}

	
	/** Método de generaAlertaPAI.       
	*  Acción prepara los datos a ser mostrados de alerta de valoración en plan de atención integral en la consulta ajax, se define el icono de alerta.
	*/								
	public function generaAlertaPAI(){
		$adols=$this->consultaAdolProf();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$consultas= new ConsultasGenerales();
				$consultas->numDocAdol=$adolescente["num_doc"];
				$consConcInt=$consultas->consultaConcInt();					
				if($consConcInt["aprueba_psicol"]==1 && $consConcInt["aprueba_tsocial"]==1){
					$pai=array();
					$pai=$this->consultaPAIAdol($adolescente["num_doc"]);
					if(empty($pai)){
						$this->numCasosPAI+=1;	
					}
				}						
			}
		}
		if($this->numCasosPAI==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arrayPAI=array(
			'url'=>CHtml::encode('alertasPAI'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('PAI (Plan de Atención Integral)'),
			'numCasos'=>CHtml::encode($this->numCasosPAI)
		);
		return $arrayPAI;
	}
	
	
	/** Método de generaAlertaReferenciacion.       
	*  Acción prepara los datos a ser mostrados de alerta de valoración en referenciación en la consulta ajax, se define el icono de alerta.
	*/								
	private function generaAlertaReferenciacion(){
		$adols=$this->consultaAdol();
		if(!empty($adols)){
			foreach($adols as $adolescente){
				$consRefer=$this->consultaReferenciacion($adolescente["num_doc"]);
				if(!empty($consRefer)){
					$dias	= (strtotime($consRefer["fecha_referenciacion"])-strtotime(date("Y-m-d")))/86400;
					$dias 	= abs($dias); $dias = floor($dias);	
					if($consRefer["id_estadoref"]==1){
						if($dias>10){
							$this->numCasosRef+=1;
						}
					}
					elseif($consRefer["id_estadoref"]==2){
						if($dias>10){
							if($dias>20){
								$this->numCasosRef+=1;
							}
						}
					}
				}
			}
		}	
		if($this->numCasosRef==0){
			$iconoSeg="glyphicon glyphicon-ok";
		}
		else{
			$iconoSeg="glyphicon glyphicon-warning-sign";
		}	
		$arrayConcInt=array(
			'url'=>CHtml::encode('alertasRef'),
			'icono'=>CHtml::encode($iconoSeg),
			'modulo'=>CHtml::encode('Referenciación'),
			'numCasos'=>CHtml::encode($this->numCasosRef)
		);
		return $arrayConcInt;	
	}
	
	/** Método de consultaAdol.       
	*  Acción para consultar los adolescetes que estan activos y cuya sede de forjar es la del usuario logueado del momento.
	*/								
	public function consultaAdol(){
		$conect= Yii::app()->db;
		$sqlConsAdol="select * from adolescente as a left join forjar_adol as b on b.num_doc=a.num_doc and id_estado_adol=1 where id_forjar=:id_forjar";
		$consAdol=$conect->createCommand($sqlConsAdol);
		$consAdol->bindParam(":id_forjar",$this->sedeForjar);
		$readAdols=$consAdol->query();
		$resAdols=$readAdols->readAll();
		$readAdols->close();
		return $resAdols;		
	}
	
	/** Método de consultaAdolProf.       
	*  Acción para consultar el equipo psicosocial responsable de cada adolescente.
	*/								
	public function consultaAdolProf(){
		$conect= Yii::app()->db;
		$sqlConsAdol="
		select * from adolescente as a 
			left join forjar_adol as b on b.num_doc=a.num_doc 
			left join hist_personal_adol as c on c.num_doc=a.num_doc 
		where id_cedula=:id_cedula and id_estado_adol=1 and asignado_actualmente is true";		
		$consAdol=$conect->createCommand($sqlConsAdol);
		$consAdol->bindParam(":id_cedula",Yii::app()->user->getState('cedula'));
		$readAdols=$consAdol->query();
		$resAdols=$readAdols->readAll();
		$readAdols->close();
		return "";		
	}
	
	/** Método de consultaAdolPai.       
	*  Acción para consultar si los adolescentes tienen pai no culminado.
	*/									
	public function consultaAdolPai(){
		$conect= Yii::app()->db;
		$sqlConsAdol="select * from adolescente as a 
			left join forjar_adol as b on b.num_doc=a.num_doc 
			left join pai as c on c.num_doc=a.num_doc 
			where id_forjar=:id_forjar and pai_actual ='true' and culminacion_pai is not true";
		$consAdol=$conect->createCommand($sqlConsAdol);
		$consAdol->bindParam(":id_forjar",$this->sedeForjar);
		$readAdols=$consAdol->query();
		$resAdols=$readAdols->readAll();
		$readAdols->close();
		return $resAdols;		
	}	
	
	
	/** Método de consultaLocAdol.       
	*  Acción para consultar los datos de localización del adolescente.
	*/									
	public function consultaLocAdol($numDoc){
		$conect= Yii::app()->db;
		$sqlConsLocAdol="select * from localizacion_viv where num_doc=:num_doc";		
		$consLocAdol=$conect->createCommand($sqlConsLocAdol);
		$consLocAdol->bindParam(":num_doc",$numDoc);
		$readLocAdols=$consLocAdol->query();
		$resLocAdols=$readLocAdols->read();
		$readLocAdols->close();
		return $resLocAdols;				
	}
	
	public function consultaDerechoCespaAdol(){
						
	}
	
	
	/** Método de consultaDocumentoAdol.       
	*  Acción para consultar el registro de documentos remitidos por el cespa.
	*/									
	public function consultaDocumentoAdol($numDoc){
		$conect= Yii::app()->db;
		$sqlConsDocsAdol="select * from adol_doccespa where num_doc=:num_doc";		
		$consDocsAdol=$conect->createCommand($sqlConsDocsAdol);
		$consDocsAdol->bindParam(":num_doc",$numDoc);
		$readDocsAdols=$consDocsAdol->query();
		$resDocsAdols=$readDocsAdols->read();
		$readDocsAdols->close();
		return $resDocsAdols;			
	}

	/** Método de consultaAcudienteAdol.       
	*  Acción para consultar el acudiente del adolescente.
	*/										
	public function consultaAcudienteAdol($numDoc){
		$conect= Yii::app()->db;
		$sqlConsAcudAdol="select * from familiar_adolescente where acudiente is true and num_doc=:num_doc";		
		$consAcudAdol=$conect->createCommand($sqlConsAcudAdol);
		$consAcudAdol->bindParam(":num_doc",$numDoc);
		$readAcudAdols=$consAcudAdol->query();
		$resAcudAdols=$readAcudAdols->read();
		$readAcudAdols->close();
		return $resAcudAdols;			
	}

	/** Método de consultaPai.       
	*  Acción para consultar pai de adolescente.
	*/											
	public function consultaPai($numDoc){
		$conect= Yii::app()->db;
		$sqlConsPai="select * from pai where num_doc=:num_doc";
		$consPai=$conect->createCommand($sqlConsPai);
		$consPai->bindParam(":num_doc",$numDoc);
		$readPai=$consPai->query();
		$resPai=$readPai->read();
		$readPai->close();
		return $resPai;			
	}
	
	
	/** Método de consultaAsistencia.       
	*  Acción para consultar la asistencia del adolescente.
	*/											
	public function consultaAsistencia($numDoc){
		$conect= Yii::app()->db;
		$sqlConsAsist="select * from asistencia where num_doc=:num_doc order by fecha_asistencia desc limit 1";
		$consAsis=$conect->createCommand($sqlConsAsist);
		$consAsis->bindParam(":num_doc",$numDoc);
		$readAsist=$consAsis->query();
		$resAsist=$readAsist->read();
		$readAsist->close();
		return $resAsist;			
	}
	
	
	/** Método de consultaSeguimiento.       
	*  Acción para consultar los seguimientos del adolescente.
	*/											
	public function consultaSeguimiento($numDoc){
		$conect= Yii::app()->db;
		$sqlConsSeg="select * from seguimiento_adol where num_doc=:num_doc order by fecha_seguimiento desc limit 1";
		$consSeg=$conect->createCommand($sqlConsSeg);
		$consSeg->bindParam(":num_doc",$numDoc);
		$readSegAdol=$consSeg->query();
		$resSegAdol=$readSegAdol->read();
		$readSegAdol->close();
		return $resSegAdol;			
	}
		
	/** Método de consultaValPsicol.       
	*  Acción para consultar la valoración en psicología del adolescente.
	*/											
	public function consultaValPsicol($numDoc){
		$conect= Yii::app()->db;
		$sqlConsValPsicol="select * from valoracion_psicologia where num_doc=:num_doc";
		$consValPsicol=$conect->createCommand($sqlConsValPsicol);
		$consValPsicol->bindParam(":num_doc",$numDoc);
		$consValPsicol->execute();
		$readValPsicol=$consValPsicol->query();
		$resValPsicol=$readValPsicol->read();
		$readValPsicol->close();
		return $resValPsicol;
	}
	
	/** Método de consultaValTrSoc.       
	*  Acción para consultar la valoración en trabajo social del adolescente.
	*/											
	public function consultaValTrSoc($numDoc){
		$conect= Yii::app()->db;
		$sqlConsValTrSoc="select * from valoracion_trabajo_social where num_doc=:num_doc";
		$consValTrSoc=$conect->createCommand($sqlConsValTrSoc);
		$consValTrSoc->bindParam(":num_doc",$numDoc);
		$consValTrSoc->execute();
		$readValTrSoc=$consValTrSoc->query();
		$resValTrSoc=$readValTrSoc->read();
		$readValTrSoc->close();
		return $resValTrSoc;
	}
	
	/** Método de consultaValTO.       
	*  Acción para consultar la valoración en terapia ocupacional del adolescente.
	*/											
	public function consultaValTO($numDoc){
		$conect= Yii::app()->db;
		$sqlConsValTO="select * from valoracion_teo where num_doc=:num_doc";
		$consValTO=$conect->createCommand($sqlConsValTO);
		$consValTO->bindParam(":num_doc",$numDoc);
		$consValTO->execute();
		$readValTO=$consValTO->query();
		$resValTO=$readValTO->read();
		$readValTO->close();
		return $resValTO;
	}
	
	/** Método de consultaValPsiq.       
	*  Acción para consultar la valoración en psiquiatría del adolescente.
	*/											
	public function consultaValPsiq($numDoc){
		$conect= Yii::app()->db;
		$sqlConsValPsiq="select * from valoracion_psiquiatria where num_doc=:num_doc";
		$consValPsiq=$conect->createCommand($sqlConsValPsiq);
		$consValPsiq->bindParam(":num_doc",$numDoc);
		$consValPsiq->execute();
		$readValPsiq=$consValPsiq->query();
		$resValPsiq=$readValPsiq->read();
		$readValPsiq->close();
		return $resValPsiq;
	}
		
	/** Método de consultaValEnf.       
	*  Acción para consultar la valoración enfermería del adolescente.
	*/											
	public function consultaValEnf($numDoc){
		$conect= Yii::app()->db;
		$sqlConsValEnf="select * from valoracion_enfermeria where num_doc=:num_doc";
		$consValEnf=$conect->createCommand($sqlConsValEnf);
		$consValEnf->bindParam(":num_doc",$numDoc);
		$consValEnf->execute();
		$readValEnf=$consValEnf->query();
		$resValEnf=$readValEnf->read();
		$readValEnf->close();
		return $resValEnf;
	}
	
	/** Método de consultaPAIAdol.       
	*  Acción para consultar el plan de atención integral actual del adolescente.
	*/											
	public function consultaPAIAdol($numDoc){
		$conect= Yii::app()->db;
		$sqlConsPAI="select * from pai where num_doc=:num_doc and pai_actual is true";
		$consPAI=$conect->createCommand($sqlConsPAI);
		$consPAI->bindParam(":num_doc",$numDoc);
		$consPAI->execute();
		$readPAI=$consPAI->query();
		$resPAI=$readPAI->read();
		$readPAI->close();
		return $resPAI;		
	}
	
	/** Método de consultaReferenciacion.       
	*  Acción para consultar las referenciaciones del adolescente que están en trámite o que están en solicitud..
	*/												
	public function consultaReferenciacion($numDoc){
		$conect= Yii::app()->db;
		$sqlConsRef="select * from referenciacion_adol where num_doc=:num_doc and id_estadoref=1 or num_doc=:num_doc and id_estadoref=2";
		$consRef=$conect->createCommand($sqlConsRef);
		$consRef->bindParam(":num_doc",$numDoc);
		$consRef->execute();
		$readRef=$consRef->query();
		$resRef=$readRef->read();
		$readRef->close();
		return $resRef;		
	}
}