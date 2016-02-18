<?php

/**
 * This is the model class for table "valoracion_teo".
 *
 * The followings are the available columns in table 'valoracion_teo':
 * @property integer $id_valor_teo
 * @property integer $id_estado_val
 * @property string $num_doc
 * @property string $desemp_area_ocup
 * @property string $desemp_laboral
 * @property string $patron_desemp
 * @property string $interes_expect_ocup
 * @property string $aptit_habilid_destrezas
 * @property string $criterios_area_int
 * @property string $ubicacion_area_intere
 * @property string $fecha_inicio_valteo
 * @property boolean $estado_val_teo
 * @property string $recomend_perfoc
 * @property string $concepto_teo
 * @property string $plan_interv_teo
 * @property string $fecha_modifvalteo
 * @property boolean $val_hab_to
 * @property string $observ_estvalto
 * @property boolean $val_act_to
 *
 * The followings are the available model relations:
 * @property AspectoValteo[] $aspectoValteos
 * @property ModificacionValteo[] $modificacionValteos
 * @property EstadoValoracion $idEstadoVal
 * @property Adolescente $numDoc
 */
class ValoracionTeo extends CActiveRecord
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
		return 'valoracion_teo';
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
			array('num_doc', 'length', 'max'=>15),
			array('contHist,desemp_area_ocup, desemp_laboral, patron_desemp, interes_expect_ocup, aptit_habilid_destrezas, criterios_area_int, ubicacion_area_intere, fecha_inicio_valteo, estado_val_teo, recomend_perfoc, concepto_teo, plan_interv_teo, fecha_modifvalteo, val_hab_to, observ_estvalto, val_act_to', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('contHist,id_valor_teo, id_estado_val, num_doc, desemp_area_ocup, desemp_laboral, patron_desemp, interes_expect_ocup, aptit_habilid_destrezas, criterios_area_int, ubicacion_area_intere, fecha_inicio_valteo, estado_val_teo, recomend_perfoc, concepto_teo, plan_interv_teo, fecha_modifvalteo, val_hab_to, observ_estvalto, val_act_to', 'safe', 'on'=>'search'),
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
			'aspectoValteos' => array(self::HAS_MANY, 'AspectoValteo', 'id_valor_teo'),
			'modificacionValteos' => array(self::HAS_MANY, 'ModificacionValteo', 'id_valor_teo'),
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
			'id_valor_teo' => 'Id Valor Teo',
			'id_estado_val' => 'Id Estado Val',
			'num_doc' => 'Num Doc',
			'desemp_area_ocup' => 'Desempeño en áreas ocupacionales',
			'desemp_laboral' => 'Desempeño Laboral',
			'patron_desemp' => 'Patrones de desempeño (Hábitos y roles ocupacionales)',
			'interes_expect_ocup' => 'Intereses y expectativas ocupacionales (actividades significativas)',
			'aptit_habilid_destrezas' => 'Aptitudes, habilidades y destrezas',
			'criterios_area_int' => 'Criterios para la ubicación en áreas de interés',
			'ubicacion_area_intere' => 'Ubicacion Area Intere',
			'fecha_inicio_valteo' => 'Fecha Inicio Valteo',
			'estado_val_teo' => 'Estado Val Teo',
			'recomend_perfoc' => 'Recomend Perfoc',
			'concepto_teo' => 'Concepto ocupacional',
			'plan_interv_teo' => 'Proyección y plan de intervención',
			'fecha_modifvalteo' => 'Fecha Modifvalteo',
			'val_hab_to' => 'Val Hab To',
			'observ_estvalto' => 'Observ Estvalto',
			'val_act_to' => 'Val Act To',
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

		$criteria->compare('id_valor_teo',$this->id_valor_teo);
		$criteria->compare('id_estado_val',$this->id_estado_val);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('desemp_area_ocup',$this->desemp_area_ocup,true);
		$criteria->compare('desemp_laboral',$this->desemp_laboral,true);
		$criteria->compare('patron_desemp',$this->patron_desemp,true);
		$criteria->compare('interes_expect_ocup',$this->interes_expect_ocup,true);
		$criteria->compare('aptit_habilid_destrezas',$this->aptit_habilid_destrezas,true);
		$criteria->compare('criterios_area_int',$this->criterios_area_int,true);
		$criteria->compare('ubicacion_area_intere',$this->ubicacion_area_intere,true);
		$criteria->compare('fecha_inicio_valteo',$this->fecha_inicio_valteo,true);
		$criteria->compare('estado_val_teo',$this->estado_val_teo);
		$criteria->compare('recomend_perfoc',$this->recomend_perfoc,true);
		$criteria->compare('concepto_teo',$this->concepto_teo,true);
		$criteria->compare('plan_interv_teo',$this->plan_interv_teo,true);
		$criteria->compare('fecha_modifvalteo',$this->fecha_modifvalteo,true);
		$criteria->compare('val_hab_to',$this->val_hab_to);
		$criteria->compare('observ_estvalto',$this->observ_estvalto,true);
		$criteria->compare('val_act_to',$this->val_act_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ValoracionTeo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaIdValTO(){
		$conect=Yii::app()->db;
		$sqlConsIdValTO="select * from valoracion_teo where num_doc=:numDoc and val_act_to='true'" ;
		$consIdValTO=$conect->createCommand($sqlConsIdValTO);
		$consIdValTO->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readIdValTO=$consIdValTO->query();
		$resConsIdValTO=$readIdValTO->read();
		$readIdValTO->close();
		return $resConsIdValTO;
	}
	public function creaRegValTO(){
		$conect=Yii::app()->db;
		$sqlCreaValTO="insert into valoracion_teo (id_valor_teo,num_doc,val_act_to) values (default,:numDoc,'true') returning id_valor_teo";
		$creaValTO=$conect->createCommand($sqlCreaValTO);
		$creaValTO->bindParam(":numDoc",$this->num_doc,PDO::PARAM_STR);
		$readValTO=$creaValTO->query();
		$resValTO=$readValTO->read();
		$readValTO->close();
		return $resValTO["id_valor_teo"];
	}
	
	public function regHistoricoValTO(){
		if(!empty($this->nombreCampoValoracioni)){
			$this->nombreCampoValoracion=$this->nombreCampoValoracioni;
		}
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegHist="insert into modificacion_valteo (
				id_modvalto,
				id_valor_teo,
				id_cedula,
				modvalteo,
				nomb_campovalteo,
				fecha_mod_valto
  			) values (
				default,
				:id_valor_teo,
				:id_cedula,
				:modvalteo,
				:nomb_campovalteo,
				:fecha_mod_valto
			)";//
			$regHist=$conect->createCommand($sqlRegHist);
			$fecha=date("Y-m-d H:i:s");
			$regHist->bindParam(":id_valor_teo",$this->id_valor_teo,PDO::PARAM_INT);
			$regHist->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regHist->bindParam(":modvalteo",$this->contHist,PDO::PARAM_STR);
			$regHist->bindParam(":nomb_campovalteo",$this->nombreCampoValoracion,PDO::PARAM_STR);
			$regHist->bindParam(":fecha_mod_valto",$fecha,PDO::PARAM_STR);
			$regHist->execute();
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			
			
		}
	}
	
	
	public function modificaValoracionTO($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValTO="update valoracion_teo 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".$this->campoFecha."=:fecha 
				where id_valor_teo=:id_valor_teo";
			$modValTO=$conect->createCommand($sqlModValTO);
			$modValTO->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValTO->bindParam(':contVal',$this->contenidoValoracion);
			$modValTO->bindParam(':id_valor_teo',$this->id_valor_teo,PDO::PARAM_INT);
			$modValTO->execute();
			$this->creaRegProfVal($this->id_valor_teo,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaValoracionTOOpt($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModValTO="update valoracion_teo 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".pg_escape_string($this->nombreCampoValoracioni)."=:contVali,
				".pg_escape_string($this->campoFecha)."=:fecha 
				where id_valor_teo=:id_valor_teo and num_doc=:num_doc";
			$modValTo=$conect->createCommand($sqlModValTO);
			$modValTo->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modValTo->bindParam(':contVal',$this->contenidoValoracion);
			$modValTo->bindParam(':contVali',$this->contenidoValoracioni);
			$modValTo->bindParam(':id_valor_teo',$this->id_valor_teo,PDO::PARAM_INT);
			$modValTo->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
			$modValTo->execute();
			$this->creaRegProfVal($this->id_valor_teo,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function consValHabTO(){
		$conect=Yii::app()->db;
		$sqlConsHabVal="select val_hab_to from valoracion_teo where num_doc=:num_doc";
		$consHabVal=$conect->createCommand($sqlConsHabVal);
		$consHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$readHabVal=$consHabVal->query();
		$resHabVal=$readHabVal->read();
		$readHabVal->close();
		return $resHabVal;
	}
	public function modValHabFalseTO(){
		$conect=Yii::app()->db;
		$sqlActHabVal="update valoracion_teo set val_hab_to='false' where num_doc=:num_doc";
		$actHabVal=$conect->createCommand($sqlActHabVal);
		$actHabVal->bindParam(":num_doc",Yii::app()->getSession()->get('numDocAdol'),PDO::PARAM_STR);
		$actHabVal->execute();		
	}
	public function creaRegProfVal($idValoracion,$accion){
		$conect=Yii::app()->db;
		$fechaRegistro=date("Y-m-d");
		$sqlConsFechaMod="select fecha_regprvto from profesional_to where id_valor_teo=:id_valor_teo and id_accval=:id_accval order by fecha_regprvto desc limit 1";
		$consFechaMod=$conect->createCommand($sqlConsFechaMod);
		$consFechaMod->bindParam(":id_valor_teo",$idValoracion,PDO::PARAM_INT);
		$consFechaMod->bindParam(":id_accval",$accion,PDO::PARAM_INT);
		$readFechaMod=$consFechaMod->query();
		$resFechaMod=$readFechaMod->read();
		$readFechaMod->close();
		$creaRegistro=false;
		
		if(empty($resFechaMod["fecha_regprvto"])){
			$creaRegistro=true;
		}
		elseif($resFechaMod["fecha_regprvto"]!=$fechaRegistro){
			$creaRegistro=true;
		}
		if($creaRegistro==true){
			$sqlCreaRegProfVal="insert into profesional_to (
				id_cedula,
				id_valor_teo,
				id_accval,
				fecha_regprvto
			) values (
				:id_cedula,
				:id_valor_teo,
				:id_accval,
				:fecha_regprvto
			)";	
			$creaRegProfVal=$conect->createCommand($sqlCreaRegProfVal);	
			$creaRegProfVal->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_valor_teo",$idValoracion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_accval",$accion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":fecha_regprvto",$fechaRegistro,PDO::PARAM_STR);
			$creaRegProfVal->execute();
		}
	}
	public function consultaValTO(){
		$conect=Yii::app()->db;
		$sqlConsValTO="select * from valoracion_teo where id_valor_teo=:id_valor_teo";
		$consValTO=$conect->createCommand($sqlConsValTO);
		$consValTO->bindParam(":id_valor_teo",$this->id_valor_teo);
		$readValTO=$consValTO->query();
		$resValTO=$readValTO->read();
		$readValTO->close();
		return $resValTO;
	}

}