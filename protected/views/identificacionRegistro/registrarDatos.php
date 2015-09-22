<fieldset >
<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'article_tab',
    'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..

    'tabs'=>array(
    	'Datos del Adolescente'=> $this->renderPartial('_formAdolescente', array('formAdol'=>$formAdol),true,false),
    	'Localización del adolescente'=> 'bla',
		'Informacion Judicial/Admtva'=>$this->renderPartial('_formInfJudicialAdmtva', array('modeloInfJudAdmon'=>$modeloInfJudAdmon),true,false),
		'Vinculación'=> 'bla',
		'Derechos'=> 'bla',
		'Documentos remitidos'=> 'bla',
		'Acudiente'=> 'bla',
    ),
    'options'=>array('collapsible'=>false),
)); 

?>
</fieldset>