<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<fieldset >
<legend>Registrar datos del adolescente</legend>
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'article_tab',
    'htmlOptions'=>array('style'=>'display: block;font-size:12px;'),  // INVISIBLE..

    'tabs'=>array(
    	'Datos del Adolescente'=> $this->renderPartial('_formAdolescente', 
			array(
				'formAdol'=>$formAdol,
				'tipoDocBd'=>$tipoDocBd,
				'departamento'=>$departamento,
				'sexo'=>$sexo,
				'etnia'=>$etnia,
				'psicologo'=>$psicologo,
				'trabSocial'=>$trabSocial,
			),true,false),
    	'Localización del adolescente'=>$this->renderPartial('_formLocalizacion', 
			array(
				'modeloLocalizacion'=>$modeloLocalizacion,
				'localidad'=>$localidad,
				'estrato'=>$estrato,
				'modeloTelefono'=>$modeloTelefono,
				'numDocAdol'=>$numDocAdol
			),true,false),
		//'Informacion Judicial/Admtva'=>$this->renderPartial('_formInfJudicialAdmtva', array('modeloInfJudAdmon'=>$modeloInfJudAdmon),true,false),
		//'Vinculación'=> 'bla',
		//'Derechos'=> 'bla',
		'Verificación de derechos Defensoría'=>$this->renderPartial('_formVerificacionDerCespa', 
			array(
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'numDocAdol'=>$numDocAdol
			),true,false),
		'Documentos remitidos'=> $this->renderPartial('_formAdolDocsCespa', 
			array(
				'modeloDocCespa'=>$modeloDocCespa,
				'docsCespa'=>$docsCespa,
				'numDocAdol'=>$numDocAdol
			),true,false),
		'Acudiente'=> $this->renderPartial('_formAcudiente', 
			array(
				'modeloAcudiente'=>$modeloAcudiente,
				'tipoDocBd'=>$tipoDocBd,
				'parentesco'=>$parentesco,
				'modeloLocalizacion'=>$modeloLocalizacion,
				'localidad'=>$localidad,
				'estrato'=>$estrato,
				'modeloTelefono'=>$modeloTelefono,
				'numDocAdol'=>$numDocAdol
			),true,false),
    ),
    'options'=>array('collapsible'=>false),
)); 

?>
</fieldset>
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
