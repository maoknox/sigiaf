<?php

/**
 * This is the model class for table "componente_derecho".
 *
 * The followings are the available columns in table 'componente_derecho':
 * @property string $fecha_estab_compderecho
 * @property integer $id_derechocespa
 * @property integer $id_pai
 * @property string $num_doc
 * @property string $derecho_compderecho
 * @property string $objetivo_compderecho
 * @property string $actividades_compderecho
 * @property string $indicadores_compderecho
 * @property string $responsable_compderecho
 * @property string $observ_compderecho
 *
 * The followings are the available model relations:
 * @property Derechocespa $idDerechocespa
 * @property Pai $idPai
 * @property Pai $numDoc
 * @property SeguimientoCompderecho[] $seguimientoCompderechoes
 */
class ComponenteDerecho extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'componente_derecho';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pai,id_derechocespa', 'required'),
			array('id_derechocespa, id_pai', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('derecho_compderecho, objetivo_compderecho, actividades_compderecho, indicadores_compderecho, responsable_compderecho, observ_compderecho', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fecha_estab_compderecho, id_derechocespa, id_pai, num_doc, derecho_compderecho, objetivo_compderecho, actividades_compderecho, indicadores_compderecho, responsable_compderecho, observ_compderecho', 'safe', 'on'=>'search'),
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
			'idDerechocespa' => array(self::BELONGS_TO, 'Derechocespa', 'id_derechocespa'),
			'idPai' => array(self::BELONGS_TO, 'Pai', 'id_pai'),
			'numDoc' => array(self::BELONGS_TO, 'Pai', 'num_doc'),
			'seguimientoCompderechoes' => array(self::HAS_MANY, 'SeguimientoCompderecho', 'fecha_estab_compderecho'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fecha_estab_compderecho' => 'Fecha establecimiento',
			'id_derechocespa' => 'Id Derechocespa',
			'id_pai' => 'Id Pai',
			'num_doc' => 'Num Doc',
			'derecho_compderecho' => 'Derecho Compderecho',
			'objetivo_compderecho' => 'Objetivo Compderecho',
			'actividades_compderecho' => 'Actividades Compderecho',
			'indicadores_compderecho' => 'Indicadores Compderecho',
			'responsable_compderecho' => 'Responsable Compderecho',
			'observ_compderecho' => 'Observ Compderecho',
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

		$criteria->compare('fecha_estab_compderecho',$this->fecha_estab_compderecho,true);
		$criteria->compare('id_derechocespa',$this->id_derechocespa);
		$criteria->compare('id_pai',$this->id_pai);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('derecho_compderecho',$this->derecho_compderecho,true);
		$criteria->compare('objetivo_compderecho',$this->objetivo_compderecho,true);
		$criteria->compare('actividades_compderecho',$this->actividades_compderecho,true);
		$criteria->compare('indicadores_compderecho',$this->indicadores_compderecho,true);
		$criteria->compare('responsable_compderecho',$this->responsable_compderecho,true);
		$criteria->compare('observ_compderecho',$this->observ_compderecho,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ComponenteDerecho the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaPaiDerechoAdol(){
		$conect= Yii::app()->db;
		$sqlConsPaiDerAdol="select * from componente_derecho where id_pai=:id_pai and id_derechocespa=:id_derechocespa order by fecha_estab_compderecho desc";
		$consPaiDerAdol=$conect->createCommand($sqlConsPaiDerAdol);
		$consPaiDerAdol->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
		$consPaiDerAdol->bindParam(":id_derechocespa",$this->id_derechocespa,PDO::PARAM_INT);
		$readConsPaiDerAdol=$consPaiDerAdol->query();
		$resConsPaiDerAdol=$readConsPaiDerAdol->read();
		$readConsPaiDerAdol->close();
		return $resConsPaiDerAdol;
	}
	public function creaDerechoPai(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegistraDerPai="insert into componente_derecho (
				fecha_estab_compderecho,
				id_derechocespa,
				id_pai,
				num_doc,
				derecho_compderecho,
				objetivo_compderecho,
				actividades_compderecho,
				indicadores_compderecho,
				responsable_compderecho
			) values (
				:fecha_estab_compderecho,
				:id_derechocespa,
				:id_pai,
				:num_doc,
				:derecho_compderecho,
				:objetivo_compderecho,
				:actividades_compderecho,
				:indicadores_compderecho,
				:responsable_compderecho
			)";
			$fechaRegDerecho=date("Y-m-d H:i:s");
			if(empty($this->derecho_compderecho)){$this->derecho_compderecho=null;}
			if(empty($this->objetivo_compderecho)){$this->objetivo_compderecho=null;}
			if(empty($this->actividades_compderecho)){$this->actividades_compderecho=null;}
			if(empty($this->indicadores_compderecho)){$this->indicadores_compderecho=null;}
			if(empty($this->responsable_compderecho)){$this->responsable_compderecho=null;}
			$registraDerPai=$conect->createCommand($sqlRegistraDerPai);
			$registraDerPai->bindParam(":fecha_estab_compderecho",$fechaRegDerecho,PDO::PARAM_STR);
			$registraDerPai->bindParam(":id_derechocespa",$this->id_derechocespa,PDO::PARAM_INT);
			$registraDerPai->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$registraDerPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$registraDerPai->bindParam(":derecho_compderecho",$this->derecho_compderecho);
			$registraDerPai->bindParam(":objetivo_compderecho",$this->objetivo_compderecho);
			$registraDerPai->bindParam(":actividades_compderecho",$this->actividades_compderecho);
			$registraDerPai->bindParam(":indicadores_compderecho",$this->indicadores_compderecho);
			$registraDerPai->bindParam(":responsable_compderecho",$this->responsable_compderecho);
			$registraDerPai->execute();
			$transaction->commit();
			$this->fecha_estab_compderecho=$fechaRegDerecho;
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaRegPai($nombreCampo,$contenido){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		//echo $nombreCampo." ".$contenido." ".$this->fecha_estab_compderecho." ".$this->id_derechocespa." ".$this->id_pai;
		try{
			$sqlModifRegPai="update componente_derecho set ".$nombreCampo."=:contenido 
				where fecha_estab_compderecho=:fecha_estab_compderecho and id_derechocespa=:id_derechocespa and id_pai=:id_pai";
			$ModifRegPai=$conect->createCommand($sqlModifRegPai);
			$ModifRegPai->bindParam(":contenido",$contenido,PDO::PARAM_STR);
			$ModifRegPai->bindParam(":fecha_estab_compderecho",$this->fecha_estab_compderecho,PDO::PARAM_STR);
			$ModifRegPai->bindParam(":id_derechocespa",$this->id_derechocespa,PDO::PARAM_INT);
			$ModifRegPai->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$ModifRegPai->execute();
			$transaction->commit();
			return "exito";

		}catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
}
