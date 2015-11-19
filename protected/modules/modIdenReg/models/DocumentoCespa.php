<?php

/**
 * This is the model class for table "documento_cespa".
 *
 * The followings are the available columns in table 'documento_cespa':
 * @property integer $id_doccespa
 * @property string $doccespa
 *
 * The followings are the available model relations:
 * @property Adolescente[] $adolescentes
 */
class DocumentoCespa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $numDocAdol; /**< número de documento del adolescente. */
	public $mensajeErrorDocAdol; /**< mensaje de error de la transacción. */
	public function tableName()
	{
		return 'documento_cespa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_doccespa,numDocAdol', 'required'),
			//array('id_doccespa', 'numerical', 'integerOnly'=>true),
			//array('doccespa', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_doccespa, doccespa', 'safe', 'on'=>'search'),
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
			'adolescentes' => array(self::MANY_MANY, 'Adolescente', 'adol_doccespa(id_doccespa, num_doc)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_doccespa' => 'Lista de documentos: ',
			'doccespa' => 'Lista de documentos: ',
			'numDocAdol'=>'Documento del adolescente: '
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

		$criteria->compare('id_doccespa',$this->id_doccespa);
		$criteria->compare('doccespa',$this->doccespa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DocumentoCespa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 *	Crea registro de documentos del adolescente.
	 *	@param int id_doccespa.
	 *	@param string num_doc.
	 *	@param booleano doc_presentado.
	 *	@return resultado de la transacción
	 */		
	public function registraDocAdol($presentado,$documentoRevision){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegistraDoc="insert into adol_doccespa (
				num_doc,
				id_doccespa,
				doc_presentado
			) values (
				:numDoc,
				:idDocCespa,
				:docPresentado
			)";
			$registraDocAdol=$conect->createCommand($sqlRegistraDoc);
			$registraDocAdol->bindParam(':numDoc',$this->numDocAdol,PDO::PARAM_STR);
			$registraDocAdol->bindParam(':idDocCespa',$documentoRevision,PDO::PARAM_INT);
			$registraDocAdol->bindParam(':docPresentado',$presentado,PDO::PARAM_BOOL);
			$registraDocAdol->execute();
			$transaction->commit();
			$this->mensajeErrorDocAdol="";
			return "exito";
		}
		catch(CDbException  $e){
			$transaction->rollBack();
			$this->mensajeErrorDocAdol=$e;
			return "error";
		}
	}
	
	/**
	 *	Consulta los documentos remitidos por el cespa del adolescente.
	 *	@return $resDocsAdol documentos remitidos 
	 */		
	public function consDocAdolCespa($numDocAdol){
		$conect= Yii::app()->db;
		$sqlConsDocsAdol="select * from adol_doccespa as a left join documento_cespa as b on b.id_doccespa=a.id_doccespa where num_doc=:numdoc";
		$consultaDocsAdol=$conect->createCommand($sqlConsDocsAdol);
		$consultaDocsAdol->bindParam(':numdoc',$numDocAdol,PDO::PARAM_STR);
		$readDocsAdol=$consultaDocsAdol->query();
		$resDocsAdol=$readDocsAdol->readAll();
		$readDocsAdol->close();
		return $resDocsAdol;
	}
	
	/**
	 *	Modifica registro de documentos remitidos del cespa respecto a un adolescente.
	 *	@param int id_doccespa.
	 *	@param string num_doc.
	 *	@param booleano doc_presentado.
	 *	@return resultado de la transacción
	 */		
	public function modDocCespa($presentado,$documentoRevision){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModDocCespa="update adol_doccespa set doc_presentado=:docPresentado where num_doc=:numDoc and id_doccespa=:idDoccespa";
			$modDocCespa=$conect->createCommand($sqlModDocCespa);
			$modDocCespa->bindParam(':docPresentado',$presentado,PDO::PARAM_BOOL);
			$modDocCespa->bindParam(':idDoccespa',$documentoRevision,PDO::PARAM_INT);
			$modDocCespa->bindParam(':numDoc',$this->numDocAdol,PDO::PARAM_BOOL);
			$modDocCespa->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbException  $e){
			$transaction->rollBack();
			$this->mensajeErrorDocAdol=$e;
			return "error";
		}
		
	}
}
