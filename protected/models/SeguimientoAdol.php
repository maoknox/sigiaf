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
	public $idCedula;				/**< cédula del usuario registrado y quien va a realizar una acción en el módulo de referenciación  */
	public $fechaSegPE;				/**< fecha de seguimiento  del plan post egreso*/
	public $fecha_inicial;			/**< fecha inicial de informa de seguimiento  */
	public $fecha_fin;				/**< fecha final de informe de seguimiento  */
	public $seg_posegreso;			/**< el texto de seguimiento del post egreso  */
	public $seg_extraordinario;		/**< texto de seguimiento de seguimiento extraordinario */
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
			'fecha_registro_seg' => 'Fecha registro seguimiento',
			'id_seguimientoadol' => 'Seguimientoadol',
			'num_doc' => 'Número de documento',
			'id_area_seguimiento' => 'Área Seguimiento',
			'id_tipo_seguim' => 'Tipo Seguimiento',
			'seguimiento_adol' => 'Seguimiento',
			'seg_posegreso' => 'Seguimiento Post egreso',
			'seg_extraordinario' => 'Seguimiento Extraordinario',
			'seguim_conj' => 'Seguimiento en conjunción',
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
	
	/**
	 * 	registra el seguimiento general del adolescente, este seguimiento lo realizan todos los profesionales que tienen acceso al aplicativo exepto coordinación y administrativos. 
	 */
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
	/**
	 * 	consulta de seguimientos del proceso del adolescente que no son extraordinarios y no son de post egreso. 
	 */
	public function consSegAdol(){
		$conect=Yii::app()->db;
		$rolUsuario=Yii::app()->user->getState('rol');
		$consCedula=false;
		if($rolUsuario==4 || $rolUsuario==1 || $rolUsuario==5 ||$rolUsuario==6 ||$rolUsuario==18 ||$rolUsuario==7 ||$rolUsuario==18){
			$sqlConsSegAdol="select * from seguimiento_adol where num_doc=:num_doc and seg_posegreso='false' and seg_extraordinario='false' order by fecha_seguimiento desc";
		}
		else{
			$sqlConsSegAdol="select * from seguimiento_adol as a 
				left join persl_seg_adol as b on b.fecha_registro_seg=a.fecha_registro_seg 
				where num_doc=:num_doc and seg_posegreso='false' and seg_extraordinario='false' and id_cedula=:id_cedula  
				order by fecha_seguimiento desc";
			$consCedula=true;
		}
		$consSegAdol=$conect->createCommand($sqlConsSegAdol);
		$consSegAdol->bindParam("num_doc",$this->num_doc,PDO::PARAM_STR);
		if($consCedula==true){
			$consSegAdol->bindParam("id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
		}
		$readSegAdol=$consSegAdol->query();
		$resSegAdol=$readSegAdol->readAll();
		$readSegAdol->close();
		return $resSegAdol;		
	}
	/**
	 * 	Consulta el seguimiento a ser modificado. 
	 */
	public function consSegAdolMod(){
		$conect=Yii::app()->db;
		$sqlConsSegAdol="select * from seguimiento_adol where num_doc=:num_doc and id_seguimientoadol=:id_seguimientoadol and fecha_registro_seg=:fecha_registro_seg";
		$consSegAdol=$conect->createCommand($sqlConsSegAdol);
		$consSegAdol->bindParam("num_doc",$this->num_doc,PDO::PARAM_STR);
		$consSegAdol->bindParam("id_seguimientoadol",$this->id_seguimientoadol,PDO::PARAM_STR);
		$consSegAdol->bindParam("fecha_registro_seg",$this->fecha_registro_seg,PDO::PARAM_STR);
		$readSegAdol=$consSegAdol->query();
		$resSegAdol=$readSegAdol->read();
		$readSegAdol->close();
		return $resSegAdol;		
	}
	/**
	 * 	Modifica seguimiento seleccionado. 
	 */
	public function registraModSeguimiento(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlConsSegAdol="update seguimiento_adol set seguimiento_adol=:seguimiento_adol, fecha_seguimiento=:fecha_seguimiento where num_doc=:num_doc and id_seguimientoadol=:id_seguimientoadol and fecha_registro_seg=:fecha_registro_seg";
			$consSegAdol=$conect->createCommand($sqlConsSegAdol);
			$consSegAdol->bindParam("num_doc",$this->num_doc,PDO::PARAM_STR);
			$consSegAdol->bindParam("id_seguimientoadol",$this->id_seguimientoadol,PDO::PARAM_INT);
			$consSegAdol->bindParam("fecha_registro_seg",$this->fecha_registro_seg,PDO::PARAM_STR);
			$consSegAdol->bindParam("seguimiento_adol",$this->seguimiento_adol,PDO::PARAM_STR);
			$consSegAdol->bindParam("fecha_seguimiento",$this->fecha_seguimiento,PDO::PARAM_STR);
			$readSegAdol=$consSegAdol->execute();
			$transaction->commit();
			return "exito";		
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	/**
	 * 	consulta de seguimientos de post egreso del adolescente
	 */
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
	/**
	 * 	consulta el profesional autor del seguimiento del adolescente.
	 */
	public function consultaProfSeg($autorReg,$fechaReg,$idRegSeg){
		$autorReg=CHtml::encode($autorReg);
		$fechaReg=CHtml::encode($fechaReg);
		$idRegSeg=CHtml::encode($idRegSeg);
		$conect=Yii::app()->db;
		$sqlConsProfReg="select (nombre_personal||' '||apellidos_personal) as nombrespersonal,d.nombre_rol, b.id_cedula  from persl_seg_adol as a 
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
	/**
	 * consulta el profesional autor del seguimiento post egreso del adolescente.
	 */
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
	/**
	 * registra seguimiento post egreso.
	 */
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
			$regSeg->bindParam(":id_area_seguimiento",$this->id_area_seguimiento);
			$regSeg->bindParam(":id_tipo_seguim",$this->id_tipo_seguim);
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
	
	/**
	 * consulta seguimientos del adolescente según rangos de fecha.
	 */
	public function consultaSeguimiento(){
		$sqlConsSeg="select * from seguimiento_adol as a 
			left join tipo_seguimiento as b on b.id_tipo_seguim=a.id_tipo_seguim 
			where num_doc=:num_doc and fecha_seguimiento>:fecha_inicio and fecha_seguimiento<=:fecha_fin 
			and seg_posegreso=:seg_posegreso and seg_extraordinario=:seg_extraordinario order by fecha_seguimiento asc";
		$conect=Yii::app()->db;
		$consSeg=$conect->createCommand($sqlConsSeg);
		$consSeg->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consSeg->bindParam(":fecha_inicio",$this->fecha_inicial,PDO::PARAM_STR);
		$consSeg->bindParam(":fecha_fin",$this->fecha_fin,PDO::PARAM_STR);
		$consSeg->bindParam(":seg_posegreso",$this->seg_posegreso,PDO::PARAM_STR);
		$consSeg->bindParam(":seg_extraordinario",$this->seg_extraordinario,PDO::PARAM_STR);
		$readConsSeg=$consSeg->query();
		$resConsSeg=$readConsSeg->readAll();
		$readConsSeg->close();
		return $resConsSeg;		
	}
}
