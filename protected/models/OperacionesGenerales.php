<?php
/**
 * Clase modelo "OperacionesGenerales".
 */
class OperacionesGenerales{
	
	/**
	 * Valida el formato de la fecha y devuelve en 'año-mes-dia'
	 */
	public function validaFormatoFecha($fechaPas,$formato='Y-m-d'){
		$version = explode('.', phpversion());
		if (((int) $version[0] >= 5 && (int) $version[1] >= 2 && (int) $version[2] > 17)) {
			$d = DateTime::createFromFormat($formato, $fechaPas);
		} else {
		$d = new DateTime(date($formato, strtotime($fechaPas)));
		}
		return $d && $d->format($formato) == $fechaPas;
	}
	
	/**
	 * Halla la edad del adolescente según fecha de nacimiento con la fecha actual.
	 */
	public function hallaEdad($fecha_nacimiento,$fechaActual){
		//echo $fecha_nacimiento." ".$fechaActual;
		$fechaInicio=split("-",$fecha_nacimiento);
		$fechaFinal=split("-",$fechaActual);
		$anio=$fechaFinal[0]-$fechaInicio[0];
		$mes=$fechaFinal[1]-$fechaInicio[1];
		$dia=$fechaFinal[2]-$fechaInicio[2];
		if($dia<0){
			$mesComp=abs($mes)-1;
			$mesComp+=abs($dia)/30;
		}
		else{
			$mesComp=abs($mes)+($dia/30);
		}
		if($mes<0){
			$anio-=1;
		}
		$anio+=$mesComp/12;
		return round($anio ,2); 
	}
	/**
	 * método para quitar las tildes y carácteres especiales cuando se digita el nombre de adolescente en el campo búsqueda.
	 */
	public function quitar_tildes($cadena) {
		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã","Ã‹","Ñ","ä","ë","ï","ö","ü","Ä","Ë","Ï","Ö","Ü");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","N","a","e","i","o","u","A","E","I","O","U");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}
	/**
	 * Método que encripta en sha1 con un hash la clave del adolescente con un hash key
	 */
	public function encriptaClaveHMAC($clave){
		$hash=  hash_init('sha1',HASH_HMAC,Yii::app()->params["hash_key"]);
        hash_update($hash, $clave);
		return hash_final($hash);
	}
	public function comparaFecha($fechaInicial,$fechaFinal){
		// Pasa la fecha de la DB a epoch y le aqgrega 7 días
		$fechaCompIni = strtotime($fechaInicial);
		$fechaCompFin = strtotime($fechaFinal);
		if($fechaCompFin<$fechaCompIni){
			return false;
		}
		else{
			return true;
		}
	}
}

?>