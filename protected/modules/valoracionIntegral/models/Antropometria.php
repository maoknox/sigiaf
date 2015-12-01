<?php

/**
 * This is the model class for table "antropometria".
 *
 * The followings are the available columns in table 'antropometria':
 * @property integer $id_antropometria
 * @property integer $id_val_nutricion
 * @property string $antr_peso_kgs
 * @property integer $antr_talla_cms
 * @property string $antr_imc
 * @property string $circunf_cefalica
 * @property string $antr_peso_ideal
 * @property integer $antr_talla_ideal
 * @property string $antr_ind_p_t_imc_ed
 * @property string $indice_talla_edad
 * @property string $fecha_antrp
 *
 * The followings are the available model relations:
 * @property ValoracionNutricional $idValNutricion
 * @property AntropSeguimientonutr[] $antropSeguimientonutrs
 */
class Antropometria extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $nombreCampo;
	public $contenido;
	public $idNutricion;
	public function tableName()
	{
		return 'antropometria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_val_nutricion, antr_peso_kgs, antr_talla_cms, antr_imc, circunf_cefalica, antr_peso_ideal, antr_talla_ideal, antr_ind_p_t_imc_ed, indice_talla_edad', 'required'),
			array('id_val_nutricion,antr_talla_cms,antr_talla_ideal', 'numerical', 'integerOnly'=>true),
			array('antr_peso_kgs,antr_imc,antr_peso_ideal,antr_ind_p_t_imc_ed,indice_talla_edad','type','type' => 'float','message'=>'Debe digitar un decimal, con punto'),			
			array('fecha_antrp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_antropometria, id_val_nutricion, antr_peso_kgs, antr_talla_cms, antr_imc, circunf_cefalica, antr_peso_ideal, antr_talla_ideal, antr_ind_p_t_imc_ed, indice_talla_edad, fecha_antrp', 'safe', 'on'=>'search'),
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
			'idValNutricion' => array(self::BELONGS_TO, 'ValoracionNutricional', 'id_val_nutricion'),
			'antropSeguimientonutrs' => array(self::HAS_MANY, 'AntropSeguimientonutr', 'id_antropometria'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
public function attributeLabels()
	{
		return array(
			'id_antropometria' => 'Antropometría',
			'id_val_nutricion' => 'Valoración en nutrición',
			'antr_peso_kgs' => 'Peso (kgs)',
			'antr_talla_cms' => 'Talla (cms)',
			'antr_imc' => 'IMC',
			'circunf_cefalica' => 'Circunferencia cefálica',
			'antr_peso_ideal' => 'Peso ideal (kgs)',
			'antr_talla_ideal' => 'Talla ideal (cms)',
			'antr_ind_p_t_imc_ed' => 'Indice Peso / talla o IMC / Edad',
			'indice_talla_edad' => 'Indice Talla / Edad',
			'fecha_antrp' => 'Fecha Antrpopometría',
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

		$criteria->compare('id_antropometria',$this->id_antropometria);
		$criteria->compare('id_val_nutricion',$this->id_val_nutricion);
		$criteria->compare('antr_peso_kgs',$this->antr_peso_kgs,true);
		$criteria->compare('antr_talla_cms',$this->antr_talla_cms);
		$criteria->compare('antr_imc',$this->antr_imc,true);
		$criteria->compare('circunf_cefalica',$this->circunf_cefalica,true);
		$criteria->compare('antr_peso_ideal',$this->antr_peso_ideal,true);
		$criteria->compare('antr_talla_ideal',$this->antr_talla_ideal);
		$criteria->compare('antr_ind_p_t_imc_ed',$this->antr_ind_p_t_imc_ed,true);
		$criteria->compare('indice_talla_edad',$this->indice_talla_edad,true);
		$criteria->compare('fecha_antrp',$this->fecha_antrp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Antropometria the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	Consulta información sobre antropometría inicial del adolexcente.
	 *
	 *	@param int id_val_nutricion.
	 *	@return $resValNutr 
	 */		
	public function consultaAntropValNutr(){
		$conect= Yii::app()->db;
		$sqlAntrValNutr="select * from antropometria where id_val_nutricion=:id_val_nutricion order by fecha_antrp asc  limit 1";	
		$consValNutr=$conect->createCommand($sqlAntrValNutr);
		$consValNutr->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$readValNutr=$consValNutr->query();
		$resValNutr=$readValNutr->read();
		$readValNutr->close();
		return $resValNutr;							
	}
	/**
	 *	Consulta información sobre las mediciones de antropometría del adolescente hasta la fecha.
	 *
	 *	@param int id_val_nutricion.
	 *	@return $resValNutr 
	 */		
	public function consultaAntropValNutrSeg(){
		$conect= Yii::app()->db;
		$sqlAntrValNutr="select * from antropometria where id_val_nutricion=:id_val_nutricion order by fecha_antrp desc";	
		$consValNutr=$conect->createCommand($sqlAntrValNutr);
		$consValNutr->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
		$readValNutr=$consValNutr->query();
		$resValNutr=$readValNutr->readAll();
		$readValNutr->close();
		return $resValNutr;							
	}

	/**
	 *	Registra la información de antropometría del adolescente.
	 *
	 *	@param int $this->id_val_nutricion
	 *	@param int $this->antr_peso_kgs
	 *	@param int $this->antr_talla_cms
	 *	@param int $this->antr_imc
	 *	@param int $this->circunf_cefalica
	 *	@param int $this->antr_peso_ideal
	 *	@param int $this->antr_talla_ideal
	 *	@param int $this->antr_ind_p_t_imc_ed
	 *	@param int $this->indice_talla_edad
	 *	@param string $fecha
	 *	@return resultado de la transacción 
	 */		
	public function registraAntropometria(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		$fecha=date("Y-m-d");
		try{
			$sqlRegAntr="insert into antropometria (
				id_antropometria,
				id_val_nutricion,
				antr_peso_kgs,
				antr_talla_cms,
				antr_imc,
				circunf_cefalica,
				antr_peso_ideal,
				antr_talla_ideal,
				antr_ind_p_t_imc_ed,
				indice_talla_edad,
				fecha_antrp
			) values (
				default,
				:id_val_nutricion,
				:antr_peso_kgs,
				:antr_talla_cms,
				:antr_imc,
				:circunf_cefalica,
				:antr_peso_ideal,
				:antr_talla_ideal,
				:antr_ind_p_t_imc_ed,
				:indice_talla_edad,
				:fecha_antrp
			) returning id_antropometria";
			$regAntr=$conect->createCommand($sqlRegAntr);
			$regAntr->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$regAntr->bindParam(":antr_peso_kgs",$this->antr_peso_kgs);
			$regAntr->bindParam(":antr_talla_cms",$this->antr_talla_cms);
			$regAntr->bindParam(":antr_imc",$this->antr_imc,PDO::PARAM_STR);
			$regAntr->bindParam(":circunf_cefalica",$this->circunf_cefalica);
			$regAntr->bindParam(":antr_peso_ideal",$this->antr_peso_ideal);
			$regAntr->bindParam(":antr_talla_ideal",$this->antr_talla_ideal);
			$regAntr->bindParam(":antr_ind_p_t_imc_ed",$this->antr_ind_p_t_imc_ed);
			$regAntr->bindParam(":indice_talla_edad",$this->indice_talla_edad);
			$regAntr->bindParam(":fecha_antrp",$fecha,PDO::PARAM_STR);
			$readIdAntr=$regAntr->query();
			$resIdAntr=$readIdAntr->read();
			$readIdAntr->close();
			$this->id_antropometria=$resIdAntr["id_antropometria"];
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}
	}
	/**
	 *	Modifica un campo en específico de antropometría del adolescente.
	 *
	 *	@param int $this->id_val_nutricion
	 *	@param int $this->id_antropometria
	 *	@param int $this->contenido
	 *	@return resultado de la transacción 
	 */		
	public function modificaAntropometria(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlModAntrop="update antropometria set ".pg_escape_string($this->nombreCampo)."=:contenido 
			where id_antropometria=:id_antropometria and id_val_nutricion=:id_val_nutricion";
			$modAntrop=$conect->createCommand($sqlModAntrop);
			$modAntrop->bindParam(":contenido",$this->contenido);
			$modAntrop->bindParam(":id_antropometria",$this->id_antropometria,PDO::PARAM_INT);
			$modAntrop->bindParam(":id_val_nutricion",$this->id_val_nutricion,PDO::PARAM_INT);
			$modAntrop->execute();
			$transaction->commit();
			return "exito";			
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}		
	}
	/**
	 *	Registra seguimiento de la antropometría.
	 *
	 *	@param int $this->id_antropometria
	 *	@param int $this->id_nutradol
	 *	@param int $this->id_val_nutricion
	 *	@return resultado de la transacción 
	 */		
	public function registraAntropometriaNutrAdol(){
		$conect= Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegAntrNutr="insert into antrop_seguimientonutr(
				id_antropometria,
				id_nutradol,
				id_val_nutricion
			) values (
				:id_antropometria,
				:id_nutradol,
				:id_val_nutricion
			)";
			$regAntrNutr=$conect->createCommand($sqlRegAntrNutr);
			$regAntrNutr->bindParam(":id_antropometria",$this->id_antropometria);
			$regAntrNutr->bindParam(":id_nutradol",$this->idNutricion);
			$regAntrNutr->bindParam(":id_val_nutricion",$this->id_val_nutricion);
			$regAntrNutr->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}		
	}
}
