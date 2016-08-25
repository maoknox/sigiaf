<fieldset>
<legend>Estado de valoraciones</legend>
<?php $formConsultaEstadoVal=$this->beginWidget('CActiveForm', 
	array(
		'action'=>'consultarEstadoValsForm',
		'id'=>'formConsultaEstadoVal',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange' => true,
			'validateOnType' => true
		),
		'htmlOptions' => array('class' => 'form-horizontal')
		)
	);
?>
		<div class="form-group">
			<?php echo $formConsultaEstadoVal->labelEx($modeloPersona,'id_cedula',array('class'=>'col-md-4 control-label','for'=>'searchinput')); ?>
            <div class="col-md-4">
                <?php echo $formConsultaEstadoVal->dropDownList($modeloPersona,'id_cedula',CHtml::listData($funcionarios,'id_cedula', 'nombres'), 
					array(
						'prompt'=>'Seleccione...',
						'class'=>'selectpicker form-control','data-hide-disabled'=>'true','data-live-search'=>'true',								
					)); 
				?>
            </div>
		</div>        



	<div class="form-group"> 
	<?php echo CHtml::label("Seleccione Fecha de inicio del reporte","search_term",array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">

<?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array(
			'name'=>'fecha_inicio',
			'id'=>'fecha_inicio',
			'attribute'=>'fecha_inicio',
			'value'=>'',
			'language'=>'es',			
			'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control'),			
			'options'=>array('autoSize'=>true,
					'defaultDate'=>'',
					'dateFormat'=>'yy-mm-dd',
					'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'minDate'=>'2010-1-1',//fecha minima
					'maxDate'=>'date("Y-m-d")-1m',//fecha maxima
			),
		));
		
	?>
    </div>
    
</div>
	<div class="form-group"> 
	<?php echo CHtml::label("Seleccione Fecha de fin del reporte","search_term",array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
        <div class="col-md-4">

<?php //
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array(
			'name'=>'fecha_fin_reporte',
			'id'=>'fecha_fin_reporte',
			'attribute'=>'fecha_fin_reporte',
			'value'=>'',
			'language'=>'es',			
			'htmlOptions'=>	array('readonly'=>"readonly",'class'=>'form-control'),			
			'options'=>array('autoSize'=>true,
					'defaultDate'=>'',
					'dateFormat'=>'yy-mm-dd',
					'buttonText'=>'Seleccione Fecha',
					'selectOtherMonths'=>true,
					'showAnim'=>'slide',
					'showOtherMonths'=>true,
					'changeMonth'=>'true',
					'changeYear'=>'true',
					'minDate'=>'2010-1-1',//fecha minima
					'maxDate'=>'date("Y-m-d")',//fecha maxima
			),
		));
		
	?>
    </div>
</div>

    <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
        <?php $boton=CHtml::submitButton ('enviar',array('id'=>'btnForm','name'=>'btnForm','class'=>'btn btn-default btn-sdis')); ?>
        <?php echo $boton?>    
    </div>
</div>
<?php $this->endWidget();?>

