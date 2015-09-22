<?php

/**
 * This is the model class for table "cambio_sede".
 *
 * The followings are the available columns in table 'cambio_sede':
 * @property integer $id_cambio_sede
 * @property integer $id_doc_soporte
 * @property string $num_doc
 * @property string $sede_nueva
 * @property string $sede_anterior
 * @property boolean $vbno_coord
 * @property string $doc_coord
 * @property string $fecha_cambio_sede
 *
 * The followings are the available model relations:
 * @property Adolescente $numDoc
 * @property DocumentoSoporte $idDocSoporte
 */
class CambioSede extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $numeroCarpeta;
	public function tableName()
	{
		return 'cambio_sede';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' num_doc, sede_nueva, sede_anterior, fecha_cambio_sede', 'required'),
			array('id_doc_soporte', 'numerical', 'integerOnly'=>true),
			array('num_doc', 'length', 'max'=>15),
			array('sede_nueva, sede_anterior', 'length', 'max'=>50),
			array('doc_coord', 'length', 'max'=>20),
			array('vbno_coord', 'safe'),
			array('vbno_coord', 'validaVoBno'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cambio_sede, id_doc_soporte, num_doc, sede_nueva, sede_anterior, vbno_coord, doc_coord, fecha_cambio_sede', 'safe', 'on'=>'search'),
		);
	}
	public function validaVoBno($attribute=NULL,$params=NULL){			
		if(Yii::app()->controller->action->id=='procedeCambioSede'){
			$controlAcceso=new ControlAcceso();
			$controlAcceso->accion="resolverSolicitudCambioSede";
			$permiso=$controlAcceso->controlAccesoAcciones();
			if($permiso["acceso_rolmenu"]==1){
				if(isset($_POST["CambioSede"]["vbno_coord"])&&empty($_POST["CambioSede"]["vbno_coord"])){
						//print_r($_POST["Adolescente"]);
						$this->addError($attribute,"Debe seleccionar una opción en aprobación");					
				}
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
			'numDoc' => array(self::BELONGS_TO, 'Adolescente', 'num_doc'),
			'idDocSoporte' => array(self::BELONGS_TO, 'DocumentoSoporte', 'id_doc_soporte'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cambio_sede' => 'Id Cambio Sede',
			'id_doc_soporte' => 'Id Doc Soporte',
			'num_doc' => 'Num Doc',
			'sede_nueva' => 'Sede Nueva',
			'sede_anterior' => 'Sede Anterior',
			'vbno_coord' => 'Vbno Coord',
			'doc_coord' => 'Doc Coord',
			'fecha_cambio_sede' => 'Fecha Cambio Sede',
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

		$criteria->compare('id_cambio_sede',$this->id_cambio_sede);
		$criteria->compare('id_doc_soporte',$this->id_doc_soporte);
		$criteria->compare('num_doc',$this->num_doc,true);
		$criteria->compare('sede_nueva',$this->sede_nueva,true);
		$criteria->compare('sede_anterior',$this->sede_anterior,true);
		$criteria->compare('vbno_coord',$this->vbno_coord);
		$criteria->compare('doc_coord',$this->doc_coord,true);
		$criteria->compare('fecha_cambio_sede',$this->fecha_cambio_sede,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CambioSede the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function consultaSolCambioSede($numDocAdol){
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsSolCS="select * from cambio_sede as a left join documento_soporte as b on b.id_doc_soporte=a.id_doc_soporte 			
			where num_doc=$1 order by fecha_cambio_sede desc limit 1";
		$res=pg_prepare($linkBd,"consSolCS",$sqlConsSolCS);
		$res=pg_execute($linkBd, "consSolCS", array($numDocAdol));
		$consSolCS=array();
		$consSolCS=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consSolCS;
	}
	public function consultaCambioSede($numDocAdol){
		$consultasGenerales=new ConsultasGenerales();
		$linkBd=$consultasGenerales->conectaBDSinPdo();
		$sqlConsSolCS="select * from cambio_sede as a left join documento_soporte as b on b.id_doc_soporte=a.id_doc_soporte 
			where num_doc=$1 and vbno_coord is null";
		$res=pg_prepare($linkBd,"consSolCS",$sqlConsSolCS);
		$res=pg_execute($linkBd, "consSolCS", array($numDocAdol));
		$consSolCS=array();
		$consSolCS=pg_fetch_array($res);
		pg_close($linkBd);	
		return $consSolCS;
	}
	
	
	
	public function registraSolCambioSede($modeloDocSoporte){
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlRegDocSoporte="insert into documento_soporte (
				id_doc_soporte,
				nombre_doc_ds,
				ruta_acceso_ds,
				fecha_reg_ds			
			) values (
				default,
				:nombre_doc_ds,
				:ruta_acceso_ds,
				:fecha_reg_ds			
			) returning id_doc_soporte";
			$regDocSoporte=$conect->createCommand($sqlRegDocSoporte);
			$regDocSoporte->bindParam(":nombre_doc_ds",$modeloDocSoporte->nombre_doc_ds,PDO::PARAM_STR);
			$regDocSoporte->bindParam(":ruta_acceso_ds",$modeloDocSoporte->ruta_acceso_ds,PDO::PARAM_STR);
			$regDocSoporte->bindParam(":fecha_reg_ds",$modeloDocSoporte->fecha_reg_ds,PDO::PARAM_STR);			
			$readIdDocSoporte=$regDocSoporte->query();
			$resIdDocSoporte=$readIdDocSoporte->read();
			$readIdDocSoporte->close();
			
			$sqlRegSolCambioSede="insert into cambio_sede (
				id_cambio_sede,
				id_doc_soporte,
				num_doc,
				sede_nueva,
				sede_anterior,
				fecha_cambio_sede
			) values (
				default,
				:id_doc_soporte,
				:num_doc,
				:sede_nueva,
				:sede_anterior,
				:fecha_cambio_sede
			)";	
			$regSolCambioSede=$conect->createCommand($sqlRegSolCambioSede);
			$regSolCambioSede->bindParam(":id_doc_soporte",$resIdDocSoporte["id_doc_soporte"],PDO::PARAM_INT);
			$regSolCambioSede->bindParam(":num_doc",$this["num_doc"],PDO::PARAM_INT);
			$regSolCambioSede->bindParam(":sede_nueva",$this["sede_nueva"],PDO::PARAM_STR);
			$regSolCambioSede->bindParam(":sede_anterior",$this["sede_anterior"],PDO::PARAM_STR);
			$regSolCambioSede->bindParam(":fecha_cambio_sede",$this["fecha_cambio_sede"],PDO::PARAM_STR);
			$regSolCambioSede->execute();
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}				
	}
	public function registraDecCambioSede(){		
		$infoSol=$this->consultaCambioSede($this->num_doc);
		$conect=Yii::app()->db;
		$transaction=$conect->beginTransaction();
		try{
			$sqlActCambSede="update cambio_sede set vbno_coord=:vbno_coord,doc_coord=:doc_coord where num_doc=:num_doc and id_cambio_sede=:id_cambio_sede";
			$actCambioSede=$conect->createCommand($sqlActCambSede);
			$actCambioSede->bindParam(':vbno_coord',$this->vbno_coord,PDO::PARAM_BOOL);
			$actCambioSede->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
			$actCambioSede->bindParam(':id_cambio_sede',$infoSol["id_cambio_sede"],PDO::PARAM_INT);
			$actCambioSede->bindParam(':doc_coord',Yii::app()->user->getState('cedula'),PDO::PARAM_INT);
			$actCambioSede->execute();
			
			if($this->vbno_coord=="true"){
				$sqlAdolSede="update forjar_adol set id_forjar=:id_forjar,id_estado_adol=1 where num_doc=:num_doc";
				$adolSede=$conect->createCommand($sqlAdolSede);
				$adolSede->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);
				$adolSede->bindParam(':id_forjar',$infoSol["sede_nueva"],PDO::PARAM_STR);
				$adolSede->execute();
				
				$sqlConsNumCarpetaActual="select id_numero_carpeta from numero_carpeta where id_forjar=:id_forjar and id_forjar is not null and num_doc is not null  order by id_numero_carpeta desc limit 1";
				$consNumCarpetaActual=$conect->createCommand($sqlConsNumCarpetaActual);
				$consNumCarpetaActual->bindParam(':id_forjar',$infoSol["sede_nueva"],PDO::PARAM_STR);
				$readNumCarpetaActual=$consNumCarpetaActual->query();
				$resNumCarpeta=$readNumCarpetaActual->read();
				if(empty($resNumCarpeta)){
					$idCarpeta=1;					
				}
				else{
					$idCarpeta=$resNumCarpeta["id_numero_carpeta"]+1;					
				}
				
				$sqlAsignaNumCarp="insert into numero_carpeta (
					id_reg,
					id_forjar,
					num_doc,
					id_numero_carpeta
				) values (
					default,
					:id_forjar,
					:num_doc,
					:id_numero_carpeta
				)returning id_numero_carpeta";
				$queryAsignaNumCarp=$conect->createCommand($sqlAsignaNumCarp);
				$queryAsignaNumCarp->bindParam(':num_doc',$this->num_doc,PDO::PARAM_STR);//
				$queryAsignaNumCarp->bindParam(':id_forjar',$infoSol["sede_nueva"],PDO::PARAM_STR);
				$queryAsignaNumCarp->bindParam(':id_numero_carpeta',$idCarpeta,PDO::PARAM_STR);
				$readNumCarpeta=$queryAsignaNumCarp->query();
				$resNumCarpeta=$readNumCarpeta->read();
				$this->numeroCarpeta=$resNumCarpeta["id_numero_carpeta"];
				$readNumCarpeta->close();								
			}
			
			$transaction->commit();
			return "exito";
		}
		catch(CDbCommand $e){
			$transaction->rollBack();
			return $e;			
		}				
	}
}
