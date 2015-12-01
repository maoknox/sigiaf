<?php

/**
 * This is the model class for table "valoracion_psiquiatria".
 *
 * The followings are the available columns in table 'valoracion_psiquiatria':
 * @property integer $id_val_psiquiatria
 * @property integer $id_estado_val
 * @property string $num_doc
 * @property string $desc_val_psic
 * @property string $hist_psiq_ant
 * @property string $examen_mental
 * @property string $analisis_psiq
 * @property string $diagnostico_psiq
 * @property string $recomend_psic
 * @property string $fecha_ini_vpsiq
 * @property boolean $estado_vpsiq
 * @property string $fecha_modifvalpsiq
 * @property boolean $val_hab_psq
 * @property string $observ_estvalpsiq
 * @property boolean $val_act_psiq
 *
 * The followings are the available model relations:
 * @property MoficiacionValpsiq[] $moficiacionValpsiqs
 * @property EstadoValoracion $idEstadoVal
 * @property Adolescente $numDoc
 */
class ValoracionPsiquiatria extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $nombreCampoValoracion;
	public $contenidoValoracion;
	public $nombreCampoValoracioni;
	public $contenidoValoracioni;
	public $campoFecha;
	public $fecha;
	public $contHist;
	public function tableName()
	{
		return 'valoracion_psiquiatria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc','required'),
			array('id_estado_val', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('contHist,desc_val_psic, hist_psiq_ant, examen_mental, analisis_psiq, diagnostico_psiq, recomend_psic, fecha_ini_vpsiq, estado_vpsiq, fecha_modifvalpsiq, val_hab_psq, observ_estvalpsiq, val_act_psiq', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('contHist,id_val_psiquiatria, id_estado_val, num_doc, desc_val_psic, hist_psiq_ant, examen_mental, analisis_psiq, diagnostico_psiq, recomend_psic, fecha_ini_vpsiq, estado_vpsiq, fecha_modifvalpsiq, val_hab_psq, observ_estvalpsiq, val_act_psiq', 'safe', 'on'=>'search'),
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
			'moficiacionValpsiqs' => array(self::HAS_MANY, 'MoficiacionValpsiq', 'id_val_psiquiatria'),
			'idEstadoVal' => array(self::BELONGS_TO, 'EstadoValoracion', 'id_estado_val'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_val_psiquiatria' => 'Valoración psiquiatría',
			'id_estado_val' => 'Estado de la valoración',
			'num_doc' => 'Número de documento del adolescente',
			'desc_val_psic' => 'Desc Val Psic',
			'hist_psiq_ant' => 'Historia Psiquiátrica/Antecedentes',
			'examen_mental' => 'Examen mental',
			'analisis_psiq' => 'Análisis',
			'diagnostico_psiq' => 'Diagnóstico',
			'recomend_psic' => 'Recomendaciones',
			'fecha_ini_vpsiq' => 'Fecha de inicio de la valoración',
			'estado_vpsiq' => 'Estado de la valoración',
			'fecha_modifvalpsiq' => 'Fecha de modificación de la valoración',
			'val_hab_psq' => 'Valoración habilitada?',
			'observ_estvalpsiq' => 'Observaciones del estado de la valoración',
			'val_act_psiq' => 'Valoración actual?',
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

		$criteria->compare('id_val_psiquiatria',$this->id_val_psiquiatria);
		$criteria->compare('id_estado_val',$this->id_estado_val);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('desc_val_psic',$this->desc_val_psic,true);
		$criteria->compare('hist_psiq_ant',$this->hist_psiq_ant,true);
		$criteria->compare('examen_mental',$this->examen_mental,true);
		$criteria->compare('analisis_psiq',$this->analisis_psiq,true);
		$criteria->compare('diagnostico_psiq',$this->diagnostico_psiq,true);
		$criteria->compare('recomend_psic',$this->recomend_psic,true);
		$criteria->compare('fecha_ini_vpsiq',$this->fecha_ini_vpsiq,true);
		$criteria->compare('estado_vpsiq',$this->estado_vpsiq);
		$criteria->compare('fecha_modifvalpsiq',$this->fecha_modifvalpsiq,true);
		$criteria->compare('val_hab_psq',$this->val_hab_psq);
		$criteria->compare('observ_estvalpsiq',$this->observ_estvalpsiq,true);
		$criteria->compare('val_act_psiq',$this->val_act_psiq);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ValoracionPsiquiatria the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	Consulta valoración actual en psiquiatría del adolescente.
	 *
	 *	@param string $this->num_doc
	 *	@return $consIdValNutr
	 */		
	public function consultaIdValPsiq(){
		$conect=Yii::app()->db;
		$sqlConsIdValPsiq="select * from valoracion_psiquiatria where num_doc=:numDoc and val_act_psiq='true'" ;
		$consIdValPsiq=$conect->createCommand($sqlConsIdValPsiq);
		$consIdValPsiq->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readIdValPsiq=$consIdValPsiq->query();
		$resConsIdValPsiq=$readIdValPsiq->read();
		$readIdValPsiq->close();
		return $resConsIdValPsiq;
	}
	/**
	 *	Registra valoración empty de psiquiatría del adolescente.
	 *
	 *	@param string $this->num_doc
	 *	@return resultado de la transacción 
	 */		
	public function creaRegValPsiq(){
		$conect=Yii::app()->db;
		$sqlCreaValPsiq="insert into valoracion_psiquiatria (id_val_psiquiatria,num_doc,val_act_psiq) values (default,:numDoc,'true') returning id_val_psiquiatria";
		$creaValPsiq=$conect->createCommand($sqlCreaValPsiq);
		$creaValPsiq->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readValPsiq=$creaValPsiq->query();
		$resValPsiq=$readValPsiq->read();
		$readValPsiq->close();
		return $resValPsiq["id_val_psiquiatria"];
	}
	/**
	 *	Modifica la valoración en psiquiatría del adolescente por campo específico
	 *
	 *	@param int $this->id_val_psiquiatria
	 *	@param int Yii::app()->user->getState('cedula')
	 *	@param string $this->contHist
	 *	@param string $this->nombreCampoValoracion
	 *	@param string $fecha
	 *	@return resultado de la transacción 
	 */		
	public function regHistoricoValPsiq(){
		if(!empty($this->nombreCampoValoracioni)){
			$this->nombreCampoValoracion=$this->nombreCampoValoracioni;
		}
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegHist="insert into modificacion_valpsiq (
				id_modvalpsiq,
				id_val_psiquiatria,
				id_cedula,
				modvpsiq,
				campo_vpsiq,
				fecha_mod_valpsiq
			) values (
				default,
				:id_val_psiquiatria,
				:id_cedula,
				:modvpsiq,
				:campo_vpsiq,
				:fecha_mod_valpsiq
			)";//
			$regHist=$conect->createCommand($sqlRegHist);
			$fecha=date("Y-m-d H:i:s");
			$regHist->bindParam(":id_val_psiquiatria",$this->id_val_psiquiatria,PDO::PARAM_INT);
			$regHist->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regHist->bindParam(":modvpsiq",$this->contHist,PDO::PARAM_STR);
			$regHist->bindParam(":campo_vpsiq",$this->nombreCampoValoracion,PDO::PARAM_STR);
			$regHist->bindParam(":fecha_mod_valpsiq",$fecha,PDO::PARAM_STR);
			$regHist->execute();
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			
			
		}
	}
	
	/**
	 *	Modifica la valoración en psiquiatría del adolescente por campo específico
	 *
	 *	@param string $this->nombreCampoValoracion
	 *	@param string $this->campoFecha
	 *	@param string $this->fecha
	 *	@param string $this->contenidoValoracion
	 *	@param int $this->id_val_psiquiatria
	 *	@return resultado de la transacción 
	 */		
	public function modificaValoracionPsiq($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValPsiq="update valoracion_psiquiatria 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".$this->campoFecha."=:fecha 
				where id_val_psiquiatria=:id_val_psiquiatria";
			$modValPsiq=$conect->createCommand($sqlModValPsiq);
			$modValPsiq->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValPsiq->bindParam(':contVal',$this->contenidoValoracion,PDO::PARAM_NULL);
			$modValPsiq->bindParam(':id_val_psiquiatria',$this->id_val_psiquiatria,PDO::PARAM_INT);
			$modValPsiq->execute();
			$this->creaRegProfVal($this->id_val_psiquiatria,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	/**
	 *	Modifica vinculación en psiquiatría por dos campo en específico
	 *
	 *	@param string 	$this->nombreCampoValoracion
	 *	@param string 	$this->nombreCampoValoracioni
	 *	@param string 	$this->campoFecha
	 *	@param string   $this->fecha
	 *	@param   	    $this->contenidoValoracion
	 *	@param   	    $this->contenidoValoracioni
	 *	@param int	    $this->id_val_psiquiatria
	 *	@param string   $this->num_doc
	 *	@return resultado de la transacción 
	 */		
	public function modificaValoracionPsiqOpt($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValPsiq="update valoracion_psiquiatria 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".pg_escape_string($this->nombreCampoValoracioni)."=:contVali,
				".pg_escape_string($this->campoFecha)."=:fecha 
				where id_val_psiquiatria=:id_val_psiquiatria and num_doc=:num_doc";
			$modValPsiq=$conect->createCommand($sqlModValPsiq);
			$modValPsiq->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValPsiq->bindParam(':contVal',$this->contenidoValoracion,PDO::PARAM_NULL);
			$modValPsiq->bindParam(':contVali',$this->contenidoValoracioni,PDO::PARAM_NULL);
			$modValPsiq->bindParam(':id_val_psiquiatria',$this->id_val_psiquiatria,PDO::PARAM_INT);
			$modValPsiq->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
			$modValPsiq->execute();
			$this->creaRegProfVal($this->id_val_psiquiatria,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	/**
	 *	Consulta el estado de modificación de la valoración en psiquiatría
	 *
	 *	@param string Yii::app()->getSession()->get('numDocAdol')
	 *	@return $resHabVal
	 */		
	public function consValHabPsiq(){
		$conect=Yii::app()->db;
		$sqlConsHabVal="select val_hab_psq from valoracion_psiquiatria where num_doc=:num_doc";
		$consHabVal=$conect->createCommand($sqlConsHabVal);
		$consHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$readHabVal=$consHabVal->query();
		$resHabVal=$readHabVal->read();
		$readHabVal->close();
		return $resHabVal;
	}
	/**
	 *	Modifica a false el estado de modificación de la valoración en psiquiatría
	 *
	 *	@param string Yii::app()->getSession()->get('numDocAdol')
	 *	@return resultado de la transacción 
	 */		
	public function modValHabFalsePsiq(){
		$conect=Yii::app()->db;
		$sqlActHabVal="update valoracion_psiquiatria set val_hab_psq='false' where num_doc=:num_doc";
		$actHabVal=$conect->createCommand($sqlActHabVal);
		$actHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$actHabVal->execute();		
	}
	/**
	 *	Registra cédula del prfesional que realiza o modifica la  valoración de psiquiatría
	 *
	 *	@param int 	   Yii::app()->user->getState('cedula')
	 *	@param int 	   $idValoracion
	 *	@param int 	   $accion
	 *	@param string  $fechaRegistro
	 *	@return resultado de la transacción 
	 */		
	public function creaRegProfVal($idValoracion,$accion){
		$conect=Yii::app()->db;
		$fechaRegistro=date("Y-m-d");
		$sqlConsFechaMod="select fecha_regprvpsiq from profesional_valpsiq where id_val_psiquiatria=:id_val_psiquiatria and id_accval=:id_accval order by fecha_regprvpsiq desc limit 1";
		$consFechaMod=$conect->createCommand($sqlConsFechaMod);
		$consFechaMod->bindParam(":id_val_psiquiatria",$idValoracion,PDO::PARAM_INT);
		$consFechaMod->bindParam(":id_accval",$accion,PDO::PARAM_INT);
		$readFechaMod=$consFechaMod->query();
		$resFechaMod=$readFechaMod->read();
		$readFechaMod->close();
		$creaRegistro=false;
		
		if(empty($resFechaMod["fecha_regprvpsiq"])){
			$creaRegistro=true;
		}
		elseif($resFechaMod["fecha_regprvpsiq"]!=$fechaRegistro){
			$creaRegistro=true;
		}
		if($creaRegistro==true){
			$sqlCreaRegProfVal="insert into profesional_valpsiq (
				id_cedula,
				id_val_psiquiatria,
				id_accval,
				fecha_regprvpsiq
			) values (
				:id_cedula,
				:id_val_psiquiatria,
				:id_accval,
				:fecha_regprvpsiq
			)";	
			$creaRegProfVal=$conect->createCommand($sqlCreaRegProfVal);	
			$creaRegProfVal->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_val_psiquiatria",$idValoracion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_accval",$accion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":fecha_regprvpsiq",$fechaRegistro,PDO::PARAM_STR);
			$creaRegProfVal->execute();
		}
	}
	/**
	 *	Consulta la valoración en psuiquiatría del adolescente
	 *
	 *	@param int $this->id_val_psiquiatria
	 *	@return $resValPsiq
	 */		
	public function consultaValPsiq(){
		$conect=Yii::app()->db;
		$sqlConsValPsiq="select * from valoracion_psiquiatria where id_val_psiquiatria=:id_val_psiquiatria";
		$consValPsiq=$conect->createCommand($sqlConsValPsiq);
		$consValPsiq->bindParam(":id_val_psiquiatria",$this->id_val_psiquiatria);
		$readValPsiq=$consValPsiq->query();
		$resValPsiq=$readValPsiq->read();
		$readValPsiq->close();
		return $resValPsiq;
	}	
}
