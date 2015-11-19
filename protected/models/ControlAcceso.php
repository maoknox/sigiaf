<?php
/**
 * Classe modelo controlAcceso
 *
 * Clase que consulta si el usuario tiene acceso o no a la acción solicitada. 
 * 
 * 
 */

	class ControlAcceso {
		public $accion;		/**< acción que ejecuta el usuario. */
		
		/**
		* Método que consulta, según la acción que ejecute el usuario, el permiso de acceso a ésta. 
		*/		
		public function controlAccesoAcciones(){
			if(!empty($this->accion)){	
				$conect=Yii::app()->db;
				$parametro='%'.$this->accion.'%';
				$sqlConsAcceso="select acceso_rolmenu from menu as a left join rol_menu as b on a.id_menu=b.id_menu where accion like :parametro and id_rol=:id_rol";
				$consAcceso=$conect->createCommand($sqlConsAcceso);
				$consAcceso->bindParam(':parametro',$parametro,PDO::PARAM_STR);
				$consAcceso->bindParam(':id_rol',Yii::app()->user->getState('rol'),PDO::PARAM_STR);
				$readAcceso=$consAcceso->query();
				$resAcceso=$readAcceso->read();
				$readAcceso->close();
				return $resAcceso;
			}
			else{
				return false;
			}
		}		
	}

?>