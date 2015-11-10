<?php

/**
 * This is the model class for table "area_inscripcion".
 *
 * The followings are the available columns in table 'area_inscripcion':
 * @property integer $id_areainteres
 * @property integer $id_areainscr
 * @property string $area_interes
 * @property boolean $areainscr_activa
 *
 * The followings are the available model relations:
 * @property CentroForjar[] $centroForjars
 * @property TipoAreainscr $idAreainscr
 * @property Asistencia[] $asistencias
 */
class AreaInscripcion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'area_inscripcion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_areainscr, area_interes, areainscr_activa', 'required'),
			array('id_areainscr', 'numerical', 'integerOnly'=>true),
			array('area_interes', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_areainteres, id_areainscr, area_interes, areainscr_activa', 'safe', 'on'=>'search'),
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
			'centroForjars' => array(self::MANY_MANY, 'CentroForjar', 'areainscr_cforjar(id_areainteres, id_forjar)'),
			'idAreainscr' => array(self::BELONGS_TO, 'TipoAreainscr', 'id_areainscr'),
			'asistencias' => array(self::HAS_MANY, 'Asistencia', 'id_areainteres'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_areainteres' => 'Área interés',
			'id_areainscr' => 'Área inscripción',
			'area_interes' => 'Área Interés',
			'areainscr_activa' => 'Estado área interés',
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

		$criteria->compare('id_areainteres',$this->id_areainteres);
		$criteria->compare('id_areainscr',$this->id_areainscr);
		$criteria->compare('area_interes',$this->area_interes,true);
		$criteria->compare('areainscr_activa',$this->areainscr_activa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AreaInscripcion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function creaAreaInteres(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaAreaInt="insert into area_inscripcion (
				id_areainteres,
				id_areainscr,
				area_interes,
				areainscr_activa			
			) values (
				default,
				:id_areainscr,
				:area_interes,
				:areainscr_activa
			) returning id_areainteres";
			$creaAreaInt=$conect->createCommand($sqlCreaAreaInt);
			$creaAreaInt->bindParam(":id_areainscr",$this->id_areainscr,PDO::PARAM_INT);
			$creaAreaInt->bindParam(":area_interes",mb_strtoupper($this->area_interes),PDO::PARAM_STR);
			$creaAreaInt->bindParam(":areainscr_activa",$this->areainscr_activa,PDO::PARAM_BOOL);
			$readAreaInt=$creaAreaInt->query();
			$resAreaInt=$readAreaInt->read();
			$readAreaInt->close();
			$transaction->commit();
			$this->id_areainteres=$resAreaInt["id_areainteres"];
			return "exito";						
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}		
	}
}
