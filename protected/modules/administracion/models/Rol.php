<?php

/**
 * This is the model class for table "rol".
 *
 * The followings are the available columns in table 'rol':
 * @property integer $id_rol
 * @property string $nombre_rol
 * @property string $descripcion_rol
 *
 * The followings are the available model relations:
 * @property AreaDisciplina[] $areaDisciplinas
 * @property Menu[] $menus
 * @property Modulo[] $modulos
 * @property TipoSeguimiento[] $tipoSeguimientos
 * @property Persona[] $personas
 */
class Rol extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $menu;
	public function tableName()
	{
		return 'rol';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre_rol, descripcion_rol', 'required'),
			array('nombre_rol', 'length', 'max'=>50),
			array('descripcion_rol', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('menu,id_rol, nombre_rol, descripcion_rol', 'safe', 'on'=>'search'),
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
			'areaDisciplinas' => array(self::MANY_MANY, 'AreaDisciplina', 'areaseg_rol(id_rol, id_area_seguimiento)'),
			'menus' => array(self::MANY_MANY, 'Menu', 'rol_menu(id_rol, id_menu)'),
			'modulos' => array(self::MANY_MANY, 'Modulo', 'rol_modulo(id_rol, id_modulo)'),
			'tipoSeguimientos' => array(self::MANY_MANY, 'TipoSeguimiento', 'tiposeg_rol(id_rol, id_tipo_seguim)'),
			'personas' => array(self::MANY_MANY, 'Persona', 'usuario(id_rol, id_cedula)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_rol' => 'Id Rol',
			'nombre_rol' => 'Nombre Rol',
			'descripcion_rol' => 'Descripcion Rol',
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

		$criteria->compare('id_rol',$this->id_rol);
		$criteria->compare('nombre_rol',$this->nombre_rol,true);
		$criteria->compare('descripcion_rol',$this->descripcion_rol,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function creaRolMenu(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlCreaRol="insert into rol (
				id_rol,
				nombre_rol,
				descripcion_rol
			) values (
				default,
				:nombre_rol,
				:descripcion_rol
			) returning id_rol";	
			$creaRol=$conect->createCommand($sqlCreaRol);
			$creaRol->bindParam(":nombre_rol",$this->nombre_rol,PDO::PARAM_STR);
			$creaRol->bindParam(":descripcion_rol",$this->descripcion_rol,PDO::PARAM_STR);
			$read=$creaRol->query();
			$res=$read->read();
			$read->close();
			$this->id_rol=$res['id_rol'];
			if(!empty($this->menu) && is_array($this->menu)){
				foreach($this->menu as $pk=>$dataInputPr){
					$this->asignaModulo($pk);
					$this->asignaRolMenu($pk);
					//echo $pk."<br>";
					if(is_array($dataInputPr)){	
						foreach($dataInputPr as $pki=>$dataInputPrSec){
							if($dataInputPrSec=="on"){
								$this->asignaRolMenu($pki);
								//echo "-".$pki." ".$dataInputPrSec."<br>";
							}
							else{
								$this->asignaRolMenu($pki);
								if(is_array($dataInputPrSec)){
									//echo "-".$pki."<br>";
									foreach($dataInputPrSec as $pkii=>$dataInputPrTer){
										$this->asignaRolMenu($pkii);
										//echo "--".$pkii." ".$dataInputPrTer."<br>";
									}
								}
							}
						}
					}	
				}
			}
			$transaction->commit();			
			return "exito";
		}
		catch(CDbException $e){		
			$transaction->rollBack();
			throw new CHttpException(403,'Error en la creación del rol: '.$e->getMessage());						
		}
		
	}
	private function asignaRolMenu($idMenu){
		$conect=Yii::app()->db;
		$sqlCreaMenuRol="insert into rol_menu (
			id_menu,
			id_rol,
			id_modoacceso,
			acceso_rolmenu		
		) values (
			:id_menu,
			:id_rol,
			1,
			'true'		
		)";
		$creaMenuRol=$conect->createCommand($sqlCreaMenuRol);
		$creaMenuRol->bindParam(":id_menu",$idMenu,PDO::PARAM_STMT);
		$creaMenuRol->bindParam(":id_rol",$this->id_rol,PDO::PARAM_INT);
		$creaMenuRol->execute();
	}
	private function asignaModulo($idMenu){
		$conect=Yii::app()->db;
		$sqlConsModulo="select * from modulo as a left join menu as b on a.id_modulo=b.id_modulo where id_menu=:id_menu";
		$consModulo=$conect->createCommand($sqlConsModulo);
		$consModulo->bindParam(":id_menu",$idMenu);
		$readModulo=$consModulo->query();
		$resModulo=$readModulo->read();
		$readModulo->close();
		if(!empty($resModulo)){
			$sqlConsRolModulo="select * from rol_modulo where id_modulo=:id_modulo and id_rol=:id_rol";
			$consRolModulo=$conect->createCommand($sqlConsRolModulo);
			$consRolModulo->bindParam(":id_modulo",$resModulo["id_modulo"],PDO::PARAM_STMT);
			$consRolModulo->bindParam(":id_rol",$this->id_rol,PDO::PARAM_INT);
			$readRolModulo=$consRolModulo->query();
			$resRolModulo=$readRolModulo->read();
			$readRolModulo->close();
			if(empty($resRolModulo)){
				$sqlCreaMenuRol="insert into rol_modulo (
					id_modulo,
					id_rol,
					acceso_modulo
				) values (
					:id_modulo,
					:id_rol,
					'true'		
				)";
				$creaMenuRol=$conect->createCommand($sqlCreaMenuRol);
				$creaMenuRol->bindParam(":id_modulo",$resModulo["id_modulo"],PDO::PARAM_STMT);
				$creaMenuRol->bindParam(":id_rol",$this->id_rol,PDO::PARAM_INT);
				$creaMenuRol->execute();
			}
		}
	}
}
