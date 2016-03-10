<?php

/**
 * This is the model class for table "referenciacion_adol".
 *
 * The followings are the available columns in table 'referenciacion_adol':
 * @property integer $id_referenciacion
 * @property integer $id_esp_sol
 * @property integer $id_beneficiario
 * @property string $num_doc
 * @property integer $id_motivonovinc
 * @property integer $id_tipo_referenciacion
 * @property integer $id_esp_soliii
 * @property integer $id_esp_solii
 * @property integer $id_estadoref
 * @property string $fecha_referenciacion
 * @property string $fecha_gestion
 * @property string $institucion_ref
 * @property string $resultado_gestion
 * @property string $observaciones_refer
 * @property integer $satisfactoriedad_gestion
 * @property integer $satisfactoriedad_vinculacion
 * @property boolean $culminacion_refer
 * @property integer $estado_sol_refer
 *
 * The followings are the available model relations:
 * @property EstadoSolicitud[] $estadoSolicituds
 * @property FamiliarBeneficiario[] $familiarBeneficiarios
 * @property SeguimientoRefer[] $seguimientoRefers
 * @property Beneficiarios $idBeneficiario
 * @property EspSolNiii $idEspSoliii
 * @property EspSolNii $idEspSolii
 * @property EspSolNi $idEspSol
 * @property EstadoReferenciacion $idEstadoref
 * @property MotivoNovinculacion $idMotivonovinc
 * @property Adolescente $numDoc
 * @property Tiporeferenciacion $idTipoReferenciacion
 */
