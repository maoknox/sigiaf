<?php
/**
 * This is the model class for table "cforjar_personal".
 *
 * The followings are the available columns in table 'cforjar_personal':
 * @property string $id_forjar
 * @property string $id_cedula
 */
class CforjarPersonal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cforjar_personal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_forjar, id_cedula', 'required'),
			array('id_forjar', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_forjar, id_cedula', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_forjar' => 'Sede Forjar',
			'id_cedula' => 'Funcionario',
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

		$criteria->compare('id_forjar',$this->id_forjar,true);
		$criteria->compare('id_cedula',$this->id_cedula,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CforjarPersonal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	@param int $this->id_cedula.	
	 *	@return $resSedeFuncionario sedes que el usuario tiene asociadas.
	 */		
	public function consultarSedeFuncionario(){
		$conect=Yii::app()->db;		
		$sqlConsSedeFuncionario="select id_cedula,a.id_forjar,nombre_sede from cforjar_personal as a left join centro_forjar as b on b.id_forjar=a.id_forjar where id_cedula=:id_cedula";
		$consSedeFuncionario=$conect->createCommand($sqlConsSedeFuncionario);
		$consSedeFuncionario->bindParam(":id_cedula",$this->id_cedula);
		$readSedeFuncionario=$consSedeFuncionario->query();
		$resSedeFuncionario=$readSedeFuncionario->readAll();
		$readSedeFuncionario->close();			
		return $resSedeFuncionario;	
	}
	
	/**
	 *	@param bool $this->areacforjar_activa.
	 *	@return retorna consulta si tiene asignado un adolescente actualmente, aplica solo para equipo psicosocial.
	 */		
	public function validarAsocAdol(){
		$conect=Yii::app()->db;
		$sqlVerifAsocAdol="select * from persona as a 
			left join cforjar_personal as b on b.id_cedula=a.id_cedula 
			left join hist_personal_adol as c on c.id_cedula=a.id_cedula 
			where asignado_actualmente is true and a.id_cedula = :id_cedula";
		$verifAsocAdol=$conect->createCommand($sqlVerifAsocAdol);
		$verifAsocAdol->bindParam(":id_cedula",$this->id_cedula);
		$readAsocAdol=$verifAsocAdol->query();
		$resAsocAdol=$readAsocAdol->rowCount;
		$readAsocAdol->close();			
		return $resAsocAdol;	
	}
	
	/**
	 *	@param string $this->id_cedula.
	 *	@param string $this->id_forjar.
	 *	@return $resAsocAdol consulta si tiene asignado un adolescente actualmente en una respectiva sede, aplica solo para equipo psicosocial.
	 */		
	public function validarAsocAdolForjar(){
		$conect=Yii::app()->db;
		$sqlVerifAsocAdol="select * from persona as a 
			left join cforjar_personal as b on b.id_cedula=a.id_cedula 
			left join hist_personal_adol as c on c.id_cedula=a.id_cedula 
			where asignado_actualmente is true and a.id_cedula = :id_cedula and id_forjar=:id_forjar";
		$verifAsocAdol=$conect->createCommand($sqlVerifAsocAdol);
		$verifAsocAdol->bindParam(":id_cedula",$this->id_cedula);
		$verifAsocAdol->bindParam(":id_forjar",$this->id_forjar);
		$readAsocAdol=$verifAsocAdol->query();
		$resAsocAdol=$readAsocAdol->rowCount;
		$readAsocAdol->close();			
		return $resAsocAdol;	
	}
	
	/**
	 *	@param int $this->id_cedula.
	 *	@return retorna consulta de las valoraciones que un psicólogo tiene incompletas, no realizadas o con un estado sin definir.
	 */		
	public function validarEstadoVal(){
		$conect=Yii::app()->db;
		$sqlValidaEstVal="select distinct(num_doc) from profesional_valpsicol as a 
			left join valoracion_psicologia as b on b.id_valoracion_psicol=a.id_valoracion_psicol 
			where id_cedula=:id_cedula and id_estado_val <> 1";
		$validaEstVal=$conect->createCommand($sqlValidaEstVal);
		$validaEstVal->bindParam(":id_cedula",$this->id_cedula);
		$readValidaEstVal=$validaEstVal->query();
		$resValidaEstVal=$readValidaEstVal->rowCount;
		$readValidaEstVal->close();			
		return $resValidaEstVal;	
	}

	
	/**
	 *	Se realiza el cambio de relación personal - forjar, cuando el profesional es trasladado de sede, es asociado nueva sede a la persona.
	 *	@param int $this->areacforjar_activa.
	 *	@param bool $this->areacforjar_activa.
	 *	@return retorna consulta si tiene asignado un adolescente actualmente en una respectiva sede, aplica solo para equipo psicosocial.
	 */		
	public function trasladarFuncionario(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlTrasladoFunc="update cforjar_personal set id_forjar=:id_forjar where id_cedula=:id_cedula";
			$trasladoFun=$conect->createCommand($sqlTrasladoFunc);
			$trasladoFun->bindParam(":id_forjar",$this->id_forjar,PDO::PARAM_INT);
			$trasladoFun->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
			$trasladoFun->execute();	
			$transaction->commit();
			return "exito";				
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e->message();
		}
	}
	
	/**
	 *	Se realiza el cambio de relación personal - forjar, cuando el profesional es trasladado de sede..
	 *	@param int $this->areacforjar_activa.
	 *	@param bool $this->areacforjar_activa.
	 *	@return retorna consulta si tiene asignado un adolescente actualmente en una respectiva sede, aplica solo para equipo psicosocial.
	 */		
	public function asociarSedeAUsuario(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlDelSedeUsr="delete from cforjar_personal where id_cedula=:id_cedula";
			$delSedeUsr=$conect->createCommand($sqlDelSedeUsr);
			$delSedeUsr->bindParam(":id_cedula",$this->id_cedula);
			$delSedeUsr->execute();
			$sqlAsocSedeUsr="insert into cforjar_personal (
				id_cedula,
				id_forjar
			) values (
				:id_cedula,
				:id_forjar
			)";
			foreach($this->id_forjar as $idForjar){
				$asocSedeUsr=$conect->createCommand($sqlAsocSedeUsr);
				$asocSedeUsr->bindParam(":id_cedula",$this->id_cedula);
				$asocSedeUsr->bindParam(":id_forjar",$idForjar);
				$asocSedeUsr->execute();
			}
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e->getMessate();
			
		}
	}
}
