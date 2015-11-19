<?php
///!  ControlApp.  
/**
*	Clase del ámbito modelo
*/

class ControlApp extends CFormModel
{
	/**
	 * Consulta los modulos a los cuales puede acceder el rol del usuario.
	 */	 
	public function consultaModulo(){
		$conect= Yii::app()->db;
		$sql_RolModulo="select * from rol_modulo as a left join modulo as b on a.id_modulo=b.id_modulo where id_rol=:rol order by a.id_modulo asc";
		$query_RolModulo=$conect->createCommand($sql_RolModulo);
		$query_RolModulo->bindParam(":rol",Yii::app()->user->getState('rol'),PDO::PARAM_INT);
		$read_RolModulo=$query_RolModulo->query();
		$res_RolModulo=$read_RolModulo->readAll();
		$read_RolModulo->close();
		return $res_RolModulo;
	}
	
	/**
	 * Consulta el menú al cual puede acceder el rol del usuario.
	 */	 
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
		
	/**
	 * Consulta los submenú a los cuales puede acceder el rol del usuario.
	 */	 
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
