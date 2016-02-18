<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<fieldset >
<legend>Modificar datos del adolescente</legend>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/modificarDatosForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>


<?php if(!empty($numDocAdol)):?>

<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'article_tab',
    'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..

    'tabs'=>array(
    	'Datos del Adolescente'=>$this->renderPartial('_formAdolescenteMod', 
			array(
				'formAdol'=>$formAdol,
				'tipoDocBd'=>$tipoDocBd,
				'departamento'=>$departamento,
				'sexo'=>$sexo,
				'etnia'=>$etnia,
				'municipio'=>$municipio,
				'departamento'=>$departamento,
				'idDepartamento'=>$idDepartamento
			),true,false),
    	'Localización del adolescente'=>$this->renderPartial($formularioCarga, 
			array(
				'modeloLocalizacion'=>$modeloLocalizacion,
				'localidad'=>$localidad,
				'estrato'=>$estrato,
				'modeloTelefono'=>$modeloTelefono,
				'numDocAdol'=>$numDocAdol,
				'telefonoAdol'=>$telefonoAdol
			),true,false),
		'Verificación de derechos Defensoría'=>$this->renderPartial($formularioCargaDerechos, 
			array(
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'numDocAdol'=>$numDocAdol,
			),true,false),
		'Documentos remitidos'=>$this->renderPartial($formularioCargaDocsCespa, 
			array(
				'modeloDocCespa'=>$modeloDocCespa,
				'docsCespa'=>$docsCespa,
				'numDocAdol'=>$numDocAdol,
				'categories'=>$categories
			),true,false),
		'Acudiente'=>$this->renderPartial($formularioCargaAcud, 
			array(
				'modeloAcudiente'=>$modeloAcudiente,
				'tipoDocBd'=>$tipoDocBd,
				'parentesco'=>$parentesco,
				'modeloLocalizacion'=>$modeloLocalizacionAcud,
				'localidad'=>$localidad,
				'estrato'=>$estrato,
				'modeloTelefono'=>$modeloTelefonoAcud,
				'numDocAdol'=>$numDocAdol,
				'acudiente'=>$acudiente,
				'telefonoAcud'=>$telefonoAcud
			),true,false),
    ),
    'options'=>array('collapsible'=>false),
)); 

?>

<?php Yii::app()->getClientScript()->registerScript('scriptRegistraDatos','
$(document).ready(function(){
	$("form").find(":input").change(function(){
		var dirtyForm = $(this).parents("form");
		// change form status to dirty
		dirtyForm.addClass("unsavedForm");
	});
});	
var campoText=0;
$(window).bind("beforeunload", function(){
	if($(".unsavedForm").size()){
		return "Aún no ha guardado cambios.  Los perderá si abandona.";
	}
});'
,CClientScript::POS_END);
?>

<?php endif;?>
</fieldset>
