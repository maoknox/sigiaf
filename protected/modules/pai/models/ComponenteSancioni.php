<?php

/**
 * This is the model class for table "componente_sancion".
 *
 * The followings are the available columns in table 'componente_sancion':
 * @property string $fecha_establec_compsanc
 * @property integer $id_inf_judicial
 * @property integer $id_pai
 * @property string $num_doc
 * @property string $objetivo_compsanc
 * @property string $actividades_compsanc
 * @property string $indicador_compsanc
 * @property string $responsable_compsancion
 * @property string $observ_compsancion
 *
 * The followings are the available model relations:
 * @property InformacionJudicial $idInfJudicial
 * @property Pai $idPai
 * @property Pai $numDoc
 * @property SeguimientoCompsancion[] $seguimientoCompsancions
 * @property SeguimientoCompsancion[] $seguimientoCompsancions1
 */
class ComponenteSancion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'componente_sancion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pai,id_inf_judicial', 'required'),
			array('id_inf_judicial, id_pai', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('objetivo_compsanc, actividades_compsanc, indicador_compsanc, responsable_compsancion, observ_compsancion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fecha_establec_compsanc, id_inf_judicial, id_pai, num_doc, objetivo_compsanc, actividades_compsanc, indicador_compsanc, responsable_compsancion, observ_compsancion', 'safe', 'on'=>'search'),
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
			'idInfJudicial' => array(self::BELONGS_TO, 'InformacionJudicial', 'id_inf_judicial'),
			'idPai' => array(self::BELONGS_TO, 'Pai', 'id_pai'),
			'numDoc' => array(self::BELONGS_TO, 'Pai', 'num_doc'),
			'seguimientoCompsancions' => array(self::HAS_MANY, 'SeguimientoCompsancion', 'id_inf_judicial'),
			'seguimientoCompsancions1' => array(self::HAS_MANY, 'SeguimientoCompsancion', 'fecha_establec_compsanc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fecha_establec_compsanc' => 'Fecha Establec Compsanc',
			'id_inf_judicial' => 'Id Inf Judicial',
			'id_pai' => 'Id Pai',
			'num_doc' => 'Num Doc',
			'objetivo_compsanc' => 'Objetivo Compsanc',
			'actividades_compsanc' => 'Actividades Compsanc',
			'indicador_compsanc' => 'Indicador Compsanc',
			'responsable_compsancion' => 'Responsable Compsancion',
			'observ_compsancion' => 'Observ Compsancion',
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

		$criteria->compare('fecha_establec_compsanc',$this->fecha_establec_compsanc,true);
		$criteria->compare('id_inf_judicial',$this->id_inf_judicial);
		$criteria->compare('id_pai',$this->id_pai);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('objetivo_compsanc',$this->objetivo_compsanc,true);
		$criteria->compare('actividades_compsanc',$this->actividades_compsanc,true);
		$criteria->compare('indicador_compsanc',$this->indicador_compsanc,true);
		$criteria->compare('responsable_compsancion',$this->responsable_compsancion,true);
		$criteria->compare('observ_compsancion',$this->observ_compsancion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ComponenteSancion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaPaiSanc($id_inf_judicial){
		$conect= Yii::app()->db;
		$sqlConsPaiSancAdol="select * from componente_sancion as a left join informacion_judicial as b on a.id_inf_judicial=b.id_inf_judicial 
			where a.id_inf_judicial=:id_inf_judicial order by fecha_establec_compsanc desc";
		$consPaiSancAdol=$conect->createCommand($sqlConsPaiSancAdol);
		$consPaiSancAdol->bindParam(":id_inf_judicial",$id_inf_judicial,PDO::PARAM_INT);
		$readConsPaiSancAdol=$consPaiSancAdol->query();
		$resConsPaiSancAdol=$readConsPaiSancAdol->read();
		$readConsPaiSancAdol->close();
		return $resConsPaiSancAdol;
	}
	public function consultaPaiSancAdol(){
		$conect= Yii::app()->db;
		$sqlConsPaiSancAdol="select * from componente_sancion where id_pai=:id_pai and id_inf_judicial=:id_inf_judicial order by fecha_establec_compsanc desc";
		$consPaiSancAdol=$conect->createCommand($sqlConsPaiSancAdol);
		$consPaiSancAdol->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
		$consPaiSancAdol->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
		$readConsPaiSancAdol=$consPaiSancAdol->query();
		$resConsPaiSancAdol=$readConsPaiSancAdol->read();
		$readConsPaiSancAdol->close();
		return $resConsPaiSancAdol;
	}
		public function creaSancionPai(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegistraSancPai="insert into componente_sancion (
				fecha_establec_compsanc,
				id_inf_judicial,
				id_pai,
				num_doc,
				objetivo_compsanc,
				actividades_compsanc,
				indicador_compsanc,
				responsable_compsancion
			) values (
				:fecha_establec_compsanc,
				:id_inf_judicial,
				:id_pai,
				:num_doc,
				:objetivo_compsanc,
				:actividades_compsanc,
				:indicador_compsanc,
				:responsable_compsancion
			)";
			$fechaRegSancion=date("Y-m-d H:i:s");
			if(empty($this->objetivo_compsanc)){$this->objetivo_compsanc=null;}
			if(empty($this->actividades_compsanc)){$this->actividades_compsanc=null;}
			if(empty($this->indicador_compsanc)){$this->indicador_compsanc=null;}
			if(empty($this->responsable_compsancion)){$this->responsable_compsancion=null;}
			$registraSancPai=$conect->createCommand($sqlRegistraSancPai);
			$registraSancPai->bindParam(":fecha_establec_compsanc",$fechaRegSancion,PDO::PARAM_STR);
			$registraSancPai->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
			$registraSancPai->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$registraSancPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$registraSancPai->bindParam(":objetivo_compsanc",$this->objetivo_compsanc,PDO::PARAM_NULL);
			$registraSancPai->bindParam(":actividades_compsanc",$this->actividades_compsanc,PDO::PARAM_NULL);
			$registraSancPai->bindParam(":indicador_compsanc",$this->indicador_compsanc,PDO::PARAM_NULL);
			$registraSancPai->bindParam(":responsable_compsancion",$this->responsable_compsancion,PDO::PARAM_NULL);
			$registraSancPai->execute();
			$transaction->commit();
			$this->fecha_establec_compsanc=$fechaRegSancion;
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function modificaRegPaiSanc($nombreCampo,$contenido){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		//echo $nombreCampo." ".$contenido." ".$this->fecha_estab_compderecho." ".$this->id_derechocespa." ".$this->id_pai;
		try{
			$sqlModifRegPai="update componente_sancion set ".$nombreCampo."=:contenido 
				where fecha_establec_compsanc=:fecha_establec_compsanc and id_inf_judicial=:id_inf_judicial and id_pai=:id_pai";
			$ModifRegPai=$conect->createCommand($sqlModifRegPai);
			$ModifRegPai->bindParam(":contenido",$contenido,PDO::PARAM_STR);
			$ModifRegPai->bindParam(":fecha_establec_compsanc",$this->fecha_establec_compsanc,PDO::PARAM_STR);
			$ModifRegPai->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
			$ModifRegPai->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
			$ModifRegPai->execute();
			$transaction->commit();
			return "exito";

		}catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function creaCompSancion(){
		//Consulta inicialmente si existe un componente de sanción con la información judicial suministrada
		$conect= Yii::app()->db;
		$sqlConsInJud="select * from componente_sancion where id_inf_judicial=:id_inf_judicial and num_doc=:num_doc";
		$consInfJud=$conect->createCommand($sqlConsInJud);
		$consInfJud->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
		$consInfJud->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readConsInfJud=$consInfJud->query();
		$resConsInfJud=$readConsInfJud->read();
		$readConsInfJud->close();
		//Si no existe crea el componente de información judicial	
		if(empty($resConsInfJud)){
			//fecha_establec_compsanc timestamp without time zone NOT NULL,
 // id_inf_judicial integer NOT NULL,
  //id_pai integer NOT NULL,
  			$transaction=$conect->beginTransaction();
			try{
				$sqlCreaCompSanc="insert into componente_sancion (
					fecha_establec_compsanc,
					id_inf_judicial,
					id_pai,
					num_doc
				) values (
					:fecha_establec_compsanc,
					:id_inf_judicial,
					:id_pai,
					:num_doc
				)";
				$this->fecha_establec_compsanc=date("Y-m-d H:i:s");	
				$creaCompSanc=$conect->createCommand($sqlCreaCompSanc);
				$creaCompSanc->bindParam(":fecha_establec_compsanc",$this->fecha_establec_compsanc,PDO::PARAM_STR);
				$creaCompSanc->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
				$creaCompSanc->bindParam(":id_pai",$this->id_pai,PDO::PARAM_INT);
				$creaCompSanc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
				$creaCompSanc->execute();
				$transaction->commit();
			}
			catch(CDbCommand $e){
				$transaction->rollBack();
			}
		}
		
	}
}
