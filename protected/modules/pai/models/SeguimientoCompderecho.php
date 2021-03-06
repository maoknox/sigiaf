<?php

/**
 * This is the model class for table "seguimiento_compderecho".
 *
 * The followings are the available columns in table 'seguimiento_compderecho':
 * @property string $fecha_seguim_compderecho
 * @property integer $id_pai
 * @property string $num_doc
 * @property integer $id_derechocespa
 * @property string $id_cedula
 * @property string $fecha_estab_compderecho
 * @property string $seguim_compderecho
 *
 * The followings are the available model relations:
 * @property ComponenteDerecho $fechaEstabCompderecho
 * @property ComponenteDerecho $idDerechocespa
 * @property ComponenteDerecho $idPai
 * @property ComponenteDerecho $numDoc
 * @property Persona $idCedula
 */
class SeguimientoCompderecho extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimiento_compderecho';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_seguim_compderecho, id_pai, num_doc, id_derechocespa, seguim_compderecho', 'required'),
			array('id_pai, id_derechocespa', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('id_cedula, fecha_estab_compderecho', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fecha_seguim_compderecho, id_pai, num_doc, id_derechocespa, id_cedula, fecha_estab_compderecho, seguim_compderecho', 'safe', 'on'=>'search'),
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
			'fechaEstabCompderecho' => array(self::BELONGS_TO, 'ComponenteDerecho', 'fecha_estab_compderecho'),
			'idDerechocespa' => array(self::BELONGS_TO, 'ComponenteDerecho', 'id_derechocespa'),
			'idPai' => array(self::BELONGS_TO, 'ComponenteDerecho', 'id_pai'),
			'numDoc' => array(self::BELONGS_TO, 'ComponenteDerecho', 'num_doc'),
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fecha_seguim_compderecho' => 'Fecha seguimiento',
			'id_pai' => 'Pai',
			'num_doc' => 'Número de documento del adolescente',
			'id_derechocespa' => 'Derecho cespa',
			'id_cedula' => 'Profesional',
			'fecha_estab_compderecho' => 'Fecha establecimiento componente',
			'seguim_compderecho' => 'Seguimiento componente',
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

		$criteria->compare('fecha_seguim_compderecho',$this->fecha_seguim_compderecho,true);
		$criteria->compare('id_pai',$this->id_pai);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_derechocespa',$this->id_derechocespa);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('fecha_estab_compderecho',$this->fecha_estab_compderecho,true);
		$criteria->compare('seguim_compderecho',$this->seguim_compderecho,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoCompderecho the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	Crea registro del seguimiento de un componente de derecho en específico..
	 *	@param strint fecha_seguim_compderecho.
	 *	@param int id_pai.
	 *	@param string num_doc.
	 *	@param int id_derechocespa.
	 *	@param int id_cedula.
	 *	@param string fecha_estab_compderecho.
	 *	@param text seguim_compderecho.
	 *	@return resultado de la transacción
	 */		
	public function regSegSancionPai(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegSegSanc="insert into seguimiento_compderecho (
				fecha_seguim_compderecho,
				id_pai,
				num_doc,
				id_derechocespa,
				id_cedula,
				fecha_estab_compderecho,
				seguim_compderecho				
			) values (
				:fecha_seguim_compderecho,
				:id_pai,
				:num_doc,
				:id_derechocespa,
				:id_cedula,
				:fecha_estab_compderecho,
				:seguim_compderecho	
			)";
			$micro_date = microtime();
			$date_array = explode(" ",$micro_date);
			$date = date("Y-m-d H:i:s.",$date_array[1]); $milisec=explode(".",round($date_array[0],6));
			$fechaRegSeg=$date.$milisec[1];			
			$regSegCompDer=$conect->createCommand($sqlRegSegSanc);
			$regSegCompDer->bindParam(":fecha_seguim_compderecho",$fechaRegSeg,PDO::PARAM_STR);
			$regSegCompDer->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$regSegCompDer->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regSegCompDer->bindParam(":id_derechocespa",$this->id_derechocespa,PDO::PARAM_INT);
			$regSegCompDer->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regSegCompDer->bindParam(":fecha_estab_compderecho",$this->fecha_estab_compderecho,PDO::PARAM_STR);
			$regSegCompDer->bindParam(":seguim_compderecho",$this->seguim_compderecho,PDO::PARAM_STR);
			$regSegCompDer->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
		
	}
	/**
	 *	Retorna los seguimientos por componente de derecho
	 *	@param int $this->id_pai.
	 *	@param int $this->id_derechocespa.
	 *	@param string $this->num_doc.
	 *	@return $resConsSegPaiDer 
	 */		
	public function consultaSeguimientos(){
		$conect= Yii::app()->db;
		$sqlConsSegPaiDer="select fecha_seguim_compderecho,seguim_compderecho from seguimiento_compderecho 
		where id_pai=:id_pai and id_derechocespa=:id_derechocespa and num_doc=:num_doc order by fecha_seguim_compderecho desc";
		$segCompDer=$conect->createCommand($sqlConsSegPaiDer);
		$segCompDer->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
		$segCompDer->bindParam(":id_derechocespa",$this->id_derechocespa,PDO::PARAM_INT);
		$segCompDer->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readConsSegPaiDer=$segCompDer->query();
		$resConsSegPaiDer=$readConsSegPaiDer->readAll();
		$readConsSegPaiDer->close();
		return $resConsSegPaiDer;
	}
}
