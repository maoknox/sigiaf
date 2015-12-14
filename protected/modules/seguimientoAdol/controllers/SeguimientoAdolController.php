<?php
Yii::import('application.modules.modIdenReg.models.ForjarAdol');	
Yii::import('application.modules.planpostegreso.models.PlanPostegreso');	
Yii::import('application.modules.valoracionIntegral.models.Antropometria');	
Yii::import('application.modules.valoracionIntegral.models.NutricionAdol');	
Yii::import('application.modules.valoracionIntegral.models.PorcionesComida');	
Yii::import('application.modules.valoracionIntegral.models.GrupocomidaNutradol');	
Yii::import('application.modules.valoracionIntegral.models.ValoracionNutricional');	

class SeguimientoAdolController extends Controller{
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
		return array(
			'enforcelogin',
			array('application.filters.ActionLogFilter - buscaAdolGen','modulo'=>$this->module->id,'controlador'=>$this->id,'parametros'=>Yii::app()->input->post()),
			array('application.filters.ActionVerifEstadoFilter + consPscSeg seguimientoNutrForm','num_doc'=>Yii::app()->getSession()->get('numDocAdol'))
		);
	}
	/**
	 *	Acción que renderiza la vista que contiene el formulario para el diligenciamiento del seguimiento del adolescente ya sea del proceso o seguimiento al post egreso.
	 *
	 *	Vista a renderizar:
	 *		- _registrarSegForm.
	 *
	 *	Modelos instanciados:
	 *		- PlanPostegreso
	 * 		- SeguimientoAdol
	 * 		- Psc
	 * 		- AsistenciaPsc
	 * 		- SeguimientoPsc
	 * 		- InformacionJudicial
	 * 		- Pai.
	 * 		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *
	 *	@param string	$numDocAdol
	 *	@param array	$datosAdol
	 *	@param int		$edad
	 *	@param object	$modeloInfJud,
	 *	@param array	$infJudicial,
	 *	@param object	$modeloSeguimiento,
	 *	@param int		$tipoSeguimiento,
	 *	@param array	$areaDisc,
	 *	@param array	$seguimientos,
	 *	@param array	$seguimientoPosEgreso,
	 *	@param object	$modeloPsc,
	 *	@param array	$pscSinCulm,
	 *	@param object	$modeloSeguimientoPsc,
	 *	@param object	$modeloAsistenciaPsc,
	 *	@param array	$pscDes, 
	 *	@param int		$offset,
	 *	@param array	$paiAdol
	 */		
	public function actionRegistrarSeg(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="registrarSeg";
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
			if(!empty($numDocAdol)){ // 
				$modeloPlanPostegreso=new PlanPostegreso();
				$modeloSeguimiento=new SeguimientoAdol();
				$modeloPsc=new Psc();
				$modeloAsistenciaPsc=new AsistenciaPsc();
				$modeloSeguimientoPsc=new SeguimientoPsc();
				$modeloInfJud=new InformacionJudicial();
				$modeloPai= new Pai();
				$modeloPai->num_doc=$numDocAdol;				
				$paiAdol=$modeloPai->consultaPAIActual(); //llama al pai actual del adolescente													
				if(empty($paiAdol)){					
					$modeloPlanPostegreso->num_doc=$numDocAdol;
					$planPEgreso=$modeloPlanPostegreso->consultaPlanPe();	
					$modeloPlanPostegreso->attributes=$planPEgreso;
					$modeloPai->id_pai=$modeloPlanPostegreso->id_pai;
					$paiAdol=$modeloPai->consultaPAIPlanPE();
					$modeloPai->attributes=$paiAdol;						
				}						
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				/*if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}*/
				$tipoSeguimiento=$consultaGeneral->consTipoSeguimiento();
				$areaDisc=$consultaGeneral->consAreaDisciplina();
				$seguimientos=$modeloSeguimiento->consSegAdol();
				$seguimientoPosEgreso=$modeloSeguimiento->consSegAdolPosEgreso();
				$modeloPsc->num_doc=$numDocAdol;
				$pscSinCulm=$modeloPsc->consultaPscSinCulm();	
				$seguimientoPsc=$modeloSeguimientoPsc->consSeguimientosPsc();
				$pscDes=$modeloPsc->consultaPscSeg(0);
				$offset=0;
	
			//Yii::app()->user->getState('rol');
			}
			$this->render('_registrarSegForm',array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$infJudicial,
				'modeloSeguimiento'=>$modeloSeguimiento,
				'tipoSeguimiento'=>$tipoSeguimiento,
				'areaDisc'=>$areaDisc,
				'seguimientos'=>$seguimientos,
				'seguimientoPosEgreso'=>$seguimientoPosEgreso,
				'modeloPsc'=>$modeloPsc,
				'pscSinCulm'=>$pscSinCulm,
				'modeloSeguimientoPsc'=>$modeloSeguimientoPsc,
				'modeloAsistenciaPsc'=>$modeloAsistenciaPsc,
				'pscDes'=>$pscDes, 
				'offset'=>$offset,
				'paiAdol'=>$paiAdol,
				'operaciones'=>$operaciones
					
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	llamada de ajax, consulta el profesional que realizó un seguimiento determinado, y si fue en conjunción consulta quien apoyó el seguimiento.
	 *
	 *	Modelos instanciados:
	 *		- ConsultasGenerales
	 *
	 *	@return json con el listado de profesionales que realizaron un seguimiento en específico.
	 */		
	public function actionConsProf(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["idSegConj"]) && !empty($_POST["idSegConj"])){
			if($dataInput["idSegConj"]!=1){
				$consultaGeneral=new ConsultasGenerales();
				$consultaGeneral->searchTerm=$dataInput["idSegConj"];
				$prof=$consultaGeneral->consultaProfSeg();
				if(!empty($prof)){
					echo CJSON::encode($prof);
				}
				else{
					echo CJSON::encode(array(""=>""));	
				}
			}
			else{
				echo CJSON::encode(array(""=>""));	
			}
		}
	}
	
	/**
	 *	Recibe datos del formulario de seguimiento e instancia a modelo para registrar el seguimiento al proceso.
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoAdol
	 *
	 *	@param arrya $dataClean $_POST	de datos del formulario de seguimiento ya sea al proceso o post egreso.
	 *	@param string $modeloInfJudAdmon->mensajeErrorInfJud.
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegistraSegimiento(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["SeguimientoAdol"]) && !empty($_POST["SeguimientoAdol"])){
			$modeloSeguimiento=new SeguimientoAdol();
			$modeloSeguimiento->attributes=$dataInput["SeguimientoAdol"];
			if($modeloSeguimiento->validate()){
				if($_POST["SeguimientoAdol"]["seguim_conj"]==1){$modeloSeguimiento->seguim_conj='false';}else{$modeloSeguimiento->seguim_conj='true';}
				$resultado=$modeloSeguimiento->registraSeguimiento();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloSeguimiento);
			}
		}
	}
	/**
	 *	Recibe datos del formulario de seguimiento e instancia a modelo para registrar el seguimiento post egreso.
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoAdol
	 *
	 *	@param arrya $dataClean $_POST	de datos del formulario de seguimiento ya sea al proceso o post egreso.
	 *	@param string $modeloInfJudAdmon->mensajeErrorInfJud.
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegistraSegimientoPe(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["SeguimientoAdol"]) && !empty($_POST["SeguimientoAdol"])){
			$modeloSeguimiento=new SeguimientoAdol();
			$modeloSeguimiento->attributes=$dataInput["SeguimientoAdol"];
			if($modeloSeguimiento->validate()){
				if($_POST["SeguimientoAdol"]["seguim_conj"]==1){$modeloSeguimiento->seguim_conj='false';}else{$modeloSeguimiento->seguim_conj='true';}
				$resultado=$modeloSeguimiento->registraSeguimientoPe();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloSeguimiento);
			}
		}
	}
	/**
	 *	llamada de ajax, consulta seguimiento según adolescente y según fecha
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoPsc
	 *
	 *	@return json retorna true si tiene seguimiento en esa fecha de lo contrario retorna false.
	 */		
	public function actionCompFechaAsistencia(){
		$dataInput=Yii::app()->input->post();
		if(!empty($_POST["date"]) && !empty($_POST["id_psc"])&& !empty($_POST["num_doc"])){
			$modeloSegPsc=new SeguimientoPsc();
			$modeloSegPsc->id_psc=$dataInput["id_psc"];
			$modeloSegPsc->num_doc=$dataInput["num_doc"];			
			$modeloSegPsc->fechaAsistencia=$dataInput["date"];	
			$resultado=$modeloSegPsc->compFechaAsistencia();	
			if(!empty($resultado)){
				echo CJSON::encode(array("resultado"=>CJavaScript::encode(CJavaScript::quote("false"))));
			}
			else{
				echo CJSON::encode(array("resultado"=>CJavaScript::encode(CJavaScript::quote("true"))));
			}	
		}
	}
	/**
	 *	Recibe datos del formulario de seguimiento e instancia a modelo para registrar el seguimiento post egreso.
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoPsc
	 *		- AsistenciaPsc
	 *		- ConsultasGenerales
	 *
	 *	@param array $dataInput array de datos de formulario de seguimiento de psc.
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegistraSegimientoPSC(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["SeguimientoPsc"]) && !empty($_POST["SeguimientoPsc"]) && isset($_POST["AsistenciaPsc"]) && !empty($_POST["AsistenciaPsc"])){
			$modeloSeguimientoPsc=new SeguimientoPsc();
			$modeloAsistenciaPsc=new AsistenciaPsc();		
			$consultaGeneral=new ConsultasGenerales();
			$modeloSeguimientoPsc->attributes=$dataInput["SeguimientoPsc"];
			$modeloAsistenciaPsc->attributes=$dataInput["AsistenciaPsc"];
			//print_r($_POST);
			if($dataInput["numFechas"]==0){
				$modeloAsistenciaPsc->fecha_asist_psc="";
			}
			else{
				for($i=1;$i<=$dataInput["numFechas"];$i++){
					$fecha = date('w', strtotime($dataInput["AsistenciaPsc"]["inpFecha_".$i]));
					$numHoras=$consultaGeneral->consultaNumHoras($dataInput["SeguimientoPsc"]["id_psc"],$dataInput["SeguimientoPsc"]["num_doc"],$fecha);
					$modeloSeguimientoPsc->fechas[]=array('fecha'=>$dataInput["AsistenciaPsc"]["inpFecha_".$i],'horas'=>$dataInput["AsistenciaPsc"]["num_horas_".$i],'minutos'=>$dataInput["AsistenciaPsc"]["num_minutos_".$i]);
				}
			}
			if($modeloSeguimientoPsc->validate() && $modeloAsistenciaPsc->validate()){
				//if($_POST["SeguimientoAdolPsc"]["seguim_conj"]==1){$modeloSeguimiento->seguim_conj='false';}else{$modeloSeguimiento->seguim_conj='true';}
				$resultado=$modeloSeguimientoPsc->registraSeguimientoPsc();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate(array($modeloSeguimientoPsc,$modeloAsistenciaPsc));
			}
		}
	}
	/**
	 *	Acción que renderiza la vista para mostrar todos los servicios a la comunidad que el adolescente ha realizado y que se han registrado en el sistema
	 *
	 *	Vista a renderizar:
	 *		- _consultaPSC.
	 *
	 *	Modelos instanciados:          
	 *		- Psc
	 * 		- Telefono
	 *		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *
	 *	@param object 	$modeloPsc 
	 *	@param string	$numDocAdol
	 *	@param array 	$datosAdol
	 *	@param int	 	$edad
	 *	@param array 	$telefono
	 *	@param object 	$offset
	 */		
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
				$pscDes=$modeloPsc->consultaPscSeg($offset);
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
	
	/**
	 *	Acción que renderiza la vista para mostrar el histórico de seguimientos de prestación de servicios a la comunidad
	 *
	 *	Vista a renderizar:
	 *		- _consultaPSC.
	 *
	 *	Modelos instanciados:          
	 *		- Psc
	 *		- InformacionJudicial
	 * 		- Telefono
	 *		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *
	 *	@param object 	$modeloPsc  
	 *	@param array	$pscDes
	 *	@param string	$numDocAdol
	 *	@param array 	$datosAdol
	 *	@param int	 	$edad
	 *	@param array 	$telefono
	 *	@param int 		$offset
	 *	@param array 	$infJudicial
	 */		
	public function actionConsPscSeg(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consPscSeg";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloPsc=new Psc();
			$modeloInfJud=new InformacionJudicial();					
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
				$pscDes=$modeloPsc->consultaPscSeg($offset);
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
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
			//consulta Instancia remisora
			$this->render('_consultaPSC',
				array(
					'modeloPsc'=>$modeloPsc,
					'pscDes'=>$pscDes,
					'numDocAdol'=>$numDocAdol,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset,
					'infJudicial'=>$infJudicial
				)
			);
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista para mostrar el formulario de prestación de servicios a la comunidad y para mostrar el histórico de seguimientos 
	 *
	 *	Vista a renderizar:
	 *		- _segPscForm.
	 *
	 *	Modelos instanciados:          
	 *		- Psc
	 *		- InformacionJudicial
	 * 		- Telefono
	 * 		- AsistenciaPsc
	 * 		- SeguimientoPsc
	 *		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *
	 *	@param string 	$numDocAdol  
	 *	@param object	$modeloInfJud
	 *	@param array	$infJudicial
	 *	@param object 	$modeloSeguimiento
	 *	@param object 	$modeloPsc
	 *	@param array 	$pscSinCulm
	 *	@param object	$modeloSeguimientoPsc
	 *	@param object 	$modeloPsc
	 *	@param object	$modeloAsistenciaPsc
	 *	@param array 	$pscDes
	 *	@param array 	$datosAdol
	 *	@param int	 	$edad
	 *	@param array 	$telefono
	 *	@param int 		$offset
	 */		
	public function actionCargaFormSegPsc(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consPscSeg";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
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
				$modeloPsc=new Psc();
				$modeloInfJud=new InformacionJudicial();					
				$modeloDatosTelefono=new Telefono();
				$modeloAsistenciaPsc=new AsistenciaPsc();
				$modeloSeguimientoPsc=new SeguimientoPsc();
				$consGen=new ConsultasGenerales();	
				$operaciones=new OperacionesGenerales();
				$datosAdol="";
				$edad="";
				$telefono="";			
				$datosAdol=$consGen->consultaDatosAdol($numDocAdol);
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);
				$modeloPsc->num_doc=$numDocAdol;
				$pscDes=$modeloPsc->consultaPscSeg($offset);
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}
				$modeloPsc->num_doc=$numDocAdol;
				$modeloPsc->id_psc=$dataInput["Psc"]["id_psc"];
				$pscSinCulm=$modeloPsc->consultaPscSegForm();	
				$seguimientoPsc=$modeloSeguimientoPsc->consSeguimientosPsc();
			}
			//consulta Instancia remisora
			$this->render('_segPscForm',
				array(
					'numDocAdol'=>$numDocAdol,	
					//'modeloInfJud'=>$modeloInfJud,
					//'infJudicial'=>$infJudicial,
					//'modeloSeguimiento'=>$modeloSeguimiento,
					'modeloPsc'=>$modeloPsc,
					'pscSinCulm'=>$pscSinCulm,
					'modeloSeguimientoPsc'=>$modeloSeguimientoPsc,
					'modeloPsc'=>$modeloPsc,
					'modeloAsistenciaPsc'=>$modeloAsistenciaPsc,
					'pscDes'=>$pscDes,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset,
					'operaciones'=>$operaciones					
				)
			);		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
