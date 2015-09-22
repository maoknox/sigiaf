<?php

/**
 * This is the model class for table "familiar".
 *
 * The followings are the available columns in table 'familiar':
 * @property integer $id_doc_familiar
 * @property integer $id_tipo_doc
 * @property integer $id_parentesco
 * @property integer $id_nivel_educ
 * @property string $num_doc_fam
 * @property string $nombres_familiar
 * @property string $apellidos_familiar
 * @property string $edad_familiar
 * @property string $ocupacion_familiar
 *
 * The followings are the available model relations:
 * @property Adolescente[] $adolescentes
 * @property LocalizacionViv[] $localizacionVivs
 * @property NivelEducativo $idNivelEduc
 * @property Parentesco $idParentesco
 * @property TipoDocumento $idTipoDoc
 * @property Telefono[] $telefonos
 */
class Familiar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $num_docAdolFam;
	public $mensajeErrorAcud;
	public function tableName()
	{
		return 'familiar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombres_familiar,apellidos_familiar,id_tipo_doc,id_parentesco', 'required'),
			array('id_tipo_doc, id_parentesco, id_nivel_educ,id_doc_familiar', 'numerical', 'integerOnly'=>true),
			array('num_doc_fam', 'length', 'max'=>50),
			array('nombres_familiar, apellidos_familiar', 'length', 'max'=>100),
			array('num_docAdolFam', 'length', 'max'=>15),
			array('edad_familiar', 'length', 'max'=>3),
			array('ocupacion_familiar', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_doc_familiar, id_tipo_doc, id_parentesco, id_nivel_educ, num_doc_fam, nombres_familiar, apellidos_familiar, edad_familiar, ocupacion_familiar', 'safe', 'on'=>'search'),
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
			'adolescentes' => array(self::MANY_MANY, 'Adolescente', 'familiar_adolescente(id_doc_familiar, num_doc)'),
			'localizacionVivs' => array(self::HAS_MANY, 'LocalizacionViv', 'id_doc_familiar'),
			'idNivelEduc' => array(self::BELONGS_TO, 'NivelEducativo', 'id_nivel_educ'),
			'idParentesco' => array(self::BELONGS_TO, 'Parentesco', 'id_parentesco'),
			'idTipoDoc' => array(self::BELONGS_TO, 'TipoDocumento', 'id_tipo_doc'),
			'telefonos' => array(self::HAS_MANY, 'Telefono', 'id_doc_familiar'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_doc_familiar' => 'Documento del familiar',
			'id_tipo_doc' => 'Tipo de documento',
			'id_parentesco' => 'Parentesco',
			'id_nivel_educ' => 'Nivel Educativo',
			'num_doc_fam' => 'Número de documento',
			'nombres_familiar' => 'Nombres Familiar',
			'apellidos_familiar' => 'Apellidos Familiar',
			'edad_familiar' => 'Edad Familiar',
			'ocupacion_familiar' => 'Ocupacion Familiar',
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

		$criteria->compare('id_doc_familiar',$this->id_doc_familiar);
		$criteria->compare('id_tipo_doc',$this->id_tipo_doc);
		$criteria->compare('id_parentesco',$this->id_parentesco);
		$criteria->compare('id_nivel_educ',$this->id_nivel_educ);
		$criteria->compare('num_doc_fam',$this->num_doc_fam,true);
		$criteria->compare('nombres_familiar',$this->nombres_familiar,true);
		$criteria->compare('apellidos_familiar',$this->apellidos_familiar,true);
		$criteria->compare('edad_familiar',$this->edad_familiar,true);
		$criteria->compare('ocupacion_familiar',$this->ocupacion_familiar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Familiar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function registraAcudiente(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->num_doc_fam)){$this->num_doc_fam=null;}
			$municipio='11001';
			$sqlCreaAcud="insert into familiar (
				id_doc_familiar,
				id_tipo_doc,
				id_parentesco,
				num_doc_fam,
				nombres_familiar,
				apellidos_familiar
			)values(
				default,
				:idTipoDoc,
				:idParentesco,
				:numDocFam,
				:nombresFamiliar,
				:apellidosFamiliar
			) returning id_doc_familiar";
			$creaAcud=$conect->createCommand($sqlCreaAcud);
			$creaAcud->bindParam(':idTipoDoc',$this->id_tipo_doc,PDO::PARAM_INT);
			$creaAcud->bindParam(':idParentesco',$this->id_parentesco,PDO::PARAM_INT);
			$creaAcud->bindParam(':numDocFam',$this->num_doc_fam,PDO::PARAM_NULL);
			$creaAcud->bindParam(':nombresFamiliar',$this->nombres_familiar,PDO::PARAM_STR);
			$creaAcud->bindParam(':apellidosFamiliar',$this->apellidos_familiar,PDO::PARAM_STR);
			$read_IdFam=$creaAcud->query();
			$resIdFam=$read_IdFam->read();
			$this->id_doc_familiar=$resIdFam["id_doc_familiar"];
			$read_IdFam->close();
			$sqlRegistraAdolAcud="insert into familiar_adolescente (
				num_doc,
				id_doc_familiar,
				acudiente
			) values (
				:numDoc,
				:idDocFamiliar,
				:acudiente
			)";
			$acudiente=true;
			$registraAdolAcud=$conect->createCommand($sqlRegistraAdolAcud);
			$registraAdolAcud->bindParam(':numDoc',$this->num_docAdolFam,PDO::PARAM_STR);
			$registraAdolAcud->bindParam(':idDocFamiliar',$this->id_doc_familiar,PDO::PARAM_INT);
			$registraAdolAcud->bindParam(':acudiente',$acudiente,PDO::PARAM_BOOL);
			$registraAdolAcud->execute();
			$transaction->commit();
			$this->mensajeErrorAcud=" ";
			return true;
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorAcud=$e;
			return false;
		}
	}
	public function consultaAcudiente($numDocAdol){
		$conect= Yii::app()->db;
		$sqlConsFamiliar="select * from familiar_adolescente as a 
			left join familiar as b on a.id_doc_familiar=b.id_doc_familiar 
			where num_doc=:numDoc and acudiente='true'";
		$consFamiliar=$conect->createCommand($sqlConsFamiliar);
		$consFamiliar->bindParam(':numDoc',$numDocAdol,PDO::PARAM_STR);
		$readConsFamiliar=$consFamiliar->query();
		$resConsFamiliar=$readConsFamiliar->read();
		$readConsFamiliar->close();
		return $resConsFamiliar;
	}
	public function consultaFamiliar($idDocfam){
		$conect= Yii::app()->db;
		$sqlConsFamiliar="select * from familiar where id_doc_familiar=:idDocFam";
		$consFamiliar=$conect->createCommand($sqlConsFamiliar);
		$consFamiliar->bindParam(':idDocFam',$idDocfam,PDO::PARAM_INT);
		$readConsFamiliar=$consFamiliar->query();
		$resConsFamiliar=$readConsFamiliar->read();
		$readConsFamiliar->close();
		return $resConsFamiliar;
	}
	public function modificaDatosAcudiente($nombreCampo,$nombreTabla,$datoAntiguo,$datoActual,$idDocFam,$tipoDato){
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
			$modDatos->bindParam(':idDocFam',$idDocFam,PDO::PARAM_INT);
			$modDatos->execute();
			$transaction->commit();
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeError.=$e;
		}
	}
	public function consultaFamiliarAdol(){
		$conect= Yii::app()->db;
		$sqlConsFamiliar="select * from familiar_adolescente as a 
			left join familiar as b on a.id_doc_familiar=b.id_doc_familiar 
			where num_doc=:numDoc and otro_referente <> 'true'";
		$consFamiliar=$conect->createCommand($sqlConsFamiliar);
		$consFamiliar->bindParam(':numDoc',$this->num_docAdolFam,PDO::PARAM_STR);
		$readConsFamiliar=$consFamiliar->query();
		$resConsFamiliar=$readConsFamiliar->readAll();
		$readConsFamiliar->close();
		return $resConsFamiliar;
	}
	
	
	public function consultaOtrRef(){
		$conect= Yii::app()->db;
		$sqlConsOtrRef="select * from familiar_adolescente as a 
			left join familiar as b on a.id_doc_familiar=b.id_doc_familiar 
			where num_doc=:numDoc and otro_referente = 'true' ";
		$consOtrRef=$conect->createCommand($sqlConsOtrRef);
		$consOtrRef->bindParam(':numDoc',$this->num_docAdolFam,PDO::PARAM_STR);
		$readConsOtrRef=$consOtrRef->query();
		$resConsOtrRef=$readConsOtrRef->readAll();
		$readConsOtrRef->close();
		return $resConsOtrRef;
	}
	public function creaRegFamiliarAdol(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->num_doc_fam)){$this->num_doc_fam=null;}
			$municipio='11001';
			$sqlCreaAcud="insert into familiar (
				id_doc_familiar,
				id_tipo_doc,
				id_parentesco,
				num_doc_fam,
				nombres_familiar,
				apellidos_familiar
			)values(
				default,
				:idTipoDoc,
				:idParentesco,
				:numDocFam,
				:nombresFamiliar,
				:apellidosFamiliar
			) returning id_doc_familiar";
			$creaAcud=$conect->createCommand($sqlCreaAcud);
			$creaAcud->bindParam(':idTipoDoc',$this->id_tipo_doc,PDO::PARAM_INT);
			$creaAcud->bindParam(':idParentesco',$this->id_parentesco,PDO::PARAM_INT);
			$creaAcud->bindParam(':numDocFam',$this->num_doc_fam,PDO::PARAM_NULL);
			$creaAcud->bindParam(':nombresFamiliar',$this->nombres_familiar,PDO::PARAM_STR);
			$creaAcud->bindParam(':apellidosFamiliar',$this->apellidos_familiar,PDO::PARAM_STR);
			$read_IdFam=$creaAcud->query();
			$resIdFam=$read_IdFam->read();
			$this->id_doc_familiar=$resIdFam["id_doc_familiar"];
			$read_IdFam->close();
			$sqlRegistraAdolAcud="insert into familiar_adolescente (
				num_doc,
				id_doc_familiar,
				acudiente
			) values (
				:numDoc,
				:idDocFamiliar,
				:acudiente
			)";
			$acudiente="";
			$registraAdolAcud=$conect->createCommand($sqlRegistraAdolAcud);
			$registraAdolAcud->bindParam(':numDoc',$this->num_docAdolFam,PDO::PARAM_STR);
			$registraAdolAcud->bindParam(':idDocFamiliar',$this->id_doc_familiar,PDO::PARAM_INT);
			$registraAdolAcud->bindParam(':acudiente',$acudiente,PDO::PARAM_BOOL);
			$registraAdolAcud->execute();
			$transaction->commit();
			$this->mensajeErrorAcud=" ";
			return true;
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorAcud=$e;
			return false;
		}
	}
}
