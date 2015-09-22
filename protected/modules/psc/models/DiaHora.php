<?php

/**
 * This is the model class for table "dia_hora".
 *
 * The followings are the available columns in table 'dia_hora':
 * @property integer $id_hora_dia
 * @property integer $id_dia
 * @property string $id_psc
 * @property string $num_doc
 * @property integer $hora_inicio
 * @property integer $hora_fin
 * @property string $hora_inicio_m
 * @property string $hora_fin_m
 * @property integer $horas_dia
 *
 * The followings are the available model relations:
 * @property AsistenciaPsc[] $asistenciaPscs
 * @property Psc $idPsc
 * @property Psc $numDoc
 * @property Dia $idDia
 */
class DiaHora extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dia_hora';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hora_inicio, hora_fin, hora_inicio_m, hora_fin_m, horas_dia', 'required'),
			array('id_dia, hora_inicio, hora_fin, horas_dia', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('hora_inicio_m, hora_fin_m', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_hora_dia, id_dia, id_psc, num_doc, hora_inicio, hora_fin, hora_inicio_m, hora_fin_m, horas_dia', 'safe', 'on'=>'search'),
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
			'asistenciaPscs' => array(self::HAS_MANY, 'AsistenciaPsc', 'id_hora_dia'),
			'idPsc' => array(self::BELONGS_TO, 'Psc', 'id_psc'),
			'numDoc' => array(self::BELONGS_TO, 'Psc', 'num_doc'),
			'idDia' => array(self::BELONGS_TO, 'Dia', 'id_dia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_hora_dia' => 'Id Hora Dia',
			'id_dia' => 'Id Dia',
			'id_psc' => 'Id Psc',
			'num_doc' => 'Num Doc',
			'hora_inicio' => 'Hora Inicio',
			'hora_fin' => 'Hora Fin',
			'hora_inicio_m' => 'Hora Inicio M',
			'hora_fin_m' => 'Hora Fin M',
			'horas_dia' => 'Horas Dia',
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

		$criteria->compare('id_hora_dia',$this->id_hora_dia);
		$criteria->compare('id_dia',$this->id_dia);
		$criteria->compare('id_psc',$this->id_psc,true);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('hora_inicio',$this->hora_inicio);
		$criteria->compare('hora_fin',$this->hora_fin);
		$criteria->compare('hora_inicio_m',$this->hora_inicio_m,true);
		$criteria->compare('hora_fin_m',$this->hora_fin_m,true);
		$criteria->compare('horas_dia',$this->horas_dia);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DiaHora the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaHorario(){
		$conect=Yii::app()->db;
		$sqlConsHorario="select * from dia_hora as a left join dia as b on b.id_dia=a.id_dia where id_psc=:id_psc and num_doc=:num_doc order by a.id_dia asc";
		$consHorario=$conect->createCommand($sqlConsHorario);	
		$consHorario->bindParam(":id_psc",$this->id_psc,PDO::PARAM_INT);
		$consHorario->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readHorario=$consHorario->query();
		$resHorario=$readHorario->readAll();
		$readHorario->close();
		return $resHorario;
	}
}
