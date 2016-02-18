<?php

/**
 * This is the model class for table "forjar_adol".
 *
 * The followings are the available columns in table 'forjar_adol':
 * @property string $id_forjar
 * @property string $num_doc
 * @property integer $id_estado_adol
 * @property string $fecha_primer_ingreso
 * @property string $fecha_vinc_forjar
 * @property integer $num_ingresos
 * @property string $observaciones_ingreso
 * @property integer $tiempo_modificacion
 */
class ForjarAdol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'forjar_adol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_forjar, num_doc, id_estado_adol', 'required'),
			array('id_estado_adol, num_ingresos, tiempo_modificacion', 'numerical', 'integerOnly'=>true),
			array('id_forjar', 'length', 'max'=>10),
			array('num_doc', 'length', 'max'=>15),
			array('fecha_primer_ingreso, fecha_vinc_forjar, observaciones_ingreso', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_forjar, num_doc, id_estado_adol, fecha_primer_ingreso, fecha_vinc_forjar, num_ingresos, observaciones_ingreso, tiempo_modificacion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_forjar' => 'Sede Forjar',
			'num_doc' => 'Número de identificación',
			'id_estado_adol' => 'Estado Adolescente',
			'fecha_primer_ingreso' => 'Fecha Primer Ingreso',
			'fecha_vinc_forjar' => 'Fecha Vinculación Forjar',
			'num_ingresos' => 'Num. Ingresos',
			'observaciones_ingreso' => 'Observaciones Ingreso',
			'tiempo_modificacion' => 'Tiempo Modificación',
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

		$criteria->compare('id_forjar',$this->id_forjar,true);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_estado_adol',$this->id_estado_adol);
		$criteria->compare('fecha_primer_ingreso',$this->fecha_primer_ingreso,true);
		$criteria->compare('fecha_vinc_forjar',$this->fecha_vinc_forjar,true);
		$criteria->compare('num_ingresos',$this->num_ingresos);
		$criteria->compare('observaciones_ingreso',$this->observaciones_ingreso,true);
		$criteria->compare('tiempo_modificacion',$this->tiempo_modificacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ForjarAdol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	Consulta la información de ingreso del adolescente y a cuál sede está asignado.
	 *	@return $resDocsAdol documentos remitidos 
	 */		
	public function consultaDatosForjarAdol(){
		$conect=Yii::app()->db;
		$sqlConsForjarAdol="select * from forjar_adol where num_doc=:num_doc";
		$consForjarAdol=$conect->createCommand($sqlConsForjarAdol);	
		$consForjarAdol->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readForjarAdol=$consForjarAdol->query();
		$resForjarAdol=$readForjarAdol->read();
		$readForjarAdol->close();
		return $resForjarAdol;
	}
	/**
	 *	Modifica el estado del adolescente respecto al servicios, es decir si está activo o egresado.
	 *	Si la modificación del estado se da a 1 entonces actualiza las actuaciones que estan actuales a false.
	 *	@param int ,$this->id_estado_adol.
	 *	@param string $this->num_doc.
	 *	@return resultado de la transacción
	 */		
	public function cambiaEstadoAdol(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCambiaEstadoAdol="update forjar_adol set id_estado_adol=:id_estado_adol where num_doc=:num_doc";
			$cambiaEstadoAdol=$conect->createCommand($sqlCambiaEstadoAdol);
			$cambiaEstadoAdol->bindParam(":id_estado_adol",$this->id_estado_adol,PDO::PARAM_INT);
			$cambiaEstadoAdol->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$cambiaEstadoAdol->execute();
			if($this->id_estado_adol==1){
				$sqlConsEstadoPai="select culminacion_pai from pai where num_doc=:num_doc and pai_actual is true and culminacion_pai is true";
				$consEstadoPai=$conect->createCommand($sqlConsEstadoPai);
				$consEstadoPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
				$readEstadoPai=$consEstadoPai->query();
				$resEstadoPai=$readEstadoPai->read();
				$readEstadoPai->close();
				if(!empty($resEstadoPai)){
					//cambia estado de plan post egreso en el caso que tenga uno activado anteriormente.
					$sqlActualizaEstadoPlaPE="update plan_postegreso set plan_peactual='false' where num_doc=:num_doc and plan_peactual='true'";
					$actualizaEstadoPlaPE=$conect->createCommand($sqlActualizaEstadoPlaPE);
					$actualizaEstadoPlaPE->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$actualizaEstadoPlaPE->execute();				
					//Cambia la vigencia del pai a false, es decir el pai culminado ya no es actual, si se crea otro pai será completamente nuevo.
					$sqlActualizaVigenciaPai="update pai set pai_actual='false' where num_doc=:num_doc and pai_actual='true'";
					$actualizaVigenciaPai=$conect->createCommand($sqlActualizaVigenciaPai);
					$actualizaVigenciaPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$actualizaVigenciaPai->execute();
					//cambia vigencia de valoración en psicología.
					$sqlActualizaVigenciaPsicol="update valoracion_psicologia set val_act_psicol='false' where num_doc=:num_doc and val_act_psicol='true'";
					$actualizaVigenciaPsicol=$conect->createCommand($sqlActualizaVigenciaPsicol);
					$actualizaVigenciaPsicol->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$actualizaVigenciaPsicol->execute();
					//cambia vigencia de valoración en trabajo social.
					$sqlActualizaVigenciaTrSoc="update valoracion_trabajo_social set val_act_trsoc='false' where num_doc=:num_doc and val_act_trsoc='true'";
					$actualizaVigenciaTrSoc=$conect->createCommand($sqlActualizaVigenciaTrSoc);
					$actualizaVigenciaTrSoc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$actualizaVigenciaTrSoc->execute();
					//cambia vigencia de valoración en terapia ocupacional.
					$sqlActualizaVigenciaTO="update valoracion_teo set val_act_to='false' where num_doc=:num_doc and val_act_to='true'";
					$actualizaVigenciaTO=$conect->createCommand($sqlActualizaVigenciaTO);
					$actualizaVigenciaTO->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$actualizaVigenciaTO->execute();
					//cambia vigencia de valoración de enfermería.
					$sqlActualizaVigenciaEnf="update valoracion_enfermeria set val_act_enf='false' where num_doc=:num_doc and val_act_enf='true'";
					$actualizaVigenciaEnf=$conect->createCommand($sqlActualizaVigenciaEnf);
					$actualizaVigenciaEnf->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$actualizaVigenciaEnf->execute();
					//cambia vigencia de valoración en psiquiatría.
					$sqlActualizaVigenciaPsiq="update valoracion_psiquiatria set val_act_psiq='false' where num_doc=:num_doc and val_act_psiq='true'";
					$actualizaVigenciaPsiq=$conect->createCommand($sqlActualizaVigenciaPsiq);
					$actualizaVigenciaPsiq->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$actualizaVigenciaPsiq->execute();
					//cambia vigencia de valoración en psiquiatría.
					$sqlActualizaVigenciaNutr="update valoracion_nutricional set val_act_nutr='false' where num_doc=:num_doc and val_act_nutr='true'";
					$actualizaVigenciaPsiq=$conect->createCommand($sqlActualizaVigenciaNutr);
					$actualizaVigenciaPsiq->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$actualizaVigenciaPsiq->execute();

				}
			}
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e->getMessage();
		}
	}
	/**
	 *	Modifica los datos del adolescente respeco a ingreso y fechas de vinculación.
	 *	Si la modificación del estado se da a 1 entonces actualiza las actuaciones que estan actuales a false.
	 *	@param string $this->num_doc. 
	 *	@param string $this->fecha_primer_ingreso. 
	 *	@param string $this->fecha_vinc_forjar. 
	 *	@param int $this->num_ingresos.
	 *	@return resultado de la transacción
	 */		
	public function actualizaDatosForjarAdol(){
		if(empty($this->fecha_primer_ingreso)){$this->fecha_primer_ingreso=null;}
		if(empty($this->fecha_vinc_forjar)){$this->fecha_vinc_forjar=null;}
		if(empty($this->num_ingresos)){$this->num_ingresos=null;}
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlActualiza="update forjar_adol set fecha_primer_ingreso=:fecha_primer_ingreso,fecha_vinc_forjar=:fecha_vinc_forjar,num_ingresos=:num_ingresos where num_doc=:num_doc";
			$actializa=$conect->createCommand($sqlActualiza);
			$actializa->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$actializa->bindParam(":fecha_primer_ingreso",$this->fecha_primer_ingreso);
			$actializa->bindParam(":fecha_vinc_forjar",$this->fecha_vinc_forjar);
			$actializa->bindParam(":num_ingresos",$this->num_ingresos);
			$actializa->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e->getMessage();
		}
		
	}
}
