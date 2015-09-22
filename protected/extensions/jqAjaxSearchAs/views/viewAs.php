<fieldset>
<?php echo CHtml::beginForm($action,'post',array("id"=>"searchform_".$numDocAdol,'class' => 'form-horizontal')); ?>
<div class="form-group">
	<?php echo CHtml::label("Digite el nombre del adolescente","search_term",array('class'=>'col-md-4 control-label'));?>
    <div class="col-md-4">
		<?php echo CHtml::textField("search_term","",array('id'=>'search_term_','class'=>'form-control'));?>
        <div id="resultado" style="border:1px solid #003; position:absolute; width:300px; background:#FFF; z-index:100"></div>
	</div> 
</div>
<?php echo CHtml::endForm(); ?>
</fieldset>
<fieldset>
<?php echo CHtml::beginForm('','post',array("id"=>"datosAdol",'class' => 'form-horizontal')); ?>
<?php echo CHtml::hiddenField("numDocAdol","",array('id'=>'numDocAdol'));?>
   	<div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
			<?php
            echo  CHtml::button('Agregar',
                array(
					'class'=>'btn btn-default btn-sdis',
                    'onclick'=>'javascript:var numDoc=$("#numDocAdol").val(); if(numDoc.length==0){alert("No ha seleccionado un adolescente");return;} if($("#listaAdolescentes #"+numDoc).length!=0){alert("el adolescente ya fue agregado a la lista");}else{agregaAdol(numDoc,$("#search_term_").val())}',
                    //'confirm' => 'Are you sure?'
                    // or you can use 'params'=>array('id'=>$id)
                )
            );
	CHtml::ajaxButton('Continuar',array('asistencia/agregaAdol'), 
		array(                                   
			'beforeSend' => 'function(){ return;}',
			 'success' => 'function (datos){$("#listaAdolescentes").append("<p>bla</p>")}',
		),
		array(
			//coloco la clase que quiero que tenga el boton y listo
			'class'=>'btn btn-primary',
		)
	); 		
?>
	</div>
</div>
<?php echo CHtml::endForm(); ?>
</fieldset>
