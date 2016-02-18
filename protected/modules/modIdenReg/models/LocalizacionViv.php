<?php

/**
 * This is the model class for table "localizacion_viv".
 *
 * The followings are the available columns in table 'localizacion_viv':
 * @property integer $id_loc_adol
 * @property string $num_doc
 * @property integer $id_estrato
 * @property string $id_municipio
 * @property integer $id_doc_familiar
 * @property integer $id_localidad
 * @property string $barrio
 * @property string $direccion
 *
 * The followings are the available model relations:
 * @property Estrato $idEstrato
 * @property Familiar $idDocFamiliar
 * @property Adolescente $numDoc
 * @property Localidad $idLocalidad
 * @property Municipio $idMunicipio
 */
class LocalizacionViv extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $mensajeErrorLoc;		/**< mensaje de error de la transacción. */
	public $mensajeErrorLocAcud;	/**< mensaje de error de la transacción. */
	public function tableName()
	{
		return 'localizacion_viv';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc,barrio','required'),
			array('id_estrato, id_doc_familiar, id_localidad', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('id_municipio', 'length', 'max'=>10),
			array('barrio', 'length', 'max'=>100),
			array('direccion', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_loc_adol, num_doc, id_estrato, id_municipio, id_doc_familiar, id_localidad, barrio, direccion', 'safe', 'on'=>'search'),
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
			'idEstrato' => array(self::BELONGS_TO, 'Estrato', 'id_estrato'),
			'idDocFamiliar' => array(self::BELONGS_TO, 'Familiar', 'id_doc_familiar'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idLocalidad' => array(self::BELONGS_TO, 'Localidad', 'id_localidad'),
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_loc_adol' => 'Localidad',
			'num_doc' => 'Documento del adolescente: ',
			'id_estrato' => 'Estrato',
			'id_municipio' => 'Municipio',
			'id_doc_familiar' => 'Documento Familiar',
			'id_localidad' => 'Localidad',
			'barrio' => 'Barrio',
			'direccion' => 'Dirección',
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

		$criteria->compare('id_loc_adol',$this->id_loc_adol);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_estrato',$this->id_estrato);
		$criteria->compare('id_municipio',$this->id_municipio,true);
		$criteria->compare('id_doc_familiar',$this->id_doc_familiar);
		$criteria->compare('id_localidad',$this->id_localidad);
		$criteria->compare('barrio',$this->barrio,true);
		$criteria->compare('direccion',$this->direccion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LocalizacionViv the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Crea registro de localización del adolescente.
	 * @param string $this->num_doc
	 * @param int $this->id_estrato
	 * @param int $municipio
	 * @param int $this->id_localidad
	 * @param string $this->barrio
	 * @param string $this->direccion
	 * @return $return resultado de transacción
	 */
	public function registraLocAdol(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->id_localidad))$this->id_localidad=null;
			if(empty($this->id_estrato))$this->id_estrato=null;
			$municipio='11001';
			if(empty($this->direccion))$this->direccion=null;
			$sqlCreaLoc="insert into localizacion_viv (
				id_loc_adol,
				num_doc,
				id_estrato,
				id_municipio,
				id_localidad,
				barrio,
				direccion
			)values(
				default,
				:numDoc,
				:idEstrato,
				:idMunicipio,
				:idLocalidad,
				:Barrio,
				:Direccion
			)";
			$creaLocAdol=$conect->createCommand($sqlCreaLoc);
			$creaLocAdol->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
			$creaLocAdol->bindParam(':idEstrato',$this->id_estrato);
			$creaLocAdol->bindParam(':idMunicipio',$municipio,PDO::PARAM_STR);
			$creaLocAdol->bindParam(':idLocalidad',$this->id_localidad);
			$creaLocAdol->bindParam(':Barrio',$this->barrio,PDO::PARAM_STR);
			$creaLocAdol->bindParam(':Direccion',$this->direccion);
			$creaLocAdol->execute();
			$transaction->commit();
			$this->mensajeErrorLoc=" ";
			return true;
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorLoc=$e;
			return false;
		}
	}
	/**
	 * Crea registro de localización del acudiente.
	 * @param int $id_doc_familiar
	 * @param int $this->id_estrato
	 * @param int $municipio
	 * @param int $this->id_localidad
	 * @param string $this->barrio
	 * @param string $this->direccion
	 * @return $return resultado de transacción
	 */
	public function registraLocAcudiente(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->id_localidad))$this->id_localidad=null;
			if(empty($this->id_estrato))$this->id_estrato=null;
			$municipio='11001';
			if(empty($this->direccion))$this->direccion=null;
			$sqlCreaLoc="insert into localizacion_viv (
				id_loc_adol,
				id_doc_familiar,
				id_estrato,
				id_municipio,
				id_localidad,
				barrio,
				direccion
			)values(
				default,
				:idDocFamiliar,
				:idEstrato,
				:idMunicipio,
				:idLocalidad,
				:Barrio,
				:Direccion
			)";
			$creaLocAdol=$conect->createCommand($sqlCreaLoc);
			$creaLocAdol->bindParam(':idDocFamiliar',$this->id_doc_familiar,PDO::PARAM_INT);
			$creaLocAdol->bindParam(':idEstrato',$this->id_estrato);
			$creaLocAdol->bindParam(':idMunicipio',$municipio,PDO::PARAM_STR);
			$creaLocAdol->bindParam(':idLocalidad',$this->id_localidad);
			$creaLocAdol->bindParam(':Barrio',$this->barrio,PDO::PARAM_STR);
			$creaLocAdol->bindParam(':Direccion',$this->direccion);
			$creaLocAdol->execute();
			$transaction->commit();
			$this->mensajeErrorLocAcud="";
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorLocAcud=$e;
		}
	}
	/**
	 *	Consulta la información de localización del adolescente.
	 *	@param string $this->num_doc
	 *	@return $resConsultaLocVivAdol documentos remitidos 
	 */		
	public function consultaLocVivadol($numDocAdol){
		$conect= Yii::app()->db;
		$sqlConsultaLocVivAdol="select * from localizacion_viv where num_doc=:numDoc";
		$queryConsultaLocVivAdol=$conect->createCommand($sqlConsultaLocVivAdol);
		$queryConsultaLocVivAdol->bindParam(':numDoc',$numDocAdol,PDO::PARAM_STR);
		$readConsultaLocVivAdol=$queryConsultaLocVivAdol->query();
		$resConsultaLocVivAdol=$readConsultaLocVivAdol->read();
		$readConsultaLocVivAdol->close();			
		return $resConsultaLocVivAdol;	
	}
	
	/**
	 *	Consulta la información de localización de acudiente.
	 *	@param int $idDocFam
	 *	@return $resConsultaLocVivAdol documentos remitidos 
	 */		
	public function consultaLocVivFam($idDocFam){
		$conect= Yii::app()->db;
		$sqlConsultaLocVivAcud="select * from localizacion_viv where id_doc_familiar=:idDocFam";
		$queryConsultaLocVivAcud=$conect->createCommand($sqlConsultaLocVivAcud);
		$queryConsultaLocVivAcud->bindParam(':idDocFam',$idDocFam,PDO::PARAM_INT);
		$readConsultaLocVivAcud=$queryConsultaLocVivAcud->query();
		$resConsultaLocVivAcud=$readConsultaLocVivAcud->read();
		$readConsultaLocVivAcud->close();			
		return $resConsultaLocVivAcud;	
	}	
	/**
	 * Modifica registro de localización del adolescente.
	 * @param string $this->num_doc
	 * @param int $this->id_estrato
	 * @param int $municipio
	 * @param int $this->id_localidad
	 * @param string $this->barrio
	 * @param string $this->direccion
	 * @return $return resultado de transacción
	 */
	public function modificaDatosLocAdol($nombreCampo,$nombreTabla,$datoAntiguo,$datoActual,$numDocAdol,$tipoDato){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$nombreCampo=htmlspecialchars(strip_tags(trim($nombreCampo)));
			$nombreTabla=htmlspecialchars(strip_tags(trim($nombreTabla)));
			$datoAntiguo=htmlspecialchars(strip_tags(trim($datoAntiguo)));
			//$datoActual=htmlspecialchars(strip_tags(trim($datoActual)));
			
			$sqlModDatos="update ".$nombreTabla." set ".$nombreCampo."=:datoActual where num_doc=:numDocAdol";
			$modDatos=$conect->createCommand($sqlModDatos);
			$modDatos->bindParam(':datoActual',$datoActual,$tipoDato);
			$modDatos->bindParam(':numDocAdol',$numDocAdol,PDO::PARAM_STR);
			$modDatos->execute();
			$transaction->commit();
			$this->mensajeErrorLocAcud="";
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorLocAcud.=$e;
		}
	}
	/**
	 * Crea registro de localización del acudiente.
	 * @param int $id_doc_familiar
	 * @param int $this->id_estrato
	 * @param int $municipio
	 * @param int $this->id_localidad
	 * @param string $this->barrio
	 * @param string $this->direccion
	 * @return $return resultado de transacción
	 */
	public function modificaDatosLocAcud($nombreCampo,$nombreTabla,$datoAntiguo,$datoActual,$idDocFam,$tipoDato){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$nombreCampo=htmlspecialchars(strip_tags(trim($nombreCampo)));
			$nombreTabla=htmlspecialchars(strip_tags(trim($nombreTabla)));
			$datoAntiguo=htmlspecialchars(strip_tags(trim($datoAntiguo)));
			//$datoActual=htmlspecialchars(strip_tags(trim($datoActual)));
			
			$sqlModDatos="update ".$nombreTabla." set ".$nombreCampo."=:datoActual where id_doc_familiar=:idDocFam";
			$modDatos=$conect->createCommand($sqlModDatos);
			$modDatos->bindParam(':datoActual',$datoActual,$tipoDato);
			$modDatos->bindParam(':idDocFam',$idDocFam,PDO::PARAM_STR);
			$modDatos->execute();
			$transaction->commit();
			$this->mensajeErrorLocAcud="";
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorLocAcud.=$e;
		}
	}
}
