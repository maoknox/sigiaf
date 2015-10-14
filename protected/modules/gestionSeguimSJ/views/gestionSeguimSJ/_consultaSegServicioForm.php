<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('referenciacion/asignacionServicio/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('referenciacion/asignacionServicio/consultaSegServicioForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)):?>
<strong>Listado de referenciaciones</strong>
<table cellpadding="0" cellspacing="0" border="0px" style="width:100%">
	<tr>
    	<td style="border:1px solid #000">
        	Fecha de la referenciación
        </td>
        <td style="border:1px solid #000">
        	Línea de acción
        </td>
        <td style="border:1px solid #000">
        	Especificación de nivel 1
        </td>
        <td style="border:1px solid #000">
        	Especificación de nivel 2
        </td>
        <td style="border:1px solid #000">
        	Especificación de nivel 3
        </td>
        <td style="border:1px solid #000">
        	Beneficiario
        </td>
        
    </tr>
<?php 
	foreach($datosRef as $pk=>$datosRef)://revisar variable
?>
<?php $formConsRef=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioConsRef_'.$pk,
	'action'=>'segServicioForm',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
));
?>
<tr>
    <td style="border:1px solid #000">
       <?php echo $datosRef["fecha_referenciacion"];?>
    </td>
    <td style="border:1px solid #000">
       <?php echo $datosRef["tipo_referenciacion"];?>
    </td>
    <td style="border:1px solid #000">
        <?php echo $datosRef["esp_sol"];?>
    </td>
    <td style="border:1px solid #000">
        <?php echo $datosRef["esp_solii"];?>
    </td>
    <td style="border:1px solid #000">
        <?php echo $datosRef["esp_soliii"];?>
    </td>
    <td style="border:1px solid #000">
       <?php echo $datosRef["beneficiario"];?>
    </td>
    <td style="border:1px solid #000">
    
    	<?php 
			echo CHtml::hiddenField('id_referenciacion',$datosRef["id_referenciacion"]);
			echo CHtml::hiddenField('numDocAdol',$numDocAdol);
			echo CHtml::button(
			'Ir a seguimiento',
			array('onclick'=>'js:servicioSegForm("'.$pk.'")')
		);//echo $offset//echo $datosRef["id_referenciacion"]?>
    </td>
    </tr>
 <?php $this->endWidget();?>

<?php
	endforeach;
?>
</table>
<?php if($offset==0): $superior=$offset+5;?>
<label>Mostrando del registro 1 al registro <?php echo  $superior;?></label>

<?php echo CHtml::link('Siguiente','Siguiente',array('submit'=>array('asignacionServicio/consultaSegServicioForm'),'params'=>array('offset'=>$superior))); ?>
<?php else: $superior=$offset+5; $inferior=$offset-5?>
<?php echo CHtml::link('Anterior','Siguiente',array('submit'=>array('asignacionServicio/consultaSegServicioForm'),'params'=>array('offset'=>$inferior))); ?>
<label>Mostrando del registro <?php echo  $offset+1;?> al registro <?php echo  $superior;?></label>
<?php echo CHtml::link('Siguiente','Siguiente',array('submit'=>array('asignacionServicio/consultaSegServicioForm'),'params'=>array('offset'=>$superior))); ?>
<?php endif;?>
<?php Yii::app()->getClientScript()->registerScript('script_modifestado','
	function servicioSegForm(idForm){
		$( "#formularioConsRef_"+idForm ).submit();
	}
'
,CClientScript::POS_END);
?>

<?php endif;?>
