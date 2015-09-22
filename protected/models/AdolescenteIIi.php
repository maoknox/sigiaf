<?php

/**
 * This is the model class for table "adolescente".
 *
 * The followings are the available columns in table 'adolescente':
 * @property string $num_doc
 * @property integer $id_tipo_doc
 * @property integer $id_sexo
 * @property string $id_municipio
 * @property integer $id_familia
 * @property integer $id_etnia
 * @property string $apellido_1
 * @property string $apellido_2
 * @property string $nombres
 * @property string $fecha_nacimiento
 * @property double $edad_ingreso
 * @property double $edad_actual
 *
 * The followings are the available model relations:
 * @property DocumentoCespa[] $documentoCespas
 * @property AuditoriaSistcforjar[] $auditoriaSistcforjars
 * @property EscIngEgr[] $escIngEgrs
 * @property EscolaridadAdolescente[] $escolaridadAdolescentes
 * @property Familiar[] $familiars
 * @property CentroForjar[] $centroForjars
 * @property Persona[] $personas
 * @property LocalizacionViv[] $localizacionVivs
 * @property InformacionJudicial[] $informacionJudicials
 * @property NumeroCarpeta[] $numeroCarpetas
 * @property Sgsss[] $sgssses
 * @property DerechoAdol[] $derechoAdols
 * @property Telefono[] $telefonos
 * @property ValoracionEnfermeria[] $valoracionEnfermerias
 * @property ValoracionPsicologia[] $valoracionPsicologias
 * @property ValoracionPsiquiatria[] $valoracionPsiquiatrias
 * @property ValoracionTeo[] $valoracionTeos
 * @property ValoracionTrabajoSocial[] $valoracionTrabajoSocials
 * @property Familia $idFamilia
 * @property Etnia $idEtnia
 * @property Municipio $idMunicipio
 * @property Sexo $idSexo
 * @property TipoDocumento $idTipoDoc
 */
class Adolescente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'adolescente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc, id_tipo_doc, id_sexo, id_municipio, apellido_1, nombres, fecha_nacimiento', 'required'),
			array('id_tipo_doc, id_sexo, id_familia, id_etnia', 'numerical', 'integerOnly'=>true),
			array('edad_ingreso, edad_actual', 'numerical'),
			array('num_doc', 'length', 'max'=>15),
			array('id_municipio', 'length', 'max'=>10),
			array('apellido_1, apellido_2, nombres', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('num_doc, id_tipo_doc, id_sexo, id_municipio, id_familia, id_etnia, apellido_1, apellido_2, nombres, fecha_nacimiento, edad_ingreso, edad_actual', 'safe', 'on'=>'search'),
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
			'documentoCespas' => array(self::MANY_MANY, 'DocumentoCespa', 'adol_doccespa(num_doc, id_doccespa)'),
			'auditoriaSistcforjars' => array(self::HAS_MANY, 'AuditoriaSistcforjar', 'num_doc'),
			'escIngEgrs' => array(self::MANY_MANY, 'EscIngEgr', 'escadol_ingr_egr(num_doc, id_escingegr)'),
			'escolaridadAdolescentes' => array(self::HAS_MANY, 'EscolaridadAdolescente', 'num_doc'),
			'familiars' => array(self::MANY_MANY, 'Familiar', 'familiar_adolescente(num_doc, id_doc_familiar)'),
			'centroForjars' => array(self::MANY_MANY, 'CentroForjar', 'forjar_adol(num_doc, id_forjar)'),
			'personas' => array(self::MANY_MANY, 'Persona', 'hist_personal_adol(num_doc, id_cedula)'),
			'localizacionVivs' => array(self::HAS_MANY, 'LocalizacionViv', 'num_doc'),
			'informacionJudicials' => array(self::HAS_MANY, 'InformacionJudicial', 'num_doc'),
			'numeroCarpetas' => array(self::HAS_MANY, 'NumeroCarpeta', 'num_doc'),
			'sgssses' => array(self::HAS_MANY, 'Sgsss', 'num_doc'),
			'derechoAdols' => array(self::HAS_MANY, 'DerechoAdol', 'num_doc'),
			'telefonos' => array(self::HAS_MANY, 'Telefono', 'num_doc'),
			'valoracionEnfermerias' => array(self::HAS_MANY, 'ValoracionEnfermeria', 'num_doc'),
			'valoracionPsicologias' => array(self::HAS_MANY, 'ValoracionPsicologia', 'num_doc'),
			'valoracionPsiquiatrias' => array(self::HAS_MANY, 'ValoracionPsiquiatria', 'num_doc'),
			'valoracionTeos' => array(self::HAS_MANY, 'ValoracionTeo', 'num_doc'),
			'valoracionTrabajoSocials' => array(self::HAS_MANY, 'ValoracionTrabajoSocial', 'num_doc'),
			'idFamilia' => array(self::BELONGS_TO, 'Familia', 'id_familia'),
			'idEtnia' => array(self::BELONGS_TO, 'Etnia', 'id_etnia'),
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
			'idSexo' => array(self::BELONGS_TO, 'Sexo', 'id_sexo'),
			'idTipoDoc' => array(self::BELONGS_TO, 'TipoDocumento', 'id_tipo_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'num_doc' => 'Num Doc',
			'id_tipo_doc' => 'Id Tipo Doc',
			'id_sexo' => 'Id Sexo',
			'id_municipio' => 'Id Municipio',
			'id_familia' => 'Id Familia',
			'id_etnia' => 'Id Etnia',
			'apellido_1' => 'Apellido 1',
			'apellido_2' => 'Apellido 2',
			'nombres' => 'Nombres',
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'edad_ingreso' => 'Edad Ingreso',
			'edad_actual' => 'Edad Actual',
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

		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_tipo_doc',$this->id_tipo_doc);
		$criteria->compare('id_sexo',$this->id_sexo);
		$criteria->compare('id_municipio',$this->id_municipio,true);
		$criteria->compare('id_familia',$this->id_familia);
		$criteria->compare('id_etnia',$this->id_etnia);
		$criteria->compare('apellido_1',$this->apellido_1,true);
		$criteria->compare('apellido_2',$this->apellido_2,true);
		$criteria->compare('nombres',$this->nombres,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('edad_ingreso',$this->edad_ingreso);
		$criteria->compare('edad_actual',$this->edad_actual);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Adolescente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
