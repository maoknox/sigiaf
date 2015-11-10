<?php

/**
 * This is the model class for table "persona".
 *
 * The followings are the available columns in table 'persona':
 * @property string $id_cedula
 * @property string $nombre_personal
 * @property string $apellidos_personal
 * @property string $numero_tarjetaprof
 * @property string $correo_electronico
 *
 * The followings are the available model relations:
 * @property AuditoriaSistcforjar[] $auditoriaSistcforjars
 * @property CentroForjar[] $centroForjars
 * @property ConceptoIntegral[] $conceptoIntegrals
 * @property DatosContrato[] $datosContratos
 * @property EquipopsicosocPai[] $equipopsicosocPais
 * @property Adolescente[] $adolescentes
 * @property JustificacionHabVal[] $justificacionHabVals
 * @property PerslSegAdol[] $perslSegAdols
 * @property ProfesionalTo[] $profesionalTos
 * @property ProfesionalTrsoc[] $profesionalTrsocs
 * @property ProfesionalValenf[] $profesionalValenfs
 * @property ProfesionalValpsicol[] $profesionalValpsicols
 * @property ProfesionalValpsiq[] $profesionalValpsiqs
 * @property SeguimientoCompderecho[] $seguimientoCompderechoes
 * @property SeguimientoCompsancion[] $seguimientoCompsancions
 * @property Psc[] $pscs
 * @property SeguimientoPsc[] $seguimientoPscs
 * @property SeguimientoRefer[] $seguimientoRefers
 * @property ReferenciacionAdol[] $referenciacionAdols
 * @property Rol[] $rols
 */
