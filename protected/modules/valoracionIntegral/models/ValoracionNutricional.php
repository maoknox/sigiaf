<?php

/**
 * This is the model class for table "valoracion_nutricional".
 *
 * The followings are the available columns in table 'valoracion_nutricional':
 * @property integer $id_val_nutricion
 * @property integer $id_esquema_vac
 * @property integer $id_masticacion
 * @property integer $id_apetito
 * @property integer $id_digestion
 * @property integer $id_estado_val
 * @property integer $id_hab_intest
 * @property integer $id_ingesta
 * @property integer $id_nivel_act_fis
 * @property string $num_doc
 * @property integer $id_tipo_parto
 * @property string $semanas_gestacion
 * @property string $talla_nacim_cms
 * @property string $peso_nacim_kgs
 * @property string $observaciones_nacim
 * @property string $patologicos
 * @property string $quirurgicos
 * @property string $hospitaliz_causas
 * @property string $alergicos
 * @property string $toxicos 
 * @property string $familiares_nutr
 * @property string $otros_nutr
 * @property string $obs_esquema_vac
 * @property boolean $control_crec_des
 * @property string $obs_crec_des
 * @property string $medicamentos_nutr
 * @property string $procedencia_padres
 * @property string $alimentos_preferidos
 * @property string $alimentos_rechazados
 * @property string $alimentos_intolerados
 * @property string $supl_compl_nutr
 * @property boolean $recibio_leche_mat
 * @property string $tiempo_lactancia
 * @property boolean $recibio_biberon
 * @property string $tiempo_biberon
 * @property integer $personas_alim_olla
 * @property string $quien_cocina_casa
 * @property integer $num_comidas_diarias
 * @property string $donde_recibe_alim
 * @property integer $inicio_almient_compl
 * @property integer $horas_sueno 
 * @property string $desarrollo_psicomotor
 * @property string $examen_fisico
 * @property string $concepto_nutr
 * @property string $estrategia_intervencion
 * @property string $objetivo_aliment_nutr
 * @property string $diagnostico_clasif_nutr
 * @property string $fecha_ini_vnutr
 * @property string $fecha_modif_vnutr
 * @property boolean $val_hab_nutr
 * @property boolean $val_act_nutr
 * @property string $observ_estvalnutr
 * @property boolean $estado_val_nutr  
 *
 * The followings are the available model relations:
 * @property Antropometria[] $antropometrias
 * @property GrupocomidaValnutr[] $grupocomidaValnutrs
 * @property LaboratorioClinico[] $laboratorioClinicos
 * @property ModificacionValnutr[] $modificacionValnutrs
 * @property OrigenAlimentos[] $origenAlimentoses
 * @property NutricionAdol[] $nutricionAdols
 * @property ProfesionalValnutr[] $profesionalValnutrs
 * @property TipoDiscapacidad[] $tipoDiscapacidads
 * @property Apetito $idApetito
 * @property Digestion $idDigestion
 * @property EsquemaVacunacion $idEsquemaVac
 * @property EstadoValoracion $idEstadoVal
 * @property HabitoIntestinal $idHabIntest
 * @property Ingesta $idIngesta
 * @property Masticacion $idMasticacion
 * @property NivelActFis $idNivelActFis
 * @property TipoParto $idTipoParto
 * @property Adolescente $numDoc
 */
