<?php

/**
 * This is the model class for table "escolaridad_adolescente".
 *
 * The followings are the available columns in table 'escolaridad_adolescente':
 * @property integer $id_escolaridad
 * @property integer $id_estado_escol
 * @property integer $id_jornada_educ
 * @property string $num_doc
 * @property integer $id_nivel_educ
 * @property string $instituto_escolaridad
 * @property string $anio_escolaridad
 * @property string $escolarizado
 * @property integer $semestre
 *
 * The followings are the available model relations:
 * @property Adolescente $numDoc
 * @property EstadoEscolarizacion $idEstadoEscol
 * @property JornadaEduc $idJornadaEduc
 * @property NivelEducativo $idNivelEduc
 */
class EscolaridadAdolescente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $tipoDato;
	public $nombreCampo;
	public $datosCampo;
	public function tableName()
	{
		return 'escolaridad_adolescente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_estado_escol, id_jornada_educ, id_nivel_educ,id_municipio', 'required'),
			array('id_estado_escol, id_jornada_educ, id_nivel_educ, semestre', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('id_municipio', 'length', 'max'=>10),
			array('instituto_escolaridad', 'length', 'max'=>100),
			array('anio_escolaridad', 'length', 'max'=>4),
			array('escolarizado', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_escolaridad, id_estado_escol, id_jornada_educ, num_doc, id_nivel_educ,id_municipio, instituto_escolaridad, anio_escolaridad, escolarizado, semestre', 'safe', 'on'=>'search'),
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
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
			'idEstadoEscol' => array(self::BELONGS_TO, 'EstadoEscolarizacion', 'id_estado_escol'),
			'idJornadaEduc' => array(self::BELONGS_TO, 'JornadaEduc', 'id_jornada_educ'),
			'idNivelEduc' => array(self::BELONGS_TO, 'NivelEducativo', 'id_nivel_educ'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_escolaridad' => 'Escolaridad',
			'id_estado_escol' => 'Estado escolaridad',
			'id_jornada_educ' => 'Jornada educativa',
			'num_doc' => 'Número de documento',
			'id_nivel_educ' => 'Nivel educativo',
			'id_municipio' => 'Municipio',
			'instituto_escolaridad' => 'Instituto Escolaridad',
			'anio_escolaridad' => 'Año Escolaridad',
			'escolarizado' => 'Escolarizado',
			'semestre' => 'Semestre',
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

		$criteria->compare('id_escolaridad',$this->id_escolaridad);
		$criteria->compare('id_estado_escol',$this->id_estado_escol);
		$criteria->compare('id_jornada_educ',$this->id_jornada_educ);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_nivel_educ',$this->id_nivel_educ);
		$criteria->compare('id_municipio',$this->id_municipio,true);
		$criteria->compare('instituto_escolaridad',$this->instituto_escolaridad,true);
		$criteria->compare('anio_escolaridad',$this->anio_escolaridad,true);
		$criteria->compare('escolarizado',$this->escolarizado,true);
		$criteria->compare('semestre',$this->semestre);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EscolaridadAdolescente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaEscolaridad(){
		$conect= Yii::app()->db;
		$sqlConsEscAdol="select * from escolaridad_adolescente where num_doc=:numDoc order by anio_escolaridad desc";
		$consEscAdol=$conect->createCommand($sqlConsEscAdol);
		$consEscAdol->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
		$readConsEscAdol=$consEscAdol->query();
		$resConsAdol=$readConsEscAdol->readAll();
		$readConsEscAdol->close();
		return $resConsAdol;
	}
	public function consultaAnioEsc(){
		$conect= Yii::app()->db;
		$sqlConsEscAdol="select * from escolaridad_adolescente where num_doc=:numDoc and id_escolaridad=:id_escolaridad ";
		$consEscAdol=$conect->createCommand($sqlConsEscAdol);
		$consEscAdol->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
		$consEscAdol->bindParam(':id_escolaridad',$this->id_escolaridad,PDO::PARAM_STR);
		$readConsEscAdol=$consEscAdol->query();
		$resConsAdol=$readConsEscAdol->read();
		$readConsEscAdol->close();
		return $resConsAdol;

	}
	public function creaRegEscAdol(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaRegEd="insert into escolaridad_adolescente (
				id_escolaridad,
				num_doc,
				id_nivel_educ,
				anio_escolaridad,
				instituto_escolaridad,
				id_municipio,
				id_jornada_educ
			) values (
				default,
				:num_doc,
				:id_nivel_educ,
				:anio_escolaridad,
				:instituto_escolaridad,
				:id_municipio,
				:id_jornada_educ
			) returning id_escolaridad";
			$creaRegEd=$conect->createCommand($sqlCreaRegEd);
			$creaRegEd->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$creaRegEd->bindParam(":id_nivel_educ",$this->id_nivel_educ,PDO::PARAM_INT);
			$creaRegEd->bindParam(":anio_escolaridad",$this->anio_escolaridad,PDO::PARAM_STR);
			$creaRegEd->bindParam(":instituto_escolaridad",$this->instituto_escolaridad,PDO::PARAM_STR);
			$creaRegEd->bindParam(":id_municipio",$this->id_municipio,PDO::PARAM_INT);
			$creaRegEd->bindParam(":id_jornada_educ",$this->id_jornada_educ,PDO::PARAM_INT);
			$readRegEd=$creaRegEd->query();
			$resRegEd=$readRegEd->read();
			$readRegEd->close();
			$this->id_escolaridad=$resRegEd["id_escolaridad"];
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaEscolAdol(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModEscAdol="update escolaridad_adolescente set ".pg_escape_string($this->nombreCampo)."=:datos_campo where id_escolaridad=:id_escolaridad and num_doc=:num_doc";
			$modEscAdol=$conect->createCommand($sqlModEscAdol);
			$modEscAdol->bindParam(":datos_campo",$this->datosCampo,$this->tipoDato);
			$modEscAdol->bindParam(":id_escolaridad",$this->id_escolaridad,PDO::PARAM_INT);
			$modEscAdol->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$modEscAdol->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
		
	}
}
