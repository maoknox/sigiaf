<?php

/**
 * This is the model class for table "seguimiento_adol".
 *
 * The followings are the available columns in table 'seguimiento_adol':
 * @property string $fecha_registro_seg
 * @property integer $id_seguimientoadol
 * @property string $num_doc
 * @property integer $id_area_seguimiento
 * @property integer $id_tipo_seguim
 * @property string $seguimiento_adol
 * @property boolean $seg_posegreso
 * @property boolean $seg_extraordinario
 * @property boolean $seguim_conj
 * @property string $fecha_seguimiento
 *
 * The followings are the available model relations:
 * @property PerslSegAdol[] $perslSegAdols
 * @property PerslSegAdol[] $perslSegAdols1
 * @property Adolescente $numDoc
 * @property AreaDisciplina $idAreaSeguimiento
 * @property TipoSeguimiento $idTipoSeguim
 */
class SeguimientoAdol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $idCedula;
	public $fechaSegPE;
	public function tableName()
	{
		return 'seguimiento_adol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seguim_conj,num_doc,id_tipo_seguim, seguimiento_adol, fecha_seguimiento,id_area_seguimiento', 'required'),
			array('id_area_seguimiento, id_tipo_seguim', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('seg_extraordinario, seguim_conj', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fechaSegPE,fecha_registro_seg, id_seguimientoadol, num_doc, id_area_seguimiento, id_tipo_seguim, seguimiento_adol, seg_posegreso, seg_extraordinario, seguim_conj, fecha_seguimiento', 'safe', 'on'=>'search'),
			array('idCedula','validaSegConj'),
		);
	}
	
	public function validaSegConj($attribute=NULL,$params=NULL){
		
		if(isset($_POST["SeguimientoAdol"]["seguim_conj"]) && !empty($_POST["SeguimientoAdol"]["seguim_conj"])){
			if($_POST["SeguimientoAdol"]["seguim_conj"]!=1 && empty($_POST["SeguimientoAdol"]["idCedula"])){
				$this->addError($attribute,"Profesional no puede ser nulo");
			}
		}
					
	}

	//SeguimientoAdol_seguim_conj idCedula
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'perslSegAdols' => array(self::HAS_MANY, 'PerslSegAdol', 'id_seguimientoadol'),
			'perslSegAdols1' => array(self::HAS_MANY, 'PerslSegAdol', 'fecha_registro_seg'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idAreaSeguimiento' => array(self::BELONGS_TO, 'AreaDisciplina', 'id_area_seguimiento'),
			'idTipoSeguim' => array(self::BELONGS_TO, 'TipoSeguimiento', 'id_tipo_seguim'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fecha_registro_seg' => 'Fecha Registro Seg',
			'id_seguimientoadol' => 'Id Seguimientoadol',
			'num_doc' => 'Num Doc',
			'id_area_seguimiento' => 'Id Area Seguimiento',
			'id_tipo_seguim' => 'Id Tipo Seguim',
			'seguimiento_adol' => 'Seguimiento Adol',
			'seg_posegreso' => 'Seg Posegreso',
			'seg_extraordinario' => 'Seg Extraordinario',
			'seguim_conj' => 'Seguim Conj',
			'fecha_seguimiento' => 'Fecha Seguimiento',
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

		$criteria->compare('fecha_registro_seg',$this->fecha_registro_seg,true);
		$criteria->compare('id_seguimientoadol',$this->id_seguimientoadol);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_area_seguimiento',$this->id_area_seguimiento);
		$criteria->compare('id_tipo_seguim',$this->id_tipo_seguim);
		$criteria->compare('seguimiento_adol',$this->seguimiento_adol,true);
		$criteria->compare('seg_posegreso',$this->seg_posegreso);
		$criteria->compare('seg_extraordinario',$this->seg_extraordinario);
		$criteria->compare('seguim_conj',$this->seguim_conj);
		$criteria->compare('fecha_seguimiento',$this->fecha_seguimiento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoAdol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function registraSeguimiento(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegSeg="insert into seguimiento_adol (
				fecha_registro_seg,
				id_seguimientoadol,
				num_doc,
				id_area_seguimiento,
				id_tipo_seguim,
				seguimiento_adol,
				seg_posegreso,
				seg_extraordinario,
				seguim_conj,
				fecha_seguimiento
			) values (
				:fecha_registro_seg,
				default,
				:num_doc,
				:id_area_seguimiento,
				:id_tipo_seguim,
				:seguimiento_adol,
				'false',
				'false',
				:seguim_conj,
				:fecha_seguimiento
			) returning id_seguimientoadol";
			$fechaRegistro=date("Y-m-d H:i:s");
			$regSeg=$conect->createCommand($sqlRegSeg);
			$regSeg->bindParam(":fecha_registro_seg",$fechaRegistro,PDO::PARAM_STR);
			$regSeg->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regSeg->bindParam(":id_area_seguimiento",$this->id_area_seguimiento,PDO::PARAM_INT);
			$regSeg->bindParam(":id_tipo_seguim",$this->id_tipo_seguim,PDO::PARAM_INT);
			$regSeg->bindParam(":seguimiento_adol",$this->seguimiento_adol,PDO::PARAM_STR);
			$regSeg->bindParam(":seguim_conj",$this->seguim_conj,PDO::PARAM_BOOL);
			$regSeg->bindParam(":fecha_seguimiento",$this->fecha_seguimiento,PDO::PARAM_BOOL);
			$readSeg=$regSeg->query();
			$resSeg=$readSeg->read();
			$readSeg->close();
			$sqlRegProf="insert into persl_seg_adol (
				id_cedula,
				id_seguimientoadol,
				fecha_registro_seg,
				autor_registro
			) values (
				:id_cedula,
				:id_seguimientoadol,
				:fecha_registro_seg,
				'true'
			)";
			$regProf=$conect->createCommand($sqlRegProf);
			$regProf->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regProf->bindParam(":id_seguimientoadol",$resSeg["id_seguimientoadol"],PDO::PARAM_INT);
			$regProf->bindParam(":fecha_registro_seg",$fechaRegistro,PDO::PARAM_STR);
			$regProf->execute();
			if($this->seguim_conj=='true'){
				$sqlRegProf="insert into persl_seg_adol (
					id_cedula,
					id_seguimientoadol,
					fecha_registro_seg,
					autor_registro
				) values (
					:id_cedula,
					:id_seguimientoadol,
					:fecha_registro_seg,
					'false'
				)";
				$regProf=$conect->createCommand($sqlRegProf);
				$regProf->bindParam(":id_cedula",$this->idCedula,PDO::PARAM_INT);
				$regProf->bindParam(":id_seguimientoadol",$resSeg["id_seguimientoadol"],PDO::PARAM_INT);
				$regProf->bindParam(":fecha_registro_seg",$fechaRegistro,PDO::PARAM_STR);
				$regProf->execute();
			}
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function consSegAdol(){
		$conect=Yii::app()->db;
		$sqlConsSegAdol="select * from seguimiento_adol where num_doc=:num_doc and seg_posegreso='false' and seg_extraordinario='false'";
		$consSegAdol=$conect->createCommand($sqlConsSegAdol);
		$consSegAdol->bindParam("num_doc",$this->num_doc,PDO::PARAM_STR);
		$readSegAdol=$consSegAdol->query();
		$resSegAdol=$readSegAdol->readAll();
		$readSegAdol->close();
		return $resSegAdol;		
	}
	public function consSegAdolPosEgreso(){
		$conect=Yii::app()->db;
		$sqlConsSegAdol="select * from seguimiento_adol where num_doc=:num_doc and seg_posegreso='true'";
		$consSegAdol=$conect->createCommand($sqlConsSegAdol);
		$consSegAdol->bindParam("num_doc",$this->num_doc,PDO::PARAM_STR);
		$readSegAdol=$consSegAdol->query();
		$resSegAdol=$readSegAdol->readAll();
		$readSegAdol->close();
		return $resSegAdol;		
	}
	public function consultaProfSeg($autorReg,$fechaReg,$idRegSeg){
		$autorReg=CHtml::encode($autorReg);
		$fechaReg=CHtml::encode($fechaReg);
		$idRegSeg=CHtml::encode($idRegSeg);
		$conect=Yii::app()->db;
		$sqlConsProfReg="select (nombre_personal||' '||apellidos_personal) as nombrespersonal,d.nombre_rol  from persl_seg_adol as a 
		left join persona as b on b.id_cedula=a.id_cedula 
		left join usuario as c on c.id_cedula=b.id_cedula 
		left join rol as d on d.id_rol=c.id_rol 
		where id_seguimientoadol=:id_seguimientoadol and fecha_registro_seg=:fecha_registro_seg and autor_registro=:autor_registro";
		$consProfReg=$conect->createCommand($sqlConsProfReg);
		$consProfReg->bindParam(":id_seguimientoadol",$idRegSeg,PDO::PARAM_INT);
		$consProfReg->bindParam(":fecha_registro_seg",$fechaReg,PDO::PARAM_STR);
		$consProfReg->bindParam(":autor_registro",$autorReg,PDO::PARAM_BOOL);
		$readConsProfReg=$consProfReg->query();
		$resConsProfReg=$readConsProfReg->read();
		$readConsProfReg->close();
		return $resConsProfReg;
	}
	public function consultaProfSegPE($autorReg,$fechaReg,$idRegSeg){
		$autorReg=CHtml::encode($autorReg);
		$fechaReg=CHtml::encode($fechaReg);
		$idRegSeg=CHtml::encode($idRegSeg);
		$conect=Yii::app()->db;
		$sqlConsProfReg="select (nombre_personal||' '||apellidos_personal) as nombrespersonal,d.nombre_rol  from persl_seg_adol as a 
		left join persona as b on b.id_cedula=a.id_cedula 
		left join usuario as c on c.id_cedula=b.id_cedula 
		left join rol as d on d.id_rol=c.id_rol 
		where id_seguimientoadol=:id_seguimientoadol and fecha_registro_seg=:fecha_registro_seg and autor_registro=:autor_registro";
		$consProfReg=$conect->createCommand($sqlConsProfReg);
		$consProfReg->bindParam(":id_seguimientoadol",$idRegSeg,PDO::PARAM_INT);
		$consProfReg->bindParam(":fecha_registro_seg",$fechaReg,PDO::PARAM_STR);
		$consProfReg->bindParam(":autor_registro",$autorReg,PDO::PARAM_BOOL);
		$readConsProfReg=$consProfReg->query();
		$resConsProfReg=$readConsProfReg->read();
		$readConsProfReg->close();
		return $resConsProfReg;
	}
	public function registraSeguimientoPe(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegSeg="insert into seguimiento_adol (
				fecha_registro_seg,
				id_seguimientoadol,
				num_doc,
				id_area_seguimiento,
				id_tipo_seguim,
				seguimiento_adol,
				seg_posegreso,
				seg_extraordinario,
				seguim_conj,
				fecha_seguimiento
			) values (
				:fecha_registro_seg,
				default,
				:num_doc,
				:id_area_seguimiento,
				:id_tipo_seguim,
				:seguimiento_adol,
				'true',
				'false',
				:seguim_conj,
				:fecha_seguimiento
			) returning id_seguimientoadol";
			$fechaRegistro=date("Y-m-d H:i:s");
			$this->id_area_seguimiento=null;
			$this->id_tipo_seguim=null;
			$regSeg=$conect->createCommand($sqlRegSeg);
			$regSeg->bindParam(":fecha_registro_seg",$fechaRegistro,PDO::PARAM_STR);
			$regSeg->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regSeg->bindParam(":id_area_seguimiento",$this->id_area_seguimiento,PDO::PARAM_NULL);
			$regSeg->bindParam(":id_tipo_seguim",$this->id_tipo_seguim,PDO::PARAM_NULL);
			$regSeg->bindParam(":seguimiento_adol",$this->seguimiento_adol,PDO::PARAM_STR);
			$regSeg->bindParam(":seguim_conj",$this->seguim_conj,PDO::PARAM_BOOL);
			$regSeg->bindParam(":fecha_seguimiento",$this->fecha_seguimiento,PDO::PARAM_BOOL);
			$readSeg=$regSeg->query();
			$resSeg=$readSeg->read();
			$readSeg->close();
			$sqlRegProf="insert into persl_seg_adol (
				id_cedula,
				id_seguimientoadol,
				fecha_registro_seg,
				autor_registro
			) values (
				:id_cedula,
				:id_seguimientoadol,
				:fecha_registro_seg,
				'true'
			)";
			$regProf=$conect->createCommand($sqlRegProf);
			$regProf->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regProf->bindParam(":id_seguimientoadol",$resSeg["id_seguimientoadol"],PDO::PARAM_INT);
			$regProf->bindParam(":fecha_registro_seg",$fechaRegistro,PDO::PARAM_STR);
			$regProf->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}	
}
