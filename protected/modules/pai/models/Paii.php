<?php

/**
 * This is the model class for table "pai".
 *
 * The followings are the available columns in table 'pai':
 * @property integer $id_pai
 * @property string $num_doc
 * @property integer $id_pai_origen
 * @property string $observaciones_pai
 * @property string $fecha_creacion_pai
 * @property string $fecha_modif_pai
 * @property string $recomend_posegreso
 * @property boolean $culminacion_pai
 * @property string $recom_pai_egreso
 * @property boolean $pai_actual
 * @property boolean $hab_modpai
 * @property boolean $actualizacion_pai
 * @property boolean $pai_habilitado
 *
 * The followings are the available model relations:
 * @property EquipopsicosocPai[] $equipopsicosocPais
 * @property EquipopsicosocPai[] $equipopsicosocPais1
 * @property Adolescente $numDoc
 * @property ComponenteDerecho[] $componenteDerechoes
 * @property ComponenteDerecho[] $componenteDerechoes1
 * @property ComponenteSancion[] $componenteSancions
 * @property ComponenteSancion[] $componenteSancions1
 */
class Pai extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pai';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pai, num_doc', 'required'),
			array('id_pai, id_pai_origen', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('observaciones_pai, fecha_creacion_pai, fecha_modif_pai, recomend_posegreso, culminacion_pai, recom_pai_egreso, pai_actual, hab_modpai, actualizacion_pai, pai_habilitado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pai, num_doc, id_pai_origen, observaciones_pai, fecha_creacion_pai, fecha_modif_pai, recomend_posegreso, culminacion_pai, recom_pai_egreso, pai_actual, hab_modpai, actualizacion_pai, pai_habilitado', 'safe', 'on'=>'search'),
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
			'equipopsicosocPais' => array(self::HAS_MANY, 'EquipopsicosocPai', 'id_pai'),
			'equipopsicosocPais1' => array(self::HAS_MANY, 'EquipopsicosocPai', 'num_doc'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'componenteDerechoes' => array(self::HAS_MANY, 'ComponenteDerecho', 'id_pai'),
			'componenteDerechoes1' => array(self::HAS_MANY, 'ComponenteDerecho', 'num_doc'),
			'componenteSancions' => array(self::HAS_MANY, 'ComponenteSancion', 'id_pai'),
			'componenteSancions1' => array(self::HAS_MANY, 'ComponenteSancion', 'num_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_pai' => 'Id Pai',
			'num_doc' => 'Num Doc',
			'id_pai_origen' => 'Id Pai Origen',
			'observaciones_pai' => 'Observaciones Pai',
			'fecha_creacion_pai' => 'Fecha Creacion Pai',
			'fecha_modif_pai' => 'Fecha Modif Pai',
			'recomend_posegreso' => 'Recomend Posegreso',
			'culminacion_pai' => 'Culminacion Pai',
			'recom_pai_egreso' => 'Recom Pai Egreso',
			'pai_actual' => 'Pai Actual',
			'hab_modpai' => 'Hab Modpai',
			'actualizacion_pai' => 'Actualizacion Pai',
			'pai_habilitado' => 'Pai Habilitado',
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

		$criteria->compare('id_pai',$this->id_pai);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_pai_origen',$this->id_pai_origen);
		$criteria->compare('observaciones_pai',$this->observaciones_pai,true);
		$criteria->compare('fecha_creacion_pai',$this->fecha_creacion_pai,true);
		$criteria->compare('fecha_modif_pai',$this->fecha_modif_pai,true);
		$criteria->compare('recomend_posegreso',$this->recomend_posegreso,true);
		$criteria->compare('culminacion_pai',$this->culminacion_pai);
		$criteria->compare('recom_pai_egreso',$this->recom_pai_egreso,true);
		$criteria->compare('pai_actual',$this->pai_actual);
		$criteria->compare('hab_modpai',$this->hab_modpai);
		$criteria->compare('actualizacion_pai',$this->actualizacion_pai);
		$criteria->compare('pai_habilitado',$this->pai_habilitado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pai the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaPAIActual(){
		$conect= Yii::app()->db;
		$sqlConsPai="select * from pai where num_doc=:num_doc and pai_actual='true'";
		$consPai=$conect->createCommand($sqlConsPai);
		$consPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readConsPai=$consPai->query();
		$resConsPai=$readConsPai->read();
		$readConsPai->close();
		$this->id_pai=$resConsPai["id_pai"];
		return $resConsPai;
	}
	public function consultaPAI(){
		$conect= Yii::app()->db;
		$sqlConsPai="select * from pai where num_doc=:num_doc order by id_pai desc limit 1";
		$consPai=$conect->createCommand($sqlConsPai);
		$consPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readConsPai=$consPai->query();
		$resConsPai=$readConsPai->read();
		$readConsPai->close();
		$this->id_pai=$resConsPai["id_pai"];
		return $resConsPai;
	}
	public function creaPAI(){
		$conect=Yii::app()->db;
		$sqlConsPai="insert into pai (
			id_pai,
			num_doc,
			pai_actual,
			fecha_creacion_pai
		) values (
			:id_pai,
			:num_doc,
			:pai_actual,
			:fecha_creacion_pai
		) returning id_pai";
		$paiActual='true';
		$this->fecha_creacion_pai=date("Y-m-d");
		$creaPai=$conect->createCommand($sqlConsPai);
		$creaPai->bindParam(":id_pai",$this->id_pai,PDO::PARAM_STR);
		$creaPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$creaPai->bindParam(":pai_actual",$paiActual,PDO::PARAM_BOOL);
		$creaPai->bindParam(":fecha_creacion_pai",$this->fecha_creacion_pai,PDO::PARAM_STR);
		$readCreaPai=$creaPai->query();
		$resCreaPai=$readCreaPai->read();
		$readCreaPai->close();
		$this->id_pai=$resCreaPai["id_pai"];
	}
	public function regCulmPai(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegCulmPai="update pai set culminacion_pai=:culminacion_pai,recomend_posegreso=:recomend_posegreso where num_doc=:num_doc and id_pai=:id_pai";
			$regCulmPai=$conect->createCommand($sqlRegCulmPai);
			$regCulmPai->bindParam(":culminacion_pai",$this->culminacion_pai,PDO::PARAM_BOOL);
			$regCulmPai->bindParam(":recomend_posegreso",$this->recomend_posegreso,PDO::PARAM_STR);
			$regCulmPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regCulmPai->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$regCulmPai->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;	
		}
	}
	public function actualizaEstadoPai(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlActEstPai="update pai set pai_habilitado=:estado where id_pai=:id_pai and num_doc=:num_doc";
			$actEstPai=$conect->createCommand($sqlActEstPai);
			$actEstPai->bindParam(":estado",$this->pai_habilitado,PDO::PARAM_BOOL);
			$actEstPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$actEstPai->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$actEstPai->execute();
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();			
		}		
	}
	public function estadoPaiActual(){
		$conect= Yii::app()->db;
		$sqlActPaiActual="update pai set pai_actual='false' where num_doc=:num_doc";
		$actPaiActual=$conect->createCommand($sqlActPaiActual);
		$actPaiActual->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$actPaiActual->execute();
	}
}
