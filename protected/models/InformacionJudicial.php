<?php

/**
 * This is the model class for table "informacion_judicial".
 *
 * The followings are the available columns in table 'informacion_judicial':
 * @property integer $id_inf_judicial
 * @property string $num_doc
 * @property integer $id_tipo_sancion
 * @property integer $id_instancia_rem
 * @property string $defensor
 * @property string $juez
 * @property string $juzgado
 * @property integer $tiempo_sancion
 * @property integer $tiempo_sancion_dias
 * @property string $autoridad_remisora
 * @property string $fecha_remision
 * @property string $fecha_aprehension
 * @property string $no_proceso
 * @property string $defensor_publico
 * @property string $fecha_imposicion
 * @property boolean $pard
 * @property string $observaciones_sancion
 * @property boolean $mec_sust_lib
 * @property string $fecha_reg_infjud
 *
 * The followings are the available model relations:
 * @property InfjudDelRemcesp[] $infjudDelRemcesps
 * @property InfjudEprocj[] $infjudEprocjs
 * @property NovedadInfJudicial[] $novedadInfJudicials
 * @property NovedadInfJudicial[] $novedadInfJudicials1
 * @property Adolescente $numDoc
 * @property TipoSancion $idTipoSancion
 * @property InstanciaRemisora $idInstanciaRem
 */
