<?php

/**
 * This is the model class for table "factor_vteo".
 *
 * The followings are the available columns in table 'factor_vteo':
 * @property integer $id_factorvteo
 * @property integer $id_gradofact
 * @property integer $id_factorperfoc
 * @property integer $id_aspectovteo
 *
 * The followings are the available model relations:
 * @property AspectoValteo $idAspectovteo
 * @property FactorPerfoc $idFactorperfoc
 * @property GradoFactor $idGradofact
 */
class FactorVteo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $factorGrado;
	public function tableName()
	{
		return 'factor_vteo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_factorperfoc', 'required'),
			array('id_gradofact, id_factorperfoc, id_aspectovteo', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_factorvteo, id_gradofact, id_factorperfoc, id_aspectovteo', 'safe', 'on'=>'search'),
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
			'idAspectovteo' => array(self::BELONGS_TO, 'AspectoValteo', 'id_aspectovteo'),
			'idFactorperfoc' => array(self::BELONGS_TO, 'FactorPerfoc', 'id_factorperfoc'),
			'idGradofact' => array(self::BELONGS_TO, 'GradoFactor', 'id_gradofact'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_factorvteo' => 'Factor',
			'id_gradofact' => 'Grado',
			'id_factorperfoc' => 'Factor perfil ocupacional',
			'id_aspectovteo' => 'Aspecto',
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

		$criteria->compare('id_factorvteo',$this->id_factorvteo);
		$criteria->compare('id_gradofact',$this->id_gradofact);
		$criteria->compare('id_factorperfoc',$this->id_factorperfoc);
		$criteria->compare('id_aspectovteo',$this->id_aspectovteo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FactorVteo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 *	Elimina registro de los factores del perfil ocupacional del adolescente
	 *
	 *	@param int $this->id_aspectovteo
	 */		
	public function delAspectoFactVto(){
		$conect=Yii::app()->db;
		$sqlDelFactorVteo="delete from factor_vteo where id_aspectovteo=:id_aspectovteo";	
		$delFactorVteo=$conect->createCommand($sqlDelFactorVteo);
		$delFactorVteo->bindParam(":id_aspectovteo",$this->id_aspectovteo);
		$delFactorVteo->execute();			
	}
	/**
	 *	Registra factor del perfil ocupacional del adolescente.
	 *
	 *	@param int $factorGrado
	 *	@param int $pk
	 *	@param int $this->id_aspectovteo
	 *	@return resultado de la transacción 
	 */		
	public function creaFactorAspectoVTeo(){	
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			foreach($this->factorGrado as $pk=>$factorGrado){
				$sqlCreaFactorAspectoVTo="insert into factor_vteo (
					id_factorvteo,
					id_gradofact,
					id_factorperfoc,
					id_aspectovteo 
				) values (
					default,
					:id_gradofact,
					:id_factorperfoc,
					:id_aspectovteo 
				)";
				$creaFactorAspectoVTo=$conect->createCommand($sqlCreaFactorAspectoVTo);
				$creaFactorAspectoVTo->bindParam(":id_gradofact",$factorGrado,PDO::PARAM_INT);
				$creaFactorAspectoVTo->bindParam(":id_factorperfoc",$pk,PDO::PARAM_INT);
				$creaFactorAspectoVTo->bindParam(":id_aspectovteo",$this->id_aspectovteo,PDO::PARAM_INT);
				$creaFactorAspectoVTo->execute();
			}
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}
	}
	/**
	 *	Consulta factor del perfil ocupacional del adolescente.
	 *
	 *	@param int $this->id_gradofact
	 *	@param int $this->id_factorperfoc
	 *	@param int $this->id_aspectovteo
	 *	@return $resFactorAspectoVTo
	 */		
	public function consGradoFactor(){
		$conect=Yii::app()->db;
		$sqlConsFactorAspectoVTo="select * from factor_vteo where id_gradofact=:id_gradofact and id_factorperfoc=:id_factorperfoc and id_aspectovteo=:id_aspectovteo";
		$consFactorAspectoVTo=$conect->createCommand($sqlConsFactorAspectoVTo);
		$consFactorAspectoVTo->bindParam(":id_gradofact",$this->id_gradofact,PDO::PARAM_INT);
		$consFactorAspectoVTo->bindParam(":id_factorperfoc",$this->id_factorperfoc,PDO::PARAM_INT);
		$consFactorAspectoVTo->bindParam(":id_aspectovteo",$this->id_aspectovteo,PDO::PARAM_INT);
		$readFactorAspectoVTo=$consFactorAspectoVTo->query();
		$resFactorAspectoVTo=$readFactorAspectoVTo->read();
		$readFactorAspectoVTo->close();
		return $resFactorAspectoVTo;
	}
}
