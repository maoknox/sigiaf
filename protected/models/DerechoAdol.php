<?php

/**
 * This is the model class for table "derecho_adol".
 *
 * The followings are the available columns in table 'derecho_adol':
 * @property integer $id_derecho_adol
 * @property integer $id_derechocespa
 * @property integer $id_instanciader
 * @property string $num_doc
 * @property integer $id_momento_verif
 * @property boolean $estado_derecho
 * @property string $observaciones_derecho
 * @property string $fecha_reg_derecho
 *
 * The followings are the available model relations:
 * @property AlternativasParticipacion[] $alternativasParticipacions
 * @property SituacionesRiesgo[] $situacionesRiesgos
 * @property Adolescente $numDoc
 * @property InstanciaDerecho $idInstanciader
 * @property Derechocespa $idDerechocespa
 * @property MomentoVerificacion $idMomentoVerif
 */
class DerechoAdol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $atributos;			/**< array de propiedades de cada uno de los 5 derechos  */
	public $msnErrorDerecho="";	/**< almacena mensaje de error. */

	public function tableName()
	{
		return 'derecho_adol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_instanciader, num_doc, estado_derecho, fecha_reg_derecho', 'required'),
			array('id_instanciader, id_momento_verif', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('observaciones_derecho', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_derecho_adol, id_derechocespa, id_instanciader, num_doc, id_momento_verif, estado_derecho, observaciones_derecho, fecha_reg_derecho', 'safe', 'on'=>'search'),
			array('situacionesRiesgos','validaSitRiesgo'),
			//array('id_derechocespa','validaSitRiesgo'),
			array('alternativasParticipacions','validaParticipacion'),
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
			'alternativasParticipacions' => array(self::MANY_MANY, 'AlternativasParticipacion', 'alternativa_derecho(id_derecho_adol, id_alternativaproc)'),
			'situacionesRiesgos' => array(self::MANY_MANY, 'SituacionesRiesgo', 'situaciones_riesg_derecho(id_derecho_adol, id_sit_riesgo)'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idInstanciader' => array(self::BELONGS_TO, 'InstanciaDerecho', 'id_instanciader'),
			'idDerechocespa' => array(self::BELONGS_TO, 'Derechocespa', 'id_derechocespa'),
			'idMomentoVerif' => array(self::BELONGS_TO, 'MomentoVerificacion', 'id_momento_verif'),
		);
	}
	
	/**
	 * 	Valida si selecciona que tiene relacionado una situación de riesgos, debe relacionar a qué tipo de riesgos esta expuesto.
	 */	
	public function validaSitRiesgo($attribute=null,$params=null){
		if(isset($_POST["DerechoAdol"]["id_derechocespa"]) && !empty($_POST["DerechoAdol"]["id_derechocespa"])){
			$derechoCesp=$this->model()->findBySql("select * from derechocespa where derechocespa like '%Protecc%'");
			if(in_array($derechoCesp->id_derechocespa,$_POST["DerechoAdol"]["id_derechocespa"])){
				if(!isset($_POST["DerechoAdol"]["situacionesRiesgos"]) || empty($_POST["DerechoAdol"]["situacionesRiesgos"])){
					$this->addError($attribute,"Debe seleccionar un una situación de riesgo");
				}
			}
			
		}
	}
	
	/**
	 * Valida si selecciona que realiza participaciones en la comunidad, debe relacionar qué tipo de participaciones.
	 */	
	public function validaParticipacion($attribute=null,$params=null){
		if(isset($_POST["DerechoAdol"]["id_derechocespa"]) && !empty($_POST["DerechoAdol"]["id_derechocespa"])){
			$participCesp=$this->model()->findBySql("select * from derechocespa where derechocespa like '%Particip%'");
			if(in_array($participCesp->id_derechocespa,$_POST["DerechoAdol"]["id_derechocespa"])){
				if(!isset($_POST["DerechoAdol"]["alternativasParticipacions"]) || empty($_POST["DerechoAdol"]["alternativasParticipacions"])){
					$this->addError($attribute,"Debe seleccionar una alternativa de participación");
				}
			}
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_derecho_adol' => 'Derecho',
			'id_derechocespa' => 'Derecho',
			'id_instanciader' => 'Instancia de verificación',
			'num_doc' => 'Documento del adolescente:',
			'id_momento_verif' => 'Momento de verificación',
			'estado_derecho' => 'Estado Derecho',
			'observaciones_derecho' => 'Observaciones Derecho',
			'fecha_reg_derecho' => 'Fecha Registro',
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

		$criteria->compare('id_derecho_adol',$this->id_derecho_adol);
		$criteria->compare('id_derechocespa',$this->id_derechocespa);
		$criteria->compare('id_instanciader',$this->id_instanciader);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_momento_verif',$this->id_momento_verif);
		$criteria->compare('estado_derecho',$this->estado_derecho);
		$criteria->compare('observaciones_derecho',$this->observaciones_derecho,true);
		$criteria->compare('fecha_reg_derecho',$this->fecha_reg_derecho,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DerechoAdol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	*	registra la verificación de derechos del adolescente 
	*	es relacionado un array con 5 derechos, 
	*	cada uno de ellos tiene asociado el tipo de derecho, 
	*	número de documento del adolescente
	*	momento en que se realza la verificación de derechos
	*	si tiene relacionado ese derecho
	*	observaciones del derecho
	*/	
	public function registraDerechos(){
		$derechoProt=$this->model()->findBySql("select * from derechocespa where derechocespa like '%Protecc%'");
		$derechoPart=$this->model()->findBySql("select * from derechocespa where derechocespa like '%Particip%'");
		$derechoCespa=$this->model()->findAllBySql("select * from derechocespa order by id_derechocespa asc");
		$conect= Yii::app()->db;
		$cumple=false;
		foreach($derechoCespa as $pk=>$derechosAdol){
			if(!empty($this->atributos["id_derechocespa"])&& is_array($this->atributos["id_derechocespa"])){	
				foreach($this->atributos["id_derechocespa"] as $derecho){
					if( $derechosAdol->id_derechocespa==$derecho){
						$cumple=true;
					}
				}
			}
			$transaction=$conect->beginTransaction();
			try{
				$sqlRegistraDerecho="insert into derecho_adol (
					id_derecho_adol,
					id_derechocespa,
					estado_derecho,
					id_instanciader,
					id_momento_verif,
					num_doc,
					observaciones_derecho,
					fecha_reg_derecho
				)
				values (
					default,
					:idDerechocespa,
					:estadoDerecho,
					:idInstanciaderecho,
					:id_momento_verif,
					:numDoc,
					:observDerecho,
					:fechaRegDerecho					
				) returning id_derecho_adol";
				$observacionesDer=htmlspecialchars(strip_tags(trim($this->atributos["observaciones_derecho_".$derechosAdol->id_derechocespa])));
				if(empty($observacionesDer)){$observacionesDer=null;}
				$fechaRegistro=date("Y-m-d");
				$registraDerecho=$conect->createCommand($sqlRegistraDerecho);
				$registraDerecho->bindParam(":idDerechocespa",$derechosAdol->id_derechocespa,PDO::PARAM_INT);
				$registraDerecho->bindParam(":estadoDerecho",$cumple,PDO::PARAM_BOOL);
				$registraDerecho->bindParam(":idInstanciaderecho",$this->atributos["id_instanciader"],PDO::PARAM_INT);
				$registraDerecho->bindParam(":id_momento_verif",$this->id_momento_verif,PDO::PARAM_INT);
				$registraDerecho->bindParam(":numDoc",$this->atributos["num_doc"],PDO::PARAM_STR);								
				$registraDerecho->bindParam(":observDerecho",$observacionesDer);
				$registraDerecho->bindParam(":fechaRegDerecho",$fechaRegistro,PDO::PARAM_STR);
				$readIdDerecho=$registraDerecho->query();
				$resIdDerecho=$readIdDerecho->read();
				$readIdDerecho->close();
				if($derechosAdol->id_derechocespa==$derechoProt->id_derechocespa && $cumple==true){
					foreach($this->atributos["situacionesRiesgos"] as $sitRiesgo){
						$sqlRegistraSitRiesgo="insert into situaciones_riesg_derecho (
							id_sit_riesgo,
							id_derecho_adol
						) values (
							:idSitRiesgo,
							:idDerechoAdol
						)";
						$registraSitRiesgo=$conect->createCommand($sqlRegistraSitRiesgo);
						$registraSitRiesgo->bindParam(':idSitRiesgo', $sitRiesgo,PDO::PARAM_INT);
						$registraSitRiesgo->bindParam(':idDerechoAdol', $resIdDerecho["id_derecho_adol"],PDO::PARAM_INT);
						$registraSitRiesgo->execute();
					}
				}
				if($derechosAdol->id_derechocespa==$derechoPart->id_derechocespa && $cumple==true){
					foreach($this->atributos["alternativasParticipacions"] as $altPart){
						$sqlRegistraAltPart="insert into alternativa_derecho (
							id_alternativaproc,
							id_derecho_adol
						) values (
							:idAlternativaproc,
							:idDerechoAdol
						)";
						$registraAltPart=$conect->createCommand($sqlRegistraAltPart);
						$registraAltPart->bindParam(':idAlternativaproc', $altPart,PDO::PARAM_INT);
						$registraAltPart->bindParam(':idDerechoAdol', $resIdDerecho["id_derecho_adol"],PDO::PARAM_INT);
						$registraAltPart->execute();
					}
				}
				$cumple=false;
				$transaction->commit();
			}
			catch(CDbException $e){
				$transaction->rollBack();
				$this->msnErrorDerecho.=$e;
				return "error";
			}
		}
		return "exito";
	}
	
	/**
	 * consulta la verificación de derechos del adolescente.
	 */	
	public function consultaDerechos(){
		$conect= Yii::app()->db;
		$sqlConsDerecho="select * from derecho_adol as a 
			left join derechocespa as b on a.id_derechocespa=b.id_derechocespa 
			where num_doc=:numDoc and id_instanciader=:id_instanciader and id_momento_verif=:id_momento_verif order by a.id_derechocespa asc";
		$consDerecho=$conect->createCommand($sqlConsDerecho);
		$consDerecho->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
		$consDerecho->bindParam(':id_instanciader',$this->id_instanciader,PDO::PARAM_INT);
		$consDerecho->bindParam(':id_momento_verif',$this->id_momento_verif,PDO::PARAM_INT);
		$readDerecho=$consDerecho->query();
		$resDerecho=$readDerecho->readAll();
		$readDerecho->close();
		return $resDerecho;
	}
	
	/**
	 * consulta los riesgos a los que se enfrenta el adolescente según la verifiación de derechos.
	 */	
	public function consultaProteccion($idDerecho){
		$conect= Yii::app()->db;
		$sqlConsRiesgo="select * from situaciones_riesg_derecho 
			where id_derecho_adol=:idDerechoAdol order by id_sit_riesgo asc";
		$consConsRiesgo=$conect->createCommand($sqlConsRiesgo);
		$consConsRiesgo->bindParam(':idDerechoAdol',$idDerecho,PDO::PARAM_INT);
		$readConsRiesgo=$consConsRiesgo->query();
		$resConsRiesgo=$readConsRiesgo->readAll();
		$readConsRiesgo->close();
		return $resConsRiesgo;		
	}
	
	/**
	 * consulta los tipos de participación del adolescente en su entorno.
	 */	
	public function consultaParticipacion($idDerecho){
		$conect= Yii::app()->db;
		$sqlConsPart="select * from alternativa_derecho 
			where id_derecho_adol=:idDerechoAdol order by id_alternativaproc asc";
		$consPart=$conect->createCommand($sqlConsPart);
		$consPart->bindParam(':idDerechoAdol',$idDerecho,PDO::PARAM_INT);
		$readPart=$consPart->query();
		$resPart=$readPart->readAll();
		$readPart->close();
		return $resPart;	
	}

	/**
	*	modifica la verificación de derechos del adolescente 
	*	es relacionado un array con 5 derechos, 
	*	cada uno de ellos tiene asociado el tipo de derecho, 
	*	número de documento del adolescente
	*	momento en que se realza la verificación de derechos
	*	si tiene relacionado ese derecho
	*	observaciones del derecho
	*/	
	public function modVerifDerAdol(){
		$derechoProt=$this->model()->findBySql("select * from derechocespa where derechocespa like '%Protecc%'");
		$derechoPart=$this->model()->findBySql("select * from derechocespa where derechocespa like '%Particip%'");
		$derechoCespa=$this->model()->findAllBySql("select * from derechocespa order by id_derechocespa asc");
		$conect= Yii::app()->db;
		foreach($derechoCespa as $pk=>$derechosAdol){
			$cumple=false;
			foreach($this->atributos["id_derechocespa"] as $derecho){
				if( $derechosAdol->id_derechocespa==$derecho){
					$cumple=true;
				}
			}
			//echo $derechosAdol->id_derechocespa."-".$cumple." ";
			//$transaction=$conect->beginTransaction();
			try{
				$sqlRegistraDerecho="update derecho_adol set estado_derecho=:estadoDerecho, observaciones_derecho=:observDerecho 
					where num_doc=:numDoc and id_derechocespa=:idDerechocespa and id_instanciader=:idInstanciaderecho and id_momento_verif=:id_momento_verif returning id_derecho_adol";
				$observacionesDer=$this->atributos["observaciones_derecho_".$derechosAdol->id_derechocespa];
				if(empty($observacionesDer)){$observacionesDer=null;}
				//$fechaRegistro=date("Y-m-d");
				$registraDerecho=$conect->createCommand($sqlRegistraDerecho);
				$registraDerecho->bindParam(":idDerechocespa",$derechosAdol->id_derechocespa,PDO::PARAM_INT);
				$registraDerecho->bindParam(":estadoDerecho",$cumple,PDO::PARAM_BOOL);
				$registraDerecho->bindParam(":idInstanciaderecho",$this->atributos["id_instanciader"],PDO::PARAM_INT);
				$registraDerecho->bindParam(":numDoc",$this->atributos["num_doc"],PDO::PARAM_STR);
				$registraDerecho->bindParam(":observDerecho",$observacionesDer);
				$registraDerecho->bindParam(":id_momento_verif",$this->id_momento_verif);
				//$registraDerecho->bindParam(":fechaRegDerecho",$fechaRegistro,PDO::PARAM_STR);
				$readIdDerecho=$registraDerecho->query();
				$resIdDerecho=$readIdDerecho->read();
				$readIdDerecho->close();
				if($derechosAdol->id_derechocespa==$derechoProt->id_derechocespa){
					$sqlDelRiesgo="delete from situaciones_riesg_derecho where id_derecho_adol=:idDerechoAdol";
					$delRiesgo=$conect->createCommand($sqlDelRiesgo);
					$delRiesgo->bindParam(':idDerechoAdol', $resIdDerecho["id_derecho_adol"],PDO::PARAM_INT);
					$delRiesgo->execute();
					if($cumple){
						foreach($this->atributos["situacionesRiesgos"] as $sitRiesgo){
							$sqlRegistraSitRiesgo="insert into situaciones_riesg_derecho (
								id_sit_riesgo,
								id_derecho_adol
							) values (
								:idSitRiesgo,
								:idDerechoAdol
							)";
							$registraSitRiesgo=$conect->createCommand($sqlRegistraSitRiesgo);
							$registraSitRiesgo->bindParam(':idSitRiesgo', $sitRiesgo,PDO::PARAM_INT);
							$registraSitRiesgo->bindParam(':idDerechoAdol', $resIdDerecho["id_derecho_adol"],PDO::PARAM_INT);
							$registraSitRiesgo->execute();
						}
					}
				}
				if($derechosAdol->id_derechocespa==$derechoPart->id_derechocespa){
					$sqlDelPart="delete from alternativa_derecho where id_derecho_adol=:idDerechoAdol";
					$delPart=$conect->createCommand($sqlDelPart);
					$delPart->bindParam(':idDerechoAdol', $resIdDerecho["id_derecho_adol"],PDO::PARAM_INT);
					$delPart->execute();
					if($cumple){
						foreach($this->atributos["alternativasParticipacions"] as $altPart){
							$sqlRegistraAltPart="insert into alternativa_derecho (
								id_alternativaproc,
								id_derecho_adol
							) values (
								:idAlternativaproc,
								:idDerechoAdol
							)";
							$registraAltPart=$conect->createCommand($sqlRegistraAltPart);
							$registraAltPart->bindParam(':idAlternativaproc', $altPart,PDO::PARAM_INT);
							$registraAltPart->bindParam(':idDerechoAdol', $resIdDerecho["id_derecho_adol"],PDO::PARAM_INT);
							$registraAltPart->execute();
						}
					}
				}
				//$transaction->commit();
			}
			catch(CDbException $e){
				//$transaction->rollBack();
				$this->msnErrorDerecho.=$e;
				return "error";
			}
		}
		return "exito";		
	}
}