class InformacionJudicial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id_inf_actual;
	public $id_inf_nueva;
	public $mensajeErrorInfJud="";
	public $idPai;
	public function tableName()
	{
		return 'informacion_judicial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(
				'
				fecha_remision,
				num_doc,
				id_tipo_sancion,
				id_instancia_rem,
				tiempo_sancion,
				juzgado,
				fecha_remision,
				fecha_aprehension,
				no_proceso,
				fecha_imposicion,
				id_proc_jud,
				infjudDelRemcesps',
				'required'
			),
			array('id_tipo_sancion, id_instancia_rem, tiempo_sancion, tiempo_sancion_dias', 'numerical', 'integerOnly'=>true),
			array('num_doc, autoridad_remisora', 'length', 'max'=>15),
			array('defensor, juez, juzgado', 'length', 'max'=>200),
			array('defensor_publico', 'length', 'max'=>100),
			array('fecha_remision, fecha_aprehension, no_proceso, fecha_imposicion, pard, observaciones_sancion, mec_sust_lib, fecha_reg_infjud', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_inf_actual,id_inf_judicial, num_doc, id_tipo_sancion, id_instancia_rem, defensor, juez, juzgado, tiempo_sancion, tiempo_sancion_dias, autoridad_remisora, fecha_remision, fecha_aprehension, no_proceso, defensor_publico, fecha_imposicion, pard, observaciones_sancion, mec_sust_lib, fecha_reg_infjud', 'safe', 'on'=>'search'),
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
			'infjudDelRemcesps' => array(self::HAS_MANY, 'InfjudDelRemcesp', 'id_inf_judicial'),
			'novedadInfJudicials' => array(self::HAS_MANY, 'NovedadInfJudicial', 'id_inf_judicial'),
			'novedadInfJudicials1' => array(self::HAS_MANY, 'NovedadInfJudicial', 'nov_id_inf_judicial'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idTipoSancion' => array(self::BELONGS_TO, 'TipoSancion', 'id_tipo_sancion'),
			'idInstanciaRem' => array(self::BELONGS_TO, 'InstanciaRemisora', 'id_instancia_rem'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_inf_judicial' => 'Id Inf Judicial',
			'num_doc' => 'Num Doc',
			'id_tipo_sancion' => 'Id Tipo Sancion',
			'id_instancia_rem' => 'Remitido por: ',
			'defensor' => 'Defensor de familia:',
			'juez' => 'Juez',
			'juzgado' => 'Juzgado',
			'tiempo_sancion' => 'Tiempo sanción en meses',
			'tiempo_sancion_dias' => 'Tiempo sancion en días',
			'autoridad_remisora' => 'Autoridad Remisora',
			'fecha_remision' => 'Fecha Remision',
			'fecha_aprehension' => 'Fecha aprehensión',
			'no_proceso' => 'No. Proceso',
			'defensor_publico' => 'Defensor público',
			'fecha_imposicion' => 'Fecha Imposición',
			'pard' => 'PARD con vinculación al SRPA',
			'observaciones_sancion' => 'Observaciones Sanción',
			'mec_sust_lib' => 'Mecanismo sustitutivo de privación de la libertad',
			'fecha_reg_infjud' => 'Fecha Reg Infjud',
			'infjudDelRemcesps'=>'Delito',
			'id_proc_jud'=>'Estado del proceso'
		);
	}
	
	public function consultaEntidadesPrimarias($nombreEntidad,$campoId){
		$consGen=new ConsultasGenerales();
		return 	$consGen->consultaEntidades($nombreEntidad,$campoId);		
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

		$criteria->compare('id_inf_judicial',$this->id_inf_judicial);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_tipo_sancion',$this->id_tipo_sancion);
		$criteria->compare('id_instancia_rem',$this->id_instancia_rem);
		$criteria->compare('defensor',$this->defensor,true);
		$criteria->compare('juez',$this->juez,true);
		$criteria->compare('juzgado',$this->juzgado,true);
		$criteria->compare('tiempo_sancion',$this->tiempo_sancion);
		$criteria->compare('tiempo_sancion_dias',$this->tiempo_sancion_dias);
		$criteria->compare('autoridad_remisora',$this->autoridad_remisora,true);
		$criteria->compare('fecha_remision',$this->fecha_remision,true);
		$criteria->compare('fecha_aprehension',$this->fecha_aprehension,true);
		$criteria->compare('no_proceso',$this->no_proceso,true);
		$criteria->compare('defensor_publico',$this->defensor_publico,true);
		$criteria->compare('fecha_imposicion',$this->fecha_imposicion,true);
		$criteria->compare('pard',$this->pard);
		$criteria->compare('observaciones_sancion',$this->observaciones_sancion,true);
		$criteria->compare('mec_sust_lib',$this->mec_sust_lib);
		$criteria->compare('fecha_reg_infjud',$this->fecha_reg_infjud,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformacionJudicial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function registraInfJudAdminAdol(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			
			if(empty($this->observaciones_sancion)){$this->observaciones_sancion=null;}
			if(empty($this->defensor)){$this->defensor=null;}
			if(empty($this->juez)){$this->juez=null;}
			if(empty($this->tiempo_sancion_dias)){$this->tiempo_sancion_dias=null;}
			if(empty($this->defensor_publico)){$this->defensor_publico=null;}
			if(empty($this->pard)){$this->pard=false;}
			if(empty($this->mec_sust_lib)){$this->mec_sust_lib=false;}
			
			$fechaRegistro=date("Y-m-d");
			//$novedadInfjud='false';
			$sqlRegistraInfJudAdmin="insert into informacion_judicial (
				id_inf_judicial,
				id_proc_jud,
				num_doc,
				id_tipo_sancion,
				id_instancia_rem,
				defensor,
				juez,
				juzgado,
				tiempo_sancion,
				tiempo_sancion_dias,
				fecha_remision,
				fecha_aprehension,
				no_proceso,
				defensor_publico,
				fecha_imposicion,
				pard,
				observaciones_sancion,
				mec_sust_lib,
				fecha_reg_infjud,
				novedad_infjud
			) values (
				default,
				:idProcJud,
				:numDoc,
				:idTipoSancion,
				:idInstanciaRem,
				:defensor,
				:juez,
				:juzgado,
				:tiempoSancion,
				:tiempoSanciondias,
				:fechaRemision,
				:fechaAprehension,
				:noProceso,
				:defensorPublico,
				:fechaImposicion,
				:pard,
				:observacionesSancion,
				:mecSustLib,
				:fechaRegInfjud,
				:novedad_infjud
			) returning id_inf_judicial";
			$registraInfJudAdmin=$conect->createCommand($sqlRegistraInfJudAdmin);
			$registraInfJudAdmin->bindParam(':idProcJud',$this->id_proc_jud,PDO::PARAM_INT);
			$registraInfJudAdmin->bindParam(':numDoc',$this->num_doc,PDO::PARAM_STR);
			$registraInfJudAdmin->bindParam(':idTipoSancion',$this->id_tipo_sancion,PDO::PARAM_INT);
			$registraInfJudAdmin->bindParam(':idInstanciaRem',$this->id_instancia_rem,PDO::PARAM_INT);
			$registraInfJudAdmin->bindParam(':defensor',$this->defensor,PDO::PARAM_NULL);
			$registraInfJudAdmin->bindParam(':juez',$this->juez,PDO::PARAM_NULL);
			$registraInfJudAdmin->bindParam(':juzgado',$this->juzgado,PDO::PARAM_NULL);
			$registraInfJudAdmin->bindParam(':tiempoSancion',$this->tiempo_sancion,PDO::PARAM_STR);
			$registraInfJudAdmin->bindParam(':tiempoSanciondias',$this->tiempo_sancion_dias,PDO::PARAM_NULL);
			$registraInfJudAdmin->bindParam(':fechaRemision',$this->fecha_remision,PDO::PARAM_STR);
			$registraInfJudAdmin->bindParam(':fechaAprehension',$this->fecha_aprehension,PDO::PARAM_STR);
			$registraInfJudAdmin->bindParam(':noProceso',$this->no_proceso,PDO::PARAM_INT);
			$registraInfJudAdmin->bindParam(':defensorPublico',$this->defensor_publico,PDO::PARAM_NULL);
			$registraInfJudAdmin->bindParam(':fechaImposicion',$this->fecha_imposicion,PDO::PARAM_NULL);
			$registraInfJudAdmin->bindParam(':pard',$this->pard,PDO::PARAM_BOOL);
			$registraInfJudAdmin->bindParam(':observacionesSancion',$this->observaciones_sancion,PDO::PARAM_NULL);
			$registraInfJudAdmin->bindParam(':mecSustLib',$this->mec_sust_lib,PDO::PARAM_BOOL);
			$registraInfJudAdmin->bindParam(':fechaRegInfjud',$fechaRegistro,PDO::PARAM_STR);
			$registraInfJudAdmin->bindParam(':novedad_infjud',$this->novedad_infjud,PDO::PARAM_BOOL);
			$readInfJudAdol=$registraInfJudAdmin->query();
			$resInfJudAdol=$readInfJudAdol->read();
			$readInfJudAdol->close();
			$this->id_inf_nueva=$resInfJudAdol["id_inf_judicial"];
			foreach($this->infjudDelRemcesps as $delito){
				$sqlRegistraDelito="insert into infjud_del_remcesp (
					id_del_rc,
					id_inf_judicial
				) values (
					:idDelRc,
					:idInfJudicial
				)";
				$registraDelito=$conect->createCommand($sqlRegistraDelito);
				$registraDelito->bindParam(':idDelRc',$delito,PDO::PARAM_INT);
				$registraDelito->bindParam(':idInfJudicial',$resInfJudAdol["id_inf_judicial"],PDO::PARAM_INT);
				$registraDelito->execute();
			}
			if($this->novedad_infjud=='true'){
				$fechaRegNov=date("Y-m-d H:i:s");
				//$this->id_inf_judicial=$resInfJudAdol["id_inf_judicial"];
				$sqlRegNov="insert into novedad_inf_judicial (
					id_inf_judicial,
					nov_id_inf_judicial,
					fecha_reg_novedad
				) values (
					:id_inf_judicial,
					:nov_id_inf_judicial,
					:fecha_reg_novedad				
				)";
				$regNovedad=$conect->createCommand($sqlRegNov);
				$regNovedad->bindParam(':id_inf_judicial',$this->id_inf_judicial,PDO::PARAM_INT);
				$regNovedad->bindParam(':nov_id_inf_judicial',$resInfJudAdol["id_inf_judicial"],PDO::PARAM_INT);
				$regNovedad->bindParam(':fecha_reg_novedad',$fechaRegNov,PDO::PARAM_STR);
				$regNovedad->execute();
			}
			else{
				// actualiza la fecha de inicio de la valoración a la fecha del registro de la información judicial
				$sqlActFechaIni="update valoracion_psicologia set fecha_iniciovalpsicol=:fecha_inicio where num_doc=:num_doc";
				$actFechaIni=$conect->createCommand($sqlActFechaIni);
				$actFechaIni->bindParam(':fecha_inicio',$fechaRegistro,PDO::PARAM_STR);
				$actFechaIni->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
				$actFechaIni->execute();

				$sqlActFechaIni="update valoracion_trabajo_social set fecha_inicio_valtsoc=:fecha_inicio where num_doc=:num_doc";
				$actFechaIni=$conect->createCommand($sqlActFechaIni);
				$actFechaIni->bindParam(':fecha_inicio',$fechaRegistro,PDO::PARAM_STR);
				$actFechaIni->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
				$actFechaIni->execute();
								
				$sqlActFechaIni="update valoracion_teo set fecha_inicio_valteo=:fecha_inicio where num_doc=:num_doc";
				$actFechaIni=$conect->createCommand($sqlActFechaIni);
				$actFechaIni->bindParam(':fecha_inicio',$fechaRegistro,PDO::PARAM_STR);
				$actFechaIni->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
				$actFechaIni->execute();

				$sqlActFechaIni="update valoracion_enfermeria set fecha_ini_venf=:fecha_inicio where num_doc=:num_doc";
				$actFechaIni=$conect->createCommand($sqlActFechaIni);
				$actFechaIni->bindParam(':fecha_inicio',$fechaRegistro,PDO::PARAM_STR);
				$actFechaIni->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
				$actFechaIni->execute();

				$sqlActFechaIni="update valoracion_psiquiatria set fecha_ini_vpsiq=:fecha_inicio where num_doc=:num_doc";
				$actFechaIni=$conect->createCommand($sqlActFechaIni);
				$actFechaIni->bindParam(':fecha_inicio',$fechaRegistro,PDO::PARAM_STR);
				$actFechaIni->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
				$actFechaIni->execute();
				
				$sqlConsPai="select * from pai where num_doc=:num_doc and pai_actual is true and culminacion_pai='true'";
				$consPai=$conect->createCommand($sqlConsPai);
				$consPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
				$readConsPai=$consPai->query();
				$resConsPai=$readConsPai->read();
				$readConsPai->close();				
				if(!empty($resConsPai)){
					$idPaiActual=$resConsPai["id_pai"];
					$sqlModEstadoPaiActual="update pai set pai_actual='false' where num_doc=:num_doc and pai_actual is true and culminacion_pai is true ";
					$modEstadoPaiActual=$conect->createCommand($sqlModEstadoPaiActual);
					$modEstadoPaiActual->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$modEstadoPaiActual->execute();
					$idPaiNuevo=(int)$idPaiActual+1;
					$sqlConsPai="insert into pai (
						id_pai,
						num_doc,
						pai_actual,
						fecha_creacion_pai
					) values (
						:id_pai,
						:num_doc,
						:pai_actual,
						:fecha_creacion_pai
					) returning id_pai";
					$paiActual='true';
					$fechaCreaPai=date("Y-m-d");
					$paiActual='true';
					$creaPai=$conect->createCommand($sqlConsPai);
					$creaPai->bindParam(":id_pai",$idPaiNuevo,PDO::PARAM_STR);
					$creaPai->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$creaPai->bindParam(":pai_actual",$paiActual,PDO::PARAM_BOOL);
					$creaPai->bindParam(":fecha_creacion_pai",$fechaRegistro,PDO::PARAM_STR);
					$readCreaPai=$creaPai->query();
					$resCreaPai=$readCreaPai->read();
					$readCreaPai->close();
				}
				else{
					$sqlModEstadoPaiActual="update pai set fecha_creacion_pai=:fecha_pai where num_doc=:num_doc and pai_actual is true";
					$modEstadoPaiActual=$conect->createCommand($sqlModEstadoPaiActual);
					$fecha=date("Y-m-d");
					$modEstadoPaiActual->bindParam(":fecha_pai",$fecha,PDO::PARAM_STR);
					$modEstadoPaiActual->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
					$modEstadoPaiActual->execute();
				}
			}
			$transaction->commit();
			return "exito";
		}
		catch(CDbException $e){
			$transaction->rollBack();
			$this->mensajeErrorInfJud=$e;
			return "error";
			
		}		
	}
	public function consultaInfJudModNov(){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select * from informacion_judicial where num_doc=:num_doc and id_inf_judicial=:id_inf_judicial";
		$novedadInfjud='false';
		$consInfJud=$conect->createCommand($sqlConsInfJud);	
		$consInfJud->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consInfJud->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_BOOL);
		$readInfJud=$consInfJud->query();
		$resInfJud=$readInfJud->read();
		$readInfJud->close();
		return $resInfJud;
	}
	public function consultaInfJudOffset($offset){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select * from informacion_judicial as a 
			left join forjar_adol as b on a.num_doc=b.num_doc 
			where a.num_doc=:num_doc and novedad_infjud=:novedad_infjud limit 5 offset :offset";
		$novedadInfjud='false';
		$consInfJud=$conect->createCommand($sqlConsInfJud);	
		$consInfJud->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consInfJud->bindParam(":novedad_infjud",$novedadInfjud,PDO::PARAM_BOOL);
		$consInfJud->bindParam(":offset",$offset,PDO::PARAM_INT);
		$readInfJud=$consInfJud->query();
		$resInfJud=$readInfJud->readAll();
		$readInfJud->close();
		return $resInfJud;
	}
	public function consultaInfJud(){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select * from informacion_judicial as a left join forjar_adol as b on a.num_doc=b.num_doc where a.num_doc=:num_doc and novedad_infjud=:novedad_infjud";
		$novedadInfjud='false';
		$consInfJud=$conect->createCommand($sqlConsInfJud);	
		$consInfJud->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consInfJud->bindParam(":novedad_infjud",$novedadInfjud,PDO::PARAM_BOOL);
		$readInfJud=$consInfJud->query();
		$resInfJud=$readInfJud->readAll();
		$readInfJud->close();
		return $resInfJud;
	}
	public function consultaInfJudPai(){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select * from informacion_judicial where num_doc=:num_doc";		
		$consInfJud=$conect->createCommand($sqlConsInfJud);
		$consInfJud->bindParam(":num_doc",$this->num_doc);
		$readConsInfJud=$consInfJud->query();
		$resConsInfJud=array();
		$resConsInfJud=$readConsInfJud->readAll();
		$readConsInfJud->close();
		$infJudSinPai=array();		
		foreach($resConsInfJud as $consInfJud){
			$sqlConsInfJudSinPai="select * from  componente_sancion where id_inf_judicial=:id_inf_judicial";
			$consInfJudSinPai=$conect->createCommand($sqlConsInfJudSinPai);
			$consInfJudSinPai->bindParam(":id_inf_judicial",$consInfJud["id_inf_judicial"]);
			$readInfJudSinPai=$consInfJudSinPai->query();
			$resInfJudSinPai=$readInfJudSinPai->read();
			$readInfJudSinPai->close();
			if(empty($readInfJudSinPai)){
				$infJudSinPai[]=$consInfJud;				
			}
			//
		}
		return $infJudSinPai;
	}

	public function consultaInfJudInd(){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select * from informacion_judicial where id_inf_judicial=:id_inf_judicial";
		$novedadInfjud='false';
		$consInfJud=$conect->createCommand($sqlConsInfJud);	
		$consInfJud->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
		$readInfJud=$consInfJud->query();
		$resInfJud=$readInfJud->read();
		$readInfJud->close();
		return $resInfJud;
	}
	public function consultaInfJudNov($idInfJud){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select a.id_inf_judicial as id_inf_judicial_princ,* from novedad_inf_judicial as a 
			left join informacion_judicial as b on a.nov_id_inf_judicial=b.id_inf_judicial 
			where a.id_inf_judicial=:id_inf_judicial order by fecha_reg_novedad desc limit 1";
		$novedadInfjud='false';
		$consInfJud=$conect->createCommand($sqlConsInfJud);	
		$consInfJud->bindParam(":id_inf_judicial",$idInfJud,PDO::PARAM_INT);
		$readInfJud=$consInfJud->query();
		$resInfJud=$readInfJud->read();
		$readInfJud->close();
		return $resInfJud;
	}
	
	public function consultaDelito(){
		$conect=Yii::app()->db;
		$sqlConsDel="select * from infjud_del_remcesp as a left join delito_rem_cespa as b on a.id_del_rc=b.id_del_rc where a.id_inf_judicial=:id_inf_judicial";
		$consDel=$conect->createCommand($sqlConsDel);	
		$consDel->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
		$readDel=$consDel->query();
		$resDel=$readDel->readAll();
		$readDel->close();
		return $resDel;
	}
	public function modifInfJudicial($campo,$contenido,$parametro){
		$conect=Yii::app()->db;
		$sqlModInfJud="update informacion_judicial set ".$campo."=:contenido where id_inf_judicial=:id_inf_judicial";
		$modInfJud=$conect->createCommand($sqlModInfJud);	
		$modInfJud->bindParam(":contenido",$contenido,$parametro);
		$modInfJud->bindParam(":id_inf_judicial",$this->id_inf_judicial,PDO::PARAM_INT);
		$modInfJud->execute();		
	}
	public function actualizaCompSancionInfJud(){
		$conect=Yii::app()->db;
		$sqlCompSancInfJud="update componente_sancion set id_inf_judicial=:id_inf_judNueva where id_inf_judicial=:inf_judicial_act";
		$compSancInfJud=$conect->createCommand($sqlCompSancInfJud);
		$compSancInfJud->bindParam(":id_inf_judNueva",$this->id_inf_nueva,PDO::PARAM_INT);
		$compSancInfJud->bindParam(":inf_judicial_act",$this->id_inf_actual,PDO::PARAM_INT);
		$compSancInfJud->execute();
	}
	public function consultaInfJudCabezote(){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select * from informacion_judicial as a left join tipo_sancion as b on b.id_tipo_sancion=a.id_tipo_sancion left join instancia_remisora as c on c.id_instancia_rem=a.id_instancia_rem where num_doc=:num_doc and novedad_infjud='false'";
		$consInfJud=$conect->createCommand($sqlConsInfJud);	
		$consInfJud->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readInfJud=$consInfJud->query();
		$resInfJud=$readInfJud->readAll();
		$readInfJud->close();
		return $resInfJud;
	}
	public function consultaNovInfJudCabezote($idInfJud){
		$conect=Yii::app()->db;
		$sqlConsInfJud="select a.id_inf_judicial as id_inf_judicial_princ,* from novedad_inf_judicial as a 
			left join informacion_judicial as b on a.nov_id_inf_judicial=b.id_inf_judicial 
			left join tipo_sancion as c on c.id_tipo_sancion=b.id_tipo_sancion
			left join instancia_remisora as d on d.id_instancia_rem=b.id_instancia_rem
			where a.id_inf_judicial=:id_inf_judicial order by fecha_reg_novedad desc limit 1";
		$novedadInfjud='false';
		$consInfJud=$conect->createCommand($sqlConsInfJud);	
		$consInfJud->bindParam(":id_inf_judicial",$idInfJud,PDO::PARAM_INT);
		$readInfJud=$consInfJud->query();
		$resInfJud=$readInfJud->read();
		$readInfJud->close();
		return $resInfJud;
	}
}
