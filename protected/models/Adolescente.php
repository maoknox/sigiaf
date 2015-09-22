<?php

/**
 * This is the model class for table "adolescente".
 *
 * The followings are the available columns in table 'adolescente':
 * @property string $num_doc
 * @property integer $id_tipo_doc
 * @property integer $id_sexo
 * @property string $id_municipio
 * @property integer $id_etnia
 * @property string $apellido_1
 * @property string $apellido_2
 * @property string $nombres
 * @property string $fecha_nacimiento
 * @property double $edad_ingreso
 * @property double $edad_actual
 *
 * The followings are the available model relations:
 * @property DocumentoCespa[] $documentoCespas
 * @property AuditoriaSistcforjar[] $auditoriaSistcforjars
 * @property EscIngEgr[] $escIngEgrs
 * @property EscolaridadAdolescente[] $escolaridadAdolescentes
 * @property Familiar[] $familiars
 * @property CentroForjar[] $centroForjars
 * @property Persona[] $personas
 * @property LocalizacionViv[] $localizacionVivs
 * @property InformacionJudicial[] $informacionJudicials
 * @property Sgsss[] $sgssses
 * @property DerechoAdol[] $derechoAdols
 * @property Telefono[] $telefonos
 * @property Etnia $idEtnia
 * @property Localidad $idLocalidad
 * @property Municipio $idMunicipio
 * @property Sexo $idSexo
 * @property TipoDocumento $idTipoDoc
 * @property TiempoActuacion[] $tiempoActuacions
 */
class Adolescente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $psicologos;
	public $trabSocials;
	public $responsableAdol;
	public $sedeForjar;
	public $mensajeError;
	public $numeroCarpeta;
	public $mensajeErrorProf;


	public function tableName()
	{
		return 'adolescente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc, id_tipo_doc,escIngEgrs, id_sexo, id_municipio, apellido_1, nombres,fecha_nacimiento', 'required'),
			array('id_tipo_doc, id_sexo, id_familia, id_etnia', 'numerical', 'integerOnly'=>true),
			array('edad_ingreso, edad_actual', 'numerical'),
			array('num_doc', 'length', 'max'=>15),
			array('id_municipio', 'length', 'max'=>10),
			array('apellido_1, apellido_2, nombres', 'length', 'max'=>100),
			array('num_doc','validaAdol'),
			array('fecha_nacimiento','validaFechasMod'),
			array('fecha_nacimiento,id_etnia,apellido_2,psicologos,escIngEgrs,trabSocials,responsableAdol,id_regimen_salud', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('num_doc, id_tipo_doc, id_sexo, id_municipio,id_familia, id_etnia, apellido_1, apellido_2, nombres, fecha_nacimiento, edad_ingreso, edad_actual', 'safe', 'on'=>'search'),
			array('psicologos','validaPsic'),
			array('trabSocials','validaTr'),
			array('responsableAdol','validaResp')
		);
	}
