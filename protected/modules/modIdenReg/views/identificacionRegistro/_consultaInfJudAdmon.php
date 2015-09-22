<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
if($accion=="modificar"){
	$accionController="modRegInfJudicialAdmtvaForm";
	$accionControllerReg="consInfJudMod";
	?>
	<strong>INFORMACIÓN JUDICIAL DEL ADOLESCENTE A MODIFICAR</strong>
	<?php
}
elseif($accion=="regNovedad"){
	$accionController="novRegInfJudicialAdmtvaForm";
	$accionControllerReg="consInfJudRegNov";
	?>
    	<strong>REGISTRAR NOVEDAD</strong>
    <?php
}

?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/'.$accionController),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):

?>
<table cellpadding="0" cellspacing="0" border="0px" style="width:100%">
	<tr>
    	<td style="border:1px solid #000">
        	Número de proceso
        </td>
        <td style="border:1px solid #000">
        	Delito
        </td>
        <td style="border:1px solid #000">
        	Fecha de la aprehensión
        </td>
       
        
    </tr>
<?php 
//echo $offset//echo $datosRef["id_referenciacion"]
	//echo count($infJudicial);
	foreach($infJudicial as $pk=>$infJudicial):
?>
<?php 	
	$formConsRef=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioConsInfJud_'.$pk,
	'action'=>$accionControllerReg,
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
));
?>
<tr>
    <td style="border:1px solid #000">
       <?php echo $infJudicial["no_proceso"];?>
    </td>
    <td style="border:1px solid #000">
       <?php 
	   		$modeloInfJudAdmon->num_doc=$numDocAdol;
			/*if(!empty($infJudicial["nov_id_inf_judicial"])){
				$modeloInfJudAdmon->id_inf_judicial=$infJudicial["nov_id_inf_judicial"];
			}
			else{
		   		$modeloInfJudAdmon->id_inf_judicial=$infJudicial["id_inf_judicial"];
			}*/
			$modeloInfJudAdmon->id_inf_judicial=$infJudicial["id_inf_judicial"];
	   		$delitosAdol=$modeloInfJudAdmon->consultaDelito();
			foreach($delitosAdol as  $delitosAdol){
				echo CHtml::encode($delitosAdol["del_remcespa"]);
			}	   		
		?>
    </td>
    <td style="border:1px solid #000">
        <?php echo $infJudicial["fecha_aprehension"];?>
    </td>
    
    <td style="border:1px solid #000">
    
    	<?php 
			//echo CHtml::hiddenField('id_referenciacion',$datosRef["id_referenciacion"]);
			echo $formConsRef->hiddenField($modeloInfJudAdmon,"num_doc");
			echo $formConsRef->hiddenField($modeloInfJudAdmon,"id_inf_judicial");
			// si es novedad es instanciado el id de la información judicial original.
			if(empty($infJudicial["id_inf_judicial_princ"])){
				$infJudicial["id_inf_judicial_princ"]=$infJudicial["id_inf_judicial"];
			}
			
			echo CHtml::hiddenField("id_inf_jud_primaria",$infJudicial["id_inf_judicial_princ"],array('name'=>"id_inf_jud_primaria"));
			$boton=CHtml::button(
					'Ir al registro',
					array('onclick'=>'js:renderizarInfJud("'.$pk.'")')
				); 
			echo $boton;
			?>
    </td>
   </tr>
 <?php $this->endWidget();?>
 
<?php
	endforeach;
?>
</table>
<?php if($offset==0): $superior=$offset+5;?>
<label>Mostrando del registro 1 al registro <?php echo  $superior;?></label>

<?php echo CHtml::link('Siguiente','Siguiente',array('submit'=>array('identificacionRegistro/'.$accionController),'params'=>array('offset'=>$superior))); ?>
<?php else: $superior=$offset+5; $inferior=$offset-5?>
<?php echo CHtml::link('Anterior','Siguiente',array('submit'=>array('identificacionRegistro/'.$accionController),'params'=>array('offset'=>$inferior))); ?>
<label>Mostrando del registro <?php echo  $offset+1;?> al registro <?php echo  $superior;?></label>
<?php echo CHtml::link('Siguiente','Siguiente',array('submit'=>array('identificacionRegistro/'.$accionController),'params'=>array('offset'=>$superior))); ?>
<?php endif;?>
<?php Yii::app()->getClientScript()->registerScript('script_modifestado','
	function renderizarInfJud(idForm){
		//alert("blaa");
		$( "#formularioConsInfJud_"+idForm ).submit();
	}
'
,CClientScript::POS_END);
?>

<?php endif;?>
