<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property string $id_menu
 * @property integer $id_modulo
 * @property string $men_id_menu
 * @property integer $nivel_menu
 * @property string $titulo_menu
 * @property string $accion
 * @property integer $orden
 * @property string $target
 *
 * The followings are the available model relations:
 * @property Modulo $idModulo
 * @property Menu $menIdMenu
 * @property Menu[] $menus
 * @property Rol[] $rols
 */
class Menu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_menu, nivel_menu, titulo_menu', 'required'),
			array('id_modulo, nivel_menu, orden', 'numerical', 'integerOnly'=>true),
			array('id_menu, men_id_menu, titulo_menu, target', 'length', 'max'=>50),
			array('accion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_menu, id_modulo, men_id_menu, nivel_menu, titulo_menu, accion, orden, target', 'safe', 'on'=>'search'),
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
			'idModulo' => array(self::BELONGS_TO, 'Modulo', 'id_modulo'),
			'menIdMenu' => array(self::BELONGS_TO, 'Menu', 'men_id_menu'),
			'menus' => array(self::HAS_MANY, 'Menu', 'men_id_menu'),
			'rols' => array(self::MANY_MANY, 'Rol', 'rol_menu(id_menu, id_rol)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_menu' => 'Menu',
			'id_modulo' => 'Módulo',
			'men_id_menu' => 'Menú',
			'nivel_menu' => 'Nivel Menu',
			'titulo_menu' => 'Título Menu',
			'accion' => 'Acción',
			'orden' => 'Orden',
			'target' => 'Target',
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
		$criteria->compare('id_modulo',$this->id_modulo);
		$criteria->compare('men_id_menu',$this->men_id_menu,true);
		$criteria->compare('nivel_menu',$this->nivel_menu);
		$criteria->compare('titulo_menu',$this->titulo_menu,true);
		$criteria->compare('accion',$this->accion,true);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('target',$this->target,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 *	@return $resMenu nivel máximo de menú
	 */		
	public function consultaNivelMenu(){
		$conect=Yii::app()->db;
		$sqlConsMenu="select max(nivel_menu) from menu";
		$consMenu=$conect->createCommand($sqlConsMenu);
		$readMenu=$consMenu->query();			
		$resMenu=$readMenu->readAll();
		$readMenu->close();
		return $resMenu;
	}

	
	/**
	 *	@return $resMenu array con el menú completo
	 */		
	public function consultaMenu(){
		$conect=Yii::app()->db;
		$sqlConsMenu="select * from menu";
		$consMenu=$conect->createCommand($sqlConsMenu);
		$readMenu=$consMenu->query();			
		$resMenu=$readMenu->readAll();
		$readMenu->close();
		return $resMenu;
	}
	
	/**
	 *	@return $resMenu array con menus de nivel 
	 */		
	public function consultaMenuPorNivel(){
		$conect=Yii::app()->db;
		$sqlConsMenu="select * from menu where nivel_menu=1";
		$consMenu=$conect->createCommand($sqlConsMenu);
		//$consMenu->bindParam(":nivel_menu",$this->nivel_menu);
		$readMenu=$consMenu->query();			
		$resMenu=$readMenu->readAll();
		$readMenu->close();
		return $resMenu;
	}
	/**
	 *	@return $resMenu consulta de menú padre 
	 */		
	public function consultaMenuPorIdPadre(){
		$conect=Yii::app()->db;
		$sqlConsMenu="select * from menu where men_id_menu=:id_menu";
		$consMenu=$conect->createCommand($sqlConsMenu);
		$consMenu->bindParam(":id_menu",$this->id_menu);
		$readMenu=$consMenu->query();			
		$resMenu=$readMenu->readAll();
		$readMenu->close();
		return $resMenu;
	}
	public function recursividad($a){
		if ($a < 20) {
			echo "$a\n";
			$this->recursividad($a + 1);
		}
	}

}