public function validaAdol($attribute=NULL,$params=NULL){
		
		$consultaAdol=$this->find('num_doc=:numDoc',
		array(
			':numDoc'=>$_POST["Adolescente"]["num_doc"]
		));
		if(isset($_POST["Adolescente"]["numDocAdol"]) && !empty($_POST["Adolescente"]["numDocAdol"])){
			if($_POST["Adolescente"]["numDocAdol"]!==$_POST["Adolescente"]["num_doc"]){
				if(!empty($consultaAdol)){
					$this->addError($attribute,"Este número de documento ya se encuentra registrado");
				}
			}
		}
		else{
			if(!empty($consultaAdol)){
				$this->addError($attribute,"Este número de documento ya se encuentra registrado");
			}
		}			
	}
	public function validaPsic($attribute=NULL,$params=NULL){
		if(isset($_POST["Adolescente"]["psicologos"])&&!empty($_POST["Adolescente"]["psicologos"])){
			if(empty($_POST["Adolescente"]["trabSocials"])){
				//print_r($_POST["Adolescente"]);
				$this->addError($attribute,"Debe seleccionar un Trabajador social");
			}
		}
	}
	public function validaTr($attribute=NULL,$params=NULL){
		if(isset($_POST["Adolescente"]["trabSocials"])&&!empty($_POST["Adolescente"]["trabSocials"])){
			if(empty($_POST["Adolescente"]["psicologos"])){
				$this->addError($attribute,"Debe seleccionar un Psicólogo");
			}
		}
	}
	public function validaResp($attribute=NULL,$params=NULL){
		if(isset($_POST["Adolescente"])){
			if(!empty($_POST["Adolescente"]["trabSocials"]) || !empty($_POST["Adolescente"]["psicologos"])){
				if(empty($_POST["Adolescente"]["responsableAdol"]))
					$this->addError($attribute,'Debe seleccionar un Responsable');
			}
		}
	}
	public function validaFechasMod($attribute=NULL,$params=NULL){
		$fecha=new OperacionesGenerales();
		if(!empty($this->attributes['fecha_nacimiento'])){
			if(!$fecha->validaFormatoFecha($this->attributes['fecha_nacimiento'], 'Y-m-d')){
				$this->addError($attribute,$fecha->validaFormatoFecha($this->attributes['fecha_nacimiento']));
			}
			elseif(strtotime($this->attributes['fecha_nacimiento']) >= strtotime(date('Y-m-d'))){
				$this->addError($attribute,'La fecha debe ser menor a la actual');
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
			'documentoCespas' => array(self::MANY_MANY, 'DocumentoCespa', 'adol_doccespa(num_doc, id_doccespa)'),
			'auditoriaSistcforjars' => array(self::HAS_MANY, 'AuditoriaSistcforjar', 'num_doc'),
			'escIngEgrs' => array(self::MANY_MANY, 'EscIngEgr', 'escadol_ingr_egr(num_doc, id_escingegr)'),
			'escolaridadAdolescentes' => array(self::HAS_MANY, 'EscolaridadAdolescente', 'num_doc'),
			'familiars' => array(self::MANY_MANY, 'Familiar', 'familiar_adolescente(num_doc, id_doc_familiar)'),
			'centroForjars' => array(self::MANY_MANY, 'CentroForjar', 'forjar_adol(num_doc, id_forjar)'),
			'personas' => array(self::MANY_MANY, 'Persona', 'hist_personal_adol(num_doc, id_cedula)'),
			'localizacionVivs' => array(self::HAS_MANY, 'LocalizacionViv', 'num_doc'),
			'informacionJudicials' => array(self::HAS_MANY, 'InformacionJudicial', 'num_doc'),
			'sgssses' => array(self::HAS_MANY, 'Sgsss', 'num_doc'),
			'derechoAdols' => array(self::HAS_MANY, 'DerechoAdol', 'num_doc'),
			'telefonos' => array(self::HAS_MANY, 'Telefono', 'num_doc'),
			'idFamilia' => array(self::BELONGS_TO, 'Familia', 'id_familia'),
			'idEtnia' => array(self::BELONGS_TO, 'Etnia', 'id_etnia'),
			'idMunicipio' => array(self::BELONGS_TO, 'Municipio', 'id_municipio'),
			'idSexo' => array(self::BELONGS_TO, 'Sexo', 'id_sexo'),
			'idTipoDoc' => array(self::BELONGS_TO, 'TipoDocumento', 'id_tipo_doc'),
			//'tiempoActuacions' => array(self::MANY_MANY, 'TiempoActuacion', 'tiempoact_adol(num_doc, id_tiempoact)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'num_doc' => 'Número de documento',
			'id_tipo_doc' => 'Tipo de documento',
			'id_sexo' => 'Sexo',
			'id_municipio' => 'Municipio',
			'id_familia' => 'Id Familia',
			'id_etnia' => 'Etnia',
			'apellido_1' => 'Primer Apellido',
			'apellido_2' => 'Segundo Apellido',
			'nombres' => 'Nombres',
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'edad_ingreso' => 'Edad Ingreso',
			'edad_actual' => 'Edad Actual',
			'escIngEgrs'=>'Escolaridad'
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

		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_tipo_doc',$this->id_tipo_doc);
		$criteria->compare('id_sexo',$this->id_sexo);
		$criteria->compare('id_municipio',$this->id_municipio,true);
		$criteria->compare('id_etnia',$this->id_etnia);
		$criteria->compare('apellido_1',$this->apellido_1,true);
		$criteria->compare('apellido_2',$this->apellido_2,true);
		$criteria->compare('nombres',$this->nombres,true);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('edad_ingreso',$this->edad_ingreso);
		$criteria->compare('edad_actual',$this->edad_actual);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Adolescente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function creaRegistroAdol(){
		$operGen=new OperacionesGenerales();
		$consGen=new ConsultasGenerales();
		$this->edad_ingreso=$operGen->hallaEdad($this->fecha_nacimiento,date("Y-m-d"));
		$this->edad_actual=$operGen->hallaEdad($this->fecha_nacimiento,date("Y-m-d"));
		//echo $this->edad_actual;
		$conect= Yii::app()->db;
		if(empty($this->id_etnia)){$this->id_etnia=NULL;}
		if(empty($this->apellido_2)){$this->apellido_2=NULL;}else{$this->apellido_2=mb_strtoupper($this->apellido_2,"UTF-8");}
		$this->apellido_1=mb_strtoupper($this->apellido_1,"UTF-8");
		$this->nombres=mb_strtoupper($this->nombres,"UTF-8");
		$transaction=$conect->beginTransaction();
		try{
			//Inserta los datos en adolescentes
			//$edadIngreso=$operGen->hallaEdad($this->fecha_nacimiento,date("Y-m-d"));
			$sqlCreaRegAdol="insert into adolescente (
					num_doc,
					id_tipo_doc,
					id_sexo,
					id_municipio,
					id_etnia,
					apellido_1,
					apellido_2,
					nombres,
					fecha_nacimiento,
					edad_ingreso,
					edad_actual
					) values (
						:numDoc,
						:tipoDoc,
						:sexo,
						:municipio,
						:etnia,
						:apellido1,
						:apellido2,
						:nombres,
						:fechaNacimiento,
						:edadIngreso,
						:edadActual
					)";
				$registraReg=$conect->createCommand($sqlCreaRegAdol);
				$registraReg->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
				$registraReg->bindParam(':tipoDoc',$this->id_tipo_doc,PDO::PARAM_INT);
				$registraReg->bindParam(':sexo',$this->id_sexo,PDO::PARAM_INT);
				$registraReg->bindParam(':municipio',$this->id_municipio,PDO::PARAM_STR);
				$registraReg->bindParam(':etnia',$this->id_etnia,PDO::PARAM_NULL);
				$registraReg->bindParam(':apellido1',$this->apellido_1,PDO::PARAM_STR);
				$registraReg->bindParam(':apellido2',$this->apellido_2,PDO::PARAM_NULL);
				$registraReg->bindParam(':nombres',$this->nombres,PDO::PARAM_STR);
				$registraReg->bindParam(':fechaNacimiento',$this->fecha_nacimiento,PDO::PARAM_STR);
				$registraReg->bindParam(':edadIngreso',$this->edad_ingreso);
				$registraReg->bindParam(':edadActual',$this->edad_actual);			
				$registraReg->execute();
				//$sedeForjar
				
/*				$sqlAsignaNumCarp="insert into numero_carpeta (
					id_reg,
					id_forjar,
					num_doc,
					id_numero_carpeta
				) values (
					default,
					:id_forjar,
					:num_doc,
					(select id_numero_carpeta from numero_carpeta where id_forjar=:id_forjar_c and id_forjar is not null and num_doc is not null  order by id_numero_carpeta desc limit 1)+1
				)returning id_numero_carpeta";

				
				
				$sqlAsignaNumCarp="update numero_carpeta set num_doc=:numDoc 
					where id_forjar=:idForjar and 
					id_numero_carpeta=(
						select min(id_numero_carpeta) from numero_carpeta where id_forjar=:idForjar and num_doc is NULL) 
					returning id_numero_carpeta";
					 //$sedeForjar='asdfadsfadsfasdf';
				$queryAsignaNumCarp=$conect->createCommand($sqlAsignaNumCarp);
				$queryAsignaNumCarp->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);//
				$queryAsignaNumCarp->bindParam(':id_forjar',$this->sedeForjar,PDO::PARAM_STR);
				$queryAsignaNumCarp->bindParam(':id_forjar_c',$this->sedeForjar,PDO::PARAM_STR);
				$readNumCarpeta=$queryAsignaNumCarp->query();
				$resNumCarpeta=$readNumCarpeta->read();
				
				
				
*/				

				$sqlConsNumCarpetaActual="select id_numero_carpeta from numero_carpeta where id_forjar=:id_forjar and id_forjar is not null and num_doc is not null  order by id_numero_carpeta desc limit 1";
				$consNumCarpetaActual=$conect->createCommand($sqlConsNumCarpetaActual);
				$consNumCarpetaActual->bindParam(':id_forjar',$this->sedeForjar,PDO::PARAM_STR);
				$readNumCarpetaActual=$consNumCarpetaActual->query();
				$resNumCarpeta=$readNumCarpetaActual->read();
				if(empty($resNumCarpeta)){
					$idCarpeta=1;					
				}
				else{
					$idCarpeta=$resNumCarpeta["id_numero_carpeta"]+1;					
				}
				
				$sqlAsignaNumCarp="insert into numero_carpeta (
					id_reg,
					id_forjar,
					num_doc,
					id_numero_carpeta
				) values (
					default,
					:id_forjar,
					:num_doc,
					:id_numero_carpeta
				)returning id_numero_carpeta";
				$queryAsignaNumCarp=$conect->createCommand($sqlAsignaNumCarp);
				$queryAsignaNumCarp->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);//
				$queryAsignaNumCarp->bindParam(':id_forjar',$this->sedeForjar,PDO::PARAM_STR);
				$queryAsignaNumCarp->bindParam(':id_numero_carpeta',$idCarpeta,PDO::PARAM_STR);
				$readNumCarpeta=$queryAsignaNumCarp->query();
				$resNumCarpeta=$readNumCarpeta->read();
				$this->numeroCarpeta=$resNumCarpeta["id_numero_carpeta"];
				$readNumCarpeta->close();								
				$readNumCarpeta->close();
				$sqlCreaSedForj="insert into forjar_adol(
					id_forjar,
					num_doc,
					id_estado_adol,
					tiempo_modificacion
				) values (
					:idForjar,
					:numDoc,
					1,
					15)";
				$registraAdolForjar=$conect->createCommand($sqlCreaSedForj);
				$registraAdolForjar->bindParam('idForjar',$this->sedeForjar,PDO::PARAM_STR);
				$registraAdolForjar->bindParam('numDoc',$this->num_doc,PDO::PARAM_STR);
				$registraAdolForjar->execute();
				$sqlRegistraEscol="insert into escadol_ingr_egr (
						id_escingegr,
						num_doc,
						estado_escol
					) values (
						1,
						:numDoc,
						:estadoEscol
					)
				";//escIngEgrs
				$registraEscol=$conect->createCommand($sqlRegistraEscol);
				$registraEscol->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);				
				$registraEscol->bindParam(':estadoEscol',$this->escIngEgrs,PDO::PARAM_STR);
				$registraEscol->execute();
    		//$connection->createCommand($sql2)->execute();
        	$transaction->commit();
			$mensaje='exito';
			$this->mensajeError="";
		}
		catch(CDbException  $e){ // se arroja una excepción si una consulta falla
    		$transaction->rollBack();
			$mensaje='error';
			$this->mensajeError=$e;
		}
		
		return $mensaje;
	}
	public function registraEquipoPsic($profesional,$responsable){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaRegProf="insert into hist_personal_adol (
					id_cedula,
					num_doc,
					fecha_histreg_pers,
					asignado_actualmente,
					responsable_caso
				) values (
					:idCedula,
					:numDoc,
					:fechaRegistro,
					:asignacon,
					:responsableCaso
				)";
			$fechaRegProf=date("Y-m-d");
			$asignadoActualmente=true;
			$excCreaRegProf=$conect->createCommand($sqlCreaRegProf);
			$excCreaRegProf->bindParam(':idCedula',$profesional,PDO::PARAM_INT);
			$excCreaRegProf->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
			$excCreaRegProf->bindParam(':fechaRegistro',$fechaRegProf,PDO::PARAM_STR);
			$excCreaRegProf->bindParam(':asignacon',$asignadoActualmente,PDO::PARAM_BOOL);
			$excCreaRegProf->bindParam(':responsableCaso',$responsable,PDO::PARAM_BOOL);
			$excCreaRegProf->execute();
			$transaction->commit();
			$this->mensajeErrorProf=" ";
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorProf.='<br/>Aunque no se pudo registrar satisfactoriamente el equipo psicosocial. El código del error es el siguiente <br/>'.$e;
		}
	}
	public function modificaDatosAdol($nombreCampo,$nombreTabla,$datoAntiguo,$datoActual,$numDocAdol,$tipoDato){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$nombreCampo=htmlspecialchars(strip_tags(trim($nombreCampo)));
			$nombreTabla=htmlspecialchars(strip_tags(trim($nombreTabla)));
			$datoAntiguo=htmlspecialchars(strip_tags(trim($datoAntiguo)));
			//$datoActual=htmlspecialchars(strip_tags(trim($datoActual)));
			
			$sqlModDatos="update ".$nombreTabla." set ".$nombreCampo."=:datoActual where num_doc=:numDocAdol";
			$modDatos=$conect->createCommand($sqlModDatos);
			$modDatos->bindParam(':datoActual',$datoActual,$tipoDato);
			$modDatos->bindParam(':numDocAdol',$numDocAdol,PDO::PARAM_STR);
			$modDatos->execute();
			$transaction->commit();
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeError.=$e;
		}
	}
	public function modificaDatosAdolMany($nombreCampo,$nombreTabla,$datoAntiguo,$datoActual,$camposComp,$tipoDato){
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
		}		
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeError.=$e;
		}
	}
	public function consultaDatosAdol($numDocAdol){
		$conect= Yii::app()->db;
		$sqlConsultaAdol="select *,(apellido_1 || ' ' || apellido_2) as apellidos from adolescente as a left join forjar_adol as b on a.num_doc=b.num_doc 
			left join localizacion_viv as c on a.num_doc=c.num_doc
			left join sgsss as d on d.num_doc=a.num_doc 
			left join numero_carpeta as e on e.num_doc=a.num_doc 
			left join etnia as f on a.id_etnia=f.id_etnia 
			left join municipio as g on g.id_municipio=a.id_municipio 
			left join departamento as h on h.id_departamento=g.id_departamento 
			left join escadol_ingr_egr as i on i.num_doc=a.num_doc where a.num_doc=:numDoc";
		$queryConsultaAdol=$conect->createCommand($sqlConsultaAdol);
		$queryConsultaAdol->bindParam(':numDoc',$numDocAdol,PDO::PARAM_STR);
		$readConsultaAdol=$queryConsultaAdol->query();
		$resConsultaAdol=$readConsultaAdol->read();
		$readConsultaAdol->close();			
		return $resConsultaAdol;
	}
	public function consultaDatosAdolValTrSoc(){
		$conect= Yii::app()->db;
		$sqlConsultaAdol="select * from adolescente as a 
			left join familia as b on b.id_familia=a.id_familia
			left join tipo_familia as c on c.id_tipo_familia=b.id_tipo_familia
			where a.num_doc=:numDoc";
		$queryConsultaAdol=$conect->createCommand($sqlConsultaAdol);
		$queryConsultaAdol->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
		$readConsultaAdol=$queryConsultaAdol->query();
		$resConsultaAdol=$readConsultaAdol->read();
		$readConsultaAdol->close();			
		return $resConsultaAdol;
	}
	public function consAntFamiliares(){
		$conect= Yii::app()->db;
		$sqlConsultaAdol="select * from adolescente as a 
			left join familia as b on b.id_familia=a.id_familia
			left join tipo_familia as c on c.id_tipo_familia=b.id_tipo_familia
			where a.num_doc=:numDoc";
		$queryConsultaAdol=$conect->createCommand($sqlConsultaAdol);
		$queryConsultaAdol->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
		$readConsultaAdol=$queryConsultaAdol->query();
		$resConsultaAdol=$readConsultaAdol->read();
		$readConsultaAdol->close();			
		return $resConsultaAdol;
	}
}
