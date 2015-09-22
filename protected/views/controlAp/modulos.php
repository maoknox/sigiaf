<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
/*Yii::app()->getClientScript()->registerScript('myscript','$("#chk_just").keyup(function() {
alert(\'Hello world !\');
});');

$bla='hey';
Yii::app()->getClientScript()->registerScript('myscript','
	function leerDatos(datos){
		$.each( datos, function( key) {
			 alert(\''.$bla.'\'+key)
		});
	}
',CClientScript::POS_BEGIN);

*/

/*echo CHtml::beginForm(); ?>
 
    <?php echo CHtml::errorSummary(array($a,$b)); ?>
 
    <!-- ...input fields for $a, $b... -->
 
    <div class="row">
        <?php echo $form->labelEx($a,'a_field'); ?>
        <?php echo $form->textField($a,'a_field'); ?>
        <?php echo $form->error($a,'a_field'); ?>
    </div>
 
    <div class="row">
        <?php echo $form->labelEx($b,'b_field'); ?>
        <?php echo $form->textField($b,'b_field'); ?>
        <?php echo $form->error($b,'b_field'); ?>
    </div>
 
 
<?php echo CHtml::endForm(); ?>
*/
?><!--$(\'#smoothmenu1\').html(data)-->
<?php if(Yii::app()->user->hasState('cedula')):?>
<div>
    	<?php foreach($modulo as $mod): 
			if($mod['acceso_modulo']!=null):
			
				$boton=CHtml::submitButton($mod['nombre_modulo'],array(
					'id'=>'modulo_'.$mod['id_modulo'],
					'name'=>'modulo_'.$mod['id_modulo'],
					'class'=>'btn btn-default btn-sdis',
					'style'=>'display:inline;float:left;')
				);
				/*$boton=CHtml::ajaxButton (
						$mod['nombre_modulo'],   
						array('controlAp/index'),
						array(	
							'async'=>true,					
							'data' =>array('id_modulo'=>$mod['id_modulo']),
							'type' => 'post',
							'success' => 'function(datos) {$(\'#bs-example-navbar-collapse-10\').html(datos) }',							
						),
						array(
							'id'=>'modulo_'.$mod['id_modulo'],
							'name'=>'modulo_'.$mod['id_modulo'],
							'class'=>'btn btn-default btn-sdis'
						)
				);*/
			else:
				$boton="<label style='display:inline;float:left;' class='btn btn-default btn-sdis'>".$mod['nombre_modulo']."</label>";
			endif;
		?>
        	<?php if($mod['id_modulo'] % 2 ==1):?>
                    <?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'formularioAdol_'.$mod['id_modulo'],
							'enableAjaxValidation'=>false,
							'enableClientValidation'=>true,
							'clientOptions'=>array(
								'validateOnSubmit'=>true,
							),
							'action'=>'modulos',
							'htmlOptions' => array('class' => 'form-horizontal')
						));
							// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
						?>
                        <?php
                        	echo CHtml::hiddenField('id_modulo',$mod['id_modulo']);
						?>
                        <?php echo $boton;?>
                         <?php $this->endWidget();?>
                    
		<?php else:?>
        <?php $form=$this->beginWidget('CActiveForm', array(
							'id'=>'formularioAdol_'.$mod['id_modulo'],
							'enableAjaxValidation'=>false,
							'enableClientValidation'=>true,
							'clientOptions'=>array(
								'validateOnSubmit'=>true,
							),
							'action'=>'modulos',
							'htmlOptions' => array('class' => 'form-horizontal')
						));
							// si se quisiera ir a otro controlador se crearia una Url dentro del array 'action'=>$this->createUrl('controlador/metodo');
						?>
                        <?php
                        	echo CHtml::hiddenField('id_modulo',$mod['id_modulo']);
						?>
                        <?php echo $boton;?>
                         <?php $this->endWidget();?>
                        
        <?php endif;?>	
        <?php endforeach; ?>
</div>	

<?php 
//echo $_modulo;

/*$this->widget('zii.widgets.jui.CJuiTabs',array(
	    'tabs'=>array(
	        'StaticTab '=>'Content for tab 1',
	        'StaticTab With ID'=>array('content'=>'Content for tab 2 With Id' , 'id'=>'tab2'),
	        'AjaxTab'=>array('ajax'=>$this->createUrl('hola/prueba')),
	    ),
	    // additional javascript options for the tabs plugin
	    'options'=>array(
	        'collapsible'=>true,
	    ),
	    'id'=>'MyTab-Menu',
	));
*/

endif; ?>

