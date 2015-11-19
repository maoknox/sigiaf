<?php

/**
 * This is the model class for table "seguimiento_compsancion".
 *
 * The followings are the available columns in table 'seguimiento_compsancion':
 * @property string $fecha_seguim_compsancion
 * @property integer $id_pai
 * @property string $num_doc 
 * @property integer $id_inf_judicial
 * @property string $id_cedula
 * @property string $fecha_establec_compsanc
 * @property string $seguim_compsancion
 *
 * The followings are the available model relations:
 * @property ComponenteSancion $idInfJudicial
 * @property ComponenteSancion $fechaEstablecCompsanc
 * @property ComponenteSancion $idPai
 * @property ComponenteSancion $numDoc 
 * @property Persona $idCedula
 */
class SeguimientoCompsancion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimiento_compsancion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_seguim_compsancion, id_pai, num_doc, id_inf_judicial, seguim_compsancion', 'required'),
			array('id_pai, id_inf_judicial', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('id_cedula, fecha_establec_compsanc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fecha_seguim_compsancion, id_pai, num_doc, id_inf_judicial, id_cedula, fecha_establec_compsanc, seguim_compsancion', 'safe', 'on'=>'search'),
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
			'idInfJudicial' => array(self::BELONGS_TO, 'ComponenteSancion', 'id_inf_judicial'),
			'fechaEstablecCompsanc' => array(self::BELONGS_TO, 'ComponenteSancion', 'fecha_establec_compsanc'),
			'idPai' => array(self::BELONGS_TO, 'ComponenteSancion', 'id_pai'),
			'numDoc' => array(self::BELONGS_TO, 'ComponenteSancion', 'num_doc'),
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fecha_seguim_compsancion' => 'Fecha Seguimiento Compsanción',
			'id_pai' => 'Pai',
			'num_doc' => 'Número de documento del adolescente',
			'id_inf_judicial' => 'Información Judicial',
			'id_cedula' => 'Profesional',
			'fecha_establec_compsanc' => 'Fecha registro componente',
			'seguim_compsancion' => 'Seguimiento componente sanción',
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

		$criteria->compare('fecha_seguim_compsancion',$this->fecha_seguim_compsancion,true);
		$criteria->compare('id_pai',$this->id_pai);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_inf_judicial',$this->id_inf_judicial);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('fecha_establec_compsanc',$this->fecha_establec_compsanc,true);
		$criteria->compare('seguim_compsancion',$this->seguim_compsancion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoCompsancion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	Crea registro del seguimiento de un componente de sanción en específico..
	 *	@param strint fecha_seguim_compsancion.
	 *	@param int id_pai.
	 *	@param string num_doc.
	 *	@param int id_inf_judicial.
	 *	@param int id_cedula.
	 *	@param string fecha_establec_compsanc.
	 *	@param text seguim_compsancion.
	 *	@return resultado de la transacción
	 */		
	public function regSegSancionPai(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegSegSanc="insert into seguimiento_compsancion (
				fecha_seguim_compsancion,
				id_pai,
				num_doc,
				id_inf_judicial,
				id_cedula,
				fecha_establec_compsanc,
				seguim_compsancion				
			) values (
				:fecha_seguim_compsancion,
				:id_pai,
				:num_doc,
				:id_inf_judicial,
				:id_cedula,
				:fecha_establec_compsanc,
				:seguim_compsancion				
			)";
			$micro_date = microtime();
			$date_array = explode(" ",$micro_date);
			$date = date("Y-m-d H:i:s.",$date_array[1]); $milisec=explode(".",round($date_array[0],6));
			$fechaRegSeg=$date.$milisec[1];			
			$regSegSanc=$conect->createCommand($sqlRegSegSanc);
			$regSegSanc->bindParam(":fecha_seguim_compsancion",$fechaRegSeg,PDO::PARAM_STR);
			$regSegSanc->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$regSegSanc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);				
			$regSegSanc->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
			$regSegSanc->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regSegSanc->bindParam(":fecha_establec_compsanc",$this->fecha_establec_compsanc,PDO::PARAM_STR);
			$regSegSanc->bindParam(":seguim_compsancion",$this->seguim_compsancion,PDO::PARAM_STR);
			$regSegSanc->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
		
	}
	/**
	 *	Retorna los seguimientos por componente de sanción
	 *	@param int $this->id_pai.
	 *	@param int $this->id_inf_judicial.
	 *	@param string $this->num_doc.
	 *	@return $resConsSegPaiDer 
	 */		
	public function consultaSeguimientos(){
		$conect= Yii::app()->db;
		$sqlConsSegPaiDer="select fecha_seguim_compsancion,seguim_compsancion from seguimiento_compsancion 
		where id_pai=:id_pai and id_inf_judicial=:id_inf_judicial and num_doc=:num_doc order by fecha_seguim_compsancion desc";
		$segCompDer=$conect->createCommand($sqlConsSegPaiDer);
		$segCompDer->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
		$segCompDer->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
		$segCompDer->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);		
		$readConsSegPaiDer=$segCompDer->query();
		$resConsSegPaiDer=$readConsSegPaiDer->readAll();
		$readConsSegPaiDer->close();
		return $resConsSegPaiDer;
	}	

}