<?php if(!empty($idCedula) && !empty($fechaIniRep) && !empty($fechaFinRep)): ?>
<?php 
	switch($datosUsuario["id_rol"]){
		case 4:
			$modeloConsultasGenerales->idCedula=$idCedula;
			$modeloConsultasGenerales->fechaInicio=$fechaIniRep;
			$modeloConsultasGenerales->fechaFinal=$fechaFinRep;
			$adolFuncionario=array();
			$adolFuncionario=$modeloConsultasGenerales->consultaAdolFuncionarioHisPers();
			//print_r($adolFuncionario);
			if(!empty($adolFuncionario)){
				$cuerpoTabla="";
				foreach($adolFuncionario as $adolFun){
					$estado="";					
					$modeloConsultasGenerales->numDocAdol=$adolFun["num_doc"];	
					$datosAdol=$modeloConsultasGenerales->consultaDatosAdolValoraciones();										
					$infoValPsicol=$modeloConsultasGenerales->consultaValPsicolReporte();					
					if(!empty($infoValPsicol)){
						if(empty($infoValPsicol["fecha_iniciovalpsicol"])){
							$estado="Sin valoración";						
						}
						else if($infoValPsicol["id_estado_val"]==1){
							$estado="Completa";								
						}
						else if($infoValPsicol["id_estado_val"]==2){
							$estado="Incompleta";								
						}
						else if($infoValPsicol["id_estado_val"]==3){
							$estado="No realizada";															
						}
						else if(empty($infoValPsicol["id_estado_val"])){
							$estado="Estado no definido";								
						}
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$estado."</td>";
						$cuerpoTabla.="<td>".$infoValPsicol["fecha_iniciovalpsicol"]."</td>";
						$cuerpoTabla.="<td>".$infoValPsicol["observ_estvalpsicol"]."</td></tr>";											
					}
					else{
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>Sin valoración</td>";
						$cuerpoTabla.="<td>-</td>";
						$cuerpoTabla.="<td>-</td></tr>";											
					}
				}				
			}
		break;
		case 5:
			$modeloConsultasGenerales->idCedula=$idCedula;
			$modeloConsultasGenerales->fechaInicio=$fechaIniRep;
			$modeloConsultasGenerales->fechaFinal=$fechaFinRep;
			$adolFuncionario=array();
			$adolFuncionario=$modeloConsultasGenerales->consultaAdolFuncionarioHisPers();
			//print_r($adolFuncionario);
			if(!empty($adolFuncionario)){
				$cuerpoTabla="";
				foreach($adolFuncionario as $adolFun){
					$estado="";					
					$modeloConsultasGenerales->numDocAdol=$adolFun["num_doc"];	
					$datosAdol=$modeloConsultasGenerales->consultaDatosAdolValoraciones();										
					$infoVal=$modeloConsultasGenerales->consultaValTrSocReporte();					
					if(!empty($infoVal)){
						if(empty($infoVal["fecha_inicio_valtsoc"])){
							$estado="Sin valoración";						
						}
						else if($infoVal["id_estado_val"]==1){
							$estado="Completa";								
						}
						else if($infoVal["id_estado_val"]==2){
							$estado="Incompleta";								
						}
						else if($infoVal["id_estado_val"]==3){
							$estado="No realizada";															
						}
						else if(empty($infoVal["id_estado_val"])){
							$estado="Estado no definido";								
						}
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>".$estado."</td>";
						$cuerpoTabla.="<td>".$infoVal["fecha_inicio_valtsoc"]."</td>";
						$cuerpoTabla.="<td>".$infoVal["observ_estvaltsoc"]."</td></tr>";											
					}
					else{
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>Sin valoración</td>";
						$cuerpoTabla.="<td>-</td>";
						$cuerpoTabla.="<td>-</td></tr>";											
					}
				}				
			}
		break;
		case 6:
			$modeloConsultasGenerales->idCedula=$idCedula;
			$modeloConsultasGenerales->fechaInicio=$fechaIniRep;
			$modeloConsultasGenerales->fechaFinal=$fechaFinRep;
			$adolFuncionario=array();
			$adolFuncionario=$modeloConsultasGenerales->consultaAdolFuncionario();
			if(!empty($adolFuncionario)){
				$cuerpoTabla="";
				foreach($adolFuncionario as $adolFun){
					$estado="";					
					$modeloConsultasGenerales->numDocAdol=$adolFun["num_doc"];	
					$datosAdol=$modeloConsultasGenerales->consultaDatosAdolValoraciones();										
					$infoVal=$modeloConsultasGenerales->consultaValTOReporte();					
					if(!empty($infoVal)){
						if(empty($infoVal["fecha_inicio_valteo"]) && empty($infoVal["id_estado_val"])){
							$estado="Sin valoración";						
						}
						else if($infoVal["id_estado_val"]==1){
							$estado="Completa";								
						}
						else if($infoVal["id_estado_val"]==2){
							$estado="Incompleta";								
						}
						else if($infoVal["id_estado_val"]==3){
							$estado="No realizada";															
						}
						else if(empty($infoVal["id_estado_val"])){
							$estado="Estado no definido";								
						}
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>".$estado."</td>";
						$cuerpoTabla.="<td>".$infoVal["fecha_inicio_valteo"]."</td>";
						$cuerpoTabla.="<td>".$infoVal["observ_estvalto"]."</td></tr>";											
					}
					else{
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>Sin valoración</td>";
						$cuerpoTabla.="<td>-</td>";
						$cuerpoTabla.="<td>-</td></tr>";											
					}
				}				
			}
		break;
		case 7:
			$modeloConsultasGenerales->idCedula=$idCedula;
			$modeloConsultasGenerales->fechaInicio=$fechaIniRep;
			$modeloConsultasGenerales->fechaFinal=$fechaFinRep;
			$adolFuncionario=array();
			$adolFuncionario=$modeloConsultasGenerales->consultaAdolFuncionario();
			if(!empty($adolFuncionario)){
				$cuerpoTabla="";
				foreach($adolFuncionario as $adolFun){
					$estado="";					
					$modeloConsultasGenerales->numDocAdol=$adolFun["num_doc"];	
					$datosAdol=$modeloConsultasGenerales->consultaDatosAdolValoraciones();										
					$infoVal=$modeloConsultasGenerales->consultaValPsiqReporte();					
					if(!empty($infoVal)){
						if(empty($infoVal["fecha_ini_vpsiq"]) && empty($infoVal["id_estado_val"])){
							$estado="Sin valoración";						
						}
						else if($infoVal["id_estado_val"]==1){
							$estado="Completa";								
						}
						else if($infoVal["id_estado_val"]==2){
							$estado="Incompleta";								
						}
						else if($infoVal["id_estado_val"]==3){
							$estado="No realizada";															
						}
						else if(empty($infoVal["id_estado_val"])){
							$estado="Estado no definido";								
						}
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>".$estado."</td>";
						$cuerpoTabla.="<td>".$infoVal["fecha_ini_vpsiq"]."</td>";
						$cuerpoTabla.="<td>".$infoVal["observ_estvalpsiq"]."</td></tr>";											
					}
					else{
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>Sin valoración</td>";
						$cuerpoTabla.="<td>-</td>";
						$cuerpoTabla.="<td>-</td></tr>";											
					}
				}				
			}		
		break;
		case 9:
			$modeloConsultasGenerales->idCedula=$idCedula;
			$modeloConsultasGenerales->fechaInicio=$fechaIniRep;
			$modeloConsultasGenerales->fechaFinal=$fechaFinRep;
			$adolFuncionario=array();
			$adolFuncionario=$modeloConsultasGenerales->consultaAdolFuncionario();
			if(!empty($adolFuncionario)){
				$cuerpoTabla="";
				foreach($adolFuncionario as $adolFun){
					$estado="";					
					$modeloConsultasGenerales->numDocAdol=$adolFun["num_doc"];	
					$datosAdol=$modeloConsultasGenerales->consultaDatosAdolValoraciones();										
					$infoVal=$modeloConsultasGenerales->consultaValEnfReporte();					
					if(!empty($infoVal)){
						if(empty($infoVal["fecha_ini_venf"]) && empty($infoVal["id_estado_val"])){
							$estado="Sin valoración";						
						}
						else if($infoVal["id_estado_val"]==1){
							$estado="Completa";								
						}
						else if($infoVal["id_estado_val"]==2){
							$estado="Incompleta";								
						}
						else if($infoVal["id_estado_val"]==3){
							$estado="No realizada";															
						}
						else if(empty($infoVal["id_estado_val"])){
							$estado="Estado no definido";								
						}
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>".$estado."</td>";
						$cuerpoTabla.="<td>".$infoVal["fecha_ini_venf"]."</td>";
						$cuerpoTabla.="<td>".$infoVal["observ_estvalenf"]."</td></tr>";											
					}
					else{
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>Sin valoración</td>";
						$cuerpoTabla.="<td>-</td>";
						$cuerpoTabla.="<td>-</td></tr>";											
					}
				}				
			}		
		break;
		case 18:
			$modeloConsultasGenerales->idCedula=$idCedula;
			$modeloConsultasGenerales->fechaInicio=$fechaIniRep;
			$modeloConsultasGenerales->fechaFinal=$fechaFinRep;
			$adolFuncionario=array();
			$adolFuncionario=$modeloConsultasGenerales->consultaAdolFuncionario();
			if(!empty($adolFuncionario)){
				$cuerpoTabla="";
				foreach($adolFuncionario as $adolFun){
					$estado="";					
					$modeloConsultasGenerales->numDocAdol=$adolFun["num_doc"];	
					$datosAdol=$modeloConsultasGenerales->consultaDatosAdolValoraciones();										
					$infoVal=$modeloConsultasGenerales->consultaValNutrReporte();					
					if(!empty($infoVal)){
						if(empty($infoVal["fecha_ini_vnutr"]) && empty($infoVal["id_estado_val"])){
							$estado="Sin valoración";						
						}
						else if($infoVal["id_estado_val"]==1){
							$estado="Completa";								
						}
						else if($infoVal["id_estado_val"]==2){
							$estado="Incompleta";								
						}
						else if($infoVal["id_estado_val"]==3){
							$estado="No realizada";															
						}
						else if(empty($infoVal["id_estado_val"])){
							$estado="Estado no definido";								
						}
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>".$estado."</td>";
						$cuerpoTabla.="<td>".$infoVal["fecha_ini_vnutr"]."</td>";
						$cuerpoTabla.="<td>".$infoVal["observ_estvalnutr"]."</td></tr>";											
					}
					else{
						$cuerpoTabla.="<tr><td>".$datosAdol["nombres"]." ".$datosAdol["apellido_1"]." ".$datosAdol["apellido_2"]."</td>";
						$cuerpoTabla.="<td>".$datosAdol["num_doc"]."</td>";
						$cuerpoTabla.="<td>Sin valoración</td>";
						$cuerpoTabla.="<td>-</td>";
						$cuerpoTabla.="<td>-</td></tr>";											
					}
				}				
			}		
		break;
	}
?>


    <div class="panel-heading color-sdis">Histórico de valoraciones || Fecha inicio: <?php echo $fechaIniRep ?> - Fecha Fin:<?php echo $fechaFinRep?></div> 

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="ejemplo">
    <thead>
        <tr>
            <th>Nombre del adolescente</th>
            <th>Número de documento</th>
            <th>Estado de la valoración</th>
            <th>Fecha de inicio</th>
            <th>Observaciones</th>
        </tr>
    </thead>
 	<tbody>
    <?php echo $cuerpoTabla;?>
    </tbody>
</table>

<?php Yii::app()->getClientScript()->registerScript('tabla_script','
$(document).ready(function() {
 $("#ejemplo").dataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningun dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar: ",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "ultimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});
'
,CClientScript::POS_END);
?>

<?php endif;?>
</fieldset>


