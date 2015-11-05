<?php

/**
 * This is the model class for table "justificacion_hab_val".
 *
 * The followings are the available columns in table 'justificacion_hab_val':
 * @property integer $id_hab_val
 * @property string $id_cedula
 * @property string $justificacion_habval
 * @property string $valoracion_hab
 * @property integer $id_val_hab
 * @property string $fecha_hab_val
 *
 * The followings are the available model relations:
 * @property Persona $idCedula
 */
class JustificacionHabVal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $numDoc;
	public function tableName()
	{
		return 'justificacion_hab_val';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cedula,numDoc, justificacion_habval, valoracion_hab, id_val_hab, fecha_hab_val', 'required'),
			array('id_val_hab', 'numerical', 'integerOnly'=>true),
			array('valoracion_hab', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_hab_val, id_cedula, justificacion_habval, valoracion_hab, id_val_hab, fecha_hab_val', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_hab_val' => 'Id Hab Val',
			'id_cedula' => 'Id Cedula',
			'justificacion_habval' => 'Justificacion Habval',
			'valoracion_hab' => 'Valoracion a habilitar',
			'id_val_hab' => 'Id Val Hab',
			'fecha_hab_val' => 'Fecha Hab Val',
			'numDoc'=>'numero documento'
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

		$criteria->compare('id_hab_val',$this->id_hab_val);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('justificacion_habval',$this->justificacion_habval,true);
		$criteria->compare('valoracion_hab',$this->valoracion_hab,true);
		$criteria->compare('id_val_hab',$this->id_val_hab);
		$criteria->compare('fecha_hab_val',$this->fecha_hab_val,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JustificacionHabVal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function compruebaValHab($numDoc,$valoracion,$campoHab){	
		$conect=Yii::app()->db;
		$sqlConsVal="select * from ".pg_escape_string($valoracion)." where num_doc=:num_doc and ".pg_escape_string($campoHab)."='true'";
		$consval=$conect->createCommand($sqlConsVal);
		$consval->bindParam(":num_doc",$numDoc);
		$readConsVal=$consval->query();
		$resConsVal=$readConsVal->read();
		$readConsVal->close();
		return $resConsVal;
	}
	
	public function consultaProfesionales($numDoc, $valoracion){
		$roll="";
		switch($valoracion){
			case "valoracion_psicologia":
				$roll="4";
			break;	
			case "valoracion_trabajo_social":
				$roll="5";
			break;
			case "valoracion_teo":
				$roll="6";
			break;
			case "valoracion_enfermeria":
				$roll="9";
			break;
			case "valoracion_psiquiatria":
				$roll="7";
			break;	
			case "valoracion_nutricional":
				$roll="18";
			break;		
		}
		if(!empty($roll)){//
			if($roll==4||$roll==5){
				$conect=Yii::app()->db;
				$sqlPersAdol="select (nombre_personal || ' ' || apellidos_personal) as nombrpersona,b.id_cedula 
					from hist_personal_adol as a 
					left join persona as b on a.id_cedula=b.id_cedula 
					left join usuario as c on c.id_cedula=a.id_cedula 
					where id_rol=:id_rol and num_doc=:num_doc and 
						pers_habilitado is true and 
						asignado_actualmente is true";
				$persAdol=$conect->createCommand($sqlPersAdol);
				$persAdol->bindParam(":id_rol",$roll);
				$persAdol->bindParam(":num_doc",$numDoc);
				$readPersAdol=$persAdol->query();
				$resPersAdol=$readPersAdol->read();
				$readPersAdol->read();
				$profesionales=array();
				array_push($profesionales,array('id_cedula'=>CJavaScript::encode(CJavaScript::quote($resPersAdol["id_cedula"])),'nombre_prof'=>CJavaScript::encode(CJavaScript::quote($resPersAdol["nombrpersona"]))));
				return $profesionales;
			}
			else{
				$conect=Yii::app()->db;
				$sqlPersAdol="select (nombre_personal || ' ' || apellidos_personal) as nombrpersona,a.id_cedula from persona as a 
					left join cforjar_personal as b on b.id_cedula=a.id_cedula 
					left join (select id_forjar from forjar_adol where num_doc =:num_doc) as c on b.id_forjar=c.id_forjar 
					left join usuario as d on d.id_cedula=a.id_cedula 
					where b.id_forjar=c.id_forjar and id_rol=:id_rol and pers_habilitado is true";
				$persAdol=$conect->createCommand($sqlPersAdol);
				$persAdol->bindParam(":id_rol",$roll);
				$persAdol->bindParam(":num_doc",$numDoc);
				$readPersAdol=$persAdol->query();
				$resPersAdol=$readPersAdol->readAll();
				$readPersAdol->read();
				$profesionales=array();
				foreach($resPersAdol as $personal){
					array_push($profesionales,array('id_cedula'=>CJavaScript::encode(CJavaScript::quote($personal["id_cedula"])),'nombre_prof'=>CJavaScript::encode(CJavaScript::quote($personal["nombrpersona"]))));
				}				
				return $profesionales;
			}			
		}
	}
	public function habilitaValoracion($numDoc,$valoracion,$campoHab,$campoIdVal){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlHabVal="insert into justificacion_hab_val (
			 	id_hab_val,
				id_cedula,
				justificacion_habval,
				valoracion_hab,
				id_val_hab,
				fecha_hab_val
			) values (
				default,
				:id_cedula,
				:justificacion_habval,
				:valoracion_hab,
				:id_val_hab,
				:fecha_hab_val
			)";
			$habVal=$conect->createCommand($sqlHabVal);
			$habVal->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
			$habVal->bindParam(":justificacion_habval",$this->justificacion_habval,PDO::PARAM_STR);
			$habVal->bindParam(":valoracion_hab",$valoracion,PDO::PARAM_STR);
			$habVal->bindParam(":id_val_hab",$this->id_val_hab,PDO::PARAM_INT);
			$habVal->bindParam(":valoracion_hab",$valoracion,PDO::PARAM_STR);
			$habVal->bindParam(":fecha_hab_val",$this->fecha_hab_val,PDO::PARAM_STR);	
			$habVal->execute();

			$sqlHabVal="update ".pg_escape_string($valoracion)." set ".pg_escape_string($campoHab)."='true' where num_doc=:num_doc and ".pg_escape_string($campoIdVal)."=:idValoracion";
			$habVal=$conect->createCommand($sqlHabVal);
			$habVal->bindParam(":num_doc",$numDoc,PDO::PARAM_STR);	
			$habVal->bindParam(":idValoracion",$this->id_val_hab,PDO::PARAM_STR);	
			$habVal->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}		
	}
}
