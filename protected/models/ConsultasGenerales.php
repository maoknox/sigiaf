<?php
class ConsultasGenerales extends CFormModel{  
	public $searchTerm;
	public $term;
	public $termi;
	public $termii;
	public $numDocAdol;
	public $idCedula;
	public $fechaInicio;
	public $fechaFinal;
	public $idValPsicol;
	public $idDoccespa;
	
	public function consultaTiempoActuacion(){
		$conect= Yii::app()->db;
		$sqlTiempoAct="select tiempo_valoraciones from numero_carpeta as a left join centro_forjar as b on b.id_forjar=a.id_forjar left join tiempo_actuacion as c on c.id_tiempoact=b.id_tiempoact where a.num_doc=:num_doc";	
		$consTiempoAct=$conect->createCommand($sqlTiempoAct);
		$consTiempoAct->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readTiempoAct=$consTiempoAct->query();
		$resTiempoAct=$readTiempoAct->read();
		$readTiempoAct->close();
		return $resTiempoAct;	

	}
	public function consultaTiempoActuacionPai(){
		$conect= Yii::app()->db;
		$sqlTiempoAct="select tiempo_pai from numero_carpeta as a left join centro_forjar as b on b.id_forjar=a.id_forjar left join tiempo_actuacion as c on c.id_tiempoact=b.id_tiempoact where a.num_doc=:num_doc";	
		$consTiempoAct=$conect->createCommand($sqlTiempoAct);
		$consTiempoAct->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readTiempoAct=$consTiempoAct->query();
		$resTiempoAct=$readTiempoAct->read();
		$readTiempoAct->close();
		return $resTiempoAct;	
	}
	public function consEstadoVal(){
		$conect= Yii::app()->db;
		$sqlConsEstVal="select id_estado_val from ".$this->searchTerm." where num_doc=:num_doc";
		$consEstVal=$conect->createCommand($sqlConsEstVal);
		$consEstVal->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readConsEstVal=$consEstVal->query();
		$resConsEstVal=$readConsEstVal->read();
		$readConsEstVal->close();
		return $resConsEstVal;	
	}
	
