<?php

/**
 * This is the model class for table "aspecto_valteo".
 *
 * The followings are the available columns in table 'aspecto_valteo':
 * @property integer $id_aspectovteo
 * @property integer $id_aspecto_perfoc
 * @property integer $id_valor_teo
 * @property string $observacion_aspecto
 * @property double $porcentaje_factor
 *
 * The followings are the available model relations:
 * @property AspectoPerfoc $idAspectoPerfoc
 * @property ValoracionTeo $idValorTeo
 * @property FactorVteo[] $factorVteos
 */
class AspectoValteo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'aspecto_valteo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_aspecto_perfoc, id_valor_teo', 'required'),
			array('id_aspecto_perfoc, id_valor_teo', 'numerical', 'integerOnly'=>true),
			array('porcentaje_factor', 'numerical'),
			array('observacion_aspecto', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_aspectovteo, id_aspecto_perfoc, id_valor_teo, observacion_aspecto, porcentaje_factor', 'safe', 'on'=>'search'),
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
			'idAspectoPerfoc' => array(self::BELONGS_TO, 'AspectoPerfoc', 'id_aspecto_perfoc'),
			'idValorTeo' => array(self::BELONGS_TO, 'ValoracionTeo', 'id_valor_teo'),
			'factorVteos' => array(self::HAS_MANY, 'FactorVteo', 'id_aspectovteo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_aspectovteo' => 'Aspecto valoración TO',
			'id_aspecto_perfoc' => 'Aspecto perfil ocupacional',
			'id_valor_teo' => 'Valoración terapia ocupacional',
			'observacion_aspecto' => 'Observaciónes',
			'porcentaje_factor' => 'Porcentaje Factor',
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

		$criteria->compare('id_aspectovteo',$this->id_aspectovteo);
		$criteria->compare('id_aspecto_perfoc',$this->id_aspecto_perfoc);
		$criteria->compare('id_valor_teo',$this->id_valor_teo);
		$criteria->compare('observacion_aspecto',$this->observacion_aspecto,true);
		$criteria->compare('porcentaje_factor',$this->porcentaje_factor);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AspectoValteo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 *	Consulta el ámbito aspecto para construir el perfil ocupacional del adolescente.
	 *
	 *	@param int $this->id_valor_teo
	 *	@return $resAspectoValTo 
	 */		
	public function consultaAspectosValTo(){
		$conect=Yii::app()->db;
		$sqlConsAspectoValTO="select * from aspecto_valteo as a, aspecto_perfoc as b 
			where a.id_valor_teo=:id_valor_teo and b.id_aspecto_perfoc=a.id_aspecto_perfoc order by b.id_aspecto_perfoc asc";
		$consAspectoValTO=$conect->createCommand($sqlConsAspectoValTO);
		$consAspectoValTO->bindParam(":id_valor_teo",$this->id_valor_teo);
		$readAspectoValTO=$consAspectoValTO->query();
		$resAspectoValTo=$readAspectoValTO->readAll();
		$readAspectoValTO->close();
		return $resAspectoValTo;			
	}
	
	/**
	 *	Consulta todos los aspectos para construir el perfil ocupacional del adolescente.
	 *
	 *	@param int $this->id_valor_teo
	 *	@param int $this->id_aspecto_perfoc
	 *	@return $resAspectoValTo 
	 */		
	public function consultaAspectoValTo(){
		$conect=Yii::app()->db;
		$sqlConsAspectoValTO="select * from aspecto_valteo 
			where id_valor_teo=:id_valor_teo and id_aspecto_perfoc=:id_aspecto_perfoc";
		$consAspectoValTO=$conect->createCommand($sqlConsAspectoValTO);
		$consAspectoValTO->bindParam(":id_valor_teo",$this->id_valor_teo);
		$consAspectoValTO->bindParam(":id_aspecto_perfoc",$this->id_aspecto_perfoc);
		$readAspectoValTO=$consAspectoValTO->query();
		$resAspectoValTo=$readAspectoValTO->read();
		$readAspectoValTO->close();
		return $resAspectoValTo;			
	}
	/**
	 *	Registra aspecto y factor por aspecto del perfil ocupacional del adolescente.
	 *
	 *	@param int $this->id_aspecto_perfoc
	 *	@param int $this->id_valor_teo
	 *	@param int $this->id_factorperfoc
	 *	@param int $this->id_aspectovteo
	 *	@return resultado de la transacción 
	 */		
	public function creaAspectoValTo(){		
		$conect=Yii::app()->db;
		$sqlConsAspectoPerfOc="select * from aspecto_perfoc order by id_aspecto_perfoc asc";
		$consAspectoPerfOc=$conect->createCommand($sqlConsAspectoPerfOc);
		$readAspectoPerfOc=$consAspectoPerfOc->query();
		$resAspectoPerfOc=$readAspectoPerfOc->readAll();
		$readAspectoPerfOc->close();
		if(!empty($resAspectoPerfOc)){
			foreach($resAspectoPerfOc as $aspectoPerfOc){
				$sqlCreaAspValTo="insert into aspecto_valteo (
					id_aspectovteo,
					id_aspecto_perfoc,
					id_valor_teo
				) 
				values (
					default,
					:id_aspecto_perfoc,
					:id_valor_teo
				) returning id_aspectovteo";
				$creaAspValTo=$conect->createCommand($sqlCreaAspValTo);
				$creaAspValTo->bindParam(":id_aspecto_perfoc",$aspectoPerfOc["id_aspecto_perfoc"],PDO::PARAM_INT);
				$creaAspValTo->bindParam(":id_valor_teo",$this->id_valor_teo,PDO::PARAM_INT);
				$readAspecto=$creaAspValTo->query();
				$resAspecto=$readAspecto->read();
				$readAspecto->close();
				//consulta factor perfil ocupacional.
				$sqlFactPerfOc="select * from factor_perfoc where id_aspecto_perfoc=:id_aspecto_perfoc";
				$consFactPerfOc=$conect->createCommand($sqlFactPerfOc);
				$consFactPerfOc->bindParam(":id_aspecto_perfoc",$aspectoPerfOc["id_aspecto_perfoc"],PDO::PARAM_INT);
				$readFactPerfOc=$consFactPerfOc->query();
				$resFactPerfOc=$readFactPerfOc->readAll();
				$readFactPerfOc->close();
				if(!empty($resFactPerfOc)){
					foreach($resFactPerfOc as $factorPerfOc){
						$sqlCreaFacPOc="insert into factor_vteo (
							id_factorvteo,
							id_factorperfoc,
							id_aspectovteo
						) 
						values (
							default,
							:id_factorperfoc,
							:id_aspectovteo
						)";
						$creaFacPOc=$conect->createCommand($sqlCreaFacPOc);
						$creaFacPOc->bindParam(":id_factorperfoc",$factorPerfOc["id_factorperfoc"],PDO::PARAM_INT);
						$creaFacPOc->bindParam(":id_aspectovteo",$resAspecto["id_aspectovteo"],PDO::PARAM_INT);
						$creaFacPOc->execute();
					}						
				}				
			}						
		}	
	}
	
	/**
	 *	Consulta los factores del aspecto del perfil ocupacional
	 *
	 *	@param int $this->id_aspectovteo
	 *	@return $resFactoVto 
	 */		
	public function consultaFactorVTO(){
		$conect=Yii::app()->db;
		$sqlFactorVto="select * from factor_vteo as a, factor_perfoc as b  
			where a.id_aspectovteo=:id_aspectovteo and b.id_factorperfoc=a.id_factorperfoc order by b.id_factorperfoc asc";
		$factoVto=$conect->createCommand($sqlFactorVto);
		$factoVto->bindParam(":id_aspectovteo",$this->id_aspectovteo);
		$readFactorVto=$factoVto->query();
		$resFactoVto=$readFactorVto->readAll();
		$readFactorVto->close();
		return $resFactoVto;
	}
	/**
	 *	Consulta los aspectos del perfil ocupacional
	 *
	 *	@param int $this->id_aspectovteo
	 *	@return $resAspectoPerfOc 
	 */		
	public function consultaAspectoPerfOc(){
		$conect=Yii::app()->db;
		$sqlAspectoPerfOc="select * from aspecto_perfoc order by id_aspecto_perfoc asc";
		$aspectoPerfOc=$conect->createCommand($sqlAspectoPerfOc);
		$readAspectoPerfOc=$aspectoPerfOc->query();
		$resAspectoPerfOc=$readAspectoPerfOc->readAll();
		$readAspectoPerfOc->close();
		return $resAspectoPerfOc;
	}
	/**
	 *	Consulta factor del perfilo ocupacional
	 *
	 *	@param int $this->id_aspectovteo
	 *	@return $resFactorPrAVto 
	 */		
	public function consultaFactorPerfOc(){
		$conect=Yii::app()->db;
		$sqlFactorPrAVto="select * from factor_perfoc where id_aspecto_perfoc=:id_aspecto_perfoc order by id_factorperfoc asc";
		$factorPrAVto=$conect->createCommand($sqlFactorPrAVto);
		$factorPrAVto->bindParam(":id_aspecto_perfoc",$this->id_aspecto_perfoc);
		$readFactorPrAVto=$factorPrAVto->query();
		$resFactorPrAVto=$readFactorPrAVto->readAll();
		$readFactorPrAVto->close();
		return $resFactorPrAVto;
	}
	/**
	 *	Consulta el grado del factor del perfil ocupacional
	 *
	 *	@param int $this->id_aspecto_perfoc
	 *	@return $resGradoFactor 
	 */		
	public function consultaGradoFactor(){
		$conect=Yii::app()->db;
		$sqlGradoFactor="select * from grado_factor order by id_gradofact asc";
		$gradoFactor=$conect->createCommand($sqlGradoFactor);
		$readGradoFactor=$gradoFactor->query();
		$resGradoFactor=$readGradoFactor->readAll();
		$readGradoFactor->close();
		return $resGradoFactor;		
	}
	/**
	 *	Modifica datos del perfil ocupacional del adolescente.
	 *
	 *	@param string $this->observacion_aspecto
	 *	@param int $this->porcentaje_factor
	 *	@param int $this->id_aspectovteo
	 *	@return resultado de la transacción
	 */		
	public function actDatosAspectoValTO(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlActAspValTo="update aspecto_valteo set observacion_aspecto=:observacion_aspecto, porcentaje_factor=:porcentaje_factor where id_aspectovteo=:id_aspectovteo";
			$actAspValT0=$conect->createCommand($sqlActAspValTo);
			$actAspValT0->bindParam(":observacion_aspecto",$this->observacion_aspecto,PDO::PARAM_STR);
			$actAspValT0->bindParam(":porcentaje_factor",$this->porcentaje_factor);
			$actAspValT0->bindParam(":id_aspectovteo",$this->id_aspectovteo,PDO::PARAM_INT);
			$actAspValT0->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
}
