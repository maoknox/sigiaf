<?php

/**
 * This is the model class for table "seguimiento_asesoriasj".
 *
 * The followings are the available columns in table 'seguimiento_asesoriasj':
 * @property string $fecha_registrosegsj
 * @property integer $id_gestionsj
 * @property string $id_cedula
 * @property string $fecha_seguimientogsj
 * @property string $seguimiento_gestionsj
 *
 * The followings are the available model relations:
 * @property GestionSociojuridica $idGestionsj
 * @property Persona $idCedula
 */
class SeguimientoAsesoriasj extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimiento_asesoriasj';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_registrosegsj, id_gestionsj, fecha_seguimientogsj, seguimiento_gestionsj', 'required'),
			array('id_gestionsj', 'numerical', 'integerOnly'=>true),
			array('id_cedula', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fecha_registrosegsj, id_gestionsj, id_cedula, fecha_seguimientogsj, seguimiento_gestionsj', 'safe', 'on'=>'search'),
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
			'idGestionsj' => array(self::BELONGS_TO, 'GestionSociojuridica', 'id_gestionsj'),
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fecha_registrosegsj' => 'Fecha Registro del seguimiento',
			'id_gestionsj' => 'Id Gestionsj',
			'id_cedula' => 'Id Cedula',
			'fecha_seguimientogsj' => 'Fecha del seguimiento',
			'seguimiento_gestionsj' => 'Seguimiento de la gestión socio jurídica',
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

		$criteria->compare('fecha_registrosegsj',$this->fecha_registrosegsj,true);
		$criteria->compare('id_gestionsj',$this->id_gestionsj);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('fecha_seguimientogsj',$this->fecha_seguimientogsj,true);
		$criteria->compare('seguimiento_gestionsj',$this->seguimiento_gestionsj,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoAsesoriasj the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function registraSegGSJAdol(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$micro_date = microtime();
			$date_array = explode(" ",$micro_date);
			$date = date("Y-m-d H:i:s.",$date_array[1]); 
			$milisec=explode(".",round($date_array[0],6));		
			$fechaRegistroId=$date.$milisec[1];		
			//

			$sqlRegSegGSJAdol="insert into seguimiento_asesoriasj (
				fecha_registrosegsj,
				id_gestionsj,
				id_cedula,
				fecha_seguimientogsj,
				seguimiento_gestionsj
			) values (
				:fecha_registrosegsj,
				:id_gestionsj,
				:id_cedula,
				:fecha_seguimientogsj,
				:seguimiento_gestionsj
			)";
			$regSegGSJadol=$conect->createCommand($sqlRegSegGSJAdol);
			$regSegGSJadol->bindParam(":fecha_registrosegsj",$fechaRegistroId,PDO::PARAM_STR);
			$regSegGSJadol->bindParam(":id_gestionsj",$this->id_gestionsj,PDO::PARAM_INT);
			$regSegGSJadol->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regSegGSJadol->bindParam(":fecha_seguimientogsj",$this->fecha_seguimientogsj,PDO::PARAM_INT);
			$regSegGSJadol->bindParam(":seguimiento_gestionsj",$this->seguimiento_gestionsj,PDO::PARAM_INT);
			$regSegGSJadol->execute();			
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}

	}

}
