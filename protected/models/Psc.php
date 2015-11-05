<?php

/**
 * This is the model class for table "psc".
 *
 * The followings are the available columns in table 'psc':
 * @property string $id_psc
 * @property string $num_doc
 * @property string $id_cedula
 * @property integer $id_institucionpsc
 * @property integer $id_sector_psc
 * @property string $fecha_inicio_psc
 * @property string $fecha_fin_psc
 * @property boolean $firma_acuerdos
 * @property integer $horas_semana
 * @property boolean $culminacion
 * @property string $observaciones_psc
 * @property string $responsable_psc
 * @property string $telefono_resp
 * @property integer $num_dias_psc
 *
 * The followings are the available model relations:
 * @property DiaHora[] $diaHoras
 * @property DiaHora[] $diaHoras1
 * @property Adolescente $numDoc
 * @property InstitucionPsc $idInstitucionpsc
 * @property Persona $idCedula
 * @property SectorPsc $idSectorPsc
 * @property SeguimientoPsc[] $seguimientoPscs
 * @property SeguimientoPsc[] $seguimientoPscs1
 */
class Psc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $diasPrestacion;
	public $nueva_institucionpsc;	
	public $id_sector_psc;
	public function tableName()
	{
		return 'psc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc', 'required'),
			array('id_institucionpsc, id_sector_psc, horas_semana, num_dias_psc', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('responsable_psc, telefono_resp,nueva_institucionpsc', 'length', 'max'=>50),
			array('id_cedula, fecha_inicio_psc, fecha_fin_psc, firma_acuerdos, culminacion, observaciones_psc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_psc, num_doc, id_cedula, id_institucionpsc, id_sector_psc, fecha_inicio_psc, fecha_fin_psc, firma_acuerdos, horas_semana, culminacion, observaciones_psc, responsable_psc, telefono_resp, num_dias_psc', 'safe', 'on'=>'search'),
			array('id_institucionpsc','validaInstitucion'),
			array('nueva_institucionpsc','validaNuevaInstitucion')
		);
	}
	public function validaInstitucion($attribute=NULL,$params=NULL){
		if(isset($_POST["Psc"]["id_institucionpsc"]) && !empty($_POST["Psc"]["id_institucionpsc"])){
			
			$dataInput=Yii::app()->input->post();
			$this->num_doc=$dataInput["Psc"]["num_doc"];
			$this->id_institucionpsc=$dataInput["Psc"]["id_institucionpsc"];
			//consulta psc sin culminar de acuerdo al instituto.  Si tiene una psc en el mismo instituto sin culminar no dejará crear otro servicio.
			$consultaPai=$this->consultaPscSinCulmInstituto();
			if(!empty($consultaPai)){
				$this->addError($attribute,"Ya hay una prestación de servicios en esta institución y no ha culminado aún");
			}
		}		
	}
	public function validaNuevaInstitucion($attribute=NULL,$params=NULL){
		if(isset($_POST["Psc"]["id_institucionpsc"]) && $_POST["Psc"]["id_institucionpsc"]==0){
			
			$dataInput=Yii::app()->input->post();
			$this->id_institucionpsc=$dataInput["Psc"]["id_institucionpsc"];
			$this->nueva_institucionpsc=$dataInput["Psc"]["nueva_institucionpsc"];
			if(empty($this->nueva_institucionpsc)){
				$this->addError($attribute,"El campo nueva institución no puede ser nulo");
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
			'diaHoras' => array(self::HAS_MANY, 'DiaHora', 'id_psc'),
			'diaHoras1' => array(self::HAS_MANY, 'DiaHora', 'num_doc'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idInstitucionpsc' => array(self::BELONGS_TO, 'InstitucionPsc', 'id_institucionpsc'),
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
			'idSectorPsc' => array(self::BELONGS_TO, 'SectorPsc', 'id_sector_psc'),
			'seguimientoPscs' => array(self::HAS_MANY, 'SeguimientoPsc', 'id_psc'),
			'seguimientoPscs1' => array(self::HAS_MANY, 'SeguimientoPsc', 'num_doc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_psc' => 'Id Psc',
			'num_doc' => 'Número de documento del adolescente',
			'id_cedula' => 'Cédula del profesional',
			'id_institucionpsc' => 'Instituto donde se presta el servicio',
			'id_sector_psc' => 'Sector',
			'fecha_inicio_psc' => 'Fecha inicio de PSC',
			'fecha_fin_psc' => 'Fecha fin PSC',
			'firma_acuerdos' => 'Firma de acuerdos',
			'horas_semana' => 'Horas por semana',
			'culminacion' => 'Culminación',
			'observaciones_psc' => 'Observaciones PSC',
			'responsable_psc' => 'Persona de contacto',
			'telefono_resp' => 'Teléfono de contacto',
			'num_dias_psc' => 'Número de días de PSC',
			'nueva_institucionpsc'=>'Nueva organización'
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

		$criteria->compare('id_psc',$this->id_psc,true);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('id_institucionpsc',$this->id_institucionpsc);
		$criteria->compare('id_sector_psc',$this->id_sector_psc);
		$criteria->compare('fecha_inicio_psc',$this->fecha_inicio_psc,true);
		$criteria->compare('fecha_fin_psc',$this->fecha_fin_psc,true);
		$criteria->compare('firma_acuerdos',$this->firma_acuerdos);
		$criteria->compare('horas_semana',$this->horas_semana);
		$criteria->compare('culminacion',$this->culminacion);
		$criteria->compare('observaciones_psc',$this->observaciones_psc,true);
		$criteria->compare('responsable_psc',$this->responsable_psc,true);
		$criteria->compare('telefono_resp',$this->telefono_resp,true);
		$criteria->compare('num_dias_psc',$this->num_dias_psc);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Psc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaPscSinCulm(){
		$conect=Yii::app()->db;
		$sqlConsPsc="select * from psc where num_doc=:num_doc and id_estadopsc is null or num_doc=:num_doc and id_estadopsc>=3";
		$consPsc=$conect->createCommand($sqlConsPsc);
		$consPsc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readConsPsc=$consPsc->query();
		$resConsPsc=$readConsPsc->readAll();
		$readConsPsc->close();
		return $resConsPsc;	
	}
	public function consultaPscSinCulmInstituto(){
		$conect=Yii::app()->db;
		
		$sqlConsPsc="select * from psc where num_doc=:num_doc and id_estadopsc is null and id_institucionpsc=:id_institucionpsc 
			or num_doc=:num_doc and id_estadopsc>=3 and id_institucionpsc=:id_institucionpsc";
		$consPsc=$conect->createCommand($sqlConsPsc);
		$consPsc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consPsc->bindParam(":id_institucionpsc",$this->id_institucionpsc,PDO::PARAM_STR);
		$readConsPsc=$consPsc->query();
		$resConsPsc=$readConsPsc->readAll();
		$readConsPsc->close();
		return $resConsPsc;	
	}

	public function creaPsc(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaPsc="insert into psc (
				id_psc,
				num_doc,
				id_cedula,
				id_institucionpsc,
				id_estadopsc,
				fecha_inicio_psc,
				fecha_fin_psc,
				horas_semana,
				observaciones_psc,
				responsable_psc,
				telefono_resp,
				num_dias_psc
			) values (
				:id_psc,
				:num_doc,
				:id_cedula,
				:id_institucionpsc,
				4,
				:fecha_inicio_psc,
				:fecha_fin_psc,
				:horas_semana,
				:observaciones_psc,
				:responsable_psc,
				:telefono_resp,
				:num_dias_psc			
			)";
			$fechaRegistro=date("Y-m-d H:i:s");
			if(empty($this->observaciones_psc)){$this->observaciones_psc=null;}
			$creaPsc=$conect->createCommand($sqlCreaPsc);
			$creaPsc->bindParam(":id_psc",$fechaRegistro,PDO::PARAM_STR);
			$creaPsc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$creaPsc->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$creaPsc->bindParam(":id_institucionpsc",$this->id_institucionpsc,PDO::PARAM_INT);
			$creaPsc->bindParam(":fecha_inicio_psc",$this->fecha_inicio_psc,PDO::PARAM_STR);
			$creaPsc->bindParam(":fecha_fin_psc",$this->fecha_fin_psc,PDO::PARAM_STR);
			$creaPsc->bindParam(":horas_semana",$this->horas_semana,PDO::PARAM_INT);
			$creaPsc->bindParam(":observaciones_psc",$this->observaciones_psc,PDO::PARAM_NULL);
			$creaPsc->bindParam(":responsable_psc",$this->responsable_psc,PDO::PARAM_STR);
			$creaPsc->bindParam(":telefono_resp",$this->telefono_resp,PDO::PARAM_STR);
			$creaPsc->bindParam(":num_dias_psc",$this->num_dias_psc,PDO::PARAM_INT);
			$creaPsc->execute();
			
			foreach($this->diasPrestacion as $pk=>$diaPrestacion){
				$sqlCreaDias="insert into dia_hora (
					id_hora_dia,
					id_dia,
					id_psc,
					num_doc,
					hora_inicio,
					hora_fin,
					hora_inicio_m,
					hora_fin_m,
					horas_dia
				) values (
					default,
					:id_dia,
					:id_psc,
					:num_doc,
					:hora_inicio,
					:hora_fin,
					:hora_inicio_m,
					:hora_fin_m,
					:horas_dia
				)";
				$regDiaPres=$conect->createCommand($sqlCreaDias);
				$regDiaPres->bindParam(":id_dia",$diaPrestacion["dia"],PDO::PARAM_STR);
				$regDiaPres->bindParam(":id_psc",$fechaRegistro,PDO::PARAM_STR);
				$regDiaPres->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
				$regDiaPres->bindParam(":hora_inicio",$diaPrestacion["horaIniDia"],PDO::PARAM_STR);
				$regDiaPres->bindParam(":hora_fin",$diaPrestacion["hora_fin"],PDO::PARAM_STR);
				$regDiaPres->bindParam(":hora_inicio_m",$diaPrestacion["hora_inicio_m"],PDO::PARAM_STR);
				$regDiaPres->bindParam(":hora_fin_m",$diaPrestacion["hora_fin_m"],PDO::PARAM_STR);
				$regDiaPres->bindParam(":horas_dia",$diaPrestacion["hora_dia"],PDO::PARAM_INT);
				$regDiaPres->execute();
			}
			//crea Dia hora

			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
	public function consultaDiaHorario($fechaRegistro){
		$conect=Yii::app()->db;
		$sqlConsHorario="select * from dia_hora as a left join dia as b on a.id_dia=b.id_dia where num_doc=:num_doc and id_psc=:id_psc order by a.id_dia asc";
		$consHorario=$conect->createcommand($sqlConsHorario);
		$consHorario->bindParam(":id_psc",$fechaRegistro,PDO::PARAM_STR);
		$consHorario->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readConsHorario=$consHorario->query();
		$resConsHorario=$readConsHorario->readAll();
		$readConsHorario->close();
		return $resConsHorario;
	}
	public function registraOrganizacion(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaOrg="insert into institucion_psc (
				id_institucionpsc,
				id_sector_psc,
				institucionpsc,
				muestra_institucion
			) values (
				default,
				:id_sector_psc,
				:institucionpsc,
				'true'			
			) returning id_institucionpsc";
			$creaOrg=$conect->createCommand($sqlCreaOrg);
			$creaOrg->bindParam(':id_sector_psc',$this->id_sector_psc,PDO::PARAM_INT);
			$creaOrg->bindParam(':institucionpsc',$this->nueva_institucionpsc,PDO::PARAM_STR);
			$readOrg=$creaOrg->query();
			$resOrg=$readOrg->read();
			$readOrg->close();
			$transaction->commit();
			$this->id_institucionpsc=$resOrg["id_institucionpsc"];
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}		
	}
	public function consultaPscOff($offset){
		$conect=Yii::app()->db;
		$sqlConsPscDes="select * from psc as a 
			left join institucion_psc as b on b.id_institucionpsc=a.id_institucionpsc 
			left join sector_psc as c on c.id_sector_psc=b.id_sector_psc
			where num_doc=:num_doc limit 5 offset :offset";		
		$consPscDes=$conect->createCommand($sqlConsPscDes);
		$consPscDes->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consPscDes->bindParam(":offset",$offset,PDO::PARAM_INT);
		$readPscDes=$consPscDes->query();
		$resPscDes=$readPscDes->readAll();
		$readPscDes->close();
		return $resPscDes;			
	}
	public function consultaPsc(){
		$conect=Yii::app()->db;
		$sqlConsPscDes="select a.id_estadopsc as idestado,* from psc as a 
			left join institucion_psc as b on b.id_institucionpsc=a.id_institucionpsc 
			left join sector_psc as c on c.id_sector_psc=b.id_sector_psc
			left join estado_psc as d on d.id_estadopsc=a.id_estadopsc
			where num_doc=:num_doc and id_psc=:id_psc";		
		$consPscDes=$conect->createCommand($sqlConsPscDes);
		$consPscDes->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consPscDes->bindParam(":id_psc",$this->id_psc,PDO::PARAM_INT);
		$readPscDes=$consPscDes->query();
		$resPscDes=$readPscDes->read();
		$readPscDes->close();
		return $resPscDes;			
	}
	public function consultaPscSeg($offset){
		$conect=Yii::app()->db;
		$sqlConsPscDes="select * from psc as a 
			left join institucion_psc as b on b.id_institucionpsc=a.id_institucionpsc 
			left join sector_psc as c on c.id_sector_psc=b.id_sector_psc
			where num_doc=:num_doc and id_estadopsc >=3";		
		$consPscDes=$conect->createCommand($sqlConsPscDes);
		$consPscDes->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readPscDes=$consPscDes->query();
		$resPscDes=$readPscDes->readAll();
		$readPscDes->close();
		return $resPscDes;			
	}
	public function consultaPscInformeSeg(){
		$conect=Yii::app()->db;
		$sqlConsPscDes="select * from psc as a 
			left join institucion_psc as b on b.id_institucionpsc=a.id_institucionpsc 
			left join sector_psc as c on c.id_sector_psc=b.id_sector_psc
			where num_doc=:num_doc";		
		$consPscDes=$conect->createCommand($sqlConsPscDes);
		$consPscDes->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$readPscDes=$consPscDes->query();
		$resPscDes=$readPscDes->readAll();
		$readPscDes->close();
		return $resPscDes;			
	}

	public function consultaPscSegForm(){
		$conect=Yii::app()->db;
		$sqlConsPscDes="select a.id_estadopsc as idestado,* from psc as a 
			left join institucion_psc as b on b.id_institucionpsc=a.id_institucionpsc 
			left join sector_psc as c on c.id_sector_psc=b.id_sector_psc
			left join estado_psc as d on d.id_estadopsc=a.id_estadopsc
			where num_doc=:num_doc and id_psc=:id_psc";		
		$consPscDes=$conect->createCommand($sqlConsPscDes);
		$consPscDes->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consPscDes->bindParam(":id_psc",$this->id_psc,PDO::PARAM_INT);
		$readPscDes=$consPscDes->query();
		$resPscDes=$readPscDes->readAll();
		$readPscDes->close();
		return $resPscDes;			
	}
}
