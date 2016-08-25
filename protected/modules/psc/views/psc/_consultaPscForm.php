<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('valoracionIntegral/valoracionIntegral/buscaAdolGen'), 
		'target'=>'resultado', 
		'minChar'=>2,
		'numDocAdol'=>$numDocAdol,
		'url'=>Yii::app()->createUrl('psc/psc/consultarPsc'),
		'datosAdol'=>$datosAdol,
		'edad'=>$edad,
		'telefonoAdol'=>$telefonoAdol
	)
);
?>
<?php if(!empty($numDocAdol)&&!empty($modeloPsc->id_psc)):?>
		<?php $formularioPsc=$this->beginWidget('CActiveForm', array(
            'id'=>'formularioPsc',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,
            ),
            'htmlOptions' => array('class' => 'form-horizontal')
        ));
        ?>	
        <div id="MensajePsc" style="font-size:14px;"></div>
        <br />
        <?php echo  $formularioPsc->errorSummary($modeloPsc,'','',array('style' => 'font-size:14px;color:#F00')); ?>
            <div class="form-group">
                <?php echo $formularioPsc->labelEx($modeloPsc,'id_sector_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
                <div class="col-md-4">		
                      <?php echo $infPsc["sector_psc"];?>        
                </div>
           </div>   
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'id_institucionpsc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $infPsc["institucionpsc"];?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'responsable_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                        <?php echo $modeloPsc->responsable_psc; ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'telefono_resp',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $modeloPsc->telefono_resp; ?></br>
            </div>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('Horario de prestación','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <hr />
                <table border="1px" cellpadding="0" cellspacing="0" id="tabHorarioPres" style=" width:80%">
                    <tr><td>Día</td><td>Hora inicio</td><td>Hora fin</td></tr>
                    <?php 
                        $modeloDiaHora->id_psc=$modeloPsc->id_psc;
                        $modeloDiaHora->num_doc=$modeloPsc->num_doc;
                        $horario=$modeloDiaHora->consultaHorario();
                        if(!empty($horario)){
                            foreach($horario as $horario)://revisar?>
                                <tr>
                                    <td><?php echo $horario["nomb_dia"]?></td>
                                    <td><?php echo $horario["hora_inicio"]."-".$horario["hora_inicio_m"];?></td>
                                    <td><?php echo $horario["hora_fin"]."-".$horario["hora_fin_m"];?></td>
                                </tr>
                            <?php endforeach;
                            
                        }
                    ?>
                </table>
            </div>
        </div>
        <div class="form-group">
            <?php echo CHtml::label('Tiempo de la prestación del servicio','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
              <hr />
            </div>
        </div>		
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'fecha_inicio_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $modeloPsc->fecha_inicio_psc; ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'fecha_fin_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $modeloPsc->fecha_fin_psc; ?>
            </div>
        </div>		
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'id_estadopsc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">
                <?php                     
					foreach($estadoPsc as $estado){
						if($estado["id_estadopsc"]==$infPsc["idestado"]){
							echo $estado["estado_psc"];
						}
					}
                    ?>
            </div>
        </div>		
        <div class="form-group">
            <?php echo $formularioPsc->labelEx($modeloPsc,'observaciones_psc',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $modeloPsc->observaciones_psc;?>
            </div>
        </div> 
        <div class="form-group">
            <?php echo CHtml::label('','',array('class'=>'col-md-4 control-label','for'=>'searchinput'));?>
            <div class="col-md-4">		
                <?php echo $formularioPsc->hiddenField($modeloPsc,'num_doc');?>
                <?php echo $formularioPsc->hiddenField($modeloPsc,'id_psc');?>
              
            </div>
        </div>		
                <?php $this->endWidget();?>
                        
<?php endif?>   
        
        