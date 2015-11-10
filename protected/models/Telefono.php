<?php

/**
 * This is the model class for table "telefono".
 *
 * The followings are the available columns in table 'telefono':
 * @property integer $id_telefono
 * @property integer $id_doc_familiar
 * @property integer $id_tipo_telefono
 * @property string $num_doc
 * @property string $telefono
 *
 * The followings are the available model relations:
 * @property Adolescente $numDoc
 * @property Familiar $idDocFamiliar
 * @property TipoTelefono $idTipoTelefono
 */
class Telefono extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $tel_sec;//Teléfono secundario
	public $celular;//Número de celular del adolescente
	public $mensajeErrorTel;
	public function tableName()
	{
		return 'telefono';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('telefono', 'required'),
			array('id_doc_familiar, id_tipo_telefono', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('telefono,tel_sec,celular', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_telefono, id_doc_familiar, id_tipo_telefono, num_doc, telefono', 'safe', 'on'=>'search'),
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
			'idDocFamiliar' => array(self::BELONGS_TO, 'Familiar', 'id_doc_familiar'),
			'idTipoTelefono' => array(self::BELONGS_TO, 'TipoTelefono', 'id_tipo_telefono'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_telefono' => 'Teléfono',
			'id_doc_familiar' => 'Documento Familiar',
			'id_tipo_telefono' => 'Tipo Teléfono',
			'num_doc' => 'Número documento adolescente',
			'telefono' => 'Teléfono',
			'tel_sec'=>'Teléfono secundario'
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

		$criteria->compare('id_telefono',$this->id_telefono);
		$criteria->compare('id_doc_familiar',$this->id_doc_familiar);
		$criteria->compare('id_tipo_telefono',$this->id_tipo_telefono);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('telefono',$this->telefono,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Telefono the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function registraTelefono($tipoTelefono,$numeroTelefono){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegistraTelefono="insert into telefono (
				id_telefono,
				id_tipo_telefono,
				num_doc,
				telefono
			) values (
				default,
				:idTipoTelefono,
				:numDoc,
				:numTelefono
			)";
			$registraTelefono=$conect->createCommand($sqlRegistraTelefono);
			$registraTelefono->bindParam(':idTipoTelefono',$tipoTelefono,PDO::PARAM_INT);
			$registraTelefono->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
			$registraTelefono->bindParam(':numTelefono',$numeroTelefono,PDO::PARAM_STR);
			$registraTelefono->execute();
			$transaction->commit();
			$this->mensajeErrorTel="";
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorTel=$e;
		}
	}
	public function registraTelefonoAcud($tipoTelefono,$numeroTelefono){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegistraTelefono="insert into telefono (
				id_telefono,
				id_tipo_telefono,
				id_doc_familiar,
				telefono
			) values (
				default,
				:idTipoTelefono,
				:idDocFamiliar,
				:numTelefono
			)";
			$registraTelefono=$conect->createCommand($sqlRegistraTelefono);
			$registraTelefono->bindParam(':idTipoTelefono',$tipoTelefono,PDO::PARAM_INT);
			$registraTelefono->bindParam(':idDocFamiliar',$this->id_doc_familiar,PDO::PARAM_INT);
			$registraTelefono->bindParam(':numTelefono',$numeroTelefono,PDO::PARAM_STR);
			$registraTelefono->execute();
			$transaction->commit();
			$this->mensajeErrorTel='exito';
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorTel=$e;
		}
	}
	
	public function consultaTelefono($numDocAdol){
		$conect= Yii::app()->db;
		$sqlConsultaTelefono="select * from telefono as a left join tipo_telefono as b on a.id_tipo_telefono=b.id_tipo_telefono where num_doc=:numDoc";
		$queryConsultaTelefono=$conect->createCommand($sqlConsultaTelefono);
		$queryConsultaTelefono->bindParam(':numDoc',$numDocAdol,PDO::PARAM_STR);
		$readConsultaTelefono=$queryConsultaTelefono->query();
		$resConsultaTelefono=$readConsultaTelefono->readAll();
		$readConsultaTelefono->close();			
		return $resConsultaTelefono;
	}
	public function consultaTelefonosAcud($idDocFam){
		$conect= Yii::app()->db;
		$sqlConsultaTelefono="select * from telefono as a left join tipo_telefono as b on a.id_tipo_telefono=b.id_tipo_telefono where id_doc_familiar=:idDocFam";
		$queryConsultaTelefono=$conect->createCommand($sqlConsultaTelefono);
		$queryConsultaTelefono->bindParam(':idDocFam',$idDocFam,PDO::PARAM_INT);
		$readConsultaTelefono=$queryConsultaTelefono->query();
		$resConsultaTelefono=$readConsultaTelefono->readAll();
		$readConsultaTelefono->close();			
		return $resConsultaTelefono;
	}
	public function consultaTelefonoAdol($numDocAdol,$tipoTelefono){
		$conect= Yii::app()->db;
		$sqlConsultaTelefono="select * from telefono as a 
			left join tipo_telefono as b on a.id_tipo_telefono=b.id_tipo_telefono 
			where num_doc=:numDoc and a.id_tipo_telefono=:idTipoTelefono";
		$queryConsultaTelefono=$conect->createCommand($sqlConsultaTelefono);
		$queryConsultaTelefono->bindParam(':numDoc',$numDocAdol,PDO::PARAM_STR);
		$queryConsultaTelefono->bindParam(':idTipoTelefono',$tipoTelefono,PDO::PARAM_INT);
		$readConsultaTelefono=$queryConsultaTelefono->query();
		$resConsultaTelefono=$readConsultaTelefono->read();
		$readConsultaTelefono->close();			
		return $resConsultaTelefono;
	}
	public function consultaTelefonoAcud($idAcud,$tipoTelefono){
		$conect= Yii::app()->db;
		$sqlConsultaTelefono="select * from telefono as a 
			left join tipo_telefono as b on a.id_tipo_telefono=b.id_tipo_telefono 
			where id_doc_familiar=:idDocFam and a.id_tipo_telefono=:idTipoTelefono";
		$queryConsultaTelefono=$conect->createCommand($sqlConsultaTelefono);
		$queryConsultaTelefono->bindParam(':idDocFam',$idAcud,PDO::PARAM_STR);
		$queryConsultaTelefono->bindParam(':idTipoTelefono',$tipoTelefono,PDO::PARAM_INT);
		$readConsultaTelefono=$queryConsultaTelefono->query();
		$resConsultaTelefono=$readConsultaTelefono->read();
		$readConsultaTelefono->close();			
		return $resConsultaTelefono;
	}
	public function modificaDatosTelAdolMany($nombreCampo,$nombreTabla,$datoAntiguo,$datoActual,$camposComp,$tipoDato){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$nombreCampo=htmlspecialchars(strip_tags(trim($nombreCampo)));
			$nombreTabla=htmlspecialchars(strip_tags(trim($nombreTabla)));
			$datoAntiguo=htmlspecialchars(strip_tags(trim($datoAntiguo)));
			$datoActual=htmlspecialchars(strip_tags(trim($datoActual)));
			$sqlModDatos="update ".$nombreTabla." set ".$nombreCampo."=:datoActual where ";
			foreach($camposComp as $pk=>$campoComp){
				
				if($pk==0){
					$sqlModDatos.= $campoComp["id_campo"]."=:".$campoComp["id_campo"]." ";
				}
				else{
					$sqlModDatos.= "and ".$campoComp["id_campo"]."=:".$campoComp["id_campo"]." ";
				}
			}
			$modDatos=$conect->createCommand($sqlModDatos);
			$modDatos->bindParam(':datoActual',$datoActual,$tipoDato);
			foreach($camposComp as $campoComp){
				$modDatos->bindParam(':'.$campoComp["id_campo"].'',$campoComp["contenido"],$campoComp["tipoDato"]);
			}		
			$modDatos->execute();
			$transaction->commit();
			$this->mensajeErrorTel="exito";
		}		
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorTel.=$e;
		}
	}
}
