<?php 
class ActionLogFilter extends CFilter{
	public $modulo;
	public $controlador;
	public $accionLog;
	public $parametros;
	
    protected function preFilter($filterChain){
		
		if(count($this->parametros)>0){
			if (isset($_SERVER)) {
				if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
					$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
				if (isset($_SERVER["HTTP_CLIENT_IP"]))
					$ip=$_SERVER["HTTP_CLIENT_IP"];
				$ip=$_SERVER["REMOTE_ADDR"];
			}
			else{
				if (getenv('HTTP_X_FORWARDED_FOR'))
					$ip=getenv('HTTP_X_FORWARDED_FOR');
				if (getenv('HTTP_CLIENT_IP'))
					$ip=getenv('HTTP_CLIENT_IP');
				$ip=getenv('REMOTE_ADDR');
			}
			$parametrosBd=serialize($this->parametros);
			$this->accionLog=Yii::app()->controller->action->id;
			$conect=Yii::app()->db;
			$fechaLog=date("Y-m-d H:i:s");
			$sqlRegLog="insert into log_actividad  (
				id_logactividad,
				id_cedula,
				fecha_logactividad,
				array_datos,
				ip_acceso,
				modulo_log,
				contrl_log,
				accion_log
			) values (
				default,
				:id_cedula,
				:fecha_logactividad,
				:array_datos,
				:ip_acceso,
				:modulo_log,
				:contrl_log,
				:accion_log
			)";
			$regLog=$conect->createCommand($sqlRegLog);
			$regLog->bindParam(':id_cedula',Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regLog->bindParam(':fecha_logactividad',$fechaLog,PDO::PARAM_STR);
			$regLog->bindParam(':array_datos',$parametrosBd,PDO::PARAM_STR);
			$regLog->bindParam(':ip_acceso',$ip,PDO::PARAM_STR);
			$regLog->bindParam(':modulo_log',$this->modulo,PDO::PARAM_STR);
			$regLog->bindParam(':contrl_log',$this->controlador,PDO::PARAM_STR);
			$regLog->bindParam(':accion_log',$this->accionLog,PDO::PARAM_STR);
			$regLog->execute();			
		}
		$filterChain->run();
       // return false; // false if the action should not be executed
    }
 
    protected function postFilter($filterChain){
        // logic being applied after the action is executed
    }
}
?>