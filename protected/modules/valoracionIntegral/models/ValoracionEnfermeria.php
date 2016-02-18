<?php

/**
 * This is the model class for table "valoracion_enfermeria".
 *
 * The followings are the available columns in table 'valoracion_enfermeria':
 * @property integer $id_valor_enf
 * @property string $num_doc
 * @property integer $id_estado_val
 * @property double $peso_adol
 * @property double $talla_adol
 * @property string $antecedentes_clinic
 * @property string $examen_fisico_fisiol
 * @property string $recom_aten_salud
 * @property string $fecha_ini_venf
 * @property boolean $estado_venf
 * @property string $obs_gen_enferm
 * @property string $fecha_modifvalenf
 * @property boolean $val_hab_enf
 * @property string $observ_estvalenf
 * @property boolean $val_act_enf
 *
 * The followings are the available model relations:
 * @property ModificacionEnfermeria[] $modificacionEnfermerias
 * @property EstadoValoracion $idEstadoVal
 * @property Adolescente $numDoc
 */
class ValoracionEnfermeria extends CActiveRecord
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
		return 'valoracion_enfermeria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc', 'required'),
			array('id_estado_val', 'numerical', 'integerOnly'=>true),
			array('peso_adol, talla_adol', 'numerical'),
			array('contHist,num_doc', 'length', 'max'=>15),
			array('contHist,antecedentes_clinic, examen_fisico_fisiol, recom_aten_salud, fecha_ini_venf, estado_venf, obs_gen_enferm, fecha_modifvalenf, val_hab_enf, observ_estvalenf, val_act_enf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_valor_enf, num_doc, id_estado_val, peso_adol, talla_adol, antecedentes_clinic, examen_fisico_fisiol, recom_aten_salud, fecha_ini_venf, estado_venf, obs_gen_enferm, fecha_modifvalenf, val_hab_enf, observ_estvalenf, val_act_enf', 'safe', 'on'=>'search'),
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
			'modificacionEnfermerias' => array(self::HAS_MANY, 'ModificacionEnfermeria', 'id_valor_enf'),
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
			'id_valor_enf' => 'Valoración enfermería',
			'num_doc' => 'Número de documento del adolescente',
			'id_estado_val' => 'Estado de la valoración',
			'peso_adol' => 'Peso del adolescente',
			'talla_adol' => 'Talla del adolescente',
			'antecedentes_clinic' => 'Antecedentes clínicos y familiares',
			'examen_fisico_fisiol' => 'Examen físico',
			'recom_aten_salud' => 'Recomendaciones para atención en salud',
			'fecha_ini_venf' => 'Fecha inicio valoración enfermería',
			'estado_venf' => 'Estado de la valoración',
			'obs_gen_enferm' => 'Observaciones',
			'fecha_modifvalenf' => 'Fecha modificación de la valoración',
			'val_hab_enf' => 'Está activa la valoración?',
			'observ_estvalenf' => 'Observaciones del estado de la valoración',
			'val_act_enf' => 'Valoración actual?',
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

		$criteria->compare('id_valor_enf',$this->id_valor_enf);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_estado_val',$this->id_estado_val);
		$criteria->compare('peso_adol',$this->peso_adol);
		$criteria->compare('talla_adol',$this->talla_adol);
		$criteria->compare('antecedentes_clinic',$this->antecedentes_clinic,true);
		$criteria->compare('examen_fisico_fisiol',$this->examen_fisico_fisiol,true);
		$criteria->compare('recom_aten_salud',$this->recom_aten_salud,true);
		$criteria->compare('fecha_ini_venf',$this->fecha_ini_venf,true);
		$criteria->compare('estado_venf',$this->estado_venf);
		$criteria->compare('obs_gen_enferm',$this->obs_gen_enferm,true);
		$criteria->compare('fecha_modifvalenf',$this->fecha_modifvalenf,true);
		$criteria->compare('val_hab_enf',$this->val_hab_enf);
		$criteria->compare('observ_estvalenf',$this->observ_estvalenf,true);
		$criteria->compare('val_act_enf',$this->val_act_enf);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ValoracionEnfermeria the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	Consulta valoración de enfermería del adolescente actual
	 *
	 *	@param string $this->num_doc
	 *	@return $resConsIdValEnf
	 */		
	public function consultaIdValEnf(){
		$conect=Yii::app()->db;
		$sqlConsIdValEnf="select * from valoracion_enfermeria where num_doc=:numDoc and val_act_enf='true'" ;
		$consIdValEnf=$conect->createCommand($sqlConsIdValEnf);
		$consIdValEnf->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readIdValEnf=$consIdValEnf->query();
		$resConsIdValEnf=$readIdValEnf->read();
		$readIdValEnf->close();
		return $resConsIdValEnf;
	}
	/**
	 *	Crea registro empty de enfermería de acuerdo al adolescente
	 *
	 *	@param string $this->num_doc
	 *	@return resultado de la transacción 
	 */		
	public function creaRegValEnf(){
		$conect=Yii::app()->db;
		$sqlCreaValEnf="insert into valoracion_enfermeria (id_valor_enf,num_doc,val_act_enf) values (default,:numDoc,'true') returning id_valor_enf";
		$creaValEnf=$conect->createCommand($sqlCreaValEnf);
		$creaValEnf->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readValEnf=$creaValEnf->query();
		$resValEnf=$readValEnf->read();
		$readValEnf->close();
		return $resValEnf["id_valor_enf"];
	}
	/**
	 *	Registra histórico de valoración de enfermería 
	 *
	 *	@param int $this->id_valor_enf
	 *	@param int Yii::app()->user->getState('cedula')
	 *	@param string $this->contHist
	 *	@param string $this->nombreCampoValoracion
	 *	@param string $fecha
	 *	@return resultado de la transacción 
	 */		
	public function regHistoricoValEnf(){
		if(!empty($this->nombreCampoValoracioni)){
			$this->nombreCampoValoracion=$this->nombreCampoValoracioni;
		}
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegHist="insert into modificacion_enfermeria (
				id_modvalenf,
				id_cedula,
				id_valor_enf,
				modvenferm,
				nomb_campovenf,
				fecha_mod_valenf
  			) values (
				default,
				:id_cedula,
				:id_valor_enf,
				:modvenferm,
				:nomb_campovenf,
				:fecha_mod_valenf
			)";//
			$regHist=$conect->createCommand($sqlRegHist);
			$fecha=date("Y-m-d H:i:s");
			$regHist->bindParam(":id_valor_enf",$this->id_valor_enf,PDO::PARAM_INT);
			$regHist->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regHist->bindParam(":modvenferm",$this->contHist,PDO::PARAM_STR);
			$regHist->bindParam(":nomb_campovenf",$this->nombreCampoValoracion,PDO::PARAM_STR);
			$regHist->bindParam(":fecha_mod_valenf",$fecha,PDO::PARAM_STR);
			$regHist->execute();
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			
			
		}
	}

	/**
	 *	Modifica valoración de enfermería por campo específico
	 *
	 *	@param string $this->nombreCampoValoracion
	 *	@param string $this->fecha
	 *	@param string $this->contenidoValoracion
	 *	@param int	  $this->id_valor_enf
	 *	@return resultado de la transacción 
	 */		
	public function modificaValoracionEnf($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValEnf="update valoracion_enfermeria 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".$this->campoFecha."=:fecha 
				where id_valor_enf=:id_valor_enf";
			$modValEnf=$conect->createCommand($sqlModValEnf);
			$modValEnf->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValEnf->bindParam(':contVal',$this->contenidoValoracion);
			$modValEnf->bindParam(':id_valor_enf',$this->id_valor_enf,PDO::PARAM_INT);
			$modValEnf->execute();
			$transaction->commit();
			$this->creaRegProfVal($this->id_valor_enf,$accion);
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	/**
	 *	Modifica valoración de enfermería por campo específico
	 *
	 *	@param string $this->nombreCampoValoracion
	 *	@param string $this->nombreCampoValoracioni
	 *	@param string $this->campoFecha
	 *	@param string $this->contenidoValoracion
	 *	@param string $this->contenidoValoracioni
	 *	@param int	  $this->id_valor_enf
	 *	@param string	  $this->num_doc
	 *	@return resultado de la transacción 
	 */		
	public function modificaValoracionEnfOpt($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValEnf="update valoracion_enfermeria 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".pg_escape_string($this->nombreCampoValoracioni)."=:contVali,
				".pg_escape_string($this->campoFecha)."=:fecha 
				where id_valor_enf=:id_valor_enf and num_doc=:num_doc";
			$modValEnf=$conect->createCommand($sqlModValEnf);
			$modValEnf->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValEnf->bindParam(':contVal',$this->contenidoValoracion);
			$modValEnf->bindParam(':contVali',$this->contenidoValoracioni);
			$modValEnf->bindParam(':id_valor_enf',$this->id_valor_enf,PDO::PARAM_INT);
			$modValEnf->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
			$modValEnf->execute();
			$this->creaRegProfVal($this->id_valor_enf,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	/**
	 *	Consulta estado de activación de la valoración del adolescente
	 *
	 *	@param string Yii::app()->getSession()->get('numDocAdol')
	 *	@return $resHabVal
	 */		
	public function consValHabEnf(){
		$conect=Yii::app()->db;
		$sqlConsHabVal="select val_hab_enf from valoracion_enfermeria where num_doc=:num_doc";
		$consHabVal=$conect->createCommand($sqlConsHabVal);
		$consHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$readHabVal=$consHabVal->query();
		$resHabVal=$readHabVal->read();
		$readHabVal->close();
		return $resHabVal;
	}
	/**
	 *	Modifica a false estado de activación de la valoración del adolescente
	 *
	 *	@param string Yii::app()->getSession()->get('numDocAdol')
	 *	@return $resHabVal
	 */		
	public function modValHabFalseEnf(){
		$conect=Yii::app()->db;
		$sqlActHabVal="update valoracion_enfermeria set val_hab_enf='false' where num_doc=:num_doc";
		$actHabVal=$conect->createCommand($sqlActHabVal);
		$actHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$actHabVal->execute();		
	}
	/**
	 *	Registra cédula del prfesional que realiza o modifica la  valoración de enfermería
	 *
	 *	@param int 	   Yii::app()->user->getState('cedula')
	 *	@param int 	   $this->id_valor_enf
	 *	@param int 	   $this->id_accval
	 *	@param string  $this->fecha_regprvenf
	 *	@return resultado de la transacción 
	 */		
	public function creaRegProfVal($idValoracion,$accion){
		$conect=Yii::app()->db;
		$fechaRegistro=date("Y-m-d");
		$sqlConsFechaMod="select fecha_regprvenf from profesional_valenf where id_valor_enf=:id_valor_enf and id_accval=:id_accval order by fecha_regprvenf desc limit 1";
		$consFechaMod=$conect->createCommand($sqlConsFechaMod);
		$consFechaMod->bindParam(":id_valor_enf",$idValoracion,PDO::PARAM_INT);
		$consFechaMod->bindParam(":id_accval",$accion,PDO::PARAM_INT);
		$readFechaMod=$consFechaMod->query();
		$resFechaMod=$readFechaMod->read();
		$readFechaMod->close();
		$creaRegistro=false;
		
		if(empty($resFechaMod["fecha_regprvenf"])){
			$creaRegistro=true;
		}
		elseif($resFechaMod["fecha_regprvenf"]!=$fechaRegistro){
			$creaRegistro=true;
		}
		if($creaRegistro==true){
			$sqlCreaRegProfVal="insert into profesional_valenf (
				id_cedula,
				id_valor_enf,
				id_accval,
				fecha_regprvenf
			) values (
				:id_cedula,
				:id_valor_enf,
				:id_accval,
				:fecha_regprvenf
			)";	
			$creaRegProfVal=$conect->createCommand($sqlCreaRegProfVal);	
			$creaRegProfVal->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_valor_enf",$idValoracion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_accval",$accion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":fecha_regprvenf",$fechaRegistro,PDO::PARAM_STR);
			$creaRegProfVal->execute();
		}
	}
	/**
	 *	Consulta valoración del adolescente en enfermería
	 *
	 *	@param int $this->id_valor_enf
	 *	@return $resValEnf
	 */		
	public function consultaValEnf(){
		$conect=Yii::app()->db;
		$sqlConsValEnf="select * from valoracion_enfermeria where id_valor_enf=:id_valor_enf";
		$consValEnf=$conect->createCommand($sqlConsValEnf);
		$consValEnf->bindParam(":id_valor_enf",$this->id_valor_enf);
		$readValEnf=$consValEnf->query();
		$resValEnf=$readValEnf->read();
		$readValEnf->close();
		return $resValEnf;
	}	
}
