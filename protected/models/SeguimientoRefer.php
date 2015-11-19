<?php

/**
 * This is the model class for table "seguimiento_refer".
 *
 * The followings are the available columns in table 'seguimiento_refer':
 * @property integer $id_seg_refer
 * @property string $id_cedula
 * @property integer $id_referenciacion
 * @property string $seg_refer
 * @property string $fecha_seg
 *
 * The followings are the available model relations:
 * @property Persona $idCedula
 * @property ReferenciacionAdol $idReferenciacion
 */
class SeguimientoRefer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimiento_refer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_referenciacion,seg_refer', 'required'),
			array('id_referenciacion', 'numerical', 'integerOnly'=>true),
			array('id_cedula', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_seg_refer, id_cedula, id_referenciacion, seg_refer, fecha_seg', 'safe', 'on'=>'search'),
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
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
			'idReferenciacion' => array(self::BELONGS_TO, 'ReferenciacionAdol', 'id_referenciacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_seg_refer' => 'Seguimiento refer',
			'id_cedula' => 'Profesional',
			'id_referenciacion' => 'Referenciación',
			'seg_refer' => 'Seguimiento Referenciación',
			'fecha_seg' => 'Fecha seguimiento',
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

		$criteria->compare('id_seg_refer',$this->id_seg_refer);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('id_referenciacion',$this->id_referenciacion);
		$criteria->compare('seg_refer',$this->seg_refer,true);
		$criteria->compare('fecha_seg',$this->fecha_seg,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoRefer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
	/**
	 * 	Consulta los seguimientos de acuerdo a la referenciación seleccionada.
	 */
	public function consSegReferAdol(){
		$conect=Yii::app()->db;
		$sqlConsSegRefAdol="select a.fecha_seg,a.seg_refer, (nombre_personal||' '||apellidos_personal) as nombrespersonal,d.nombre_rol  from seguimiento_refer as a 
		left join persona as b on b.id_cedula=a.id_cedula 
		left join usuario as c on c.id_cedula=b.id_cedula 
		left join rol as d on d.id_rol=c.id_rol 
		where id_referenciacion=:id_referenciacion";
		
		$consSegRefAdol=$conect->createCommand($sqlConsSegRefAdol);
		$consSegRefAdol->bindParam("id_referenciacion",$this->id_referenciacion,PDO::PARAM_INT);
		$readSegRefAdol=$consSegRefAdol->query();
		$resSegRefAdol=$readSegRefAdol->readAll();
		$readSegRefAdol->close();
		return $resSegRefAdol;
		
	}
	/**
	 * 	registra seguimientos de referenciación.
	 */
	public function registraSegimiento(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegistraSeg="insert into seguimiento_refer (
				id_seg_refer,
				id_cedula,
				id_referenciacion,
				seg_refer,
				fecha_seg
			) values (
				default,
				:id_cedula,
				:id_referenciacion,
				:seg_refer,
				:fecha_seg
			)";
			$fecha=date("Y-m-d");
			$registraSeg=$conect->createCommand($sqlRegistraSeg);
			$registraSeg->bindParam("id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$registraSeg->bindParam("id_referenciacion",$this->id_referenciacion,PDO::PARAM_INT);
			$registraSeg->bindParam("seg_refer",$this->seg_refer,PDO::PARAM_STR);
			$registraSeg->bindParam("fecha_seg",$fecha,PDO::PARAM_STR);
			$registraSeg->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
}