class ValoracionNutricional extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $fecha;
	public $nombreCampoValoracion;
	public $contenidoValoracion;
	public $campoFecha;
	public $contHist;
	 
	public function tableName()
	{
		return 'valoracion_nutricional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_esquema_vac, id_masticacion, id_apetito, id_digestion, id_estado_val, id_hab_intest, id_ingesta, id_nivel_act_fis, id_tipo_parto, personas_alim_olla, num_comidas_diarias, inicio_almient_compl, horas_sueno', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('semanas_gestacion, talla_nacim_cms, peso_nacim_kgs', 'length', 'max'=>20),
			array('tiempo_lactancia, tiempo_biberon, quien_cocina_casa, donde_recibe_alim', 'length', 'max'=>100),
			array('observaciones_nacim, patologicos, quirurgicos, hospitaliz_causas, alergicos, toxicos, familiares_nutr, otros_nutr, obs_esquema_vac, control_crec_des, obs_crec_des, medicamentos_nutr, procedencia_padres, alimentos_preferidos, alimentos_rechazados, alimentos_intolerados, supl_compl_nutr, recibio_leche_mat, recibio_biberon, quien_cocina_casa, donde_recibe_alim, desarrollo_psicomotor, examen_fisico, concepto_nutr, estrategia_intervencion, objetivo_aliment_nutr, diagnostico_clasif_nutr, fecha_ini_vnutr, fecha_modif_vnutr, val_hab_nutr, val_act_nutr, observ_estvalnutr, estado_val_nutr', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_val_nutricion, id_esquema_vac, id_masticacion, id_apetito, id_digestion, id_estado_val, id_hab_intest, id_ingesta, id_nivel_act_fis, num_doc, id_tipo_parto, semanas_gestacion, talla_nacim_cms, peso_nacim_kgs, observaciones_nacim, patologicos, quirurgicos, hospitaliz_causas, alergicos, toxicos, familiares_nutr, otros_nutr, obs_esquema_vac, control_crec_des, obs_crec_des, medicamentos_nutr, procedencia_padres, alimentos_preferidos, alimentos_rechazados, alimentos_intolerados, supl_compl_nutr, recibio_leche_mat, tiempo_lactancia, recibio_biberon, tiempo_biberon, personas_alim_olla, quien_cocina_casa, num_comidas_diarias, donde_recibe_alim, inicio_almient_compl, horas_sueno, desarrollo_psicomotor, examen_fisico, concepto_nutr, estrategia_intervencion, objetivo_aliment_nutr, diagnostico_clasif_nutr, fecha_ini_vnutr, fecha_modif_vnutr, val_hab_nutr, val_act_nutr, observ_estvalnutr, estado_val_nutr', 'safe', 'on'=>'search'),
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
			'antropometrias' => array(self::HAS_MANY, 'Antropometria', 'id_val_nutricion'),
			'grupocomidaValnutrs' => array(self::HAS_MANY, 'GrupocomidaValnutr', 'id_val_nutricion'),
			'laboratorioClinicos' => array(self::MANY_MANY, 'LaboratorioClinico', 'labclin_valnutr(id_val_nutricion, id_laboratorio)'),
			'modificacionValnutrs' => array(self::HAS_MANY, 'ModificacionValnutr', 'id_val_nutricion'),
			'origenAlimentoses' => array(self::MANY_MANY, 'OrigenAlimentos', 'origenalim_valnutr(id_val_nutricion, id_origen_alim)'),
			'nutricionAdols' => array(self::HAS_MANY, 'NutricionAdol', 'id_val_nutricion'),
			'profesionalValnutrs' => array(self::HAS_MANY, 'ProfesionalValnutr', 'id_val_nutricion'),
			'tipoDiscapacidads' => array(self::MANY_MANY, 'TipoDiscapacidad', 'tipodisc_valnutr(id_val_nutricion, id_tipo_discap)'),
			'idApetito' => array(self::BELONGS_TO, 'Apetito', 'id_apetito'),
			'idDigestion' => array(self::BELONGS_TO, 'Digestion', 'id_digestion'),
			'idEsquemaVac' => array(self::BELONGS_TO, 'EsquemaVacunacion', 'id_esquema_vac'),
			'idEstadoVal' => array(self::BELONGS_TO, 'EstadoValoracion', 'id_estado_val'),
			'idHabIntest' => array(self::BELONGS_TO, 'HabitoIntestinal', 'id_hab_intest'),
			'idIngesta' => array(self::BELONGS_TO, 'Ingesta', 'id_ingesta'),
			'idMasticacion' => array(self::BELONGS_TO, 'Masticacion', 'id_masticacion'),
			'idModvalnutr' => array(self::BELONGS_TO, 'ModificacionValnutr', 'id_modvalnutr'),
			'idTipoParto' => array(self::BELONGS_TO, 'TipoParto', 'id_tipo_parto'),
			'idNivelActFis' => array(self::BELONGS_TO, 'NivelActFis', 'id_nivel_act_fis'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_val_nutricion' => 'Id Val Nutricion',
			'id_esquema_vac' => 'Esquema vacunación',
			'id_masticacion' => 'Masticación',
			'id_apetito' => 'Apetito',			
			'id_digestion' => 'Digestión',
			'id_estado_val' => 'Estado valoración',
			'id_hab_intest' => 'Hábito intestinal',
			'id_ingesta' => 'Ingesta',
			'id_nivel_act_fis'=>'Nivel actividad física',
			'num_doc' => 'Num Doc',
			'id_tipo_parto' => 'Tipo de parto',
			'id_modvalnutr' => 'Id Modvalnutr',
			'semanas_gestacion' => 'Semanas de gestación',
			'talla_nacim_cms' => 'Talla al nacer (cms)',
			'peso_nacim_kgs' => 'Peso al nacer (kgs)',
			'observaciones_nacim' => 'Observaciones al nacer',
			'patologicos' => 'Patológicos',
			'quirurgicos' => 'Quirúrgicos',
			'hospitaliz_causas' => 'Hosptialización y # de causas',//hospitaliz_causas
			'alergicos' => 'Alérgicos',
			'toxicos' => 'Tóxicos',
			'familiares_nutr' => 'Familiares',
			'otros_nutr' => 'Otros',
			'obs_esquema_vac' => 'Observación del esquema de vacunación',
			'control_crec_des' => 'Control crecimiento y desarrollo',
			'obs_crec_des' => 'Observación de control crecimiento y desarrollo',
			'medicamentos_nutr' => 'Medicamentos Nutr',
			'procedencia_padres' => 'Procedencia de los padres',
			'alimentos_preferidos' => 'Alimentos Preferidos',
			'alimentos_rechazados' => 'Alimentos Rechazados',
			'alimentos_intolerados' => 'Alimentos Intolerados',
			'supl_compl_nutr' => 'Suplempentos o complementos nutricionales',
			'recibio_leche_mat' => '¿Recibió leche materna?',
			'tiempo_lactancia' => 'Tiempo de lactancia',
			'recibio_biberon' => '¿Recibió biberón?',
			'tiempo_biberon' => 'Tiempo biberón',
			'personas_alim_olla' => '#Personas que comen de la misma olla  ',
			'quien_cocina_casa' => '¿Quién cocina en la casa?',
			'num_comidas_diarias' => 'Número de comidas diarias',
			'donde_recibe_alim' => '¿Dónde recibe los alimentos?',
			'inicio_almient_compl' => '¿A qué edad comenzó la alimentación complementaria?',
			'horas_sueno'=>'Horas de sueño',
			'desarrollo_psicomotor' => 'Desarrollo Psicomotor',
			'examen_fisico' => 'Examen Físico',
			'concepto_nutr' => 'Concepto nutricional',
			'estrategia_intervencion' => 'Estrategias de intervención',
			'objetivo_aliment_nutr' => 'Objetivos alimentarios  y nutricionales',
			'diagnostico_clasif_nutr' => 'Diagnóstico / clasificación nutricional',
			'fecha_ini_vnutr' => 'Fecha Ini Vnutr',
			'fecha_modif_vnutr' => 'Fecha Modif Vnutr',
			'val_hab_nutr' => 'Val Hab Nutr',
			'val_act_nutr' => 'Val Act Nutr',
			'observ_estvalnutr' => 'Observ Estvalnutr',
			'estado_val_nutr' => 'Estado Val Nutr',
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

		$criteria->compare('id_val_nutricion',$this->id_val_nutricion);
		$criteria->compare('id_esquema_vac',$this->id_esquema_vac);
		$criteria->compare('id_masticacion',$this->id_masticacion);
		$criteria->compare('id_apetito',$this->id_apetito);
		$criteria->compare('id_digestion',$this->id_digestion);
		$criteria->compare('id_estado_val',$this->id_estado_val);
		$criteria->compare('id_hab_intest',$this->id_hab_intest);
		$criteria->compare('id_ingesta',$this->id_ingesta);
		$criteria->compare('id_nivel_act_fis',$this->id_nivel_act_fis);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_tipo_parto',$this->id_tipo_parto);
		$criteria->compare('semanas_gestacion',$this->semanas_gestacion,true);
		$criteria->compare('talla_nacim_cms',$this->talla_nacim_cms,true);
		$criteria->compare('peso_nacim_kgs',$this->peso_nacim_kgs,true);
		$criteria->compare('observaciones_nacim',$this->observaciones_nacim,true);
		$criteria->compare('patologicos',$this->patologicos,true);
		$criteria->compare('quirurgicos',$this->quirurgicos,true);
		$criteria->compare('hospitaliz_causas',$this->hospitaliz_causas,true);
		$criteria->compare('alergicos',$this->alergicos,true);
		$criteria->compare('toxicos',$this->toxicos,true);
		$criteria->compare('familiares_nutr',$this->familiares_nutr,true);
		$criteria->compare('otros_nutr',$this->otros_nutr,true);
		$criteria->compare('obs_esquema_vac',$this->obs_esquema_vac,true);
		$criteria->compare('control_crec_des',$this->control_crec_des);
		$criteria->compare('obs_crec_des',$this->obs_crec_des,true);
		$criteria->compare('medicamentos_nutr',$this->medicamentos_nutr,true);
		$criteria->compare('procedencia_padres',$this->procedencia_padres,true);
		$criteria->compare('alimentos_preferidos',$this->alimentos_preferidos,true);
		$criteria->compare('alimentos_rechazados',$this->alimentos_rechazados,true);
		$criteria->compare('alimentos_intolerados',$this->alimentos_intolerados,true);
		$criteria->compare('supl_compl_nutr',$this->supl_compl_nutr,true);
		$criteria->compare('recibio_leche_mat',$this->recibio_leche_mat);
		$criteria->compare('tiempo_lactancia',$this->tiempo_lactancia,true);
		$criteria->compare('recibio_biberon',$this->recibio_biberon);
		$criteria->compare('tiempo_biberon',$this->tiempo_biberon,true);
		$criteria->compare('personas_alim_olla',$this->personas_alim_olla);
		$criteria->compare('quien_cocina_casa',$this->quien_cocina_casa,true);
		$criteria->compare('num_comidas_diarias',$this->num_comidas_diarias);
		$criteria->compare('donde_recibe_alim',$this->donde_recibe_alim,true);
		$criteria->compare('inicio_almient_compl',$this->inicio_almient_compl);
		$criteria->compare('desarrollo_psicomotor',$this->desarrollo_psicomotor,true);
		$criteria->compare('horas_sueno',$this->horas_sueno,true);
		$criteria->compare('examen_fisico',$this->examen_fisico,true);
		$criteria->compare('concepto_nutr',$this->concepto_nutr,true);
		$criteria->compare('estrategia_intervencion',$this->estrategia_intervencion,true);
		$criteria->compare('objetivo_aliment_nutr',$this->objetivo_aliment_nutr,true);
		$criteria->compare('diagnostico_clasif_nutr',$this->diagnostico_clasif_nutr,true);
		$criteria->compare('fecha_ini_vnutr',$this->fecha_ini_vnutr,true);
		$criteria->compare('fecha_modif_vnutr',$this->fecha_modif_vnutr,true);
		$criteria->compare('val_hab_nutr',$this->val_hab_nutr);
		$criteria->compare('val_act_nutr',$this->val_act_nutr);
		$criteria->compare('observ_estvalnutr',$this->observ_estvalnutr,true);
		$criteria->compare('estado_val_nutr',$this->estado_val_nutr);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ValoracionNutricional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	//crea registro en limpio de valoración para luego ser modificado.
	public function creaRegValNutrAdol(){
		$conect=Yii::app()->db;
		$sqlCreaValNutr="insert into valoracion_nutricional (id_val_nutricion,num_doc,val_act_nutr) values (default,:num_doc,'true') returning id_val_nutricion";
		$creaValNutr=$conect->createCommand($sqlCreaValNutr);
		$creaValNutr->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readValNutr=$creaValNutr->query();
		$resValNutr=$readValNutr->read();
		$readValNutr->close();
		return $resValNutr["id_val_nutricion"];
	}
	public function consultaIdValNutr(){
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsIdValNutr="select * from valoracion_nutricional where num_doc=$1 and val_act_nutr='true'";
		$res=pg_prepare($linkBd,"consValNutr",$sqlConsIdValNutr);
		$res=pg_execute($linkBd, "consValNutr", array($this->num_doc));
		$consIdValNutr=array();
		$consIdValNutr=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consIdValNutr;		
	}
	public function consValHab(){
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsHabVal="select val_hab_nutr from valoracion_nutricional where num_doc=$1 and val_act_nutr='true'";
		$res=pg_prepare($linkBd,"consValHabNutr",$sqlConsHabVal);
		$res=pg_execute($linkBd, "consValHabNutr", array($this->num_doc));
		$consValHabNutr=array();
		$consValHabNutr=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consValHabNutr;				
	}
	public function modValHabFalse(){
		$conect=Yii::app()->db;
		$sqlActHabVal="update valoracion_nutricional set val_hab_nutr='false' where num_doc=:num_doc";
		$actHabVal=$conect->createCommand($sqlActHabVal);
		$actHabVal->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$actHabVal->execute();		
	}
	public function consLabClinicosAdol(){
		$conect=Yii::app()->db;
		$sqlConsLabClin="select * from labclin_valnutr where id_val_nutricion=:id_val_nutricion";
		$consLabClin=$conect->createCommand($sqlConsLabClin);
		$consLabClin->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_STR);
		$readLabClin=$consLabClin->query();
		$resLabClin=$readLabClin->readAll();
		$readLabClin->close();
		return $resLabClin;		
	}
	public function consRecibLecheMat(){
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsConsLecheMat="select recibio_leche_mat from valoracion_nutricional where id_val_nutricion=$1";
		$res=pg_prepare($linkBd,"consLechMat",$sqlConsConsLecheMat);
		$res=pg_execute($linkBd, "consLechMat", array($this->id_val_nutricion));
		$consLechMat=array();
		$consLechMat=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consLechMat;		
	}
	public function consRecibBiberon(){
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsConsBib="select recibio_biberon from valoracion_nutricional where id_val_nutricion=$1";
		$res=pg_prepare($linkBd,"consBib",$sqlConsConsBib);
		$res=pg_execute($linkBd, "consBib", array($this->id_val_nutricion));
		$consBib=array();
		$consBib=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consBib;		
	}
	public function modificaValoracionNutr($accion){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			if(empty($this->contenidoValoracion)){$this->contenidoValoracion=null;}
			$sqlModVal="update valoracion_nutricional 
				set ".pg_escape_string($this->nombreCampoValoracion)."=:contVal,
				".pg_escape_string($this->campoFecha)."=:fecha 
				where id_val_nutricion=:id_val_nutricion";
			$modVal=$conect->createCommand($sqlModVal);
			$modVal->bindParam(':fecha',$this->fecha,PDO::PARAM_STR);
			$modVal->bindParam(':contVal',$this->contenidoValoracion,PDO::PARAM_NULL);
			$modVal->bindParam(':id_val_nutricion',$this->id_val_nutricion,PDO::PARAM_INT);
			$modVal->execute();
			$this->creaRegProfVal($this->id_val_nutricion,$accion);
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function creaRegProfVal($idValoracion,$accion){
		$conect=Yii::app()->db;
		$fechaRegistro=date("Y-m-d");
		$sqlConsFechaMod="select fecha_regprvnutr from profesional_valnutr where id_val_nutricion=:id_val_nutricion and id_accval=:id_accval order by fecha_regprvnutr desc limit 1";
		$consFechaMod=$conect->createCommand($sqlConsFechaMod);
		$consFechaMod->bindParam(":id_val_nutricion",$idValoracion,PDO::PARAM_INT);
		$consFechaMod->bindParam(":id_accval",$accion,PDO::PARAM_INT);
		$readFechaMod=$consFechaMod->query();
		$resFechaMod=$readFechaMod->read();
		$readFechaMod->close();
		$creaRegistro=false;
		
		if(empty($resFechaMod["fecha_regprvnutr"])){
			$creaRegistro=true;
		}
		elseif($resFechaMod["fecha_regprvnutr"]!=$fechaRegistro){
			$creaRegistro=true;
		}
		if($creaRegistro==true){
			$sqlCreaRegProfVal="insert into profesional_valnutr (
				id_cedula,
				id_val_nutricion,
				id_accval,
				fecha_regprvnutr
			) values (
				:id_cedula,
				:id_val_nutricion,
				:id_accval,
				:fecha_regprvnutr			
			)";	
			$creaRegProfVal=$conect->createCommand($sqlCreaRegProfVal);	
			$creaRegProfVal->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_val_nutricion",$idValoracion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":id_accval",$accion,PDO::PARAM_INT);
			$creaRegProfVal->bindParam(":fecha_regprvnutr",$fechaRegistro,PDO::PARAM_STR);
			$creaRegProfVal->execute();		
		}					
	}
	public function regHistoricoValNutr(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegHist="insert into modificacion_valnutr (
				id_modvalnutr,
				id_val_nutricion,
				id_cedula,						
				modvnutr,
				nomb_campovnutr,
				fecha_mod_valnutr
			) values (
				default,
				:id_val_nutricion,
				:id_cedula,						
				:modvnutr,
				:nomb_campovnutr,
				:fecha_mod_valnutr
			)";//
			$regHist=$conect->createCommand($sqlRegHist);
			$fecha=date("Y-m-d H:i:s");
			$regHist->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regHist->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regHist->bindParam(":modvnutr",$this->contHist,PDO::PARAM_STR);
			$regHist->bindParam(":nomb_campovnutr",$this->nombreCampoValoracion,PDO::PARAM_STR);
			$regHist->bindParam(":fecha_mod_valnutr",$fecha,PDO::PARAM_STR);
			$regHist->execute();
			$transaction->commit();
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
		}
	}
	public function conultaInfEsch(){
		$conect=Yii::app()->db;
		$sqlConsInfEsq="select column_name,udt_name,data_type from information_schema.columns where table_name='valoracion_nutricional'";	
		$consInfEsq=$conect->createCommand($sqlConsInfEsq);
		$readInfEsq=$consInfEsq->query();	
		$resInfEsq=$readInfEsq->readAll();
		$readInfEsq->close();
		return $resInfEsq;
	}
	public function consultaContenidoCampo(){
		$conect=Yii::app()->db;
		$sqlConsCampoVal="select ".pg_escape_string($this->nombreCampoValoracion)." from valoracion_nutricional where id_val_nutricion=:id_val_nutricion";
		$consCampoVal=$conect->createCommand($sqlConsCampoVal);
		$consCampoVal->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$readCampoVal=$consCampoVal->query();
		$resCampoVal=$readCampoVal->read();
		$readCampoVal->close();
		return $resCampoVal;
	//pg_escape_string($this->nombreCampoValoracion)	
	}
	public function consultaContenidoCampoBool($linkBd,$id){	
		$sqlConsEsqBool="select ".pg_escape_string($this->nombreCampoValoracion)." from valoracion_nutricional where id_val_nutricion=$1";
		$res=pg_prepare($linkBd,"consEsqBopl".$id,$sqlConsEsqBool);
		$res=pg_execute($linkBd, "consEsqBopl".$id,array($this->id_val_nutricion));
		$consSolCS=array();
		$consSolCS=pg_fetch_array($res);
		pg_free_result($res);
		return $consSolCS;
	}
}
