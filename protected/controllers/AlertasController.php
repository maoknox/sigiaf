<?php

class AlertasController extends Controller{
	public $sedeForjar;
	public $numCasos=0;
	public $numCasosIdReg=0;
	public $numCasosAsist=0;
	public $numCasosSeguim=0;
	public $numCasosValPsicol=0;
	public $numCasosConcInt=0;
	public $numCasosPAI=0;
	public $numCasosValTrSoc=0;
	public $numCasosValTO=0;
	public $numCasosValPsiq=0;
	public $numCasosValEnf=0;
	public $numCasosSeguimMD=0;
	public $numCasosRef=0;
	public $icono;
	public function filterEnforcelogin($filterChain){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403,"Debe loguearse primero");
		}
		$filterChain->run();
	}
	
	public function filters(){
		return array('enforcelogin',array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()));
	}
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

		//\echo 'aaaaaaaaaaaaaaaa';
	}
	public function actionMuestraFaltantes(){
		$datos=Yii::app()->input->post();
		//llama a la función que permite mostrar los adolescentes a los cuales les hace falta diligenciar información
		//$this->$datos["nombreModulo"];
		echo $this->$datos["nombreModulo"];		
		//echo $datos["nombreModulo"];
		//$infFaltante=array();		
		
	}
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
/*******************************/
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
	
	//alertas de seguimiento
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
					if($dias>60){
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
	
	public function consultaAdol(){
		$conect= Yii::app()->db;
		$sqlConsAdol="select * from adolescente as a left join forjar_adol as b on b.num_doc=a.num_doc where id_forjar=:id_forjar";
		$consAdol=$conect->createCommand($sqlConsAdol);
		$consAdol->bindParam(":id_forjar",$this->sedeForjar);
		$readAdols=$consAdol->query();
		$resAdols=$readAdols->readAll();
		$readAdols->close();
		return $resAdols;		
	}
	public function consultaAdolProf(){
		$conect= Yii::app()->db;
		$sqlConsAdol="select * from adolescente as a left join hist_personal_adol as b on b.num_doc=a.num_doc where id_cedula=:id_cedula and asignado_actualmente is true";
		$consAdol=$conect->createCommand($sqlConsAdol);
		$consAdol->bindParam(":id_cedula",Yii::app()->user->getState('cedula'));
		$readAdols=$consAdol->query();
		$resAdols=$readAdols->readAll();
		$readAdols->close();
		return $resAdols;		
	}
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