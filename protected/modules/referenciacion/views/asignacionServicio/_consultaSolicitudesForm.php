<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="ejemplo">
    <thead>
        <tr>
            <th>Nombre del adolescente</th>
            <th>Línea de acción</th>
            <th>Especificación I</th>
            <th>Especificación II</th>
            <th>Especificación III</th>
            <th>Fecha de la referenciación</th>
            <th></th>
        </tr>
    </thead>
 	<tbody>
<?php
foreach($consultaSol as $pk=>$solicitud):?>    
    
    <tr class="odd gradeX">
        <td><?php echo $solicitud["nombres"]." ".$solicitud["apellido_1"]." ".$solicitud["apellido_2"];?></td>
        <td><?php echo $solicitud["tipo_referenciacion"];?></td>
        <td><?php echo $solicitud["esp_sol"];?></td>
        <td><?php echo $solicitud["esp_solii"];?></td>
        <td><?php echo $solicitud["esp_soliii"];?></td>
        <td><?php echo $solicitud["fecha_referenciacion"];?></td>
        <td>
		<?php 
			echo CHtml::hiddenField('id_referenciacion',$solicitud["id_referenciacion"]);
			echo CHtml::hiddenField('numDocAdol',$solicitud["num_doc"]);
        	echo CHtml::link('Ir a referenciación','ir a referenciación',array('submit'=>array('asignacionServicio/servicioModForm'),'params'=>array('id_referenciacion'=>$solicitud["id_referenciacion"],'numDocAdol'=>$solicitud["num_doc"]))); ?>					        
       	</td>
     </tr>
<?php
endforeach;
?>     
     
    </tbody>
</table>
<?php Yii::app()->getClientScript()->registerScript('tabla_script','
function solRefer(idForm){
	//jAlert("blaa","Mensaje");
	$("#formularioConsSolServ_"+idForm ).submit();
}
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
