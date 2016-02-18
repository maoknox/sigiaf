<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<fieldset >
<legend>Consultar datos del adolescente</legend>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/ConsultarDatos'),
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
    	'Datos del Adolescente'=>$this->renderPartial('_formAdolescenteCons', 
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
    	'Localización del adolescente'=>$this->renderPartial("_formLocalizacionCons", 
			array(
				'modeloLocalizacion'=>$modeloLocalizacion,
				'localidad'=>$localidad,
				'estrato'=>$estrato,
				'modeloTelefono'=>$modeloTelefono,
				'numDocAdol'=>$numDocAdol,
				'telefonoAdol'=>$telefonoAdol
			),true,false),
		'Verificación de derechos Defensoría'=>$this->renderPartial("_formVerificacionDerCespaCons", 
			array(
				'modeloVerifDerechos'=>$modeloVerifDerechos,
				'derechos'=>$derechos,
				'participacion'=>$participacion,
				'proteccion'=>$proteccion,
				'numDocAdol'=>$numDocAdol,
			),true,false),
		'Documentos remitidos'=>$this->renderPartial("_formAdolDocsCespaCons", 
			array(
				'modeloDocCespa'=>$modeloDocCespa,
				'docsCespa'=>$docsCespa,
				'numDocAdol'=>$numDocAdol,
				'categories'=>$categories
			),true,false),
		'Acudiente'=>$this->renderPartial("_formAcudienteCons", 
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
<?php endif;?>
</fieldset>
