<?php

/**
 * This is the model class for table "hist_personal_adol".
 *
 * The followings are the available columns in table 'hist_personal_adol':
 * @property string $id_cedula
 * @property string $num_doc
 * @property string $fecha_histreg_pers
 * @property boolean $asignado_actualmente
 * @property boolean $responsable_caso
 */
class HistPersonalAdol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $psicologosHist;
	public $trabSocialsHist;
	public $mensajeErrorProf;

	public function tableName()
	{
		return 'hist_personal_adol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc,psicologosHist,trabSocialsHist,responsable_caso', 'required'),
			array('num_doc', 'length', 'max'=>15),
			array('responsable_caso', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cedula, num_doc, fecha_histreg_pers, asignado_actualmente, responsable_caso', 'safe', 'on'=>'search'),

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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cedula' => 'Profesional',
			'num_doc' => 'Num Doc',
			'fecha_histreg_pers' => 'Fecha Histreg Pers',
			'asignado_actualmente' => 'Asignado Actualmente',
			'responsable_caso' => 'Responsable Caso',
			'psicologosHist' => 'Psicólogo',
			'trabSocialsHist' => 'Trabajador social',
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

		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('fecha_histreg_pers',$this->fecha_histreg_pers,true);
		$criteria->compare('asignado_actualmente',$this->asignado_actualmente);
		$criteria->compare('responsable_caso',$this->responsable_caso);
		$criteria->compare('psicologosHist',$this->psicologosHist);
		$criteria->compare('trabSocialsHist',$this->trabSocialsHist);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HistPersonalAdol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function modificaPersAdol($profesional,$responsable,$asignacion){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlActualizaEstado="update hist_personal_adol set 
				asignado_actualmente=:asignado_actualmente,
				responsable_caso=:responsable_caso 
				where id_cedula=:id_cedula and num_doc=:num_doc";
			$actualizaEstado=$conect->createCommand($sqlActualizaEstado);
			$actualizaEstado->bindParam(':id_cedula',$profesional,PDO::PARAM_INT);
			$actualizaEstado->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
			$actualizaEstado->bindParam(':asignado_actualmente',$asignacion,PDO::PARAM_BOOL);
			$actualizaEstado->bindParam(':responsable_caso',$responsable,PDO::PARAM_BOOL);
			$actualizaEstado->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function registraEquipoPsic($profesional,$responsable){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaRegProf="insert into hist_personal_adol (
					id_cedula,
					num_doc,
					fecha_histreg_pers,
					asignado_actualmente,
					responsable_caso
				) values (
					:idCedula,
					:numDoc,
					:fechaRegistro,
					:asignacon,
					:responsableCaso
				)";
			$fechaRegProf=date("Y-m-d");
			$asignadoActualmente=true;
			$excCreaRegProf=$conect->createCommand($sqlCreaRegProf);
			$excCreaRegProf->bindParam(':idCedula',$profesional,PDO::PARAM_INT);
			$excCreaRegProf->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
			$excCreaRegProf->bindParam(':fechaRegistro',$fechaRegProf,PDO::PARAM_STR);
			$excCreaRegProf->bindParam(':asignacon',$asignadoActualmente,PDO::PARAM_BOOL);
			$excCreaRegProf->bindParam(':responsableCaso',$responsable,PDO::PARAM_BOOL);
			$excCreaRegProf->execute();
			$transaction->commit();
			$this->mensajeErrorProf=" ";
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorProf.='<br/>Aunque no se pudo registrar satisfactoriamente el equipo psicosocial. El código del error es el siguiente <br/>'.$e;
		}
	}
}