/*************************************************** SEGUIMIENTO PLAN DIETARIO ****************************************************************/

	/**
	 *	Acción que renderiza la vista para mostrar el formulario de seguimiento a la valoración en nutrición
	 *
	 *	Vista a renderizar:
	 *		- _segNutrForm.
	 *
	 *	Modelos instanciados:          
	 *		- Antropometria
	 *		- NutricionAdol
	 * 		- PorcionesComida
	 * 		- ForjarAdol
	 * 		- GrupocomidaNutradol
	 *		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *	
	 *	@param string	$numDocAdol
	 *	@param array	$datosAdol
	 *	@param object	$modeloValNutr
	 *	@param array	$valNutr
	 *	@param int		$idValNutr
	 *	@param int		$edad
	 *	@param int		$estadoAdol
	 *	@param array	$grupoComida
	 *	@param object	$modeloGrupocomidaValnutr
	 *	@param object	$modeloAntropometria
	 *	@param array	$antropometriaAdol
	 *	@param object	$modeloNutricionAdol
	 *	@param array	$tiempoAlimento
	 *	@param array	$seguimPlanDietario
	 *	@param object	$modeloGrupocomidaNutradol
	 *	@param object	$modeloPorcionesComida
	 *	@param int		$estadoCompVal
	 *	@param array	$seguimientosNutr
	 *	@param array	$seguimPlanDietario	
	 */		
	public function actionSeguimientoNutrForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="seguimientoNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$modeloValNutr=new ValoracionNutricional();
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloAntropometria= new Antropometria();
				$modeloNutricionAdol= new NutricionAdol();
				$modeloPorcionesComida=new PorcionesComida();
				$modeloForjarAdol=new ForjarAdol();
				$modeloGrupocomidaNutradol=new GrupocomidaNutradol();
				$modeloForjarAdol->num_doc=$numDocAdol;
				$modeloValNutr->num_doc=$numDocAdol;
				$estadoAdol=$modeloForjarAdol->consultaDatosForjarAdol();								
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));				
				$valNutr=$modeloValNutr->consultaIdValNutr();
				$idValNutr=$valNutr["id_val_nutricion"];
				$modeloValNutr->attributes=$valNutr;
				//consulta tablas primarias
				$grupoComida=$consultaGeneral->consultaEntidades('grupo_comida','id_grupo_comida');
				$tiempoAlimento=$consultaGeneral->consultaEntidades('tiempo_alimento','id_tiempo_alimento');
				$estadoCompVal=$consultaGeneral->consutlaEstadoCompVal();
				//consulta antropometría de la valoración
				$modeloAntropometria->id_val_nutricion=$idValNutr;
				$antropometriaAdol=$modeloAntropometria->consultaAntropValNutrSeg();
				//consulta plan dietario
				$modeloNutricionAdol->id_val_nutricion=$idValNutr;
				$modeloNutricionAdol->id_tipoact_pld=2;				
				$seguimientosNutr=$modeloNutricionAdol->consultaNutricionAdolSeg();
				$seguimPlanDietario=$modeloNutricionAdol->consultaPlanDietarioSeg();
						
			}
			$this->render('_segNutrForm',array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'modeloValNutr'=>$modeloValNutr,
				'valNutr'=>$valNutr,
				'idValNutr'=>$idValNutr,
				'edad'=>$edad,
				'estadoAdol'=>$estadoAdol,
				//laboratorios clinicos
				'grupoComida'=>$grupoComida,
				//frecuencia de consumo
				'modeloGrupocomidaValnutr'=>$modeloGrupocomidaValnutr,
				//estado actual
				'modeloAntropometria'=>$modeloAntropometria,
				'antropometriaAdol'=>$antropometriaAdol,
				//plan dietario
				'modeloNutricionAdol'=>$modeloNutricionAdol,
				'tiempoAlimento'=>$tiempoAlimento,	
				'seguimPlanDietario'=>$seguimPlanDietario,	
				'modeloGrupocomidaNutradol'=>$modeloGrupocomidaNutradol,	
				'modeloPorcionesComida'=>$modeloPorcionesComida,
				'estadoCompVal'=>$estadoCompVal,
				'seguimientosNutr'=>$seguimientosNutr,
				'seguimPlanDietario'=>$seguimPlanDietario				
			));			
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}	
	}
	
	/**
	 *	Recibe datos del formulario de seguimiento nutricional
	 *
	 *	Modelos instanciados:
	 *		- Antropometria
	 *		- NutricionAdol
	 *		- ConsultasGenerales
	 *
	 *	@param array $dataInput array de datos de formulario de seguimiento de psc.
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegistraSeguimientoNutr(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="seguimientoNutrForm";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			$modeloAntropometria= new Antropometria();
			$modeloNutricionAdol= new NutricionAdol();
			$modeloAntropometria->attributes=$datosInput["Antropometria"];
			$modeloAntropometria->id_antropometria=$datosInput["Antropometria"]["id_antropometria"];
			$modeloNutricionAdol->attributes=$datosInput["NutricionAdol"];
			$modeloNutricionAdol->id_cedula='0';				
			//print_r($datosInput);exit;
			if($modeloNutricionAdol->validate() && $modeloAntropometria->validate()){
				$accion="";
				if($modeloNutricionAdol->id_nutradol=="aux"){
					//crea el registro
					$accion="crea";
					$resultado=$modeloNutricionAdol->creaRegNutricionSeguimiento();
					if($resultado=="exito"){
						$resultado=$modeloAntropometria->registraAntropometria();
						if($resultado="exito"){		
							$modeloAntropometria->idNutricion=$modeloNutricionAdol->id_nutradol;
							$resultado=$modeloAntropometria->registraAntropometriaNutrAdol();	
						}						
					}
				}
				else{
					//modifica el registro
					$accion="modifica";
					/*$restulado=$modeloNutricionAdol->modRegNutricionSeguimiento();
					if($resultado=="exito"){
						$resultado=$modeloAntropometria->modificaAntropometria();						
					}*/
					$resultado="exito";
				}
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>$resultado,'accion'=>$accion,"idNutricion"=>$modeloNutricionAdol->id_nutradol,'idAntropometria'=>$modeloAntropometria->id_antropometria));
			}
			else{
				echo CActiveForm::validate(array($modeloAntropometria,$modeloNutricionAdol));
			}
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}	
	}
	/**
	 *	Acción que renderiza la vista para mostrar la consulta del seguimiento nutricional
	 *
	 *	Vista a renderizar:
	 *		- _consSegForm.
	 *
	 *	Modelos instanciados:          
	 *		- Antropometria
	 *		- NutricionAdol
	 * 		- PorcionesComida
	 * 		- ForjarAdol
	 * 		- GrupocomidaNutradol
	 *		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *	
	 *	@param string	$numDocAdol
	 *	@param array	$datosAdol
	 *	@param object	$modeloValNutr
	 *	@param array	$valNutr
	 *	@param int		$idValNutr
	 *	@param int		$edad
	 *	@param int		$estadoAdol
	 *	@param array	$grupoComida
	 *	@param object	$modeloGrupocomidaValnutr
	 *	@param object	$modeloAntropometria
	 *	@param array	$antropometriaAdol
	 *	@param object	$modeloNutricionAdol
	 *	@param array	$tiempoAlimento
	 *	@param array	$seguimPlanDietario
	 *	@param object	$modeloGrupocomidaNutradol
	 *	@param object	$modeloPorcionesComida
	 *	@param int		$estadoCompVal
	 *	@param array	$seguimientosNutr
	 *	@param array	$seguimPlanDietario	
	 */		
	public function actionConsSegAdol(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consSegAdol";
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
				$modeloPlanPostegreso=new PlanPostegreso();
				$modeloSeguimiento=new SeguimientoAdol();
				$modeloPsc=new Psc();
				$modeloAsistenciaPsc=new AsistenciaPsc();
				$modeloSeguimientoPsc=new SeguimientoPsc();
				$modeloInfJud=new InformacionJudicial();
				$modeloPai= new Pai();
				$modeloPai->num_doc=$numDocAdol;				
				$paiAdol=$modeloPai->consultaPAIActual();													
				if(empty($paiAdol)){					
					$modeloPlanPostegreso->num_doc=$numDocAdol;
					$planPEgreso=$modeloPlanPostegreso->consultaPlanPe();	
					$modeloPlanPostegreso->attributes=$planPEgreso;
					$modeloPai->id_pai=$modeloPlanPostegreso->id_pai;
					$paiAdol=$modeloPai->consultaPAIPlanPE();
					$modeloPai->attributes=$paiAdol;						
				}						
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				/*if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}*/
				$tipoSeguimiento=$consultaGeneral->consTipoSeguimiento();
				$areaDisc=$consultaGeneral->consAreaDisciplina();
				$seguimientos=$modeloSeguimiento->consSegAdol();
				$seguimientoPosEgreso=$modeloSeguimiento->consSegAdolPosEgreso();
				$modeloPsc->num_doc=$numDocAdol;
				$pscSinCulm=$modeloPsc->consultaPscSinCulm();	
				$seguimientoPsc=$modeloSeguimientoPsc->consSeguimientosPsc();
				$pscDes=$modeloPsc->consultaPscSeg(0);
				$offset=0;
	
			//Yii::app()->user->getState('rol');
			}
			$this->render('_consSegForm',array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$infJudicial,
				'modeloSeguimiento'=>$modeloSeguimiento,
				'tipoSeguimiento'=>$tipoSeguimiento,
				'areaDisc'=>$areaDisc,
				'seguimientos'=>$seguimientos,
				'seguimientoPosEgreso'=>$seguimientoPosEgreso,
				'modeloPsc'=>$modeloPsc,
				'pscSinCulm'=>$pscSinCulm,
				'modeloSeguimientoPsc'=>$modeloSeguimientoPsc,
				'modeloAsistenciaPsc'=>$modeloAsistenciaPsc,
				'pscDes'=>$pscDes,
				'offset'=>$offset,
				'paiAdol'=>$paiAdol
					
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Acción que renderiza la vista para mostrar el formulario de seguimientos de prestación de servicios a la comunidad para realizar modificaciones al seguimiento. 
	 *
	 *	Vista a renderizar:
	 *		- _modSegPscForm.
	 *
	 *	Modelos instanciados:          
	 *		- Psc
	 *		- InformacionJudicial
	 * 		- Telefono
	 * 		- AsistenciaPsc
	 * 		- SeguimientoPsc
	 *		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *
	 *	@param string 	$numDocAdol  
	 *	@param object	$modeloInfJud
	 *	@param array	$infJudicial
	 *	@param object 	$modeloSeguimiento
	 *	@param object 	$modeloPsc
	 *	@param array 	$pscSinCulm
	 *	@param object	$modeloSeguimientoPsc
	 *	@param object 	$modeloPsc
	 *	@param object	$modeloAsistenciaPsc
	 *	@param array 	$pscDes
	 *	@param array 	$datosAdol
	 *	@param int	 	$edad
	 *	@param array 	$telefono
	 *	@param int 		$offset
	 */		
	public function actionModificarSegPscForm(){
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="consPscSeg";
		$permiso=$controlAcceso->controlAccesoAcciones();
		if($permiso["acceso_rolmenu"]==1){
			$dataInput=Yii::app()->input->post();
			if(isset($_POST["numDocAdol"]) && !empty($_POST["numDocAdol"])){
				$numDocAdol=htmlspecialchars(strip_tags(trim($_POST["numDocAdol"])));
				Yii::app()->getSession()->add('numDocAdol',htmlspecialchars(strip_tags(trim($_POST["numDocAdol"]))));
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}
			if(!empty($numDocAdol)){
				$modeloPsc=new Psc();
				$modeloInfJud=new InformacionJudicial();					
				$modeloDatosTelefono=new Telefono();
				$modeloAsistenciaPsc=new AsistenciaPsc();
				$modeloAsistenciaPsc->id_seguimiento_ind=$dataInput["Psc"]["id_seguimiento_ind"];
				$consultaAsistencia=$modeloAsistenciaPsc->consultaAsistencia();
				$modeloSeguimientoPsc=new SeguimientoPsc();
				$modeloSeguimientoPsc->num_doc=$numDocAdol;
				$modeloSeguimientoPsc->id_psc=$dataInput["Psc"]["id_psc"];
				$modeloSeguimientoPsc->id_seguimiento_ind=$dataInput["Psc"]["id_seguimiento_ind"];
				$seguimientoPscInd=$modeloSeguimientoPsc->consSeguimientosInd();
				$modeloSeguimientoPsc->desarrollo_act_psc=$seguimientoPscInd["desarrollo_act_psc"];
				$modeloSeguimientoPsc->reporte_nov_psc=$seguimientoPscInd["reporte_nov_psc"];
				$modeloSeguimientoPsc->cump_acu_psc=$seguimientoPscInd["cump_acu_psc"];
				$consGen=new ConsultasGenerales();	
				$operaciones=new OperacionesGenerales();
				$datosAdol="";
				$edad="";
				$telefono="";			
				$datosAdol=$consGen->consultaDatosAdol($numDocAdol);
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$telefono=$modeloDatosTelefono->consultaTelefono($numDocAdol);
				$modeloPsc->num_doc=$numDocAdol;
				$pscDes=$modeloPsc->consultaPscSeg($offset);
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
				$infJudicial=$modeloInfJud->consultaInfJud();
				if(!empty($infJudicial)){
					foreach($infJudicial as $pk=>$infJudicialNov){
						$infJud=$modeloInfJud->consultaInfJudNov($infJudicialNov["id_inf_judicial"]);
						if(!empty($infJud)){
							$infJudicial[$pk]=$infJud;
						}			
					}
				}
				$modeloPsc->num_doc=$numDocAdol;
				$modeloPsc->id_psc=$dataInput["Psc"]["id_psc"];
				$pscSinCulm=$modeloPsc->consultaPscSegForm();	
				$seguimientoPsc=$modeloSeguimientoPsc->consSeguimientosPsc();
			}
			//consulta Instancia remisora
			$this->render('_modSegPscForm',
				array(
					'numDocAdol'=>$numDocAdol,	
					//'modeloInfJud'=>$modeloInfJud,
					//'infJudicial'=>$infJudicial,
					//'modeloSeguimiento'=>$modeloSeguimiento,
					'modeloPsc'=>$modeloPsc,
					'pscSinCulm'=>$pscSinCulm,
					'modeloSeguimientoPsc'=>$modeloSeguimientoPsc,
					'modeloPsc'=>$modeloPsc,
					'modeloAsistenciaPsc'=>$modeloAsistenciaPsc,
					'pscDes'=>$pscDes,
					'datosAdol'=>$datosAdol,
					'edad'=>$edad,
					'telefono'=>$telefono,
					'offset'=>$offset,
					'seguimientoPscInd'=>$seguimientoPscInd,
					'consultaAsistencia'=>$consultaAsistencia,
				)
			);		
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	
	/**
	 *	Recibe datos del formulario de seguimiento e instancia a modelo para registrar el seguimiento post egreso.
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoPsc
	 *		- AsistenciaPsc
	 *		- ConsultasGenerales
	 *
	 *	@param array $dataInput array de datos de formulario de seguimiento de psc.
	 *	@return json resultado de la transacción.
	 */		
	public function actionModificaSegimientoPSC(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["SeguimientoPsc"]) && !empty($_POST["SeguimientoPsc"]) && isset($_POST["AsistenciaPsc"]) && !empty($_POST["AsistenciaPsc"])){
			$modeloSeguimientoPsc=new SeguimientoPsc();
			$modeloAsistenciaPsc=new AsistenciaPsc();		
			$consultaGeneral=new ConsultasGenerales();
			$modeloSeguimientoPsc->attributes=$dataInput["SeguimientoPsc"];
			$modeloAsistenciaPsc->attributes=$dataInput["AsistenciaPsc"];
			$modeloSeguimientoPsc->id_seguimiento_ind=$dataInput["SeguimientoPsc"]["id_seguimiento_ind"];
			$modeloAsistenciaPsc->id_seguimiento_ind=$modeloSeguimientoPsc->id_seguimiento_ind;
			//print_r($modeloSeguimientoPsc->attributes);
			//echo $dataInput["SeguimientoPsc"]["id_seguimiento_ind"];
			//exit;
			if($dataInput["numFechas"]==0){
				$modeloAsistenciaPsc->fecha_asist_psc="";
			}
			else{
				for($i=1;$i<=$dataInput["numFechas"];$i++){
					$fecha = date('w', strtotime($dataInput["AsistenciaPsc"]["inpFecha_".$i]));
					$numHoras=$consultaGeneral->consultaNumHoras($dataInput["SeguimientoPsc"]["id_psc"],$dataInput["SeguimientoPsc"]["num_doc"],$fecha);
					$modeloSeguimientoPsc->fechas[]=array('fecha'=>$dataInput["AsistenciaPsc"]["inpFecha_".$i],'horas'=>$dataInput["AsistenciaPsc"]["num_horas_".$i],'minutos'=>$dataInput["AsistenciaPsc"]["num_minutos_".$i]);
				}
			}
			if($modeloSeguimientoPsc->validate() && $modeloAsistenciaPsc->validate()){
				//if($_POST["SeguimientoAdolPsc"]["seguim_conj"]==1){$modeloSeguimiento->seguim_conj='false';}else{$modeloSeguimiento->seguim_conj='true';}
				$resultado=$modeloSeguimientoPsc->modificaSeguimientoPsc();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate(array($modeloSeguimientoPsc,$modeloAsistenciaPsc));
			}
		}
	}
//modificar seguimiento
	/**
	 *	Acción que renderiza la vista que contiene el formulario para el diligenciamiento del seguimiento del adolescente ya sea del proceso o seguimiento al post egreso.
	 *
	 *	Vista a renderizar:
	 *		- _modSegForm.
	 *
	 *	Modelos instanciados:
	 *		- PlanPostegreso
	 * 		- SeguimientoAdol
	 * 		- Psc
	 * 		- AsistenciaPsc
	 * 		- SeguimientoPsc
	 * 		- InformacionJudicial
	 * 		- Pai.
	 * 		- OperacionesGenerales.
	 * 		- ConsultasGenerales.
	 *
	 *	@param string	$numDocAdol
	 *	@param array	$datosAdol
	 *	@param int		$edad
	 *	@param object	$modeloInfJud,
	 *	@param array	$infJudicial,
	 *	@param object	$modeloSeguimiento,
	 *	@param int		$tipoSeguimiento,
	 *	@param array	$areaDisc,
	 *	@param array	$seguimientos,
	 *	@param array	$seguimientoPosEgreso,
	 *	@param object	$modeloPsc,
	 *	@param array	$pscSinCulm,
	 *	@param object	$modeloSeguimientoPsc,
	 *	@param object	$modeloAsistenciaPsc,
	 *	@param array	$pscDes, 
	 *	@param int		$offset,
	 *	@param array	$paiAdol
	 */		
	public function actionModificarSegForm(){
		//print_r($_POST);exit;
		$controlAcceso=new ControlAcceso();
		$controlAcceso->accion="registrarSeg";
		$permiso=$controlAcceso->controlAccesoAcciones();		
		if($permiso["acceso_rolmenu"]==1){
			$datosInput=Yii::app()->input->post();
			//print_r($datosInput);
			if(isset($datosInput["numDocAdol"]) && !empty($datosInput["numDocAdol"])){
				$numDocAdol=$datosInput["numDocAdol"];
				Yii::app()->getSession()->add('numDocAdol',$numDocAdol);
			}
			else{
				$numDocAdol=Yii::app()->getSession()->get('numDocAdol');
			}		
			if(!empty($numDocAdol)){ // 
				$modeloSeguimiento=new SeguimientoAdol();
				$modeloSeguimiento->id_seguimientoadol=$datosInput["SeguimientoAdol"]["id_seguimientoadol"];
				$modeloSeguimiento->num_doc=$datosInput["SeguimientoAdol"]["num_doc"];
				$modeloSeguimiento->fecha_registro_seg=$datosInput["SeguimientoAdol"]["fecha_registro_seg"];
				$seguimientoAModificar=$modeloSeguimiento->consSegAdolMod();
				$operaciones=new OperacionesGenerales();
				$consultaGeneral=new ConsultasGenerales();
				$datosAdol=$consultaGeneral->consultaDatosAdol($numDocAdol);	
				$edad=$operaciones->hallaEdad($datosAdol["fecha_nacimiento"],date("Y-m-d"));
				$modeloInfJud->num_doc=$numDocAdol;
				$modeloSeguimiento->num_doc=$numDocAdol;
			}
			$this->render('_modSegForm',array(
				'numDocAdol'=>$numDocAdol,	
				'datosAdol'=>$datosAdol,
				'edad'=>$edad,
				'modeloInfJud'=>$modeloInfJud,
				'infJudicial'=>$infJudicial,
				'modeloSeguimiento'=>$modeloSeguimiento,
				'seguimientoAModificar'=>$seguimientoAModificar
			));
		}
		else{
			throw new CHttpException(403,'No tiene acceso a esta acción');
		}
	}
	/**
	 *	Recibe datos del formulario de seguimiento e instancia a modelo para registrar el seguimiento al proceso.
	 *
	 *	Modelos instanciados:
	 *		- SeguimientoAdol
	 *
	 *	@param arrya $dataClean $_POST	de datos del formulario de seguimiento ya sea al proceso o post egreso.
	 *	@param string $modeloInfJudAdmon->mensajeErrorInfJud.
	 *	@return json resultado de la transacción.
	 */		
	public function actionRegistraModSegimiento(){
		$dataInput=Yii::app()->input->post();
		if(isset($_POST["SeguimientoAdol"]) && !empty($_POST["SeguimientoAdol"])){
			$modeloSeguimiento=new SeguimientoAdol();
			$modeloSeguimiento->attributes=$dataInput["SeguimientoAdol"];
			$modeloSeguimiento->fecha_registro_seg=$dataInput["SeguimientoAdol"]["fecha_registro_seg"];
			$modeloSeguimiento->num_doc=$dataInput["SeguimientoAdol"]["num_doc"];
			$modeloSeguimiento->id_seguimientoadol=$dataInput["SeguimientoAdol"]["id_seguimientoadol"];
			if($modeloSeguimiento->validate()){
				$resultado=$modeloSeguimiento->registraModSeguimiento();
				echo CJSON::encode(array("estadoComu"=>"exito",'resultado'=>CJavaScript::encode(CJavaScript::quote($resultado))));
			}
			else{
				echo CActiveForm::validate($modeloSeguimiento);
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