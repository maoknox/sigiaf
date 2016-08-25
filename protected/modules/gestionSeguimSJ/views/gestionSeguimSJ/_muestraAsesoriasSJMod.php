<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('gestionSeguimSJ/gestionSeguimSJ/modificarDatosContactoSJForm'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<div class="panel-heading color-sdis">Consulta gestión socio jurídica del adolescente</div><br />
<?php if(!empty($numDocAdol)): ?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')): ?>

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="ejemplo">
        <thead>
            <tr>
                <th>Motivo de la asesoría</th>
                <th>A donde remite</th>
                <th>Dependencia-Entidad</th>
                <th>Tipo de gestión</th>
                <th>Nombre del contacto</th>
                <th>Telefono del contacto</th>
                <th>Fecha de la gestión</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
    <?php
    foreach($consultaGestionesAdol as $pk=>$gestionAdolSJ):?>    
        <?php
			if(empty($gestionAdolSJ["tipo_gestionsj"])){$gestionAdolSJ["tipo_gestionsj"]="No aplica";}
			if(empty($gestionAdolSJ["dependencia_entidadsj"])){$gestionAdolSJ["dependencia_entidadsj"]="No aplica";}
			if(empty($gestionAdolSJ["nombre_contactosj"])){$gestionAdolSJ["nombre_contactosj"]="No aplica";}
			if(empty($gestionAdolSJ["telefono_contactosj"])){$gestionAdolSJ["telefono_contactosj"]="No aplica";}

		?>
        <tr class="odd gradeX">
            <td><?php echo $gestionAdolSJ["motivo_asesoriasj"];?></td>
            <td><?php echo $gestionAdolSJ["remision_sj"];?></td>
            <td><?php echo $gestionAdolSJ["dependencia_entidadsj"];?></td>
            <td><?php echo $gestionAdolSJ["tipo_gestionsj"];?></td>
            <td><?php echo $gestionAdolSJ["nombre_contactosj"];?></td>
            <td><?php echo $gestionAdolSJ["telefono_contactosj"];?></td>
            <td><?php echo $gestionAdolSJ["fecha_gestionsj"];?></td>    
            <td>
				<?php 
					echo CHtml::hiddenField('id_gestionsj',$gestionAdolSJ["id_gestionsj"]);
					echo CHtml::hiddenField('numDocAdol',$gestionAdolSJ["num_doc"]);
					echo CHtml::link('Realizar modificación','Realizar modificación',array('submit'=>array('gestionSeguimSJ/muestraFormModGSJ'),'params'=>array('id_gestionsj'=>$gestionAdolSJ["id_gestionsj"],'numDocAdol'=>$gestionAdolSJ["num_doc"]))); 
				?>					        
            </td>
         </tr>
    <?php
    endforeach;
    ?>     
         
        </tbody>
    </table>
    <?php Yii::app()->getClientScript()->registerScript('tabla_scriptConsGSJ','
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
   <?php else:?>
    <hr />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                Mensaje
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 text-center">
                    <!--<img src="<?php //echo Yii::app()->baseUrl?>/images/centroForjar.png" />-->
                </div>
                <div class="col-lg-9 text-justify">
                    <?php echo Yii::app()->user->getFlash('verifEstadoAdolForjar'); ?>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <?php endif;?> 
<?php endif; ?>
