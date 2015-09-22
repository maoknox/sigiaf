<?php

/**
 * This is the model class for table "personal".
 *
 * The followings are the available columns in table 'personal':
 * @property string $id_cedula
 * @property integer $id_cargo
 * @property string $nombres_personal
 * @property string $apellidos_personal
 * @property string $nombreusuario
 * @property string $clave
 * @property boolean $pers_habilitado
 *
 * The followings are the available model relations:
 * @property ConceptoIntegral[] $conceptoIntegrals
 * @property CorreccionesValpsicol[] $correccionesValpsicols
 * @property EquipopsicosocPai[] $equipopsicosocPais
 * @property Adolescente[] $adolescentes
 * @property InformepersAdol[] $informepersAdols
 * @property LogModificaciones[] $logModificaciones
 * @property ObservacionValteo[] $observacionValteos
 * @property ObservEnfermeria[] $observEnfermerias
 * @property ObservPsiquiatria[] $observPsiquiatrias
 * @property ObservValtsocial[] $observValtsocials
 * @property PerslSegAdol[] $perslSegAdols
 * @property Psc[] $pscs
 * @property RegistroAdol[] $registroAdols
 * @property SeguimientoCompderecho[] $seguimientoCompderechoes
 * @property SeguimientoCompsancion[] $seguimientoCompsancions
 * @property SeguimientoPsc[] $seguimientoPscs
 * @property SeguimientoRefer[] $seguimientoRefers
 * @property ReferenciacionAdol[] $referenciacionAdols
 * @property ValoracionEnfermeria[] $valoracionEnfermerias
 * @property ValoracionPsicologia[] $valoracionPsicologias
 * @property ValoracionPsiquiatria[] $valoracionPsiquiatrias
 * @property ValoracionTeo[] $valoracionTeos
 * @property Cargo $idCargo
 * @property ValoracionTrabajoSocial[] $valoracionTrabajoSocials
 */
class ControlApp extends CFormModel
{
	/**
	 * @return string the associated database table name
	 */	 
	public function consultaModulo(){
		$conect= Yii::app()->db;
		$sql_RolModulo="select * from rol_modulo as a left join modulo as b on a.id_modulo=b.id_modulo where id_rol=:rol order by a.id_modulo asc";
		$query_RolModulo=$conect->createCommand($sql_RolModulo);
		$query_RolModulo->bindParam(":rol",Yii::app()->user->getState('rol'),PDO::PARAM_INT);
		$read_RolModulo=$query_RolModulo->query();
		$res_RolModulo=$read_RolModulo->readAll();
		$read_RolModulo->close();
		//echo Yii::app()->user->getState('rol');
		//exit;
		return $res_RolModulo;
	}
	
	public function consultaMenu($id_modulo=null,$id_rol=null){
		$conect= Yii::app()->db;
		$sql_RolMenu="select * from menu as a left join rol_menu as b on a.id_menu=b.id_menu 
			where a.id_modulo=:modulo and id_rol=:rol 
			and acceso_rolmenu='true' order by orden asc";
		$query_RolMenu=$conect->createCommand($sql_RolMenu);
		$query_RolMenu->bindParam(":rol",Yii::app()->user->getState('rol'),PDO::PARAM_INT);
		$query_RolMenu->bindParam(":modulo",$id_modulo,PDO::PARAM_INT);
		$read_RolMenu=$query_RolMenu->query();
		//$read_RolMenu->readAll();
		$menuPr=$read_RolMenu->readAll();
		$read_RolMenu->close();
		return $menuPr;
	}	
	public function consultaSubMenu($id_menu){
		$conect= Yii::app()->db;
		$sql_RolMenu="select * from menu as a left join rol_menu as b on 
			a.id_menu=b.id_menu where a.men_id_menu like :id_men and 
			id_rol=:rol and acceso_rolmenu='true' order by a.id_menu asc";
		$query_RolMenu=$conect->createCommand($sql_RolMenu);
		$id_menu="%".$id_menu."%";
		$query_RolMenu->bindParam(":id_men",$id_menu,PDO::PARAM_STR);
		$query_RolMenu->bindParam(":rol",Yii::app()->user->getState('rol'),PDO::PARAM_INT);
		$read_RolMenu=$query_RolMenu->query();
		//$read_RolMenu->readAll();
		$menuPr=$read_RolMenu->readAll();
		$read_RolMenu->close();
		return $menuPr;
	}
	
	
}