class Persona extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $_nombreusuario;
	public $_clave;
	public $_id_rol;
	public $_nombre_profes;
	public $_apellido_prof;
	public $_cedula;
	public $_resConsulta;
	public $_idSedeForjar;
	public $_nombreSede;
	public $confirmaCorreo;
	public function tableName()
	{
		return 'persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cedula, nombre_personal, apellidos_personal, numero_tarjetaprof', 'required'),
			array('nombre_personal, apellidos_personal, numero_tarjetaprof', 'length', 'max'=>50),
			array('correo_electronico', 'length', 'max'=>500),
			array('correo_electronico', 'email'),
			array('id_cedula','numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('confirmaContrato, confirmaCorreo, nombre_personal, apellidos_personal, numero_tarjetaprof, correo_electronico', 'safe', 'on'=>'search'),
			array('id_cedula','validaCedula','id_cedula'=>$this->id_cedula),
			array('correo_electronico','validaCorreo','correo_electronico'=>$this->correo_electronico),
			array('confirmaCorreo','confirmarCorreoUsr','correo_electronico'=>$this->correo_electronico),
		);
	}

	public function validaCedula($attribute,$params){
		if(!$this->hasErrors()){
			$persona=$this->consultaPersona();
			if($persona!=false){	
				$this->addError('id_cedula','Esta cédula ya está registrada');
			}	
		}
	}
	
	public function validaCorreo($attribute,$params){
		//if(!$this->hasErrors()){
			$correo=$this->consultaCorreo();
			if($correo!=false){	
				$this->addError('correo_electronico','Éste correo ya está registrado.  Debe digitar otro.');
			}
		//}
	}
	public function confirmarCorreoUsr($attribute,$params){
		$datos=Yii::app()->input->post();
		$confirmaCorreo=$datos["Persona"]["confirmaCorreo"];	
		if($this->correo_electronico != $confirmaCorreo){
			$this->addError('confirmaCorreo','Los correos no coinciden');
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
			'auditoriaSistcforjars' => array(self::HAS_MANY, 'AuditoriaSistcforjar', 'id_cedula'),
			'centroForjars' => array(self::MANY_MANY, 'CentroForjar', 'cforjar_personal(id_cedula, id_forjar)'),
			'conceptoIntegrals' => array(self::HAS_MANY, 'ConceptoIntegral', 'id_cedula'),
			'datosContratos' => array(self::HAS_MANY, 'DatosContrato', 'id_cedula'),
			'equipopsicosocPais' => array(self::HAS_MANY, 'EquipopsicosocPai', 'id_cedula'),
			'adolescentes' => array(self::MANY_MANY, 'Adolescente', 'hist_personal_adol(id_cedula, num_doc)'),
			'justificacionHabVals' => array(self::HAS_MANY, 'JustificacionHabVal', 'id_cedula'),
			'perslSegAdols' => array(self::HAS_MANY, 'PerslSegAdol', 'id_cedula'),
			'profesionalTos' => array(self::HAS_MANY, 'ProfesionalTo', 'id_cedula'),
			'profesionalTrsocs' => array(self::HAS_MANY, 'ProfesionalTrsoc', 'id_cedula'),
			'profesionalValenfs' => array(self::HAS_MANY, 'ProfesionalValenf', 'id_cedula'),
			'profesionalValpsicols' => array(self::HAS_MANY, 'ProfesionalValpsicol', 'id_cedula'),
			'profesionalValpsiqs' => array(self::HAS_MANY, 'ProfesionalValpsiq', 'id_cedula'),
			'seguimientoCompderechoes' => array(self::HAS_MANY, 'SeguimientoCompderecho', 'id_cedula'),
			'seguimientoCompsancions' => array(self::HAS_MANY, 'SeguimientoCompsancion', 'id_cedula'),
			'pscs' => array(self::HAS_MANY, 'Psc', 'id_cedula'),
			'seguimientoPscs' => array(self::HAS_MANY, 'SeguimientoPsc', 'id_cedula'),
			'seguimientoRefers' => array(self::HAS_MANY, 'SeguimientoRefer', 'id_cedula'),
			'referenciacionAdols' => array(self::HAS_MANY, 'ReferenciacionAdol', 'id_cedula'),
			'rols' => array(self::MANY_MANY, 'Rol', 'usuario(id_cedula, id_rol)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cedula' => 'Profesional',
			'nombre_personal' => 'Nombres Persona',
			'apellidos_personal' => 'Apellidos Persona',
			'numero_tarjetaprof' => 'Numero Tarjetaprof',
			'correo_electronico' => 'Correo Electronico',
			'confirmaCorreo'=>'Confirmar Correo',
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

		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('nombre_personal',$this->nombre_personal,true);
		$criteria->compare('apellidos_personal',$this->apellidos_personal,true);
		$criteria->compare('numero_tarjetaprof',$this->numero_tarjetaprof,true);
		$criteria->compare('correo_electronico',$this->correo_electronico,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Persona the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaUsuario(){
		$conect= Yii::app()->db;
		//$consPersonal="select * from usuario as a left join persona as b on b.id_cedula=a.id_cedula left join cforjar_personal as c on c.id_cedula=b.id_cedula ";
		//$consPersonal.="left join centro_forjar as d on c.id_forjar=d.id_forjar where nombre_usuario=:nombusr limit 1";
		$consPersonal="select * from usuario as a left join persona as b on b.id_cedula=a.id_cedula where nombre_usuario=:nombusr limit 1";
		$queryPersonal=$conect->createCommand($consPersonal);
		$queryPersonal->bindParam(":nombusr",$this->_nombreusuario,PDO::PARAM_STR);
		// reemplaza el marcador de posición ":email" con el valor real de email
		//$queryPersonal->bindParam(":clave",$this->password,PDO::PARAM_STR);
		$dataReader=$queryPersonal->query();
		$dataReader->bindColumn('nombre_usuario',$this->_nombreusuario);
		// vincular la 2da columna (email) con la variable $email
		$dataReader->bindColumn('clave',$this->_clave);
		//$this->_clave="1234";
		$dataReader->bindColumn('id_cedula',$this->_cedula);
		$dataReader->bindColumn('nombre_personal',$this->_nombre_profes);
		$dataReader->bindColumn('apellidos_personal',$this->_apellido_prof);
		$dataReader->bindColumn('id_rol',$this->_id_rol);
		//$dataReader->bindColumn('id_forjar',$this->_idSedeForjar);
		//$dataReader->bindColumn('nombre_sede',$this->_nombreSede);
		$resCons=$dataReader->read();
		$dataReader->close();
		return $resCons;
	}
	public function consultaSedeForjar(){
		$conect= Yii::app()->db;
		$sqlConsSedeForjar="select a.id_forjar,b.nombre_sede from cforjar_personal as a left join centro_forjar as b on a.id_forjar=b.id_forjar where id_cedula=:id_cedula";
		$consSedeForjar=$conect->createCommand($sqlConsSedeForjar);
		$consSedeForjar->bindParam(":id_cedula",$this->_cedula,PDO::PARAM_INT);
		$readSedeForjar=$consSedeForjar->query();
		$resSedeForjar=$readSedeForjar->readAll();
		$readSedeForjar->close();
		return $resSedeForjar;		
	}
	
	public function consultaFuncionario(){
		$conect= Yii::app()->db;
		$sqlConsFuncionarios="select (nombre_personal ||' '||apellidos_personal)as nombres,* from persona as a 
			left join cforjar_personal as b on b.id_cedula=a.id_cedula 
			left join centro_forjar as c on b.id_forjar=c.id_forjar 
			left join usuario as d on d.id_cedula=a.id_cedula
			where b.id_forjar=:id_forjar and pers_habilitado is true";
		$consFuncionarios=$conect->createCommand($sqlConsFuncionarios);
		$consFuncionarios->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));
		$readFuncionarios=$consFuncionarios->query();
		$resFuncionarios=$readFuncionarios->readAll();
		$readFuncionarios->close();
		return $resFuncionarios;
		
	}
	public function consultaFuncionarioValoracion(){
		$conect= Yii::app()->db;
		$sqlConsFuncionarios="select (nombre_personal ||' '||apellidos_personal)as nombres,* from persona as a 
			left join cforjar_personal as b on b.id_cedula=a.id_cedula 
			left join centro_forjar as c on b.id_forjar=c.id_forjar 
			left join usuario as d on d.id_cedula=a.id_cedula
			where b.id_forjar=:id_forjar and pers_habilitado is true and id_rol=4 or id_rol=5 or id_rol=6 or id_rol=7 or id_rol=9 or id_rol=18";
		$consFuncionarios=$conect->createCommand($sqlConsFuncionarios);
		$consFuncionarios->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));
		$readFuncionarios=$consFuncionarios->query();
		$resFuncionarios=$readFuncionarios->readAll();
		$readFuncionarios->close();
		return $resFuncionarios;
		
	}

	
	public function consultaPersona(){
		$conect= Yii::app()->db;
		$sqlConsPersona="select * from persona where id_cedula=:id_cedula";
		$consPersona=$conect->createCommand($sqlConsPersona);
		$consPersona->bindParam(":id_cedula",$this->id_cedula);
		$readPersona=$consPersona->query();
		$resPersona=$readPersona->read();
		$readPersona->close();
		return $resPersona;
	}
	public function consultaPersonas(){
		$conect= Yii::app()->db;
		$sqlConsPersona="select (nombre_personal ||' '||apellidos_personal)as nombres,* from persona";
		$consPersona=$conect->createCommand($sqlConsPersona);
		$readPersona=$consPersona->query();
		$resPersona=$readPersona->readAll();
		$readPersona->close();
		return $resPersona;
	}
	private function consultaCorreo(){
		$conect= Yii::app()->db;
		$sqlConsCorreo="select * from persona where correo_electronico=:correo_electronico";
		$consCorreo=$conect->createCommand($sqlConsCorreo);
		$consCorreo->bindParam(":correo_electronico",$this->correo_electronico);
		$readCorreo=$consCorreo->query();
		$resCorreo=$readCorreo->read();
		$readCorreo->close();
		return $resCorreo;
	}
	public function creaPersona($modeloUsuario){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaPersona="insert into persona (
				id_cedula,
				nombre_personal,
				apellidos_personal,
				numero_tarjetaprof,
				correo_electronico		
			) values (
				:id_cedula,
				:nombre_personal,
				:apellidos_personal,
				:numero_tarjetaprof,
				:correo_electronico		
			)";
			if(empty($this->correo_electronico)){
				$this->correo_electronico=null;
			}
			$creaPersona=$conect->createCommand($sqlCreaPersona);
			$creaPersona->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
			$creaPersona->bindParam(":nombre_personal",$this->nombre_personal,PDO::PARAM_STR);
			$creaPersona->bindParam(":apellidos_personal",$this->apellidos_personal,PDO::PARAM_STR);
			$creaPersona->bindParam(":numero_tarjetaprof",$this->numero_tarjetaprof,PDO::PARAM_STR);
			$creaPersona->bindParam(":correo_electronico",$this->correo_electronico,PDO::PARAM_NULL);
			$creaPersona->execute();
			
			$sqlCreaUsuario="insert into usuario (
				id_cedula,
				id_rol,
				clave,
				nombre_usuario,
				pers_habilitado
			) values (
				:id_cedula,
				:id_rol,
				:clave,
				:nombre_usuario,
				'true'
			)";
			$creaUsuario=$conect->createCommand($sqlCreaUsuario);
			$creaUsuario->bindParam(":id_cedula",$modeloUsuario->id_cedula,PDO::PARAM_INT);
			$creaUsuario->bindParam(":id_rol",$modeloUsuario->id_rol,PDO::PARAM_INT);
			$creaUsuario->bindParam(":clave",$modeloUsuario->clave,PDO::PARAM_STR);
			$creaUsuario->bindParam(":nombre_usuario",$modeloUsuario->nombre_usuario,PDO::PARAM_STR);
			$creaUsuario->execute();
			
			$sqlAsocForjar="insert into cforjar_personal (
				id_forjar,
				id_cedula
			) values (
				:id_forjar,
				:id_cedula
			)";			
			$asocForjar=$conect->createCommand($sqlAsocForjar);
			$asocForjar->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'),PDO::PARAM_STR);
			$asocForjar->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
			$asocForjar->execute();
			
			
			$transaction->commit();
			return "exito";			
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e->getMessage();
		}
	}
	public function consultaContrato(){
		
		
	}
}
