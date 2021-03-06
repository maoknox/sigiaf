<?php

/**
 * This is the model class for table "rol_menu".
 *
 * The followings are the available columns in table 'rol_menu':
 * @property string $id_menu
 * @property integer $id_rol
 * @property integer $id_modoacceso
 * @property boolean $acceso_rolmenu
 */
class RolMenu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $menu;	/**< array que captura menu. */
	public function tableName()
	{
		return 'rol_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_menu, id_rol', 'required'),
			array('id_rol, id_modoacceso', 'numerical', 'integerOnly'=>true),
			array('id_menu', 'length', 'max'=>50),
			array('menu,acceso_rolmenu', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_menu, id_rol, id_modoacceso, acceso_rolmenu', 'safe', 'on'=>'search'),
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
			'id_menu' => 'Menu',
			'id_rol' => 'Rol',
			'id_modoacceso' => 'Modo acceso',
			'acceso_rolmenu' => 'Acceso Rolmenu',
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

		$criteria->compare('id_menu',$this->id_menu,true);
		$criteria->compare('id_rol',$this->id_rol);
		$criteria->compare('id_modoacceso',$this->id_modoacceso);
		$criteria->compare('acceso_rolmenu',$this->acceso_rolmenu);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RolMenu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param array $readMenuRol.
	 * @return $readMenuRol 
	 */
	public function consultaMenuRol(){
		$conect=Yii::app()->db;
		$sqlConsMenuRol="select id_menu from rol_menu where id_rol=:id_rol";
		$consMenuRol=$conect->createCommand($sqlConsMenuRol);
		$consMenuRol->bindParam(':id_rol',$this->id_rol);
		$resConsMenuRol=$consMenuRol->query();
		$readMenuRol=$resConsMenuRol->readAll();
		$resConsMenuRol->close();
		return $readMenuRol;				
	}
	public function limpiaMenuRol(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlDelMenuRol="delete from rol_menu where id_rol=:id_rol";
			$delMenuRol=$conect->createCommand($sqlDelMenuRol);
			$delMenuRol->bindParam(':id_rol',$this->id_rol);
			$delMenuRol->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}
	}
	public function limpiaModuloRol(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlDelModuloRol="delete from rol_modulo where id_rol=:id_rol";
			$delModuloRol=$conect->createCommand($sqlDelModuloRol);
			$delModuloRol->bindParam(':id_rol',$this->id_rol);
			$delModuloRol->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}
	}
}