class ReferenciacionAdol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $mensajeRef="exito";	/**< mensaje de resultado de transacción, por defecto exito  */
	public $numDocRef;			/**< número de documento del adolescente  */
	public $idRef;				/**< identificación de la referenciación  */
	public function tableName()
	{
		return 'referenciacion_adol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_referenciacion,num_doc,id_tipo_referenciacion, id_estadoref, fecha_referenciacion,id_esp_sol,id_beneficiario,observaciones_refer', 'required'),
			array('id_esp_sol, id_beneficiario, id_motivonovinc, id_tipo_referenciacion, id_esp_soliii, id_esp_solii, id_estadoref, satisfactoriedad_gestion, satisfactoriedad_vinculacion, estado_sol_refer,id_cedula', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('institucion_ref', 'length', 'max'=>500),
			array('fecha_gestion, resultado_gestion, observaciones_refer, culminacion_refer', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_referenciacion, id_esp_sol, id_beneficiario, num_doc, id_motivonovinc, id_tipo_referenciacion, id_esp_soliii, id_esp_solii, id_estadoref, fecha_referenciacion, fecha_gestion, institucion_ref, resultado_gestion, observaciones_refer, satisfactoriedad_gestion, satisfactoriedad_vinculacion, culminacion_refer, estado_sol_refer,id_cedula', 'safe', 'on'=>'search'),
			array('id_esp_solii','validaNEspii'),
			array('id_esp_soliii','validaNespiii'),
			
		);
	}
	/**
	 * 	valida si al momento de crear una solicitud de referenciación selecciona un nivel de especificación i.
	 */
	public function validaNEspii($attribute=null,$params=null){
		$datosInput=Yii::app()->input->post();
		$espNi=$datosInput["ReferenciacionAdol"]["id_esp_sol"];
		if(isset($datosInput["ReferenciacionAdol"]["id_esp_sol"]) && !empty($datosInput["ReferenciacionAdol"]["id_esp_sol"])){
			$consGen=new ConsultasGenerales();
			$consEspNii=$consGen->consultaNivelEspii($datosInput["ReferenciacionAdol"]["id_esp_sol"]);
			if(!empty($consEspNii) && isset($datosInput["ReferenciacionAdol"]["id_esp_solii"]) && empty($datosInput["ReferenciacionAdol"]["id_esp_solii"])){
				$this->addError($attribute,"Debe seleccionar una especificación de nivel II");		
			}
		}
	}
	/**
	 * 	valida si al momento de crear una solicitud de referenciación selecciona un nivel de especificación ii en el caso que haya un listado dependiente de especificación de nivel i.
	 */
	public function validaNEspiii($attribute=null,$params=null){
		$datosInput=Yii::app()->input->post();
		if(isset($datosInput["ReferenciacionAdol"]["id_esp_solii"]) && !empty($datosInput["ReferenciacionAdol"]["id_esp_solii"])){
			$consGen=new ConsultasGenerales();
			$consEsp=$consGen->consultaNivelEspiii($datosInput["ReferenciacionAdol"]["id_esp_solii"]);
			if(!empty($consEsp) && isset($datosInput["ReferenciacionAdol"]["id_esp_soliii"]) && empty($datosInput["ReferenciacionAdol"]["id_esp_soliii"])){
				$this->addError($attribute,"Debe seleccionar una especificación de nivel II");		
			}
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'estadoSolicituds' => array(self::HAS_MANY, 'EstadoSolicitud', 'id_referenciacion'),
			'familiarBeneficiarios' => array(self::HAS_MANY, 'FamiliarBeneficiario', 'id_referenciacion'),
			'seguimientoRefers' => array(self::HAS_MANY, 'SeguimientoRefer', 'id_referenciacion'),
			'idBeneficiario' => array(self::BELONGS_TO, 'Beneficiarios', 'id_beneficiario'),
			'idEspSoliii' => array(self::BELONGS_TO, 'EspSolNiii', 'id_esp_soliii'),
			'idEspSolii' => array(self::BELONGS_TO, 'EspSolNii', 'id_esp_solii'),
			'idEspSol' => array(self::BELONGS_TO, 'EspSolNi', 'id_esp_sol'),
			'idEstadoref' => array(self::BELONGS_TO, 'EstadoReferenciacion', 'id_estadoref'),
			'idMotivonovinc' => array(self::BELONGS_TO, 'MotivoNovinculacion', 'id_motivonovinc'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idTipoReferenciacion' => array(self::BELONGS_TO, 'Tiporeferenciacion', 'id_tipo_referenciacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_referenciacion' => 'Referenciacion No.',
			'id_cedula'=>'Cédula del Profesional',
			'id_esp_sol' => 'Especificación de nivel I',
			'id_beneficiario' => 'Beneficiario',
			'num_doc' => 'Num Doc',
			'id_motivonovinc' => 'Id Motivonovinc',
			'id_tipo_referenciacion' => 'Líneas de acción',
			'id_esp_soliii' => 'Especificación de nivel III',
			'id_esp_solii' => 'Especificación de nivel II',
			'id_estadoref' => 'Estado de la referenciación',
			'fecha_referenciacion' => 'Fecha de la referenciacion',
			'fecha_gestion' => 'Fecha de la gestión',
			'institucion_ref' => 'Lugar al que referencia',
			'resultado_gestion' => 'Resultado Gestion',
			'observaciones_refer' => 'Motivo/Observaciones de la referenciación',
			'satisfactoriedad_gestion' => 'Satisfactoriedad Gestión',
			'satisfactoriedad_vinculacion' => 'Satisfactoriedad Vinculacóon',
			'culminacion_refer' => 'Culminación de la referenciación',
			'estado_sol_refer' => 'Estado de la solicitud',
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

		//$criteria->compare('id_referenciacion',$this->id_referenciacion);
		$criteria->compare('id_esp_sol',$this->id_esp_sol);
		$criteria->compare('id_cedula',$this->id_cedula);
		$criteria->compare('id_beneficiario',$this->id_beneficiario);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_motivonovinc',$this->id_motivonovinc);
		$criteria->compare('id_tipo_referenciacion',$this->id_tipo_referenciacion);
		$criteria->compare('id_esp_soliii',$this->id_esp_soliii);
		$criteria->compare('id_esp_solii',$this->id_esp_solii);
		$criteria->compare('id_estadoref',$this->id_estadoref);
		$criteria->compare('fecha_referenciacion',$this->fecha_referenciacion,true);
		$criteria->compare('fecha_gestion',$this->fecha_gestion,true);
		$criteria->compare('institucion_ref',$this->institucion_ref,true);
		$criteria->compare('resultado_gestion',$this->resultado_gestion,true);
		$criteria->compare('observaciones_refer',$this->observaciones_refer,true);
		$criteria->compare('satisfactoriedad_gestion',$this->satisfactoriedad_gestion);
		$criteria->compare('satisfactoriedad_vinculacion',$this->satisfactoriedad_vinculacion);
		$criteria->compare('culminacion_refer',$this->culminacion_refer);
		$criteria->compare('estado_sol_refer',$this->estado_sol_refer);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
                    'pageSize' => 20,
                )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReferenciacionAdol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * 	consulta referenciación según especificación de nivel 1 y según si la referenciación esta en solicitud o en trámite.
	 */
	public function consultaSolRefNi(){
		$conect= Yii::app()->db;
		$sqlConsSolRef="select * from referenciacion_adol as a left join estado_referenciacion as b on b.id_estadoref=a.id_estadoref
			where num_doc=:numDoc and id_esp_sol=:idEspN and a.id_estadoref=1 or num_doc=:numDoc and id_esp_sol=:idEspN and a.id_estadoref=2";
		$conSolRef=$conect->createCommand($sqlConsSolRef);
		$conSolRef->bindParam('numDoc',$this->num_doc,PDO::PARAM_STR);
		$conSolRef->bindParam('idEspN',$this->id_esp_sol,PDO::PARAM_INT);
		$readSolRef=$conSolRef->query();
		$resConsRef=$readSolRef->read();
		$readSolRef->close();
		return $resConsRef;
	}
	/**
	 * 	consulta referenciación según especificación de nivel 2 y según si la referenciación esta en solicitud o en trámite.
	 */
	public function consultaSolRefNii(){
		$conect= Yii::app()->db;
		$sqlConsSolRef="select * from referenciacion_adol as a left join estado_referenciacion as b on b.id_estadoref=a.id_estadoref
			where num_doc=:numDoc and id_esp_solii=:idEspN and a.id_estadoref=1 or num_doc=:numDoc and id_esp_solii=:idEspN and a.id_estadoref=2";
		$conSolRef=$conect->createCommand($sqlConsSolRef);
		$conSolRef->bindParam('numDoc',$this->num_doc,PDO::PARAM_STR);
		$conSolRef->bindParam('idEspN',$this->id_esp_solii,PDO::PARAM_INT);
		$readSolRef=$conSolRef->query();
		$resConsRef=$readSolRef->read();
		$readSolRef->close();
		return $resConsRef;
	}
	/**
	 * 	consulta referenciación según especificación de nivel 3 y según si la referenciación esta en solicitud o en trámite.
	 */
	public function consultaSolRefNiii(){
		$conect= Yii::app()->db;
		$sqlConsSolRef="select * from referenciacion_adol as a left join estado_referenciacion as b on b.id_estadoref=a.id_estadoref
			where num_doc=:numDoc and id_esp_soliii=:idEspN and a.id_estadoref=1 or num_doc=:numDoc and id_esp_soliii=:idEspN and a.id_estadoref=2";
		$conSolRef=$conect->createCommand($sqlConsSolRef);
		$conSolRef->bindParam('numDoc',$this->num_doc,PDO::PARAM_STR);
		$conSolRef->bindParam('idEspN',$this->id_esp_soliii,PDO::PARAM_INT);
		$readSolRef=$conSolRef->query();
		$resConsRef=$readSolRef->read();
		$readSolRef->close();
		return $resConsRef;
	}
	/**
	 * 	se crea el registro de referenciación 
	 */
	public function creaRegRef(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaRef="insert into referenciacion_adol(
				id_referenciacion,
				id_esp_sol,
				id_cedula,
				id_beneficiario,
				num_doc,
				id_tipo_referenciacion,
				id_esp_soliii,
				id_esp_solii,
				id_estadoref,
				fecha_referenciacion,
				institucion_ref,
				observaciones_refer,
				estado_sol_refer				
			) values (
				default,
				:id_esp_sol,
				:id_cedula,
				:id_beneficiario,
				:num_doc,
				:id_tipo_referenciacion,
				:id_esp_soliii,
				:id_esp_solii,
				:id_estadoref,
				:fecha_referenciacion,
				:institucion_ref,
				:observaciones_refer,
				:estado_sol_refer
				
			) returning id_referenciacion";
			if(empty($this->id_esp_soliii)){$this->id_esp_soliii=null;}
			if(empty($this->id_esp_solii)){$this->id_esp_solii=null;}
			if(empty($this->institucion_ref)){$this->institucion_ref=null;}
			if(empty($this->observaciones_refer)){$this->observaciones_refer=null;}
			$creaRef=$conect->createCommand($sqlCreaRef);
			$creaRef->bindParam(':id_esp_sol',$this->id_esp_sol,PDO::PARAM_INT);
			$creaRef->bindParam(':id_cedula',Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$creaRef->bindParam(':id_beneficiario',$this->id_beneficiario,PDO::PARAM_INT);
			$creaRef->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
			$creaRef->bindParam(':id_tipo_referenciacion',$this->id_tipo_referenciacion,PDO::PARAM_INT);
			$creaRef->bindParam(':id_esp_soliii',$this->id_esp_soliii);
			$creaRef->bindParam(':id_esp_solii',$this->id_esp_solii);
			$creaRef->bindParam(':id_estadoref',$this->id_estadoref,PDO::PARAM_INT);
			$creaRef->bindParam(':fecha_referenciacion',$this->fecha_referenciacion,PDO::PARAM_STR);
			$creaRef->bindParam(':institucion_ref',$this->institucion_ref,PDO::PARAM_STR);
			$creaRef->bindParam(':observaciones_refer',$this->observaciones_refer,PDO::PARAM_STR);
			$creaRef->bindParam(':estado_sol_refer',$this->estado_sol_refer,PDO::PARAM_INT);
			$readCreaRef=$creaRef->query();
			$resCreaRef=$readCreaRef->read();
			$transaction->commit();
			$readCreaRef->close();
			return $resCreaRef["id_referenciacion"];
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			$this->mensajeRef=$e;
			return 0;
		}		
	}
	/**
	 * 	consulta las referenciaciones creadas de un adolesacente en específico.
	 */
	public function consultaRefMod($offset){
		$conect=Yii::app()->db;
		$sqlConsRefMod="select a.id_referenciacion,a.fecha_referenciacion,b.tipo_referenciacion,c.esp_sol,d.esp_solii,e.esp_soliii,h.beneficiario from referenciacion_adol as a 
			left join tiporeferenciacion as b on a.id_tipo_referenciacion=b.id_tipo_referenciacion 
			left join esp_sol_ni as c on c.id_esp_sol=a.id_esp_sol 
			left join esp_sol_nii as d on d.id_esp_solii=a.id_esp_solii 
			left join esp_sol_niii as e on e.id_esp_soliii=a.id_esp_soliii 
			left join familiar_beneficiario as f on f.id_referenciacion=a.id_referenciacion 
			left join estado_referenciacion as g on g.id_estadoref=a.id_estadoref 
			left join beneficiarios as h on h.id_beneficiario=a.id_beneficiario
			where num_doc=:num_doc and a.id_estadoref=1 or num_doc=:num_doc and a.id_estadoref=2 order by fecha_referenciacion desc limit 5 offset :offset";
		$consRefMod=$conect->createCommand($sqlConsRefMod);
		$consRefMod->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consRefMod->bindParam(":offset",$offset,PDO::PARAM_STR);
		$readRefMod=$consRefMod->query();
		$resRefMod=$readRefMod->readAll();
		$readRefMod->close();
		return $resRefMod;
	}
	/**
	 * 	consulta la información de una referenciación en específico.
	 */
	public function consultaRefModAdol(){
		$conect=Yii::app()->db;
		$sqlConsRef="select * from referenciacion_adol where id_referenciacion=:id_referenciacion";
		$consRef=$conect->createCommand($sqlConsRef);
		$consRef->bindParam(':id_referenciacion',$this->id_referenciacion,PDO::PARAM_INT);
		$readConsRef=$consRef->query();
		$resConsRef=$readConsRef->read();
		$readConsRef->close();
		return $resConsRef;
	}
	/**
	 * 	consulta toda la información relacionada y registrada de una referenciación.
	 */
	public function consultaRefSeg($offset){
		$conect=Yii::app()->db;
		$sqlConsRefMod="select a.id_referenciacion,a.fecha_referenciacion,b.tipo_referenciacion,c.esp_sol,d.esp_solii,e.esp_soliii,h.beneficiario from referenciacion_adol as a 
			left join tiporeferenciacion as b on a.id_tipo_referenciacion=b.id_tipo_referenciacion 
			left join esp_sol_ni as c on c.id_esp_sol=a.id_esp_sol 
			left join esp_sol_nii as d on d.id_esp_solii=a.id_esp_solii 
			left join esp_sol_niii as e on e.id_esp_soliii=a.id_esp_soliii 
			left join familiar_beneficiario as f on f.id_referenciacion=a.id_referenciacion 
			left join estado_referenciacion as g on g.id_estadoref=a.id_estadoref 
			left join beneficiarios as h on h.id_beneficiario=a.id_beneficiario
			where num_doc=:num_doc order by fecha_referenciacion desc limit 5 offset :offset";
		$consRefMod=$conect->createCommand($sqlConsRefMod);
		$consRefMod->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consRefMod->bindParam(":offset",$offset,PDO::PARAM_STR);
		$readRefMod=$consRefMod->query();
		$resRefMod=$readRefMod->readAll();
		$readRefMod->close();
		return $resRefMod;
	}
	/**
	 * 	modifica el estado de la referenciación, si está en trámite, si es gestión efectiva o no efectiva.
	 */
	public function modificaEstadoRef(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModEstRef="update referenciacion_adol set id_estadoref=:id_estadoref where id_referenciacion=:id_referenciacion";
			$modEstRef=$conect->createCommand($sqlModEstRef);
			$modEstRef->bindParam(':id_estadoref',$this->id_estadoref,PDO::PARAM_INT);
			$modEstRef->bindParam(':id_referenciacion',$this->id_referenciacion,PDO::PARAM_INT);
			$modEstRef->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	/**
	 * 	Consulta los adolescentes que tienen registros de referenciación.
	 */
	public function consultaReferenciados(){
		$conect=Yii::app()->db;
		$sqlConsRef="select distinct(a.num_doc),(apellido_1 || ' ' || apellido_2) as apellidos,nombres from referenciacion_adol as a 
			left join forjar_adol as b on a.num_doc=b.num_doc 
			left join adolescente as c on b.num_doc=c.num_doc 
			where b.id_forjar=:id_forjar";
		$consRef=$conect->createCommand($sqlConsRef);
		$consRef->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'),PDO::PARAM_INT);
		$readRef=$consRef->query();
		$resRef=$readRef->readAll();
		$readRef->close();
		return $resRef;
	}
	/**
	 * 	Consulta las referenciaciones que tiene asociado el adolescente.
	 */
	public function consultaReferenciacionAdol(){
		$conect=Yii::app()->db;
		$sqlConsRef="select * from referenciacion_adol where num_doc=:num_doc";
		$consRef=$conect->CreateCommand($sqlConsRef);
		$consRef->bindParam(":num_doc",$this->numDocRef,PDO::PARAM_STR);
		$readRef=$consRef->query();
		$resRef=$readRef->readAll();
		$readRef->close();
		return $resRef;
	}
	/**
	 * 	consulta la información de la referenciación según el id de referenciación
	 */
	public function consultaReferenciacion(){
		$conect=Yii::app()->db;
		$sqlConsRef="select * from referenciacion_adol as a 
			left join tiporeferenciacion as b on a.id_tipo_referenciacion=b.id_tipo_referenciacion 
			left join esp_sol_ni as c on a.id_esp_sol=c.id_esp_sol
			left join esp_sol_nii as d on a.id_esp_solii=d.id_esp_solii
			left join esp_sol_niii as e on a.id_esp_soliii=e.id_esp_soliii
			left join persona as f on a.id_cedula=f.id_cedula
			left join estado_referenciacion as g on a.id_estadoref=g.id_estadoref
			left join beneficiarios as h on h.id_beneficiario=a.id_beneficiario
			where a.id_referenciacion=:id_referenciacion";
		$consRef=$conect->CreateCommand($sqlConsRef);
		$consRef->bindParam(":id_referenciacion",$this->idRef,PDO::PARAM_INT);
		$readRef=$consRef->query();
		$resRef=$readRef->read();
		$readRef->close();
		return $resRef;
	}
	/**
	 * 	consulta las solicitudes de referenciación realizadas.
	 */
	public function consultaSolicitudes(){
		$conect=Yii::app()->db;
		$sqlConsSol="select * from referenciacion_adol as a 
			left join adolescente as b on b.num_doc=a.num_doc 
			left join forjar_adol as c on c.num_doc=a.num_doc 
			left join tiporeferenciacion as d on d.id_tipo_referenciacion=a.id_tipo_referenciacion 
			left join esp_sol_ni as e on e.id_esp_sol=a.id_esp_sol 
			left join esp_sol_nii as f on f.id_esp_solii=a.id_esp_solii 
			left join esp_sol_niii as g on g.id_esp_soliii=a.id_esp_soliii 
			where id_estadoref=1 and id_forjar=:id_forjar";
		$consSol=$conect->createCommand($sqlConsSol);
		$consSol->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));
		$readSol=$consSol->query();
		$resSol=$readSol->readAll();
		$readSol->close();
		return $resSol;
	}
}
