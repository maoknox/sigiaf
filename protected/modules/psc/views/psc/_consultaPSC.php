<?php $this->widget('application.extensions.loading.LoadingWidget');?>
<?php
$this->widget('application.extensions.jqAjaxSearch.AjaxSearch', 
    array('action'=>Yii::app()->createUrl('modIdenReg/identificacionRegistro/buscaAdolGen'), 
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
<?php if(!empty($numDocAdol)):
	$modeloPsc->num_doc=$numDocAdol;
?>
	<?php if(!Yii::app()->user->hasFlash('verifEstadoAdolForjar')):?>
        <table cellpadding="0" cellspacing="0" border="0px" style="width:100%">
            <tr>
                <td style="border:1px solid #000">
                    Sector
                </td>
                <td style="border:1px solid #000">
                    Organización
                </td>
                <td style="border:1px solid #000">
                    Estado
                </td>
                  <td style="border:1px solid #000">
                    Fecha Inicio
                </td>
                <td></td>
            </tr>
        <?php 
        //echo $offset//echo $datosRef["id_referenciacion"]
            //echo count($infJudicial);
            foreach($pscDes as $pk=>$psc):
        ?>
        <?php 	
            $formPsc=$this->beginWidget('CActiveForm', array(
            'id'=>'formularioConsPsc_'.$pk,
            'action'=>'actEstadoPscForm',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,
            ),
        ));
        ?>
        <tr>
            <td style="border:1px solid #000">
               <?php echo $psc["sector_psc"];?>
            </td>
            <td style="border:1px solid #000">
                <?php echo $psc["institucionpsc"];?>
            </td>
            <td style="border:1px solid #000">
             <?php echo $psc["fecha_inicio_psc"];?>
            </td>
            <td style="border:1px solid #000">
            
                <?php 
                    //echo CHtml::hiddenField('id_referenciacion',$datosRef["id_referenciacion"]);
                    $modeloPsc->id_psc=$psc["id_psc"];
                    echo $formPsc->hiddenField($modeloPsc,"num_doc");
                    echo $formPsc->hiddenField($modeloPsc,"id_psc");
                    $boton=CHtml::button(
                            'Ir al registro',
                            array('onclick'=>'js:renderizarPscForm("'.$pk.'")')
                        ); 
                    echo $boton;
                    ?>
            </td>
           </tr>
         <?php $this->endWidget();?>
         
        <?php
            endforeach;
        ?>
        </table>
        <?php if($offset==0): $superior=$offset+5;?>
        <label>Mostrando del registro 1 al registro <?php echo  $superior;?></label>
        
        <?php echo CHtml::link('Siguiente','Siguiente',array('submit'=>array('psc/consultarPsc'),'params'=>array('offset'=>$superior))); ?>
        <?php else: $superior=$offset+5; $inferior=$offset-5?>
        <?php echo CHtml::link('Anterior','Siguiente',array('submit'=>array('psc/consultarPsc'),'params'=>array('offset'=>$inferior))); ?>
        <label>Mostrando del registro <?php echo  $offset+1;?> al registro <?php echo  $superior;?></label>
        <?php echo CHtml::link('Siguiente','Siguiente',array('submit'=>array('psc/consultarPsc'),'params'=>array('offset'=>$superior))); ?>
        <?php endif;?>
        <?php Yii::app()->getClientScript()->registerScript('script_modifestado','
            function renderizarPscForm(idForm){
                //alert("blaa");
                $( "#formularioConsPsc_"+idForm ).submit();
            }
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
                        <img src="/login_sdis/public/img/logo.svg" />
                    </div>
                    <div class="col-lg-9 text-justify">
                        <?php echo Yii::app()->user->getFlash('verifEstadoAdolForjar'); ?>
                    </div>
                </div>
            </div>
        </div>
        <hr />
	<?php endif;?>	
<?php endif;?>
