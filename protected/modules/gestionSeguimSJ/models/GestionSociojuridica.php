<?php

/**
 * This is the model class for table "gestion_sociojuridica".
 *
 * The followings are the available columns in table 'gestion_sociojuridica':
 * @property integer $id_gestionsj
 * @property integer $id_motivoasesoriasj
 * @property integer $id_tipogestionsj
 * @property string $num_doc
 * @property integer $id_remisionsj
 * @property string $fecha_regsitrogestionsj
 * @property string $fecha_gestionsj
 * @property string $dependencia_entidadsj
 * @property string $nombre_contactosj
 * @property string $telefono_contactosj
 * @property string $observaciones_gestionsj 
 *
 * The followings are the available model relations:
 * @property SeguimientoAsesoriasj[] $seguimientoAsesoriasjs
 * @property Adolescente $numDoc
 * @property MotivoAsesoriasj $idMotivoasesoriasj
 * @property RemisionGestionsj $idRemisionsj
 * @property TipoGestionsj $idTipogestionsj
 * @property SeguimientoAsesoriasj[] $seguimientoAsesoriasjs 
 */
class GestionSociojuridica extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gestion_sociojuridica';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_doc,id_remisionsj,id_motivoasesoriasj,fecha_regsitrogestionsj, fecha_gestionsj', 'required'),
			array('id_motivoasesoriasj, id_tipogestionsj, id_remisionsj', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('dependencia_entidadsj', 'length', 'max'=>1000),
			array('nombre_contactosj, telefono_contactosj', 'length', 'max'=>500),
			array('observaciones_gestionsj', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_gestionsj, id_motivoasesoriasj, id_tipogestionsj, num_doc, id_remisionsj, fecha_regsitrogestionsj, fecha_gestionsj, dependencia_entidadsj, nombre_contactosj, telefono_contactosj, observaciones_gestionsj', 'safe', 'on'=>'search'),
			array('dependencia_entidadsj','validaDependencia',$this->id_remisionsj),
			//array('id_tipogestionsj','validaTipoGestion',$this->id_remisionsj),
			//array('nombre_contactosj','validaNombreContacto',$this->id_remisionsj),
		);
	}

	/**
	 *	Verifica si los datos son diligenciados en el formulario dependencia, tipo de gestión, nombre de contacto, y teléfono de contacto.
	 */		
	public function validaDependencia($attribute=null,$params=null){
		//if(!$this->hasErrors()){		
			$datosInput=Yii::app()->input->post();
			if(!empty($this->id_remisionsj)){
				if($this->id_remisionsj!=11){
					if(empty($datosInput["GestionSociojuridica"]["dependencia_entidadsj"])){
						$this->addError("dependencia_entidadsj","Debe digitar una dependencia");		
					}
					if(empty($datosInput["GestionSociojuridica"]["id_tipogestionsj"])){
						$this->addError("id_tipogestionsj","Debe seleccionar un tipo de gestión");
					}
					if(empty($datosInput["GestionSociojuridica"]["nombre_contactosj"])){
						$this->addError("nombre_contactosj","Debe digitar un nombre de contacto");	
					}
					if(empty($datosInput["GestionSociojuridica"]["telefono_contactosj"])){
						$this->addError("telefono_contactosj","Debe digitar un teléfono de contacto");		
					}
				}
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
			'seguimientoAsesoriasjs' => array(self::HAS_MANY, 'SeguimientoAsesoriasj', 'id_gestionsj'),
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idMotivoasesoriasj' => array(self::BELONGS_TO, 'MorivoAsesoriasj', 'id_motivoasesoriasj'),
			'idRemisionsj' => array(self::BELONGS_TO, 'RemisionGestionsj', 'id_remisionsj'),
			'idTipogestionsj' => array(self::BELONGS_TO, 'TipoGestionsj', 'id_tipogestionsj'),
			'seguimientoAsesoriasjs' => array(self::HAS_MANY, 'SeguimientoAsesoriasj', 'id_gestionsj'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_gestionsj' => 'Gestión socio jurídica',
			'id_motivoasesoriasj' => 'Motivo de la asesoría',
			'id_tipogestionsj' => 'Tipo de gestión',
			'num_doc' => 'Número de documento',
			'id_remisionsj' => 'A donde remite',
			'fecha_regsitrogestionsj' => 'Fecha Regsitro',
			'fecha_gestionsj' => 'Fecha de la gestión',
			'dependencia_entidadsj' => 'Dependencia-Entidad',
			'nombre_contactosj' => 'Nombre del contacto',
			'telefono_contactosj' => 'Teléfono del contacto',
			'observaciones_gestionsj' => 'Observaciones',
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

		$criteria->compare('id_gestionsj',$this->id_gestionsj);
		$criteria->compare('id_motivoasesoriasj',$this->id_motivoasesoriasj);
		$criteria->compare('id_tipogestionsj',$this->id_tipogestionsj);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('id_remisionsj',$this->id_remisionsj);
		$criteria->compare('fecha_regsitrogestionsj',$this->fecha_regsitrogestionsj,true);
		$criteria->compare('fecha_gestionsj',$this->fecha_gestionsj,true);
		$criteria->compare('dependencia_entidadsj',$this->dependencia_entidadsj,true);
		$criteria->compare('nombre_contactosj',$this->nombre_contactosj,true);
		$criteria->compare('telefono_contactosj',$this->telefono_contactosj,true);
		$criteria->compare('observaciones_gestionsj',$this->observaciones_gestionsj,true);		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GestionSociojuridica the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 *	Crea registro de la gestión socio jurídica realizada por el abogado.
	 *	@param int id_gestionsj.
	 *	@param int id_motivoasesoriasj.
	 *	@param int id_tipogestionsj.
	 *	@param string num_doc.
	 *	@param int id_remisionsj.
	 *	@param string fecha_regsitrogestionsj.
	 *	@param string fecha_gestionsj.
	 *	@param string dependencia_entidadsj.
	 *	@param string nombre_contactosj.
	 *	@param string telefono_contactosj.
	 *	@return resultado de la transacción
	 */		
	public function registraGestionSJ(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegGestionSJ="insert into gestion_sociojuridica (
				id_gestionsj,
				id_motivoasesoriasj,
				id_tipogestionsj,
				num_doc,
				id_remisionsj,
				fecha_regsitrogestionsj,
				fecha_gestionsj,
				dependencia_entidadsj,
				nombre_contactosj,
				telefono_contactosj,
				observaciones_gestionsj						
			) values (
				default,
				:id_motivoasesoriasj,
				:id_tipogestionsj,
				:num_doc,
				:id_remisionsj,
				:fecha_regsitrogestionsj,
				:fecha_gestionsj,
				:dependencia_entidadsj,
				:nombre_contactosj,
				:telefono_contactosj,
				:observaciones_gestionsj			
			)";
			if(empty($this->id_tipogestionsj)){$this->id_tipogestionsj=null;}
			if(empty($this->dependencia_entidadsj)){$this->dependencia_entidadsj=null;}
			if(empty($this->nombre_contactosj)){$this->nombre_contactosj=null;}
			if(empty($this->telefono_contactosj)){$this->telefono_contactosj=null;}
			if(empty($this->observaciones_gestionsj)){$this->observaciones_gestionsj=null;}

			$regGestionSJ=$conect->createCommand($sqlRegGestionSJ);
			$regGestionSJ->bindParam(":id_motivoasesoriasj",$this->id_motivoasesoriasj,PDO::PARAM_INT);
			$regGestionSJ->bindParam(":id_tipogestionsj",$this->id_tipogestionsj);
			$regGestionSJ->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regGestionSJ->bindParam(":id_remisionsj",$this->id_remisionsj,PDO::PARAM_INT);
			$regGestionSJ->bindParam(":fecha_regsitrogestionsj",$this->fecha_regsitrogestionsj,PDO::PARAM_STR);
			$regGestionSJ->bindParam(":fecha_gestionsj",$this->fecha_gestionsj,PDO::PARAM_STR);
			$regGestionSJ->bindParam(":dependencia_entidadsj",$this->dependencia_entidadsj);
			$regGestionSJ->bindParam(":nombre_contactosj",$this->nombre_contactosj);
			$regGestionSJ->bindParam(":telefono_contactosj",$this->telefono_contactosj);
			$regGestionSJ->bindParam(":observaciones_gestionsj",$this->observaciones_gestionsj);
			$regGestionSJ->execute();
			
			$transaction->commit();
			return "exito";	
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
			
		}	
	}
	/**
	 *	Retorna consulta de las gestiones realizadas a un adolescente en específico 
	 *	@param string $this->num_doc id de documento del adolescente.
	 *	@return $resGestionSJ 
	 */		
	public function consultaGestionesSJAdol(){
		$conect=Yii::app()->db;
		$sqlConsGestionSJ="select * from gestion_sociojuridica as a 
			left join motivo_asesoriasj as b on b.id_motivoasesoriasj=a.id_motivoasesoriasj 
			left join remision_gestionsj as c on c.id_remisionsj=a.id_remisionsj 
			left join tipo_gestionsj as d on d.id_tipogestionsj=a.id_tipogestionsj 
			left join adolescente as e on e.num_doc=a.num_doc 
			where a.num_doc=:num_doc";
		$consGestionSJ=$conect->createCommand($sqlConsGestionSJ);
		$consGestionSJ->bindParam(":num_doc",$this->num_doc);
		$readGestionSJ=$consGestionSJ->query();
		$resGestionSJ=$readGestionSJ->readAll();
		$readGestionSJ->close();
		return $resGestionSJ;
	}
	/**
	 *	Retorna consulta de la información de una gestión sociojurídica en específico
	 *	@param string $this->num_doc id de documento del adolescente.
	 *	@return $resGestionSJ 
	 */		
	public function consultaGestionSJAdol(){
		$conect=Yii::app()->db;
		$sqlConsGestionSJ="select * from gestion_sociojuridica as a 
			left join motivo_asesoriasj as b on b.id_motivoasesoriasj=a.id_motivoasesoriasj 
			left join remision_gestionsj as c on c.id_remisionsj=a.id_remisionsj 
			left join tipo_gestionsj as d on d.id_tipogestionsj=a.id_tipogestionsj 			
			where a.num_doc=:num_doc and id_gestionsj=:id_gestionsj";
		$consGestionSJ=$conect->createCommand($sqlConsGestionSJ);
		$consGestionSJ->bindParam(":num_doc",$this->num_doc);
		$consGestionSJ->bindParam(":id_gestionsj",$this->id_gestionsj);
		$readGestionSJ=$consGestionSJ->query();
		$resGestionSJ=$readGestionSJ->read();
		$readGestionSJ->close();
		return $resGestionSJ;
	}
	/**
	 *	Retorna consulta de las gestiones sociojurídicas que requirieron de remisión a otra entidad.
	 *	@param string $this->num_doc id de documento del adolescente.
	 *	@return $resGestionSJ 
	 */		
	public function consultaGestionesSJAdolMod(){
		$conect=Yii::app()->db;
		$sqlConsGestionSJ="select * from gestion_sociojuridica as a 
			left join motivo_asesoriasj as b on b.id_motivoasesoriasj=a.id_motivoasesoriasj 
			left join remision_gestionsj as c on c.id_remisionsj=a.id_remisionsj 
			left join tipo_gestionsj as d on d.id_tipogestionsj=a.id_tipogestionsj 			
			where a.num_doc=:num_doc and remision_sj <> 'N.A' ";
		$consGestionSJ=$conect->createCommand($sqlConsGestionSJ);
		$consGestionSJ->bindParam(":num_doc",$this->num_doc);
		$readGestionSJ=$consGestionSJ->query();
		$resGestionSJ=$readGestionSJ->readAll();
		$readGestionSJ->close();
		return $resGestionSJ;
		
	}
	/**
	 *	Retorna consulta de las gestiones sociojurídicas que requirieron de remisión a otra entidad.
	 *	@param string $this->num_doc id de documento del adolescente.
	 *	@return $resGestionSJ 
	 */		
	public function consultaHistoricoSegGSJAdol(){
		$conect=Yii::app()->db;
		$sqlConsSegGSJAdol="select * from seguimiento_asesoriasj as a 
			left join persona as b on b.id_cedula=a.id_cedula 
			left join usuario as c on c.id_cedula=a.id_cedula 
			left join rol as d on d.id_rol=c.id_rol 
			where id_gestionsj=:id_gestionsj";
		$consSegGSJAdol=$conect->createCommand($sqlConsSegGSJAdol);
		$consSegGSJAdol->bindParam(":id_gestionsj",$this->id_gestionsj);
		$readSegGSJAdol=$consSegGSJAdol->query();
		$resSegGSJAdol=$readSegGSJAdol->readAll();
		$readSegGSJAdol->close();
		return $resSegGSJAdol;
	}
	/**
	 *	Modifica los datos de una gestión sociojurídica en específico.
	 *	@param string $this->nombre_contactosj 
	 *	@param string $this->telefono_contactosj 
	 *	@param string $this->num_doc 
	 *	@param int $this->id_gestionsj 
	 *	@return $resGestionSJ 
	 */		
	public function registraModGestionSJ(){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegModGSJ="update gestion_sociojuridica 
				set nombre_contactosj=:nombre_contactosj,telefono_contactosj=:telefono_contactosj 
				where num_doc=:num_doc and id_gestionsj=:id_gestionsj";	
			$regModGSJ=$conect->createCommand($sqlRegModGSJ);	
			$regModGSJ->bindParam(":nombre_contactosj",$this->nombre_contactosj,PDO::PARAM_STR);
			$regModGSJ->bindParam(":telefono_contactosj",$this->telefono_contactosj,PDO::PARAM_STR);
			$regModGSJ->bindParam(":num_doc",$this->num_doc,PDO::PARAM_STR);
			$regModGSJ->bindParam(":id_gestionsj",$this->id_gestionsj,PDO::PARAM_INT);
			$regModGSJ->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;
		}
	}
}
