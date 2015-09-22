  <?php $this->widget('application.extensions.loading.LoadingWidget');?>
 <?php
 	$meses=array();
	array_push($meses,array('numMes'=>'1','nombreMes'=>'Enero'));
	array_push($meses,array('numMes'=>'2','nombreMes'=>'Febrero'));
	array_push($meses,array('numMes'=>'3','nombreMes'=>'Marzo'));
	array_push($meses,array('numMes'=>'4','nombreMes'=>'Abril'));	
	array_push($meses,array('numMes'=>'5','nombreMes'=>'Mayo'));	
	array_push($meses,array('numMes'=>'6','nombreMes'=>'Junio'));	
	array_push($meses,array('numMes'=>'7','nombreMes'=>'Julio'));
	array_push($meses,array('numMes'=>'8','nombreMes'=>'Agosto'));	
	array_push($meses,array('numMes'=>'9','nombreMes'=>'Septiembre'));	
	array_push($meses,array('numMes'=>'10','nombreMes'=>'Octubre'));	
	array_push($meses,array('numMes'=>'11','nombreMes'=>'Noviembre'));	
	array_push($meses,array('numMes'=>'12','nombreMes'=>'Diciembre'));	
	
	$anio=array();
	$fechaSplit=split("-",date("Y-m-d"));
	
	for($i=2010;$i<=$fechaSplit[0];$i++){
		array_push($anio,array('numAnio'=>$i,'nombreAnio'=>$i));
	}
			
 ?>
 <?php $formularioRepAsist=$this->beginWidget('CActiveForm', array(
	'id'=>'formularioRepAsist',
	'action'=>Yii::app()->createUrl('asistencia/asistencia/reporteAsistenciaExcel'),
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>false,
	),
	'htmlOptions' => array(
		'class' => 'form-horizontal',
	)
));
?>	
<fieldset>
		
<!-- Form Name -->
<legend>Reporte de asistencia</legend>
<?php echo  $formularioRepAsist->errorSummary($modeloRepAsistencia,'','',array('style' => 'font-size:14px;color:#F00')); ?>
<div class="form-group">
	<?php echo $formularioRepAsist->labelEx($modeloRepAsistencia,'mes',array('class'=>'col-md-4 control-label'));?>
    <div class="col-md-4">
		<?php echo $formularioRepAsist->dropDownList($modeloRepAsistencia,'mes',CHtml::listData($meses,'numMes', 'nombreMes'), 
			array(
				'prompt'=>'Seleccione...',
				'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',								
			));
		?>
        <?php echo $formularioRepAsist->error($modeloRepAsistencia,'mes',array('style' => 'color:#F00'));?>     
    </div>
</div>
<div class="form-group">
	<?php echo $formularioRepAsist->labelEx($modeloRepAsistencia,'anio',array('class'=>'col-md-4 control-label'));?>
    <div class="col-md-4">
		<?php echo $formularioRepAsist->dropDownList($modeloRepAsistencia,'anio',CHtml::listData($anio,'numAnio', 'nombreAnio'), 
			array(
				'prompt'=>'Seleccione...',
				'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',								
			));
		?>
        <?php echo $formularioRepAsist->error($modeloRepAsistencia,'anio',array('style' => 'color:#F00'));?>     
    </div>
</div>
   	<div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
       		<?php 

            	echo CHtml::submitButton ('Generar',array(
					'id'=>'btnFormReg',
					'name'=>'btnFormReg',
					'class'=>'btn btn-default btn-sdis',
				));			
			?>
		</div>
	</div>
</fieldset>

<?php
$this->endWidget();
?>
