<?php

/**
 * This is the model class for table "asistencia_psc".
 *
 * The followings are the available columns in table 'asistencia_psc':
 * @property integer $id_asist_psc
 * @property integer $id_seguimiento_ind
 * @property string $fecha_asist_psc
 * @property integer $num_hora
 * @property integer $num_minutos 
 *
 * The followings are the available model relations:
 * @property SeguimientoPsc $idSeguimientoInd
 */
class AsistenciaPsc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $fechas;
	public function tableName()
	{
		return 'asistencia_psc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('fecha_asist_psc', 'required'),
			array('id_seguimiento_ind, num_hora', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_asist_psc, id_seguimiento_ind, fecha_asist_psc, num_hora, num_minutos', 'safe', 'on'=>'search'),
			array('fecha_asist_psc','valAsistenciaPsc')
		);
	}
	public function valAsistenciaPsc($attribute=NULL,$params=NULL){
		if(isset($_POST["numFechas"]) && $_POST["numFechas"]==0){
			//if($_POST["numFechas"]==0){
				$this->addError($attribute,"Debe seleccionar al menos una fecha de asistencia");
			//}
			
				//$this->addError($attribute,$_POST["numFechas"]);
			//}
		}
					
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idSeguimientoInd' => array(self::BELONGS_TO, 'SeguimientoPsc', 'id_seguimiento_ind'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_asist_psc' => 'Asistencia PSC',
			'id_seguimiento_ind' => 'Seguimiento',
			'fecha_asist_psc' => 'Fecha de asistencia',
			'num_hora' => 'Número de horas',
			'num_minutos' => 'Número de minutos',
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

		$criteria->compare('id_asist_psc',$this->id_asist_psc);
		$criteria->compare('id_seguimiento_ind',$this->id_seguimiento_ind);
		$criteria->compare('fecha_asist_psc',$this->fecha_asist_psc,true);
		$criteria->compare('num_hora',$this->num_hora);
		$criteria->compare('num_minutos',$this->num_minutos);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsistenciaPsc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaAsistencia(){
		$conect=Yii::app()->db;
		$sqlConsAsistPsc="select * from asistencia_psc where id_seguimiento_ind=:id_seguimiento_ind";
		$consAsistenciaPsc=$conect->createCommand($sqlConsAsistPsc);
		$consAsistenciaPsc->bindParam(":id_seguimiento_ind",$this->id_seguimiento_ind);
		$readAsistPsc=$consAsistenciaPsc->query();
		$resAsistPsc=$readAsistPsc->readAll();
		$readAsistPsc->close();
		return $resAsistPsc;
			
			
	}
}
