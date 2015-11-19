<?php

/**
 * This is the model class for table "seguimiento_psc".
 *
 * The followings are the available columns in table 'seguimiento_psc':
 * @property integer $id_seguimiento_ind
 * @property string $id_psc
 * @property string $num_doc
 * @property string $id_cedula
 * @property string $desarrollo_act_psc
 * @property string $reporte_nov_psc
 * @property string $cump_acu_psc
 * @property string $fecha_seg_ind
 *
 * The followings are the available model relations:
 * @property AsistenciaPsc[] $asistenciaPscs
 * @property Psc $idPsc
 * @property Psc $numDoc
 * @property Persona $idCedula
 */
class SeguimientoPsc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $fechaAsistencia;
	public $fechas;
	public function tableName()
	{
		return 'seguimiento_psc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('desarrollo_act_psc, reporte_nov_psc, cump_acu_psc', 'required'),
			array('num_doc', 'length', 'max'=>15),
			array('id_psc, id_cedula', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_seguimiento_ind, id_psc, num_doc, id_cedula, desarrollo_act_psc, reporte_nov_psc, cump_acu_psc, fecha_seg_ind', 'safe', 'on'=>'search'),
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
			'asistenciaPscs' => array(self::HAS_MANY, 'AsistenciaPsc', 'id_seguimiento_ind'),
			'idPsc' => array(self::BELONGS_TO, 'Psc', 'id_psc'),
			'numDoc' => array(self::BELONGS_TO, 'Psc', 'num_doc'),
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_seguimiento_ind' => 'Seguimiento',
			'id_psc' => 'PSC',
			'num_doc' => 'Número de documento',
			'id_cedula' => 'Profesional',
			'desarrollo_act_psc' => 'Desarrollo de actividades PSC',
			'reporte_nov_psc' => 'Reporte de novedades',
			'cump_acu_psc' => 'Cumplimiento de acuerdos',
			'fecha_seg_ind' => 'Fecha seguimiento',
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

		$criteria->compare('id_seguimiento_ind',$this->id_seguimiento_ind);
		$criteria->compare('id_psc',$this->id_psc,true);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('desarrollo_act_psc',$this->desarrollo_act_psc,true);
		$criteria->compare('reporte_nov_psc',$this->reporte_nov_psc,true);
		$criteria->compare('cump_acu_psc',$this->cump_acu_psc,true);
		$criteria->compare('fecha_seg_ind',$this->fecha_seg_ind,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SeguimientoPsc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaInstituto($idInstituto){
		$conect=Yii::app()->db;
		$sqlConsInst="select institucionpsc from institucion_psc where id_institucionpsc=:id_institucionpsc";
		$consInst=$conect->createCommand($sqlConsInst);
		$consInst->bindParam(":id_institucionpsc",$idInstituto,PDO::PARAM_INT);
		$readConsInst=$consInst->query();
		$resConsInst=$readConsInst->read();
		$readConsInst->close();
		return $resConsInst;
	}
	public function compFechaAsistencia(){
		$conect=Yii::app()->db;
		$sqlConsFechaAsist="select * from seguimiento_psc as a left join asistencia_psc as b on a.id_seguimiento_ind=b.id_seguimiento_ind where id_psc=:id_psc and num_doc=:num_doc and fecha_asist_psc=:fecha_asist_psc";
		$consFechaAsist=$conect->createCommand($sqlConsFechaAsist);
		$consFechaAsist->bindParam(":id_psc",$this->id_psc,PDO::PARAM_STR);
		$consFechaAsist->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consFechaAsist->bindParam(":fecha_asist_psc",$this->fechaAsistencia,PDO::PARAM_STR);
		$readConsFechaAsist=$consFechaAsist->query();
		$resConsFechaAsist=$readConsFechaAsist->read();
		$consFechaAsist=$readConsFechaAsist->close();
		return $resConsFechaAsist;		
	}
	/**
	 *	Crea registro de seguimiento psc.
	 *	@param int id_seguimiento_ind.
	 *	@param int id_psc.
	 *	@param string num_doc.
	 *	@param int id_cedula.
	 *	@param string desarrollo_act_psc.
	 *	@param string reporte_nov_psc.
	 *	@param string cump_acu_psc.
	 *	@param string fecha_seg_ind.
	 *	@return resultado de la transacción
	 */		
	public function registraSeguimientoPsc(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegSegPsc="insert into seguimiento_psc (
				id_seguimiento_ind,
				id_psc,
				num_doc,
				id_cedula,
				desarrollo_act_psc,
				reporte_nov_psc,
				cump_acu_psc,
				fecha_seg_ind
			) values (
				default,
				:id_psc,
				:num_doc,
				:id_cedula,
				:desarrollo_act_psc,
				:reporte_nov_psc,
				:cump_acu_psc,
				:fecha_seg_ind
			)returning id_seguimiento_ind";
			$this->fecha_seg_ind=date("Y-m-d");
			$regSegPsc=$conect->createCommand($sqlRegSegPsc);
			$regSegPsc->bindParam(":id_psc",$this->id_psc,PDO::PARAM_STR);
			$regSegPsc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regSegPsc->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$regSegPsc->bindParam(":desarrollo_act_psc",$this->desarrollo_act_psc,PDO::PARAM_STR);
			$regSegPsc->bindParam(":reporte_nov_psc",$this->reporte_nov_psc,PDO::PARAM_STR);
			$regSegPsc->bindParam(":cump_acu_psc",$this->cump_acu_psc,PDO::PARAM_STR);
			$regSegPsc->bindParam(":fecha_seg_ind",$this->fecha_seg_ind,PDO::PARAM_STR);
			$readSegPsc=$regSegPsc->query();
			$resSegPsc=$readSegPsc->read();
			$readSegPsc->close();
			foreach($this->fechas as $pk=>$fecha){
				$sqlRegsAsist="insert into asistencia_psc (
					id_asist_psc,
					id_seguimiento_ind,
					fecha_asist_psc,
					num_hora
				) values (
					default,
					:id_seguimiento_ind,
					:fecha_asist_psc,
					:num_hora
				)";
				$regAsist=$conect->createCommand($sqlRegsAsist);
				$regAsist->bindParam(":id_seguimiento_ind",$resSegPsc["id_seguimiento_ind"],PDO::PARAM_INT);
				$regAsist->bindParam(":fecha_asist_psc",$fecha["fecha"],PDO::PARAM_STR);
				$regAsist->bindParam(":num_hora",$fecha["horas"],PDO::PARAM_INT);
				$regAsist->execute();
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
	 *	Retorna las horas de cumplimiento de una prestación de servicios a la comunidad.
	 *	@param string $this->num_doc.
	 *	@param int $this->id_psc.
	 *	@return $resHorasPsc horas de cumplimiento 
	 */		
	public function consHorasCumpPsc(){
		$conect=Yii::app()->db;
		$sqlConsHorasPsc="select num_hora from seguimiento_psc as a left join asistencia_psc as b on b.id_seguimiento_ind=a.id_seguimiento_ind 
			where num_doc=:num_doc and id_psc=:id_psc";
		$consHorasPsc=$conect->createCommand($sqlConsHorasPsc);
		$consHorasPsc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consHorasPsc->bindParam(":id_psc",$this->id_psc,PDO::PARAM_STR);
		$readHorasPsc=$consHorasPsc->query();
		$resHorasPsc=$readHorasPsc->readAll();
		$readHorasPsc->close();
		return $resHorasPsc;
	}
	/**
	 *	Retorna los seguimientos de una prestación de servicios a la comunidad.
	 *	@param string $this->num_doc.
	 *	@param int $this->id_psc.
	 *	@return $resSegPsc array con los seguimientos a la psc por parte del equipo psicoterapeutico
	 */		
	public function consSeguimientosPsc(){
		$conect=Yii::app()->db;
		$sqlConsSegPsc="select a.desarrollo_act_psc,a.reporte_nov_psc,a.cump_acu_psc, 
			a.fecha_seg_ind,(nombre_personal ||' '||apellidos_personal)as nombrespersona,f.nombre_rol,c.institucionpsc 
			from seguimiento_psc as a left join psc as b on b.id_psc=a.id_psc left join institucion_psc as c on c.id_institucionpsc=b.id_institucionpsc 
			left join persona as d on a.id_cedula=d.id_cedula 
			left join usuario as e on d.id_cedula=e.id_cedula 
			left join rol as f on f.id_rol=e.id_rol where a.num_doc=:num_doc and a.id_psc=:id_psc";
		$consSegPsc=$conect->createCommand($sqlConsSegPsc);
		$consSegPsc->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
		$consSegPsc->bindParam(":id_psc",$this->id_psc,PDO::PARAM_STR);
		$readSegPsc=$consSegPsc->query();
		$resSegPsc=$readSegPsc->readAll();
		$readSegPsc->close();
		return $resSegPsc;
	}
}
