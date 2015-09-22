<?php

/**
 * This is the model class for table "asistencia".
 *
 * The followings are the available columns in table 'asistencia':
 * @property string $id_asistencia
 * @property integer $id_areapresencial
 * @property integer $id_areainteres
 * @property string $num_doc
 * @property string $fecha_asistencia
 * @property string $observacion_asistencia
 *
 * The followings are the available model relations:
 * @property AreaInscripcion $idAreainteres
 * @property AreaPresencial $idAreapresencial
 * @property Adolescente $numDoc
 */
class Asistencia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $mes;
	public $anio;
	public $areaAsistencia;
	public function tableName()
	{
		return 'asistencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_asistencia', 'required'),
			array('id_areapresencial, id_areainteres', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('observacion_asistencia', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_asistencia, id_areapresencial, id_areainteres, num_doc, fecha_asistencia, observacion_asistencia', 'safe', 'on'=>'search'),
			array('areaAsistencia','validaAreaAsist')
		);
	}
	public function validaAreaAsist($attribute=NULL,$params=NULL){
		//if(isset($_POST["numFechas"]) && $_POST["numFechas"]==0){
			//if($_POST["numFechas"]==0){
			$dataInput=Yii::app()->input->post();
			$variables=array_keys($dataInput);
			//print_r($_POST);
			/*if(isset($dataInput[$variables[0]])){
				$this->addError($attribute,"existe fecha");
			}*/
			if(count($variables)<=1){
				$this->addError($attribute,"Debe seleccionar algún adolescente para registrar la asistencia");
			}
			else{
				foreach($variables as $variable){
					$subVariable=array_keys($dataInput[$variable]);				
					if($subVariable[0]!="fecha_asistencia"){
						$numAreaInt=0;
						foreach($subVariable as $subVariablei){
							if(!empty($dataInput[$variable][$subVariablei]))
								$numAreaInt+=1;											
						}
						if($numAreaInt==0){
							$this->addError($attribute,"Hay algún adolescente sin un área de asistencia seleccionada");
							break;
						}
						//print_r($subVariable);
					}
					//print_r($subVariable);
				}
			}
			//$this->addError($attribute,$dataInput[""]);//"Hay un adolescente sin un área de asistencia seleccionada"
			//}
			
				//$this->addError($attribute,$_POST["numFechas"]);
			//}
		//}
					
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idAreainteres' => array(self::BELONGS_TO, 'AreaInscripcion', 'id_areainteres'),
			'idAreapresencial' => array(self::BELONGS_TO, 'AreaPresencial', 'id_areapresencial'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_asistencia' => 'Id Asistencia',
			'id_areapresencial' => 'Id Areapresencial',
			'id_areainteres' => 'Id Areainteres',
			'num_doc' => 'Num Doc',
			'fecha_asistencia' => 'Fecha Asistencia',
			'observacion_asistencia' => 'Observacion Asistencia',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_asistencia',$this->id_asistencia,true);
		$criteria->compare('id_areapresencial',$this->id_areapresencial);
		$criteria->compare('id_areainteres',$this->id_areainteres);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('fecha_asistencia',$this->fecha_asistencia,true);
		$criteria->compare('observacion_asistencia',$this->observacion_asistencia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Asistencia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function registraAsistencia(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegAsistencia="insert into asistencia (
				id_asistencia,
				id_areapresencial,
				id_areainteres,
				num_doc,
				fecha_asistencia
			) values (
				:id_asistencia,
				:id_areapresencial,
				:id_areainteres,
				:num_doc,
				:fecha_asistencia
			)";
			$micro_date = microtime();
			$date_array = explode(" ",$micro_date);
			$date = date("Y-m-d H:i:s.",$date_array[1]); $milisec=explode(".",$date_array[0]);
			$fechaRegistro=$date.$milisec[1];
			$regAsistencia=$conect->createCommand($sqlRegAsistencia);
			$regAsistencia->bindParam(":id_asistencia",$fechaRegistro,PDO::PARAM_STR);
			$regAsistencia->bindParam(":id_areapresencial",$this->id_areapresencial,PDO::PARAM_NULL);
			$regAsistencia->bindParam(":id_areainteres",$this->id_areainteres,PDO::PARAM_NULL);
			$regAsistencia->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regAsistencia->bindParam(":fecha_asistencia",$this->fecha_asistencia,PDO::PARAM_STR);
			$regAsistencia->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}
	}
	public function reporteAsistencia(){
		$conect=Yii::app()->db;
		
		header("Content-type: application/vnd.ms-excel; name='excel'");  
		header("Content-Disposition: filename=repAsist-".$this->anio."-".$this->mes.".xls");  
		header("Pragma: no-cache");  
		header("Expires: 0"); 
		$conect=Yii::app()->db;
		$dia = (int) 1;
		$mes = (int) $this->mes;//$mes;
		$anio = (int) $this->anio;//$anio;
		//halla el ultimo dia respecto al mes y año
		$ultimo_dia = 28;
		while (checkdate($mes,$ultimo_dia + 1,$anio)){ 
		 $ultimo_dia++; 
		} 
		//halla el dia de la semana (es decir lunes o martes etc) segun el dia primero.
		$numerodiasemana = date('w', mktime(0,0,0,$mes,1,$anio)); 
		if ($numerodiasemana == 0) //el 0 es domingo
			 $numerodiasemana = 6; 
		else 
			 $numerodiasemana--;
		$semana =1;
		$dia = 1;
		while($dia<=$ultimo_dia){
			$tabSemana .= '<th colspan="8" id="cab">Semana '.$semana.'</th>';
			$tabNomD .= '<td>L</td><td>M</td><td>M</td><td>J</td><td>V</td><td>S</td><td>D</td><td>Total</td>';
			for($contD=0;$contD<=6;$contD++){
				if($contD==$numerodiasemana&&$dia<=$ultimo_dia){
					$tabDSem .= '<td>'.$dia.'</td>';
					$numerodiasemana++;
					$dia++;
				}
				else{
					$tabDSem .= '<td> </td>';
				}
			}
			$tabDSem .= '<td> tot</td>';
			$numerodiasemana=0;
			$semana++;
		}
		$sqlConsAreaPres="select * from area_presencial order by id_areapresencial asc";
		$consAreaPres=$conect->createCommand($sqlConsAreaPres);
		$readConsAreaPres=$consAreaPres->query();
		while($resConsAreaPres=$readConsAreaPres->read()){
			$areaPres.='<td rowspan="3" >'.$resConsAreaPres["area_presencial"].'</td>';
			$idAreaPres[]=$resConsAreaPres["id_areapresencial"];			
		}	
		$readConsAreaPres->close();
		$sqlConsAreaIns="select * from areainscr_cforjar as a left join area_inscripcion as b on b.id_areainteres=a.id_areainteres where id_forjar=:id_forjar order by b.id_areainscr,area_interes asc";
		$consAreaIns=$conect->createCommand($sqlConsAreaIns);
		$consAreaIns->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));// 				
		$readConsAreaIns=$consAreaIns->query();
		while($resConsAreaIns=$readConsAreaIns->read()){
			$areaPres.='<td rowspan="3" >'.$resConsAreaIns["area_interes"].'</td>';
			$idAreaInsc[]=$resConsAreaIns["id_areainscr"];			
		}	
		$readConsAreaIns->close();
		//$tabSemana .="<tr>".$tabNomD."</tr>";
		//$tabSemana .="<tr>".$tabDSem."</tr>";
		$tabSemana = '<tr><td rowspan="3">Nombres</td><td rowspan="3">Apellidos</td><td rowspan="3">Documento Identidad</td>'.$tabSemana.'<td rowspan="3">TOTAL</td>'.$areaPres.'</tr>';
		$tabDSem = '<tr>'.$tabDSem.'</tr>';
		$tabla='<table  border="1px" style="border:1px solid #003">';
		$tabla.='<caption>Reporte del mes '.$mes.' del a&ntilde;o '.$anio.'</caption>';
		$tabla.=$tabSemana.$tabNomD.$tabDSem;
		//fin del encabezado
		
		//Inicio del reporte de asistencia por adolescente
		$sqlConsAdol="select * from adolescente as a left join numero_carpeta as b on a.num_doc=b.num_doc left join forjar_adol as c on c.num_doc=a.num_doc where c.id_forjar=:id_forjar order by id_numero_carpeta asc";
		$consAdol=$conect->createCommand($sqlConsAdol);
		$consAdol->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));
		$readConsAdol=$consAdol->query();
		while($respConsAdol = $readConsAdol->read()){
			$registroAdol[]= array("nombresAdol"=>$respConsAdol["nombres"],"apellido_1"=>$respConsAdol["apellido_1"],"apellido_2"=>$respConsAdol["apellido_2"],"num_doc"=>$respConsAdol["num_doc"]);
		}
		/*foreach($registroAdol as $pk=>$adol){
			$fechaIni = "01/".$mes."/".$anio;
			$fechaFin = $ultimo_dia."/".$mes."/".$anio;
			//$sqlConsAdAsist = "select * from asistencia where fecha_asistencia>=:fecha_ini and fecha_asistencia<=:fecha_fin and num_doc=:num_doc";		
			//$consAdAsist=$conect->createCommand($sqlConsAdAsist);
			//$consAdAsist->bindParam(":fecha_ini",$fechaIni,PDO::PARAM_STR);
			//$consAdAsist->bindParam(":fecha_fin",$fechaFin,PDO::PARAM_STR);
			//$consAdAsist->bindParam(":num_doc",$adol["num_doc"],PDO::PARAM_STR);
			//$readConsAdol=$consAdAsist->query();
			//$readConsAdol
			//'".$registroAdol[$contRegAd]["num_doc"].	
			$repAsistAdol[$pk]=$registroAdol[$pk];
		}*/
		$fechaIni = "01/".$mes."/".$anio;
		$fechaFin = $ultimo_dia."/".$mes."/".$anio;
		foreach($registroAdol as $pk=>$asistAdol){
			$semana =1;
			$dia = 1;
			$countAsistAdolSemana=0;
			$countAsistSemana;
			$countAsistAdolMes=0;
			$countAsistMes=0;
			$countAsistDia;
			//$sqlConsAdol = "select * from adolescente";
			//$query
			$numerodiasemana = date('w', mktime(0,0,0,$mes,1,$anio)); 
			if ($numerodiasemana == 0) 
				 $numerodiasemana = 6; 
			else 
				 $numerodiasemana--;
			$numDocAdol = $asistAdol["num_doc"];
			$repAdol = '<td>'.$asistAdol["nombresAdol"].'</td><td>'.$asistAdol["apellido_1"].' '.$asistAdol["apellido_2"].'</td><td>'.$asistAdol["num_doc"].'</td>';	
			while($dia<=$ultimo_dia){
				for($contD=0;$contD<=6;$contD++){
					if($contD==$numerodiasemana&&$dia<=$ultimo_dia){
						//$fechaAsist = $dia."/".$mes."/".$anio;
						$fechaAsist=$anio."-".$mes."-".$dia;
						$sqlConsAdAsist = "select * from asistencia where fecha_asistencia=:fecha and num_doc=:num_doc";		
						$consAdAsist=$conect->createCommand($sqlConsAdAsist);
						$consAdAsist->bindParam(":fecha",$fechaAsist,PDO::PARAM_STR);
						$consAdAsist->bindParam(":num_doc",$asistAdol["num_doc"],PDO::PARAM_STR);
						$readConsAdAsist=$consAdAsist->query();
						$resConsAdAsist=$readConsAdAsist->read();							
						if(!empty($resConsAdAsist)){
							$repAdol .= '<td>1</td>';
							$countAsistAdolSemana+=1;
							$countAsistDia[$dia]+=1;
							$readConsAdAsist->close();
						}
						else{
							$repAdol .= '<td> </td>';
						}
						$numerodiasemana++;
						$dia++;
					}
					else{
						$repAdol .= '<td> </td>';
					}
				}
				$repAdol .= '<td>'.$countAsistAdolSemana.'</td>';
				$numerodiasemana=0;
				$countAsistAdolMes+=$countAsistAdolSemana;
				$countAsistSemana[$semana]+=$countAsistAdolSemana;
				$countAsistAdolSemana=0;
				$semana++;
			}
			$repAdol .='<td>'.$countAsistAdolMes.'</td>';
			$countAsistAdolMes=0;
			//if($areaAsist==1){
				$repArPr=$this->consultaAreaPresencial($numDocAdol,$linkBd,$idAreaPres,$fechaIni,$fechaFin);
				$repArInsc=$this->consultaAreaInscr($numDocAdol,$linkBd,$idAreaInsc,$fechaIni,$fechaFin);
				
				$totTabla .= '<tr>'.$repAdol.$repArPr.$repArInsc.'</tr>';
			//}					
		}
		while (checkdate($mes,$ultimo_dia + 1,$anio)){ 
		 $ultimo_dia++; 
		} 
		$numerodiasemana = date('w', mktime(0,0,0,$mes,1,$anio)); 
		if ($numerodiasemana == 0) 
			 $numerodiasemana = 6; 
		else 
			 $numerodiasemana--;
		$semana =1;
		$dia = 1;
		
		//$sqlConsAdol = "select * from adolescente";
		//$query
		/*$numerodiasemana = date('w', mktime(0,0,0,$mes,1,$anio)); 
		if ($numerodiasemana == 0) 
			 $numerodiasemana = 6; 
		else 
			$numerodiasemana--;
		$totTabla .= '<tr><td colspan="3">TOTAL</td>';
		$countSemana=1;
		while($dia<=$ultimo_dia){
			for($contD=0;$contD<=6;$contD++){
				if($contD==$numerodiasemana&&$dia<=$ultimo_dia){
					$totTabla .= '<td>'.$countAsistDia[$dia].'</td>';
				}
				else{
					$totTabla .= '<td></td>';
				}
				$dia++;
				$numerodiasemana++;
			}
			$totTabla .= '<td>'.$countAsistSemana[$countSemana].'</td>';
			$totalSemMes += $countAsistSemana[$countSemana];
			$numerodiasemana=0;
			$countSemana+=1;
		}*/
		//$totTabla .= '<td>'.$totalSemMes.'</td>';

		$tabla.=$totTabla."</table>";
		echo utf8_decode($tabla);
	}
	public function consultaAreaPresencial($numDocAdol,$linkBd,$idAreaPres,$fechaIni,$fechaFin){
		$conect=Yii::app()->db;
		foreach($idAreaPres as $areaPres){
			$sqlConsAdAsist = "select count(*) as countarp from asistencia where fecha_asistencia>=:fecha_ini and fecha_asistencia<=:fecha_fin and num_doc=:num_doc and id_areapresencial=:id_area_res";
			$consAdAsist=$conect->createCommand($sqlConsAdAsist);
			$consAdAsist->bindParam(":fecha_ini",$fechaIni,PDO::PARAM_STR);
			$consAdAsist->bindParam(":fecha_fin",$fechaFin,PDO::PARAM_STR);
			$consAdAsist->bindParam(":num_doc",$numDocAdol,PDO::PARAM_STR);
			$consAdAsist->bindParam(":id_area_res",$areaPres,PDO::PARAM_INT);
			$readAdAsist=$consAdAsist->query();
			$resConsAdAsist=$readAdAsist->read();
			if(!empty($resConsAdAsist)){		
				//$readAdAsist->close();		
				$tabArPr .= '<td>'.$resConsAdAsist["countarp"].'</td>';
			}
			else{
				$tabArPr .= '<td> </td>';
			}
		}
		return $tabArPr;		
	}
	public function consultaAreaInscr($numDocAdol,$linkBd,$idAreaInsc,$fechaIni,$fechaFin){
		$conect=Yii::app()->db;
		$sqlConsAdAsist = "select * from asistencia as a left join area_inscripcion as b on b.id_areainteres=a.id_areainteres where a.num_doc=:num_doc and a.id_areainteres is not null and fecha_asistencia>=:fecha_ini and fecha_asistencia<=:fecha_fin order by id_areainscr,area_interes asc";
		$consAdAsist=$conect->createCommand($sqlConsAdAsist);
		$consAdAsist->bindParam(":fecha_ini",$fechaIni,PDO::PARAM_STR);
		$consAdAsist->bindParam(":fecha_fin",$fechaFin,PDO::PARAM_STR);
		$consAdAsist->bindParam(":num_doc",$numDocAdol,PDO::PARAM_STR);
		$readAdAsist=$consAdAsist->query();
		$resConsAdAsist=$readAdAsist->readAll();
		$readAdAsist->close();
		$numAsistAint=0;
		$numAsistDep=0;
		if(!empty($resConsAdAsist)){
			foreach($resConsAdAsist as $asistAreaInsc){			
				$areaInsc[$asistAreaInsc["id_areainteres"]]+=1;		
			}
		}
		for($i=0;$i<count($idAreaInsc);$i++){
			if($areaInsc[$idAreaInsc[$i]]!=""){
				$sumaArea=$areaInsc[$idAreaInsc[$i]];
			}
			else{
				$sumaArea=0;
			}
			$tabArPr .= '<td>'.$sumaArea.'</td>';
		}
		return $tabArPr;
	}
}