<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property string $id_cedula
 * @property integer $id_rol
 * @property string $clave
 * @property string $nombre_usuario
 * @property boolean $pers_habilitado
 */
class Usuario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $verificaClave;
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cedula, id_rol, clave, nombre_usuario, pers_habilitado', 'required'),
			array('id_rol', 'numerical', 'integerOnly'=>true),
			array('clave', 'length', 'max'=>500),
			array('nombre_usuario', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cedula, id_rol, clave, nombre_usuario, pers_habilitado', 'safe', 'on'=>'search'),
			array('nombre_usuario','validaNombreUsr','nombre_usuario'=>$this->nombre_usuario),
			array('verificaClave','verificaClave','clave'=>$this->clave,'verificaClave'=>$this->verificaClave),
		);
	}

	public function validaNombreUsr($attribute,$params){
		$usuario=$this->consultaUsuario();		
		if(count($usuario)!=0){
			$this->addError('nombre_usuario',"El nombre de usuario ya está registrado, digite uno diferente");
		}		
	}
	public function verificaClave(){
		if(isset($_POST["Usuario"]["verificaClave"])){
			if($this->clave!=$this->verificaClave){
				$this->addError('clave',"La clave no coincide con la verificación");
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cedula' => 'Funcionario',
			'id_rol' => 'Id Rol',
			'clave' => 'Clave',
			'nombre_usuario' => 'Nombre Usuario',
			'pers_habilitado' => 'Estado Usuario',
			'verificaClave'=>'Verificación de clave'
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

		$criteria->compare('id_cedula',$this->id_cedula,true);
		$criteria->compare('id_rol',$this->id_rol);
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('nombre_usuario',$this->nombre_usuario,true);
		$criteria->compare('pers_habilitado',$this->pers_habilitado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function consultaUsuarioCedula(){
		$conect=Yii::app()->db;
		$slqConsUsr="select * from usuario where id_cedula=:id_cedula";
		$consUsr=$conect->createCommand($slqConsUsr);
		$consUsr->bindParam(":id_cedula",Yii::app()->user->getState('cedula'));
		$readUsr=$consUsr->query();
		$resUsr=$readUsr->read();
		$readUsr->close();
		return $resUsr;
	}
	
	public function consultaUsuario(){
		$conect=Yii::app()->db;
		$slqConsUsr="select * from usuario where nombre_usuario=:nombre_usuario";
		$consUsr=$conect->createCommand($slqConsUsr);
		$consUsr->bindParam(":nombre_usuario",$this->nombre_usuario);
		$readUsr=$consUsr->query();
		$resUsr=$readUsr->readAll();
		$readUsr->close();
		return $resUsr;
	}
	public function consultaFuncionario(){
		$conecta=Yii::app()->db;
		$sqlConsFuncionario="select (nombre_personal ||' ' ||apellidos_personal) as nombres,* from usuario as a 
			left join persona as b on b.id_cedula=a.id_cedula 
			left join cforjar_personal as c on c.id_cedula=a.id_cedula 
			where c.id_forjar=:id_forjar";
		$consFuncionario=$conecta->createCommand($sqlConsFuncionario);
		$consFuncionario->bindParam(":id_forjar",Yii::app()->user->getState('sedeForjar'));
		$consFuncionario->query();
		$readFuncionario=$consFuncionario->query();
		$resFuncionario=$readFuncionario->readAll();
		$readFuncionario->close();
		return $resFuncionario;		
		//Yii::app()->user->getState('sedeForjar')		
	}
	public function consultaEstadoUsuario(){
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsEstadoUsuario="select pers_habilitado from usuario where id_cedula=$1";
		$res=pg_prepare($linkBd,"consEstUsr",$sqlConsEstadoUsuario);
		$res=pg_execute($linkBd, "consEstUsr", array($this->id_cedula));
		$consEstUsr=array();
		$consEstUsr=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consEstUsr;		
	}
	public function consultaEstadoUsuarioNombUsr(){
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsEstadoUsuario="select pers_habilitado from usuario where nombre_usuario=$1";
		$res=pg_prepare($linkBd,"consEstUsr",$sqlConsEstadoUsuario);
		$res=pg_execute($linkBd, "consEstUsr", array($this->nombre_usuario));
		$consEstUsr=array();
		$consEstUsr=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consEstUsr;		
	}
	public function cambiarEstadoFuncionario(){
		$conecta=Yii::app()->db;
		$transaction=$conecta->beginTransaction();
		try{
			$sqlCambiaEstFunc="update usuario set pers_habilitado=:pers_habilitado where id_cedula=:id_cedula";
			$cambiaEstFunc=$conecta->createCommand($sqlCambiaEstFunc);
			$cambiaEstFunc->bindParam(":pers_habilitado",$this->pers_habilitado,PDO::PARAM_BOOL);
			$cambiaEstFunc->bindParam(":id_cedula",$this->id_cedula,PDO::PARAM_INT);
			$cambiaEstFunc->execute();
			$transaction->commit();
			return "exito";			
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e->getMessage();			
		}
	}
	public function cambiaClave(){
		$conecta=Yii::app()->db;
		$transaction=$conecta->beginTransaction();
		try{
			$sqlCambiaClave="update usuario set clave=:clave where id_cedula=:id_cedula";
			$cambiaClave=$conecta->createCommand($sqlCambiaClave);
			$cambiaClave->bindParam(":clave",$this->clave);
			$cambiaClave->bindParam(":id_cedula",$this->id_cedula);
			$cambiaClave->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e->getMessage();			
		}
	}
}