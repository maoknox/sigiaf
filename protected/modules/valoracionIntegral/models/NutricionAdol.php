<?php

/**
 * This is the model class for table "nutricion_adol".
 *
 * The followings are the available columns in table 'nutricion_adol':
 * @property string $id_nutradol
 * @property string $id_cedula
 * @property integer $id_val_nutricion
 * @property integer $id_tipoact_pld
 * @property string $diagnostico_clasif_nutr_na
 * @property string $eval_cumpl_obj_alim
 * @property string $plan_nutr
 * @property string $ant_salud_al_cl
 * @property string $fecha_segnutr 
 *
 * The followings are the available model relations:
 * @property AntropSeguimientonutr[] $antropSeguimientonutrs
 * @property AntropSeguimientonutr[] $antropSeguimientonutrs1
 * @property GrupocomidaNutradol[] $grupocomidaNutradols
 * @property GrupocomidaNutradol[] $grupocomidaNutradols1
 * @property PorcionesComida[] $porcionesComidas
 * @property PorcionesComida[] $porcionesComidas1
 * @property Persona $idCedula 
 * @property TipoActuacionNutr $idTipoactPld
 * @property ValoracionNutricional $idValNutricion
 */
class NutricionAdol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nutricion_adol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_nutradol, id_cedula, id_val_nutricion, id_tipoact_pld', 'required'),
			array('id_val_nutricion, id_tipoact_pld', 'numerical', 'integerOnly'=>true),
			array('diagnostico_clasif_nutr_na, eval_cumpl_obj_alim, plan_nutr, ant_salud_al_cl, fecha_segnutr', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_nutradol, id_cedula,id_val_nutricion, id_tipoact_pld, diagnostico_clasif_nutr_na, eval_cumpl_obj_alim, plan_nutr, ant_salud_al_cl, fecha_segnutr', 'safe', 'on'=>'search'),
			array('ant_salud_al_cl','validaAntSalud'),
			array('plan_nutr','validaPlanNutr'),
			array('eval_cumpl_obj_alim','validaEvalCumpl'),
			array('diagnostico_clasif_nutr_na','validaDiagnostico'),
		);
	}
	public function validaAntSalud($attribute=NULL,$params=NULL){
		if(!$this->hasErrors()){
			$datosInput=Yii::app()->input->post();
			$datosInput["NutricionAdol"]["id_tipoact_pld"];
			if($datosInput["NutricionAdol"]["id_tipoact_pld"]==2 && strlen($datosInput["NutricionAdol"]["ant_salud_al_cl"])<15){
				$this->addError($attribute,"Debe diligenciar este campo");
			}
		}
	}
	public function validaPlanNutr($attribute=NULL,$params=NULL){
		//if(!$this->hasErrors()){
			$datosInput=Yii::app()->input->post();
			$datosInput["NutricionAdol"]["id_tipoact_pld"];
			if($datosInput["NutricionAdol"]["id_tipoact_pld"]==2 && strlen($datosInput["NutricionAdol"]["plan_nutr"])<15){
				$this->addError($attribute,"Debe diligenciar este campo");
			}
		//}
	}
	public function validaEvalCumpl($attribute=NULL,$params=NULL){
		//if(!$this->hasErrors()){
			$datosInput=Yii::app()->input->post();
			$datosInput["NutricionAdol"]["id_tipoact_pld"];
			if($datosInput["NutricionAdol"]["id_tipoact_pld"]==2 && strlen($datosInput["NutricionAdol"]["eval_cumpl_obj_alim"])<15){
				$this->addError($attribute,"Debe diligenciar este campo");
			}
		//}
	}
	public function validaDiagnostico($attribute=NULL,$params=NULL){
		//if(!$this->hasErrors()){
			$datosInput=Yii::app()->input->post();
			$datosInput["NutricionAdol"]["id_tipoact_pld"];
			if($datosInput["NutricionAdol"]["id_tipoact_pld"]==2 && strlen($datosInput["NutricionAdol"]["diagnostico_clasif_nutr_na"])<15){
				$this->addError($attribute,"Debe diligenciar este campo");
			}
		//}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'antropSeguimientonutrs' => array(self::HAS_MANY, 'AntropSeguimientonutr', 'id_nutradol'),
			'antropSeguimientonutrs1' => array(self::HAS_MANY, 'AntropSeguimientonutr', 'id_val_nutricion'),
			'grupocomidaNutradols' => array(self::HAS_MANY, 'GrupocomidaNutradol', 'id_nutradol'),
			'grupocomidaNutradols1' => array(self::HAS_MANY, 'GrupocomidaNutradol', 'id_val_nutricion'),
			'porcionesComidas' => array(self::HAS_MANY, 'PorcionesComida', 'id_nutradol'),
			'porcionesComidas1' => array(self::HAS_MANY, 'PorcionesComida', 'id_val_nutricion'),
			'idCedula' => array(self::BELONGS_TO, 'Persona', 'id_cedula'),
			'idTipoactPld' => array(self::BELONGS_TO, 'TipoActuacionNutr', 'id_tipoact_pld'),
			'idValNutricion' => array(self::BELONGS_TO, 'ValoracionNutricional', 'id_val_nutricion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_nutradol' => 'Id Nutradol',
			'id_cedula' => 'Id Cedula',
			'id_val_nutricion' => 'Id Val Nutricion',
			'id_tipoact_pld' => 'Id Tipoact Pld',
			'diagnostico_clasif_nutr_na' => 'Diagnostico/Clasificación nutricional',
			'eval_cumpl_obj_alim' => 'Evaluación de cumplimiento a los objetivos alimentarios y nutricionales propuestos',
			'plan_nutr' => 'Plan nutricional',
			'ant_salud_al_cl' => 'Modificación antecedentes de salud, alimentarios o clínicos.',
			'fecha_segnutr' => 'Fecha Segnutr',
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

		$criteria->compare('id_nutradol',$this->id_nutradol,true);
		$criteria->compare('id_val_nutricion',$this->id_val_nutricion);
		$criteria->compare('id_tipoact_pld',$this->id_tipoact_pld);
		$criteria->compare('diagnostico_clasif_nutr_na',$this->diagnostico_clasif_nutr_na,true);
		$criteria->compare('eval_cumpl_obj_alim',$this->eval_cumpl_obj_alim,true);
		$criteria->compare('plan_nutr',$this->plan_nutr,true);
		$criteria->compare('ant_salud_al_cl',$this->ant_salud_al_cl,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NutricionAdol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaPlanDietario(){
		$conect= Yii::app()->db;
		$sqlPlanDietario="select * from nutricion_adol where id_val_nutricion=:id_val_nutricion and id_tipoact_pld=:id_tipoact_pld";	
		$consPlanDietario=$conect->createCommand($sqlPlanDietario);
		$consPlanDietario->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$consPlanDietario->bindParam(":id_tipoact_pld",$this->id_tipoact_pld,PDO::PARAM_INT);
		$readPlanDietario=$consPlanDietario->query();
		$resPlanDietario=$readPlanDietario->read();
		$readPlanDietario->close();
		return $resPlanDietario;					
	}
	
	public function consultaPlanDietarioSeg(){
		$conect= Yii::app()->db;
		$sqlPlanDietario="select * from nutricion_adol as a 
			left join porciones_comida as b on b.id_nutradol=a.id_nutradol 
			where a.id_val_nutricion=:id_val_nutricion and id_grupo_comida is not null 
			order by fecha_segnutr desc limit 1";	
		$consPlanDietario=$conect->createCommand($sqlPlanDietario);
		$consPlanDietario->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$readPlanDietario=$consPlanDietario->query();
		$resPlanDietario=$readPlanDietario->read();
		$readPlanDietario->close();
		return $resPlanDietario;					
	}
	
	public function consultaNutricionAdolSeg(){
		$conect= Yii::app()->db;
		$sqlPlanDietario="select * from nutricion_adol as a 
			left join persona as b on b.id_cedula=a.id_cedula 
			left join usuario as c on c.id_cedula=b.id_cedula 
			left join rol as d on d.id_rol=c.id_rol 
			left join antrop_seguimientonutr as e on e.id_nutradol=a.id_nutradol and e.id_val_nutricion=a.id_val_nutricion 
			left join antropometria as f on f.id_antropometria=e.id_antropometria 
			where a.id_val_nutricion=:id_val_nutricion and id_tipoact_pld=:id_tipoact_pld order by fecha_segnutr desc";	
		$consPlanDietario=$conect->createCommand($sqlPlanDietario);
		$consPlanDietario->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$consPlanDietario->bindParam(":id_tipoact_pld",$this->id_tipoact_pld,PDO::PARAM_INT);
		$readPlanDietario=$consPlanDietario->query();
		$resPlanDietario=$readPlanDietario->readAll();
		$readPlanDietario->close();
		return $resPlanDietario;					
	}
	public function creaRegNutricion(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegNutrAdol="insert into nutricion_adol (
				id_nutradol,
				id_cedula,
				id_val_nutricion,
				id_tipoact_pld,				
				fecha_segnutr			
			) values (
				:id_nutradol,
				:id_cedula,
				:id_val_nutricion,
				:id_tipoact_pld,				
				:fecha_segnutr			
			)";
			$this->id_nutradol=date("Y-m-d H:m:s");
			$fechaSeg=date("Y-m-d");
			$regNutrAdol=$conect->createCommand($sqlRegNutrAdol);
			$regNutrAdol->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_STR);
			$regNutrAdol->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_STR);			
			$regNutrAdol->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regNutrAdol->bindParam(":id_tipoact_pld",$this->id_tipoact_pld,PDO::PARAM_INT);
			$regNutrAdol->bindParam(":fecha_segnutr",$fechaSeg,PDO::PARAM_STR);
			$regNutrAdol->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){			
			$transaction->rollBack();
			return $e;
		}		
	}
	public function creaRegNutricionSeguimiento(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegNutrAdol="insert into nutricion_adol (
				id_nutradol,
				id_cedula,
				id_val_nutricion,
				id_tipoact_pld,	
				diagnostico_clasif_nutr_na,
				eval_cumpl_obj_alim,
				plan_nutr,
				ant_salud_al_cl,	
				fecha_segnutr			
			) values (
				:id_nutradol,
				:id_cedula,
				:id_val_nutricion,
				:id_tipoact_pld,
				:diagnostico_clasif_nutr_na,
				:eval_cumpl_obj_alim,
				:plan_nutr,
				:ant_salud_al_cl,				
				:fecha_segnutr			
			)";
			$this->id_nutradol=date("Y-m-d H:m:s");
			$fechaSeg=date("Y-m-d");
			$regNutrAdol=$conect->createCommand($sqlRegNutrAdol);
			$regNutrAdol->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_STR);
			$regNutrAdol->bindParam(":id_cedula",Yii::app()->user->getState('cedula'),PDO::PARAM_STR);						
			$regNutrAdol->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regNutrAdol->bindParam(":id_tipoact_pld",$this->id_tipoact_pld,PDO::PARAM_INT);
			$regNutrAdol->bindParam(":diagnostico_clasif_nutr_na",$this->diagnostico_clasif_nutr_na,PDO::PARAM_NULL);
			$regNutrAdol->bindParam(":eval_cumpl_obj_alim",$this->eval_cumpl_obj_alim,PDO::PARAM_NULL);
			$regNutrAdol->bindParam(":plan_nutr",$this->plan_nutr,PDO::PARAM_NULL);
			$regNutrAdol->bindParam(":ant_salud_al_cl",$this->ant_salud_al_cl,PDO::PARAM_NULL);
			$regNutrAdol->bindParam(":fecha_segnutr",$fechaSeg,PDO::PARAM_STR);
			$regNutrAdol->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){			
			$transaction->rollBack();
			return $e;
		}		
	}
	public function modRegNutricionSeguimiento(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegNutrAdol="update nutricion_adol set 	
				diagnostico_clasif_nutr_na=:diagnostico_clasif_nutr_na,
				eval_cumpl_obj_alim=:eval_cumpl_obj_alim,
				plan_nutr=:plan_nutr,
				ant_salud_al_cl=:ant_salud_al_cl
			where
				id_nutradol=:id_nutradol and 
				id_val_nutricion=:id_val_nutricion and
				id_tipoact_pld=id_tipoact_pld and				
			";
			$regNutrAdol=$conect->createCommand($sqlRegNutrAdol);
			$regNutrAdol->bindParam(":id_nutradol",$this->id_nutradol,PDO::PARAM_STR);
			$regNutrAdol->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regNutrAdol->bindParam(":id_tipoact_pld",$this->id_tipoact_pld,PDO::PARAM_INT);
			$regNutrAdol->bindParam(":diagnostico_clasif_nutr_na",$this->diagnostico_clasif_nutr_na,PDO::PARAM_NULL);
			$regNutrAdol->bindParam(":eval_cumpl_obj_alim",$this->eval_cumpl_obj_alim,PDO::PARAM_NULL);
			$regNutrAdol->bindParam(":plan_nutr",$this->plan_nutr,PDO::PARAM_NULL);
			$regNutrAdol->bindParam(":ant_salud_al_cl",$this->ant_salud_al_cl,PDO::PARAM_NULL);
			$regNutrAdol->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){			
			$transaction->rollBack();
			return $e;
		}		
	}
}
