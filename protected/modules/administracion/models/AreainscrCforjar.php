<?php

/**
 * This is the model class for table "areainscr_cforjar".
 *
 * The followings are the available columns in table 'areainscr_cforjar':
 * @property integer $id_areainteres
 * @property string $id_forjar
 * @property boolean $areacforjar_activa
 */
class AreainscrCforjar extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $areasInteresDeportes;
	public $idAreainscr;
	public function tableName()
	{
		return 'areainscr_cforjar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_areainteres, id_forjar, areacforjar_activa', 'required'),
			array('id_areainteres', 'numerical', 'integerOnly'=>true),
			array('id_forjar', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_areainteres, id_forjar, areacforjar_activa', 'safe', 'on'=>'search'),
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
			'id_areainteres' => 'Id Areainteres',
			'id_forjar' => 'Centro Forjar',
			'areacforjar_activa' => 'Estado área interés',
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

		$criteria->compare('id_areainteres',$this->id_areainteres);
		$criteria->compare('id_forjar',$this->id_forjar,true);
		$criteria->compare('areacforjar_activa',$this->areacforjar_activa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AreainscrCforjar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function asociaAIntForjar(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		$sqlAsAIForjar="insert into areainscr_cforjar (
			id_areainteres,
			id_forjar,
			areacforjar_activa
		) values (
			:id_areainteres,
			:id_forjar,
			:areacforjar_activa
		)";
						
		try{
			foreach($this->id_forjar as $forjar){
				$asAIForjar=$conect->createCommand($sqlAsAIForjar);
				$asAIForjar->bindParam(":id_areainteres",$this->id_areainteres,PDO::PARAM_INT);
				$asAIForjar->bindParam(":id_forjar",$forjar,PDO::PARAM_STR);
				$asAIForjar->bindParam(":areacforjar_activa",$this->areacforjar_activa,PDO::PARAM_BOOL);
				$asAIForjar->execute();
			}	
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}
	}
	public function consultaAreaInscrSinVinc(){
		$conect=Yii::app()->db;//
		$sqlConsAreaInsSinVinc="select * from (select id_areainteres from area_inscripcion except select id_areainteres from areainscr_cforjar where id_forjar=:id_forjar) as a 
			left join area_inscripcion as b on b.id_areainteres=a.id_areainteres";
		$consAreaInsSinVinc=$conect->createCommand($sqlConsAreaInsSinVinc);
		$consAreaInsSinVinc->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));
		$readAreaInsSinVinc=$consAreaInsSinVinc->query();
		$resAreaInsSinVinc=$readAreaInsSinVinc->readAll();
		$readAreaInsSinVinc->close();
		return 	$resAreaInsSinVinc;	
	}
	public function vinculaAIntDepForjar(){
		if(!empty($this->areasInteresDeportes) && is_array($this->areasInteresDeportes)){	
			$conect=Yii::app()->db;
			$transaction=$conect->beginTransaction();
			$sqlAsAIForjar="insert into areainscr_cforjar (
				id_areainteres,
				id_forjar,
				areacforjar_activa
			) values (
				:id_areainteres,
				:id_forjar,
				:areacforjar_activa
			)";
			try{
				foreach($this->areasInteresDeportes as $areaIntDep){
					$asAIForjar=$conect->createCommand($sqlAsAIForjar);
					$asAIForjar->bindParam(":id_areainteres",$areaIntDep,PDO::PARAM_INT);
					$asAIForjar->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'),PDO::PARAM_STR);
					$asAIForjar->bindParam(":areacforjar_activa",$this->areacforjar_activa,PDO::PARAM_BOOL);
					$asAIForjar->execute();
				}	
				$transaction->commit();
				return "exito";
			}
			catch(CDbCommand $e){
				$transaction->rollBack();
				return $e;			
			}
		}
		else{
			return "No hay algún área o deporte seleccionado.";	
			
		}
	}
	public function consultaAreaInteresDeportes(){
		$conect=Yii::app()->db;
		$sqlConsAIntDep="select * from area_inscripcion as a 
			left join areainscr_cforjar as b on b.id_areainteres=a.id_areainteres 
			where id_forjar=:id_forjar and id_areainscr=:id_areainscr and areacforjar_activa=:areacforjar_activa";
		$consAIntDep=$conect->createCommand($sqlConsAIntDep);
		$consAIntDep->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));
		$consAIntDep->bindParam(":id_areainscr",$this->idAreainscr);
		$consAIntDep->bindParam(":areacforjar_activa",$this->areacforjar_activa);
		$readAintDep=$consAIntDep->query();
		$resAintDep=$readAintDep->readAll();
		$readAintDep->close();
		return $resAintDep;
		
	}
	public function deshabHabAIntDepForjar(){
		if(!empty($this->areasInteresDeportes) && is_array($this->areasInteresDeportes)){	
			$conect=Yii::app()->db;
			$transaction=$conect->beginTransaction();
			$sqldeshabHabAsAIForjar="update areainscr_cforjar set areacforjar_activa=:areacforjar_activa where id_forjar=:id_forjar and id_areainteres=:id_areainteres";
			try{
				foreach($this->areasInteresDeportes as $areaIntDep){
					$desHabAIForjar=$conect->createCommand($sqldeshabHabAsAIForjar);
					$desHabAIForjar->bindParam(":id_areainteres",$areaIntDep,PDO::PARAM_INT);
					$desHabAIForjar->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'),PDO::PARAM_STR);
					$desHabAIForjar->bindParam(":areacforjar_activa",$this->areacforjar_activa,PDO::PARAM_BOOL);
					$desHabAIForjar->execute();
				}	
				$transaction->commit();
				return "exito";
			}
			catch(CDbCommand $e){
				$transaction->rollBack();
				return $e;			
			}
		}
		else{
			return "No hay algún área o deporte seleccionado.";	
			
		}		
	}
	
}
