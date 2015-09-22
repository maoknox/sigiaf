<fieldset >


<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'id'=>'article_tab',
    'htmlOptions'=>array('style'=>'display: block;font-size:11px'),  // INVISIBLE..

    'tabs'=>array(
    	'Datos del Adolescente'=> $this->renderPartial('modificarDatos', array('a'=>$a, 'b'=>$b),true,true), 
    	'Localización del adolescente'=> 'bla',
    	'Inf. Judicial/Administrativa'=> $this->renderPartial('modificarDatos', array('a'=>$a, 'b'=>$b),true,true),
		'Vinculación'=> 'bla',
		'Derechos'=> 'bla',
		'Documentos remitidos'=> 'bla',
		'Acudiente'=> 'bla',
    ),
    'options'=>array('collapsible'=>false),
)); 

?>
</fieldset>