	public function consultaAreaInscr(){//Yii::app()->user->getState('cedula')
		$conect= Yii::app()->db;
		$sqlConsArInsc="select * from areainscr_cforjar as a left join area_inscripcion as b on b.id_areainteres=a.id_areainteres where id_forjar=:id_forjar and areacforjar_activa='true' order by b.id_areainteres asc";
		$consArInsc=$conect->createCommand($sqlConsArInsc);
		$consArInsc->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));// 		
		$readConsArInsc=$consArInsc->query();
		$resConsArInsc=$readConsArInsc->readAll();
		$readConsArInsc->close();
		return $resConsArInsc;	
	}
	
	public function consultaNumHoras($idPsc,$numDocAdol,$idDia){
		$conect= Yii::app()->db;	
		$sqlConsNumHoras="select horas_dia from dia_hora where id_psc=:id_psc and num_doc=:num_doc and id_dia=:id_dia";
		$consNumHoras=$conect->createCommand($sqlConsNumHoras);
		$consNumHoras->bindParam(":id_psc",$idPsc,PDO::PARAM_STR);
		$consNumHoras->bindParam(":num_doc",$numDocAdol,PDO::PARAM_STR);
		$consNumHoras->bindParam(":id_dia",$idDia,PDO::PARAM_INT);
		$readConsNumHoras=$consNumHoras->query();
		$resConsNumHoras=$readConsNumHoras->read();
		$readConsNumHoras->close();
		return $resConsNumHoras["horas_dia"];
		//Yii::app()->user->getState('cedula')
	}
	
	
	public function consultaProfSeg(){
		switch($this->searchTerm){
			case 2:
				$cond=" a.id_rol=4 or a.id_rol=5";
			break;
			case 3:
				$cond=" a.id_rol=4 or a.id_rol=7";
			break;
			case 4:
				$cond=" a.id_rol=6 or a.id_rol=9 and a.id_rol=10";
			break;
			case 5:
				$cond=" a.id_rol=12 or a.id_rol=14";
			break;
			case 6:
				$cond=" a.id_rol=13";
			break;	
			default:
				$cond="";
			break;			
		}
		$conect= Yii::app()->db;	
			
		$sqlConsProf="select a.id_cedula,(nombre_personal ||' '|| apellidos_personal) as nombres_persona from usuario as a 
			left join persona as b on a.id_cedula=b.id_cedula where ".$cond;	
		$consProf=$conect->createCommand($sqlConsProf);
		$readConsProf=$consProf->query();
		while($resConsProf=$readConsProf->read()){
			$profesional[$resConsProf["id_cedula"]]=$resConsProf["nombres_persona"];	
		}
		$readConsProf->close();	
		return	$profesional;	
	}
	
	public function consTipoSeguimiento(){
		$conect= Yii::app()->db;
		$sqlConsTipoSeg="select * from tiposeg_rol as a left join tipo_seguimiento as b on b.id_tipo_seguim=a.id_tipo_seguim where id_rol=:id_rol";	
		$consTipoSeg=$conect->createCommand($sqlConsTipoSeg);
		$consTipoSeg->bindParam(":id_rol",Yii::app()->user->getState('rol'),PDO::PARAM_INT);
		$readTipoSeg=$consTipoSeg->query();
		$resTipoSeg=$readTipoSeg->readAll();
		$readTipoSeg->close();
		return $resTipoSeg;
	}
	public function consAreaDisciplina(){
		$conect= Yii::app()->db;
		$sqlConsAreaDisc="select * from areaseg_rol as a left join area_disciplina as b on a.id_area_seguimiento=b.id_area_seguimiento where a.id_rol=:id_rol";	
		$consAreaDisc=$conect->createCommand($sqlConsAreaDisc);
		$consAreaDisc->bindParam(":id_rol",Yii::app()->user->getState('rol'),PDO::PARAM_INT);
		$readAreaDisc=$consAreaDisc->query();
		$resAreaDisc=$readAreaDisc->readAll();
		$readAreaDisc->close();
		return $resAreaDisc;
	}
	
	public function consultaConcInt(){
		$conect= Yii::app()->db;
		$sqlConsConcInt="select * from concepto_integral where num_doc=:num_doc";
		$consConcInt=$conect->createCommand($sqlConsConcInt);
		$consConcInt->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readConcInt=$consConcInt->query();
		$resConcInt=$readConcInt->read();
		$readConcInt->close();
		return $resConcInt;
	}
	public function consultaInstPsc(){
		$conect= Yii::app()->db;
		$sqlCons="select * from institucion_psc where id_sector_psc=:id_sector_psc order by id_institucionpsc asc";
		$consulta=$conect->createCommand($sqlCons);
		$consulta->bindParam(":id_sector_psc",$this->searchTerm,PDO::PARAM_INT);
		$readConsulta=$consulta->query();
		$resConsulta=$readConsulta->readAll();
		$readConsulta->close();
		return $resConsulta;
	}
	public function conectaBDSinPdo(){
		$pgConn = pg_connect('host=localhost port=5432 dbname=cforjarv2_4 user=postgres password=root') or die("Error al conectar a la base de datos");
		if($pgConn){
			return $pgConn;
		}
		else{
			return "error en la conexión";
		}
	}

	public function consultaEquipoPsicosocial(){
		$conect= Yii::app()->db;
		$sqlConsEquipPsic="select *,(nombre_personal||' '||apellidos_personal) as nombrecomp_pers from adolescente as a 
			left join hist_personal_adol as b on a.num_doc=b.num_doc 
			left join persona as c on b.id_cedula=c.id_cedula 
			left join usuario as d on d.id_cedula=c.id_cedula
			left join rol as e on e.id_rol=d.id_rol
			where a.num_doc=:num_doc and b.asignado_actualmente='true'";
		$consProfAdol=$conect->createCommand($sqlConsEquipPsic);
		$consProfAdol->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readProfAdol=$consProfAdol->query();
		$resProfAdol=$readProfAdol->readAll();
		$readProfAdol->close();
		return $resProfAdol;
	}

	public function consultaProfesionalAdol(){
		$conect= Yii::app()->db;
		$sqlConsProfAdol="select * from hist_personal_adol where id_cedula=:id_cedula and num_doc=:num_doc";
		$consProfAdol=$conect->createCommand($sqlConsProfAdol);
		$consProfAdol->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
		$consProfAdol->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readProfAdol=$consProfAdol->query();
		$resProfAdol=$readProfAdol->read();
		$readProfAdol->close();
		return $resProfAdol;
	}
	public function consultaProfesionalAdolHistorial(){
		$conect= Yii::app()->db;
		$sqlConsProfAdol="select * from hist_personal_adol where id_cedula=:id_cedula and num_doc=:num_doc";
		$consProfAdol=$conect->createCommand($sqlConsProfAdol);
		$consProfAdol->bindParam(":id_cedula",$this->idCedula,PDO::PARAM_INT);
		$consProfAdol->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readProfAdol=$consProfAdol->query();
		$resProfAdol=$readProfAdol->read();
		$readProfAdol->close();
		return $resProfAdol;
	}
	public function consultaTipoDocumento(){
		$conect= Yii::app()->db;
		$sql_TipoDoc="select * from tipo_documento order by id_tipo_doc asc";
		$query_TipoDoc=$conect->createCommand($sql_TipoDoc);
		$read_TipoDoc=$query_TipoDoc->query();
		$res_TipoDoc=$read_TipoDoc->readAll();
		$read_TipoDoc->close();
		return $res_TipoDoc;
	}
	public function consultaDepartamento(){
		$conect= Yii::app()->db;
		$sql_Depto="select * from departamento order by departamento asc";
		$query_Depto=$conect->createCommand($sql_Depto);
		$read_Depto=$query_Depto->query();
		$res_Depto=$read_Depto->readAll();
		$read_Depto->close();
		return $res_Depto;
	}
	
	public function consultaMunicipio($idDepto){
		$conect= Yii::app()->db;
		$sql_Munpio="select * from municipio where id_departamento=:idDepto order by municipio asc";
		$query_Munpio=$conect->createCommand($sql_Munpio);
		$query_Munpio->bindParam('idDepto',$idDepto,PDO::PARAM_STR);
		$read_Munpio=$query_Munpio->query();
		$res_Munpio=$read_Munpio->readAll();
		$read_Munpio->close();
		return $res_Munpio;
	}
	public function consultaNivelEsp($idTipoRef){
		$conect= Yii::app()->db;
		$sqlConsEspNi="select * from esp_sol_ni where id_tipo_referenciacion=:idTipoRef and hab_esp='true' order by id_esp_sol asc";
		$consEspNi=$conect->createCommand($sqlConsEspNi);
		$consEspNi->bindParam('idTipoRef',$idTipoRef,PDO::PARAM_INT);
		$readConsEspNi=$consEspNi->query();
		$resConsEspNi=$readConsEspNi->readAll();
		$readConsEspNi->close();
		return $resConsEspNi;
	}
	public function consultaNivelEspii($espNi){
		$conect= Yii::app()->db;
		$sqlConsEspNi="select * from esp_sol_nii where id_esp_sol=:idEspNi and hab_espii='true' order by id_esp_solii asc";
		$consEspNi=$conect->createCommand($sqlConsEspNi);
		$consEspNi->bindParam('idEspNi',$espNi,PDO::PARAM_INT);
		$readConsEspNi=$consEspNi->query();
		$resConsEspNi=$readConsEspNi->readAll();
		$readConsEspNi->close();
		return $resConsEspNi;
	}
	public function consultaNivelEspiii($espNii){
		$conect= Yii::app()->db;
		$sqlConsEspNi="select * from esp_sol_niii where id_esp_solii=:idEspNii and hab_espiii='true' order by id_esp_soliii asc";
		$consEspNi=$conect->createCommand($sqlConsEspNi);
		$consEspNi->bindParam('idEspNii',$espNii,PDO::PARAM_INT);
		$readConsEspNi=$consEspNi->query();
		$resConsEspNi=$readConsEspNi->readAll();
		$readConsEspNi->close();
		return $resConsEspNi;
	}
	public function consultaBeneficiario($idTipoRef){
		$conect= Yii::app()->db;
		$sqlConsBenef="select * from tiporeferenciacion where id_tipo_referenciacion=:idTipoRef";
		$consBenef=$conect->createCommand($sqlConsBenef);
		$consBenef->bindParam('idTipoRef',$idTipoRef,PDO::PARAM_STR);
		$readBenef=$consBenef->query();
		$resBenef=$readBenef->read();
		$readBenef->close();
		return $resBenef;
	}

	public function consultaSexo(){
		$conect= Yii::app()->db;
		$sql_Sexo="select * from sexo order by id_sexo asc";
		$query_Sexo=$conect->createCommand($sql_Sexo);
		$read_Sexo=$query_Sexo->query();
		$res_Sexo=$read_Sexo->readAll();
		$read_Sexo->close();
		return $res_Sexo;
	}
	public function consultaEtnia(){
		$conect= Yii::app()->db;
		$sql_Etnia="select * from etnia order by id_etnia asc";
		$query_Etnia=$conect->createCommand($sql_Etnia);
		$read_Etnia=$query_Etnia->query();
		$res_Etnia=$read_Etnia->readAll();
		$read_Etnia->close();
		return $res_Etnia;
	}
	public function consultaLocalidad(){
		$conect= Yii::app()->db;
		$sql_Localidad="select * from localidad order by localidad asc";
		$query_Localidad=$conect->createCommand($sql_Localidad);
		$read_Localidad=$query_Localidad->query();
		$res_Localidad=$read_Localidad->readAll();
		$read_Localidad->close();
		return $res_Localidad;
		
	}
	public function consultaEstrato(){
		$conect= Yii::app()->db;
		$sql_Estrato="select * from estrato order by id_estrato asc";
		$query_Estrato=$conect->createCommand($sql_Estrato);
		$read_Estrato=$query_Estrato->query();
		$res_Estrato=$read_Estrato->readAll();
		$read_Estrato->close();
		return $res_Estrato;
		
	}
	public function consultaProfesional($id_rol){
		$conect= Yii::app()->db;//Yii::app()->user->getState('sedeForjar')
		$sql_Prof="select a.id_cedula,(nombre_personal||' '||apellidos_personal) as nombrecomp_pers from persona as a 
			left join usuario as b on a.id_cedula=b.id_cedula 
			left join cforjar_personal as c on c.id_cedula=a.id_cedula 
			where id_rol=:idRol and id_forjar=:id_forjar";
		$query_Prof=$conect->createCommand($sql_Prof);
		$query_Prof->bindParam(":idRol",$id_rol,PDO::PARAM_INT);
		$query_Prof->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'),PDO::PARAM_STR);
		$read_Prof=$query_Prof->query();
		$res_Prof=$read_Prof->readAll();
		$read_Prof->close();
		return $res_Prof;
	}
		
	public function consultaDocCespa(){
		$conect= Yii::app()->db;
		$sql_Docs="select * from documento_cespa order by id_doccespa asc";
		$query_Docs=$conect->createCommand($sql_Docs);
		$read_Docs=$query_Docs->query();
		$res_Docs=$read_Docs->readAll();
		$read_Docs->close();
		return $res_Docs;
	}
	public function consultaParentesco(){
		$conect= Yii::app()->db;
		$sql_Parentesco="select * from parentesco order by id_parentesco asc";
		$query_Parentesco=$conect->createCommand($sql_Parentesco);
		$read_Parentesco=$query_Parentesco->query();
		$res_Parentesco=$read_Parentesco->readAll();
		$read_Parentesco->close();
		return $res_Parentesco;
	}	
	public function consultaDerechos(){
		$conect= Yii::app()->db;
		$sql_DerechoCespa="select * from derechocespa order by id_derechocespa asc";
		$query_DerechoCespa=$conect->createCommand($sql_DerechoCespa);
		$read_DerechoCespa=$query_DerechoCespa->query();
		$res_DerechoCespa=$read_DerechoCespa->readAll();
		$read_DerechoCespa->close();
		return $res_DerechoCespa;
	}
	public function consultaParticipacion(){
		$conect= Yii::app()->db;
		$sql_AlterPart="select * from alternativas_participacion order by id_alternativaproc asc";
		$query_AlterPart=$conect->createCommand($sql_AlterPart);
		$read_AlterPart=$query_AlterPart->query();
		$res_AlterPart=$read_AlterPart->readAll();
		$read_AlterPart->close();
		return $res_AlterPart;		
	}
	public function consultaProteccion(){
		$conect= Yii::app()->db;
		$sql_SitRiegso="select * from situaciones_riesgo order by id_sit_riesgo asc";
		$query_SitRiegso=$conect->createCommand($sql_SitRiegso);
		$read_SitRiegso=$query_SitRiegso->query();
		$res_SitRiegso=$read_SitRiegso->readAll();
		$read_SitRiegso->close();
		return $res_SitRiegso;		
	}
	public function consutlaInstanciaRem(){
		$conect= Yii::app()->db;
		$sql_InstanciaRem="select * from instancia_remisora order by id_instancia_rem asc";
		$query_InstanciaRem=$conect->createCommand($sql_InstanciaRem);
		$read_InstanciaRem=$query_InstanciaRem->query();
		$res_InstanciaRem=$read_InstanciaRem->readAll();
		$read_InstanciaRem->close();
		return $res_InstanciaRem;		
	}
	public function consutlaDelito(){
		$conect= Yii::app()->db;
		$sql_Delito="select * from delito_rem_cespa order by id_del_rc asc";
		$query_Delito=$conect->createCommand($sql_Delito);
		$read_Delito=$query_Delito->query();
		$res_Delito=$read_Delito->readAll();
		$read_Delito->close();
		return $res_Delito;	
	}
	public function consutlaEstadoProceso(){
		$conect= Yii::app()->db;
		$sql_EstadoProc="select * from estado_proc_judicial order by id_proc_jud asc";
		$query_EstadoProc=$conect->createCommand($sql_EstadoProc);
		$read_EstadoProc=$query_EstadoProc->query();
		$res_EstadoProc=$read_EstadoProc->readAll();
		$read_EstadoProc->close();
		return $res_EstadoProc;	
	}
	public function consutlaTipoSpa(){
		$conect= Yii::app()->db;
		$sql_TipoSpa="select * from tipo_droga order by id_tipo_droga asc";
		$query_TipoSpa=$conect->createCommand($sql_TipoSpa);
		$read_TipoSpa=$query_TipoSpa->query();
		$res_TipoSpa=$read_TipoSpa->readAll();
		$read_TipoSpa->close();
		return $res_TipoSpa;	
	}
	public function frecuanciaUso(){
		$conect= Yii::app()->db;
		$sql_FrecUso="select * from frecuencia_uso order by id_frecuencia_uso asc";
		$query_FrecUso=$conect->createCommand($sql_FrecUso);
		$read_FrecUso=$query_FrecUso->query();
		$res_FrecUso=$read_FrecUso->readAll();
		$read_FrecUso->close();
		return $res_FrecUso;	
	}
	public function consutlaViaAdmon(){
		$conect= Yii::app()->db;
		$sql_ViaAdmon="select * from via_admon_spa order by id_viaadmon_spa asc";
		$query_ViaAdmon=$conect->createCommand($sql_ViaAdmon);
		$read_ViaAdmon=$query_ViaAdmon->query();
		$res_ViaAdmon=$read_ViaAdmon->readAll();
		$read_ViaAdmon->close();
		return $res_ViaAdmon;	
	}
	
	public function consutlaSancion(){
		$conect= Yii::app()->db;
		$sql_EstadoProc="select * from estado_proc_judicial order by id_proc_jud asc";
		$query_EstadoProc=$conect->createCommand($sql_EstadoProc);
		$read_EstadoProc=$query_EstadoProc->query();
		$res_EstadoProc=$read_EstadoProc->readAll();
		$read_EstadoProc->close();
		return $res_EstadoProc;	
	}
	public function consutlaTipoSancion(){
		$conect= Yii::app()->db;
		$sql_EstadoProc="select * from tipo_sancion order by id_tipo_sancion asc";
		$query_EstadoProc=$conect->createCommand($sql_EstadoProc);
		$read_EstadoProc=$query_EstadoProc->query();
		$res_EstadoProc=$read_EstadoProc->readAll();
		$read_EstadoProc->close();
		return $res_EstadoProc;	
	}
	public function consutlaPatronConsumo(){
		$conect= Yii::app()->db;
		$sql_PatronCons="select * from patron_consumo order by id_patron_consumo asc";
		$query_PatronCons=$conect->createCommand($sql_PatronCons);
		$read_PatronCons=$query_PatronCons->query();
		$res_PatronCons=$read_PatronCons->readAll();
		$read_PatronCons->close();
		return $res_PatronCons;	
	}
	public function consutlaEstadoCompVal(){
		$conect= Yii::app()->db;
		$sql_EstadoCompVal="select * from estado_valoracion order by id_estado_val asc";
		$query_EstadoCompVal=$conect->createCommand($sql_EstadoCompVal);
		$read_EstadoCompVal=$query_EstadoCompVal->query();
		$res_EstadoCompVal=$read_EstadoCompVal->readAll();
		$read_EstadoCompVal->close();
		return $res_EstadoCompVal;	
	}
	public function consultaEntidades($nombreEntidad,$campoId){
		$conect= Yii::app()->db;
		$nombreEntidad=htmlspecialchars(strip_tags(trim($nombreEntidad)));
		$nombreEntidad=filter_var($nombreEntidad, FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
		$campoId=htmlspecialchars(strip_tags(trim($campoId)));
		$campoId=filter_var($campoId, FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
		$sql_ConsEnt="select * from ".pg_escape_string($nombreEntidad)." order by ".pg_escape_string($campoId)." asc";
		$query_ConsEnt=$conect->createCommand($sql_ConsEnt);
		$read_ConsEnt=$query_ConsEnt->query();
		$res_ConsEnt=$read_ConsEnt->readAll();
		$read_ConsEnt->close();
		return $res_ConsEnt;			
	}
	public function consultaEntidadesAjax($nombreEntidad,$campoId,$nombCampo){
		$conect= Yii::app()->db;
		$nombreEntidad=htmlspecialchars(strip_tags(trim($nombreEntidad)));
		$nombreEntidad=filter_var($nombreEntidad, FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
		$campoId=htmlspecialchars(strip_tags(trim($campoId)));
		$campoId=filter_var($campoId, FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
		$sql_ConsEnt="select ".$campoId." as id, ".$nombCampo." as contenido from ".$nombreEntidad." order by ".$campoId." asc";
		$query_ConsEnt=$conect->createCommand($sql_ConsEnt);
		$read_ConsEnt=$query_ConsEnt->query();
		$res_ConsEnt=$read_ConsEnt->readAll();
		$read_ConsEnt->close();
		foreach($res_ConsEnt as $res_ConsEnt){//revisar
			$res[]=array("id"=>$res_ConsEnt["id"],"contenido"=>$res_ConsEnt["contenido"]);
		}
		return $res;			
	}
	public function consultaDatosAdol($numDocAdol){
		$conect= Yii::app()->db;
		$sqlConsultaAdol="select *,(apellido_1 || ' ' || apellido_2) as apellidos from adolescente as a left join forjar_adol as b on a.num_doc=b.num_doc 
			left join localizacion_viv as c on a.num_doc=c.num_doc
			left join sgsss as d on d.num_doc=a.num_doc 
			left join numero_carpeta as e on e.num_doc=a.num_doc 
			left join etnia as f on a.id_etnia=f.id_etnia 
			left join municipio as g on g.id_municipio=a.id_municipio 
			left join departamento as h on h.id_departamento=g.id_departamento 
			left join escadol_ingr_egr as i on i.num_doc=a.num_doc where a.num_doc=:numDoc";
		$queryConsultaAdol=$conect->createCommand($sqlConsultaAdol);
		$queryConsultaAdol->bindParam(':numDoc',$numDocAdol,PDO::PARAM_STR);
		$readConsultaAdol=$queryConsultaAdol->query();
		$resConsultaAdol=$readConsultaAdol->read();
		$readConsultaAdol->close();			
		return $resConsultaAdol;
	}
	
	public function consultaDatosProfesional($idCedula){
		$conect= Yii::app()->db;
		$sqlConsDatosProf="select *,(a.nombre_personal||' '||a.apellidos_personal)as nombre from persona as a left join usuario as b on b.id_cedula=a.id_cedula 
			left join rol as c on c.id_rol=b.id_rol 
			where a.id_cedula=:id_cedula";
		$consDatosProf=$conect->createCommand($sqlConsDatosProf);
		$consDatosProf->bindParam(':id_cedula',$idCedula,PDO::PARAM_STR);
		$readDatosProf=$consDatosProf->query();
		$resDatosProf=$readDatosProf->read();
		$readDatosProf->close();
		return $resDatosProf;
	}
	public function buscaAdolGen(){
		$operaciones=new OperacionesGenerales();		
		$nombres=$operaciones->quitar_tildes($this->searchTerm);		
		$nombres=mb_strtoupper($nombres,"UTF-8");
		$nombres=split(" ",$nombres);
		$conect=Yii::app()->db;
		$compConsSql="";
		$compCondicion="";
		if(Yii::app()->user->getState('rol')==4 or Yii::app()->user->getState('rol')==5){
			$compConsSql=", hist_personal_adol as c ";
			$compCondicion="and c.num_doc=a.num_doc and c.id_cedula=:idCedula and c.asignado_actualmente is true";
		}
		else{
			$compConsSql=", forjar_adol as c ";
			$compCondicion="and c.num_doc=a.num_doc and id_forjar=:id_forjar";
		}
		if(count($nombres)==1 && !empty($nombres[0])){
			$sqlCons = "select distinct(b.num_doc), nombres,apellido_1,apellido_2,b.num_doc ";
			$sqlCons .= "from (select num_doc from adolescente where sinacentos(nombres) like '%".pg_escape_string($nombres[0])."%' or sinacentos(apellido_1) like '%".pg_escape_string($nombres[0])."%' ";
			$sqlCons .= "or sinacentos(apellido_2) like '%".pg_escape_string($nombres[0])."%' limit 20) as a,";
			$sqlCons .= "adolescente as b ".pg_escape_string($compConsSql)." where ";
			$sqlCons .= "a.num_doc=b.num_doc ".$compCondicion." order by nombres asc";
		}
		elseif(count($nombres)==2&&!empty($nombres[1])){
			$nomb = $nombres[0]." ".$nombres[1];
			$sqlCons = "select  distinct(b.num_doc), nombres,apellido_1,apellido_2,b.num_doc ";
			$sqlCons .="from (select num_doc from adolescente where sinacentos(nombres) like '%".pg_escape_string($nombres[0])." ".pg_escape_string($nombres[1])."%' or sinacentos(apellido_1) like '%".pg_escape_string($nombres[0])."%' ";
			$sqlCons .= "and sinacentos(apellido_2) like '%".pg_escape_string($nombres[1])."%' or sinacentos(nombres) like '%".pg_escape_string($nombres[0])."%' and sinacentos(apellido_1) like '%".pg_escape_string($nombres[1])."%' or sinacentos(nombres) like '%".pg_escape_string($nombres[1])."%' and sinacentos(apellido_1) like '%".pg_escape_string($nombres[0])."%' order by nombres asc limit 20) as a,";
			$sqlCons .= "adolescente as b ".pg_escape_string($compConsSql)." where a.num_doc=b.num_doc ".pg_escape_string($compCondicion)." order by nombres asc";		
		}
		elseif(count($nombres)==3&&!empty($nombres[1])&&!empty($nombres[2])){
			$nomb = $strCons[0]." ".$strCons[1];
			$sqlCons = "select  distinct(b.num_doc), nombres,apellido_1,apellido_2,b.num_doc ";
			$sqlCons .="from (select num_doc from adolescente where sinacentos(nombres) like '%".pg_escape_string($nomb)."%' and  sinacentos(apellido_1) like '%".pg_escape_string($nombres[2])."%' or  sinacentos(nombres) like '%".pg_escape_string($nombres[2])."%' ";
			$sqlCons .= "and  sinacentos(apellido_1) like '%".$nombres[0]."%' and  sinacentos(apellido_2) like '%".pg_escape_string($nombres[1])."%' order by nombres asc limit 20) as a,";
			$sqlCons .= "adolescente as b ".pg_escape_string($compConsSql)." where a.num_doc=b.num_doc ".pg_escape_string($compCondicion)." order by nombres asc";
		}
		elseif(count($nombres)==4&&$nombres[1]!=""&&$nombres[2]!=""&&$nombres[3]!=""){
			$nomb = $nombres[0]." ".$nombres[1];
			$nombi = $nombres[2]." ".$nombres[3];
			$sqlCons = "select  distinct(b.num_doc), nombres,apellido_1,apellido_2,b.num_doc ";
			$sqlCons .="from (select num_doc from adolescente where  sinacentos(nombres) like '%".pg_escape_string($nomb)."%' and  sinacentos(apellido_1) like '%".pg_escape_string($nombres[2])."%' ";
			$sqlCons .= "and  sinacentos(apellido_2) like '%".pg_escape_string($nombres[3])."%' or  sinacentos(nombres) like '%".pg_escape_string($nombi)."%' and  sinacentos(apellido_1) like '%".pg_escape_string($nombres[0])."%' and  sinacentos(apellido_2) like '%".pg_escape_string($nombres[1])."%' order by nombres asc limit 20) as a,";
			$sqlCons .= "adolescente as b ".pg_escape_string($compConsSql)." where a.num_doc=b.num_doc and a.num_doc=b.num_doc ".pg_escape_string($compCondicion)."order by nombres asc";
		}
		$consultaAdol=$conect->createCommand($sqlCons);
		if(Yii::app()->user->getState('rol')==4 or Yii::app()->user->getState('rol')==5){
			$consultaAdol->bindParam(':idCedula',Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
		}
		else{
			$consultaAdol->bindParam(':id_forjar',Yii::app()->user->getState('sedeForjar'),PDO::PARAM_STR);
		}
		$queryConsulta=$consultaAdol->query();
		while($readConsulta=$queryConsulta->read()){
			$res[]=array( "numDocAdol" =>$readConsulta["num_doc"], "nombre"=>$readConsulta["nombres"]." ".$readConsulta["apellido_1"]." ".$readConsulta["apellido_2"]);
		}
		$queryConsulta->close();
		return $res;	
	}
	//consultas para el reporte de adolescentes
	
	public function consultaAdolescentesSede(){
		$conect=Yii::app()->db;
		$sqlConsAdol="select b.id_numero_carpeta,a.apellido_1,a.apellido_2,a.nombres,d.tipo_doc,a.id_tipo_doc,a.num_doc,a.fecha_nacimiento,f.departamento, e.municipio,g.sexo,
			a.edad_ingreso, h.etnia,i.estado_escol, k.eps_adol from adolescente as a 
			left join numero_carpeta as b on b.num_doc=a.num_doc 
			left join forjar_adol as c on c.num_doc=a.num_doc 
			left join tipo_documento as d on d.id_tipo_doc=a.id_tipo_doc 
			left join municipio as e on e.id_municipio=a.id_municipio 
			left join departamento as f on f.id_departamento=e.id_departamento 
			left join sexo as g on g.id_sexo=a.id_sexo 
			left join etnia as h on h.id_etnia=a.id_etnia 
			left join escadol_ingr_egr as i on i.num_doc=a.num_doc 
			left join sgsss as j on j.num_doc=a.num_doc 
			left join eps_adol as k on k.id_eps_adol=j.id_eps_adol 
			where b.id_forjar=:id_forjar";
		$consAdol=$conect->createCommand($sqlConsAdol);
		$consAdol->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'),PDO::PARAM_STR);
		$readConsAdol=$consAdol->query();
		$resConsAdol=$readConsAdol->readAll();
		$readConsAdol->close();
		return $resConsAdol;
	}
	public function consultaAdolescenteSede(){
		$conect=Yii::app()->db;
		$sqlConsAdol="select b.id_numero_carpeta,c.fecha_primer_ingreso,a.apellido_1,a.apellido_2,a.nombres,d.tipo_doc,a.id_tipo_doc,a.num_doc,a.fecha_nacimiento,f.departamento, e.municipio,g.sexo,
			a.edad_ingreso, h.etnia,i.estado_escol, k.eps_adol,l.regimen_salud, m.direccion,m.barrio,n.localidad from adolescente as a 
			left join numero_carpeta as b on b.num_doc=a.num_doc 
			left join forjar_adol as c on c.num_doc=a.num_doc 
			left join tipo_documento as d on d.id_tipo_doc=a.id_tipo_doc 
			left join municipio as e on e.id_municipio=a.id_municipio 
			left join departamento as f on f.id_departamento=e.id_departamento 
			left join sexo as g on g.id_sexo=a.id_sexo 
			left join etnia as h on h.id_etnia=a.id_etnia 
			left join escadol_ingr_egr as i on i.num_doc=a.num_doc 
			left join sgsss as j on j.num_doc=a.num_doc 
			left join eps_adol as k on k.id_eps_adol=j.id_eps_adol
			left join regimen_salud as l on l.id_regimen_salud=j.id_regimen_salud 
			left join localizacion_viv as m on m.num_doc=a.num_doc
			left join localidad as n on n.id_localidad=m.id_localidad 
			left join estrato as o on o.id_estrato=m.id_estrato
			where a.num_doc=:num_doc";
		$consAdol=$conect->createCommand($sqlConsAdol);
		$consAdol->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readConsAdol=$consAdol->query();
		$resConsAdol=$readConsAdol->read();
		$readConsAdol->close();
		return $resConsAdol;
	}
	public function consultaLocalAdol(){
		$conect=Yii::app()->db;
		$sqlConsLocAdol="select * from localizacion_viv as a 
			left join estrato as b on b.id_estrato=a.id_estrato 
			left join localidad as c on c.id_localidad=a.id_localidad  where num_doc=:num_doc";
		$consLocAdol=$conect->createCommand($sqlConsLocAdol);	
		$consLocAdol->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readLocAdol=$consLocAdol->query();
		$resLocAdol=$readLocAdol->read();
		$readLocAdol->close();
		return $resLocAdol;	
	}
	
	public function consultaTelefono(){
		$conect=Yii::app()->db;
		$sqlConsTelAdol="select * from telefono as a 
			left join tipo_telefono as b on b.id_tipo_telefono=a.id_tipo_telefono
			where num_doc=:num_doc order by a.id_tipo_telefono asc";
		$consTelAdol=$conect->createCommand($sqlConsTelAdol);	
		$consTelAdol->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readTelAdol=$consTelAdol->query();
		$resTelAdol=$readTelAdol->readAll();
		$readTelAdol->close();
		return $resTelAdol;	
	}
	public function consultaDatosRemision(){
		$conect=Yii::app()->db;
		$sqlConsRem="select * from forjar_adol where num_doc=:num_doc";
		$consRem=$conect->createCommand($sqlConsRem);
		$consRem->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readRem=$consRem->query();
		$resRem=$readRem->read();
		$readRem->close();
		return $resRem;
	}
	public function consultaDocRemitidos(){
		$conect=Yii::app()->db;
		$sqlConsDocRem="select * from adol_doccespa as a left join documento_cespa as b on a.id_doccespa=b.id_doccespa where num_doc=:num_doc order by b.id_doccespa asc";
		$consDocRem=$conect->createCommand($sqlConsDocRem);
		$consDocRem->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readDocRem=$consDocRem->query();
		$resDocRem=$readDocRem->readAll();
		$readDocRem->close();
		return $resDocRem;
	}
	public function consultaDocRemitido(){
		$conect=Yii::app()->db;
		$sqlConsDocRem="select * from adol_doccespa where num_doc=:num_doc and id_doccespa=:id_doccespa";
		$consDocRem=$conect->createCommand($sqlConsDocRem);
		$consDocRem->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$consDocRem->bindParam(":id_doccespa",$this->idDoccespa,PDO::PARAM_STR);
		$readDocRem=$consDocRem->query();
		$resDocRem=$readDocRem->read();
		$readDocRem->close();
		return $resDocRem;
	}
	public function consultaDocumentos(){
		$conect=Yii::app()->db;
		$sqlConsDocRem="select * from documento_cespa order by id_doccespa asc";
		$consDocRem=$conect->createCommand($sqlConsDocRem);
		$consDocRem->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readDocRem=$consDocRem->query();
		$resDocRem=$readDocRem->readAll();
		$readDocRem->close();
		return $resDocRem;
	}
	
	public function consultaAcudiente(){
		$conect=Yii::app()->db;
		$sqlConsAcud="select b.nombres_familiar,b.apellidos_familiar,f.tipo_doc,b.num_doc_fam,i.parentesco,d.localidad,c.barrio,c.direccion,e.estrato 
			from familiar_adolescente as a left join familiar as b on a.id_doc_familiar=b.id_doc_familiar 
			left join localizacion_viv as c on c.id_doc_familiar=a.id_doc_familiar left join localidad as d on d.id_localidad=c.id_localidad 
			left join estrato as e on e.id_estrato=c.id_estrato left join tipo_documento as f on f.id_tipo_doc=b.id_tipo_doc 
			left join municipio as g on g.id_municipio=c.id_municipio left join departamento as h on h.id_departamento=g.id_departamento 
			left join parentesco as i on i.id_parentesco=b.id_parentesco 
			where acudiente is true and a.num_doc=:num_doc";
		$consAcud=$conect->createCommand($sqlConsAcud);
		$consAcud->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readAcud=$consAcud->query();
		$resAcud=$readAcud->read();
		$readAcud->close();
		return $resAcud;
	}
	public function consultaTelAcud(){
		$conect=Yii::app()->db;
		$sqlConsTelAcud="select * from telefono as a left join tipo_telefono as b on b.id_tipo_telefono=a.id_tipo_telefono where id_doc_familiar=:id_doc_familiar";
		$consTelAcud=$conect->createCommand($sqlConsTelAcud);
		$consTelAcud->bindParam(":id_doc_familiar",$this->searchTerm,PDO::PARAM_INT);
		$readConsTelAcud=$consTelAcud->query();
		$resConsTelAcud=$readConsTelAcud->readAll();
		$readConsTelAcud->close();
		return $resConsTelAcud;
	}
	public function consultaEquipoPsicoSoc(){
		$conect=Yii::app()->db;
		$sqlConsBina="select nombre_personal,apellidos_personal,id_rol from hist_personal_adol as a 
			left join persona as b on b.id_cedula=a.id_cedula 
			left join usuario as c on c.id_cedula=a.id_cedula 
			where num_doc=:num_doc and asignado_actualmente is true";
		$consBina=$conect->createCommand($sqlConsBina);
		$consBina->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readConsBina=$consBina->query();
		$resConsBina=$readConsBina->readAll();
		$readConsBina->close();
		return $resConsBina;
	}
	public function consultaEstadoValoracion(){
		$conect=Yii::app()->db;
		$sqlConsEstadoVal="select estado_val from ".pg_escape_string($this->term)." as a 
		left join estado_valoracion as b on a.id_estado_val=b.id_estado_val 
		where a.num_doc=:num_doc";
		$consEstadoVal=$conect->createCommand($sqlConsEstadoVal);
		$consEstadoVal->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readEstadoVal=$consEstadoVal->query();
		$resEstadoVal=$readEstadoVal->read();
		$readEstadoVal->close();
		return $resEstadoVal;
	}
	public function consultaCampoVal(){
		$conect=Yii::app()->db;
		$sqlConsCampVal="select * from ".pg_escape_string($this->searchTerm)." where num_doc=:num_doc";
		$consCampVal=$conect->createCommand($sqlConsCampVal);
		$consCampVal->bindParam(":num_doc",$this->numDocAdol,PDO::PARAM_STR);
		$readCampVal=$consCampVal->query();
		$resCampVal=$readCampVal->read();
		$readCampVal->close();
		return $resCampVal;
	}
	
	public function consultaProfValoracion(){		
		$conect=Yii::app()->db;
		$sqlConsProfVal="select (nombre_personal || ' ' || apellidos_personal) as nombres from ".pg_escape_string($this->term)." as a 
		left join persona as b on b.id_cedula=a.id_cedula 
		where ".pg_escape_string($this->searchTerm)."=:id_valoracion order by ".pg_escape_string($this->termi)." desc limit 1";
		$consProfVal=$conect->createCommand($sqlConsProfVal);
		$consProfVal->bindParam(":id_valoracion",$this->termii,PDO::PARAM_INT);
		$readProfVal=$consProfVal->query();
		$resProfVal=$readProfVal->read();
		$readProfVal->close();
		return $resProfVal;
	}
	public function consultaSedeActual($numDocAdol){
		$conect=Yii::app()->db;
		$sqlConsSedeAdolAct="select * from forjar_adol as a left join centro_forjar as b on b.id_forjar=a.id_forjar where num_doc=:num_doc";
		$consSedeAdolAct=$conect->createCommand($sqlConsSedeAdolAct);
		$consSedeAdolAct->bindParam(":num_doc",$numDocAdol);
		$consSedeAdolAct->execute();
		$readDatosSede=$consSedeAdolAct->query();
		$resDatosSede=$readDatosSede->read();
		$readDatosSede->close();
		return $resDatosSede;
	}
	public function consultarRol(){
		$conect=Yii::app()->db;
		$sqlConsRol="select * from rol order by nombre_rol asc";
		$consRol=$conect->createCommand($sqlConsRol);
		$consRol->bindParam(":num_doc",$numDocAdol);
		$consRol->execute();
		$readRol=$consRol->query();
		$resRol=$readRol->readAll();
		$readRol->close();
		return $resRol;
	}
	//consulta para reportes
	public function consultaForjarAdol(){//conectaBDSinPdo
		$conect=Yii::app()->db;
		$sqlConsAdolForjar="select nombres,apellido_1,apellido_2,a.num_doc,id_numero_carpeta from adolescente as a 
			left join numero_carpeta as c on c.num_doc=a.num_doc 
			where id_forjar=:id_forjar order by id_numero_carpeta asc";
		$consAdolForjar=$conect->createCommand($sqlConsAdolForjar);
		$consAdolForjar->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));
		$readAdolForjar=$consAdolForjar->query();
		$resAdolForjar=$readAdolForjar->readAll();
		$readAdolForjar->close();
		return $resAdolForjar;
	}
	public function consultaValoracionPsicol(){
		$conect=Yii::app()->db;
		$sqlConsValPsicol="select * from valoracion_psicologia where num_doc=:num_doc order by fecha_iniciovalpsicol desc limit 1";
		$consValPsicol=$conect->createCommand($sqlConsValPsicol);
		$consValPsicol->bindParam(":num_doc",$this->numDocAdol);
		$readValPsicol=$consValPsicol->query();
		$resValPsicol=$readValPsicol->read();
		$readValPsicol->close();
		return $resValPsicol;
	}
	public function consultaValoracionTrSoc(){
		$conect=Yii::app()->db;
		$sqlConsValPsicol="select * from valoracion_trabajo_social where num_doc=:num_doc order by fecha_inicio_valtsoc desc limit 1";
		$consValPsicol=$conect->createCommand($sqlConsValPsicol);
		$consValPsicol->bindParam(":num_doc",$this->numDocAdol);
		$readValPsicol=$consValPsicol->query();
		$resValPsicol=$readValPsicol->read();
		$readValPsicol->close();
		return $resValPsicol;
	}
	public function contulaProblemasAsociados(){
		$conect=Yii::app()->db;
		$sqlConsProbAsoc="select * from problemas_asociados order by id_problema_asoc asc";
		$consProbAsoc=$conect->createCommand($sqlConsProbAsoc);
		$consProbAsoc->bindParam(":num_doc",$this->numDocAdol);
		$readProbAsoc=$consProbAsoc->query();
		$resProbAsoc=$readProbAsoc->readAll();
		$readProbAsoc->close();
		return $resProbAsoc;		
	}
	public function contulaAntecedentesFam(){
		$conect=Yii::app()->db;
		$sqlConsAntFam="select * from antecedentes_familiares order by id_ant_fam asc";
		$consAntFam=$conect->createCommand($sqlConsAntFam);
		$consAntFam->bindParam(":num_doc",$this->numDocAdol);
		$readAntFam=$consAntFam->query();
		$resAntFam=$readAntFam->readAll();
		$readAntFam->close();
		return $resAntFam;		
	}
	//consultas de estado de valoraciones
	
	public function consultaDatosAdolValoraciones(){
		$conect= Yii::app()->db;
		$sqlConsultaAdol="select * from adolescente where num_doc=:numDoc";
		$queryConsultaAdol=$conect->createCommand($sqlConsultaAdol);
		$queryConsultaAdol->bindParam(':numDoc',$this->numDocAdol,PDO::PARAM_STR);
		$readConsultaAdol=$queryConsultaAdol->query();
		$resConsultaAdol=$readConsultaAdol->read();
		$readConsultaAdol->close();			
		return $resConsultaAdol;
	}

	
	
	public function consultaAdolFuncionarioHisPers(){
		$conect=Yii::app()->db;
		$sqlConsAdolFunc="select * from hist_personal_adol as a left 
			join forjar_adol as b on b.num_doc=a.num_doc 
			where fecha_vinc_forjar >=:fecha_ini and fecha_vinc_forjar <=:fecha_fin and a.id_cedula=:id_cedulai 
			or fecha_vinc_forjar is null and a.id_cedula=:id_cedulaii order by fecha_vinc_forjar desc";
		$consAdolFunc=$conect->createCommand($sqlConsAdolFunc);
		
		$consAdolFunc->bindParam(":fecha_ini",$this->fechaInicio);
		$consAdolFunc->bindParam(":fecha_fin",$this->fechaFinal);
		$consAdolFunc->bindParam(":id_cedulai",$this->idCedula);		
		$consAdolFunc->bindParam(":id_cedulaii",$this->idCedula);		
		$readAdolFunc=$consAdolFunc->query();
		$resAdolFunc=$readAdolFunc->readAll();
		$readAdolFunc->close();
		return $resAdolFunc;		
	}
	public function consultaAdolFuncionario(){
		$conect=Yii::app()->db;
		$sqlConsAdolFunc="select *  from forjar_adol 
			where fecha_vinc_forjar >=:fecha_ini and fecha_vinc_forjar <=:fecha_fin 
			or fecha_vinc_forjar is null order by fecha_vinc_forjar desc";
		$consAdolFunc=$conect->createCommand($sqlConsAdolFunc);
		$consAdolFunc->bindParam(":fecha_ini",$this->fechaInicio);
		$consAdolFunc->bindParam(":fecha_fin",$this->fechaFinal);
		$readAdolFunc=$consAdolFunc->query();
		$resAdolFunc=$readAdolFunc->readAll();
		$readAdolFunc->close();
		return $resAdolFunc;		
	}

	public function consultaValPsicolReporte(){
		$conect=Yii::app()->db;
		$sqlConsValPsicolAdol="select * from valoracion_psicologia
			where num_doc=:num_doc and val_act_psicol is true";
		$consValPsicolAdol=$conect->createCommand($sqlConsValPsicolAdol);
		$consValPsicolAdol->bindParam(":num_doc",$this->numDocAdol);
		$readValPsicolAdol=$consValPsicolAdol->query();
		$resValPsicolAdol=$readValPsicolAdol->read();
		$readValPsicolAdol->close();
		return $resValPsicolAdol;
	}	
	public function consultaValTrSocReporte(){
		$conect=Yii::app()->db;
		$sqlConsValPsicolAdol="select * from valoracion_trabajo_social
			where num_doc=:num_doc and val_act_trsoc is true";
		$consValPsicolAdol=$conect->createCommand($sqlConsValPsicolAdol);
		$consValPsicolAdol->bindParam(":num_doc",$this->numDocAdol);
		$readValPsicolAdol=$consValPsicolAdol->query();
		$resValPsicolAdol=$readValPsicolAdol->read();
		$readValPsicolAdol->close();
		return $resValPsicolAdol;
	}	
	public function consultaValTOReporte(){
		$conect=Yii::app()->db;
		$sqlConsValPsicolAdol="select * from valoracion_teo
			where num_doc=:num_doc and val_act_to is true";
		$consValPsicolAdol=$conect->createCommand($sqlConsValPsicolAdol);
		$consValPsicolAdol->bindParam(":num_doc",$this->numDocAdol);
		$readValPsicolAdol=$consValPsicolAdol->query();
		$resValPsicolAdol=$readValPsicolAdol->read();
		$readValPsicolAdol->close();
		return $resValPsicolAdol;
	}	
	public function consultaValPsiqReporte(){
		$conect=Yii::app()->db;
		$sqlConsValPsicolAdol="select * from valoracion_psiquiatria
			where num_doc=:num_doc and val_act_psiq is true";
		$consValPsicolAdol=$conect->createCommand($sqlConsValPsicolAdol);
		$consValPsicolAdol->bindParam(":num_doc",$this->numDocAdol);
		$readValPsicolAdol=$consValPsicolAdol->query();
		$resValPsicolAdol=$readValPsicolAdol->read();
		$readValPsicolAdol->close();
		return $resValPsicolAdol;
	}	
	public function consultaValEnfReporte(){
		$conect=Yii::app()->db;
		$sqlConsValPsicolAdol="select * from valoracion_enfermeria
			where num_doc=:num_doc and val_act_enf is true";
		$consValPsicolAdol=$conect->createCommand($sqlConsValPsicolAdol);
		$consValPsicolAdol->bindParam(":num_doc",$this->numDocAdol);
		$readValPsicolAdol=$consValPsicolAdol->query();
		$resValPsicolAdol=$readValPsicolAdol->read();
		$readValPsicolAdol->close();
		return $resValPsicolAdol;
	}	
	public function consultaValNutrReporte(){
		$conect=Yii::app()->db;
		$sqlConsValPsicolAdol="select * from valoracion_nutricional
			where num_doc=:num_doc and val_act_nutr is true";
		$consValPsicolAdol=$conect->createCommand($sqlConsValPsicolAdol);
		$consValPsicolAdol->bindParam(":num_doc",$this->numDocAdol);
		$readValPsicolAdol=$consValPsicolAdol->query();
		$resValPsicolAdol=$readValPsicolAdol->read();
		$readValPsicolAdol->close();
		return $resValPsicolAdol;
	}	
	public function consultaSgsss(){
		$conect=Yii::app()->db;
		$sqlConsSgsssAdol="select * from sgsss as a 
			left join regimen_salud as b on b.id_regimen_salud=a.id_regimen_salud 
			left join eps_adol as c on c.id_eps_adol=a.id_eps_adol  
			where num_doc=:num_doc";		
		$consSgsssAdol=$conect->createCommand($sqlConsSgsssAdol);
		$consSgsssAdol->bindParam(":num_doc",$this->numDocAdol);
		$readSgsssAdol=$consSgsssAdol->query();
		$resSgsssAdol=$readSgsssAdol->read();
		$readSgsssAdol->close();
		return $resSgsssAdol;
	}
	public function consultaInfJudicial(){
		$conect=Yii::app()->db;
		$sqlConsInfJudicial="select * from informacion_judicial as a 
			left join instancia_remisora as b on b.id_instancia_rem=a.id_instancia_rem 
			left join tipo_sancion as c on c.id_tipo_sancion=a.id_tipo_sancion
			where num_doc=:num_doc and novedad_infjud='false'";
		$consInfJudicial=$conect->createCommand($sqlConsInfJudicial);
		$consInfJudicial->bindParam(":num_doc",$this->numDocAdol);
		$readInfJudicial=$consInfJudicial->query();
		$resInfJudicial=$readInfJudicial->readAll();
		$readInfJudicial->close();
		return $resInfJudicial;
	}
	public function consultaInfJudNov($idInfJud){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select * from novedad_inf_judicial as a 
			left join informacion_judicial as b on a.nov_id_inf_judicial=b.id_inf_judicial 
			left join instancia_remisora as c on c.id_instancia_rem=b.id_instancia_rem 
			left join tipo_sancion as d on d.id_tipo_sancion=b.id_tipo_sancion
			where a.id_inf_judicial=:id_inf_judicial order by fecha_reg_novedad desc limit 1";
		$consInfJud=$conect->createCommand($sqlConsInfJud);	
		$consInfJud->bindParam(":id_inf_judicial",$idInfJud,PDO::PARAM_INT);
		$readInfJud=$consInfJud->query();
		$resInfJud=$readInfJud->read();
		$readInfJud->close();
		return $resInfJud;
	}
	public function consultaInfJudicialPorId(){
		$conect=Yii::app()->db;
		$sqlConsInfJudicial="select * from informacion_judicial as a 
			left join instancia_remisora as b on b.id_instancia_rem=a.id_instancia_rem 
			left join tipo_sancion as c on c.id_tipo_sancion=a.id_tipo_sancion
			where num_doc=:num_doc and novedad_infjud='false'";
		$consInfJudicial=$conect->createCommand($sqlConsInfJudicial);
		$consInfJudicial->bindParam(":num_doc",$this->numDocAdol);
		$readInfJudicial=$consInfJudicial->query();
		$resInfJudicial=$readInfJudicial->read();
		$readInfJudicial->close();
		return $resInfJudicial;
	}
	public function consDelitos($idInfJud){
		$conect=Yii::app()->db;
		$sqlConsDelitos="select * from infjud_del_remcesp as a left join delito_rem_cespa as b on b.id_del_rc=a.id_del_rc where id_inf_judicial=:id_inf_judicial";
		$consDelitos=$conect->createCommand($sqlConsDelitos);
		$consDelitos->bindParam(":id_inf_judicial",$idInfJud);
		$readDelitos=$consDelitos->query();
		$resDelitos=$readDelitos->readAll();
		$readDelitos->close();
		return $resDelitos;
	}
}  




?>