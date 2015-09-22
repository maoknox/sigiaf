<!--<a class="test-popup-link" href="http://farm9.staticflickr.com/8241/8589392310_7b6127e243_b.jpg">Open popup</a>-->
<div id="divFormConcPlInt">
<div id="Mensaje" style="font-size:14px;" ></div>

<fieldset id="perfilGenerVuln">
<?php $formPerfGV=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPerfGV',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formPerfGV->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       		<?php echo $formPerfGV->labelEx($modelValTrSoc,'perfil_gener_vuln',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='Describir claramente las potencialidades, fortalezas y recursos disponibles positivos con que cuenta el adolescente y su familia que permitan apoyar el desarrollo del proceso teniendo en cuenta además la red vincular con la que se cuenta (referentes positivos(amigos o parientes), instituciones de apoyo, grupos deportivos, grupos religiosos, grupos culturales). De igual manera hacer referencia a aquellos aspectos que implican una limitación, amenaza o riesgo para el adolescente y que puedan incidir en un adecuado avance en el proceso, desde todo el contexto social en el cual se interactúa. '>Ayuda</code>       
			<?php echo $formPerfGV->textArea($modelValTrSoc,
                'perfil_gener_vuln',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioPerfGV","perfilGenerVuln")',
                    'onkeyup'=>'js:$("#perfilGenerVuln").addClass("has-warning")'
                ));
            ?>
            <?php echo $formPerfGV->error($modelValTrSoc,'perfil_gener_vuln',array('style' => 'color:#F00'));?>
   		</div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormPerfGV','class'=>'btn btn-default btn-sdis','name'=>'btnFormPerfGV','onclick'=>'js:enviaForm("formularioPerfGV","perfilGenerVuln")')
                );
            ?>
            <?php echo $boton; //CHtml::submitButton('Crear');?>
   		</div>
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="concSocial">
<?php $formConcSoc=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioConcSoc',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formConcSoc->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       		<?php echo $formConcSoc->labelEx($modelValTrSoc,'concepto_social',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='Teniendo en cuenta todos los aspectos anteriores, se debe realizar un análisis profesional de la situación familiar y social por la que atraviesa el adolescente, para dar cuenta de su realidad pasada y presente frente a la situación que lo vinculó al SRPA.'>Ayuda</code>       
			<?php echo $formConcSoc->textArea($modelValTrSoc,
                'concepto_social',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioConcSoc","concSocial")',
                    'onkeyup'=>'js:$("#concSocial").addClass("has-warning")'
                ));
            ?>
            <?php echo $formConcSoc->error($modelValTrSoc,'concepto_social',array('style' => 'color:#F00'));?>
        </div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
				$boton=CHtml::Button (
					'Registrar',   
					array('id'=>'btnFormConcSoc','class'=>'btn btn-default btn-sdis','name'=>'btnFormConcSoc','onclick'=>'js:enviaForm("formularioConcSoc","concSocial")')
				);
			?>
    		<?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
</fieldset>
<hr />
<fieldset id="pryPlIntTsocial">
<?php $formPrInt=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioPrInt',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array('class' => 'form-horizontal')
));
?>
	<?php echo  $formPrInt->errorSummary($modelValTrSoc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
	<!--campo de texto para nombres del adolescente -->	
    <div class="form-group">
    	<div class="col-md-12">
       		<?php echo $formPrInt->labelEx($modelValTrSoc,'pry_pl_int_tsocial',array('class'=>'control-label','for'=>'searchinput'));?>
     		<code data-toggle="tooltip" title='De acuerdo al concepto social anterior y teniendo en cuenta la situación que llevó al adolescente a la vinculación al SRPA se determinan y se describen a nivel general las acciones profesionales que desde Trabajo Social se requieran para la intervención en el desarrollo del proceso desde las áreas de derecho, definiendo los actores que deben participar en el mismo(adolescente, familia, comunidad, referentes)'>Ayuda</code>       
			<?php echo $formPrInt->textArea($modelValTrSoc,
                'pry_pl_int_tsocial',
                array('class'=>'form-control',
                    'onblur'=>'js:enviaForm("formularioPrInt","pryPlIntTsocial")',
                    'onkeyup'=>'js:$("#pryPlIntTsocial").addClass("has-warning")'
                ));
            ?>
			<?php echo $formPrInt->error($modelValTrSoc,'pry_pl_int_tsocial',array('style' => 'color:#F00'));?>
        </div>
    </div>
	<div class="form-group">
        <div class="col-md-4">	
			<?php
                $boton=CHtml::Button (
                    'Registrar',   
                    array('id'=>'btnFormPrInt','class'=>'btn btn-default btn-sdis','name'=>'btnFormPrInt','onclick'=>'js:enviaForm("formularioPrInt","pryPlIntTsocial")')
                );
                ?>
                <?php echo $boton; //CHtml::submitButton('Crear');?>
    	</div>
    </div>
<?php $this->endWidget();?>
<hr />
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scripValTrSoc_2','
	$(document).ready(function(){
		$("#divFormConcPlInt").find(":input").change(function(){
			var dirtyForm = $(this).parents("form");
			// change form status to dirty
			dirtyForm.addClass("unsavedForm");
		});
	});
',CClientScript::POS_END);
