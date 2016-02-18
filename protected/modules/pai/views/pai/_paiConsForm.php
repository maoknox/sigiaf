<?php if($modeloPAI->culminacion_pai==1):?>
<fieldset>
	Este PAI ya se culminó.  Si desea consultarlo genere el reporte de PAI.
</fieldset>
<?php else:?>
<fieldset>
<div class="panel-heading color-sdis">Concepto Integral</div> 
<?php 
	echo CHtml::encode($conceptoInt["concepto_integral"]);
?>
</fieldset>
<hr />
<div id="formPaiCons">
<fieldset>
<div class="panel-heading color-sdis">PAI-Componente Derecho</div> 
<div id="Mensaje" style="font-size:14px;" ></div>
    <div class="form-group">
    	<div class="col-sm-2">
        	Componente/Situación
		</div>
    	<div class="col-sm-3">
        	Objetivo
		</div>
    	<div class="col-sm-3">
        	Actividades
		</div>
    	<div class="col-sm-2">
        	Indicador
		</div>
    	<div class="col-sm-2">
        	Responsable
		</div>
</div>
<?php 
	foreach($derechos as $pk=>$derecho):
		$idPai=$modeloCompDer->id_pai;
		$modeloCompDer->unsetAttributes();
		$modeloCompDer->id_pai=$idPai;
		$modeloCompDer->num_doc=$modeloPAI->num_doc;
		$modeloCompDer->id_derechocespa=$derecho["id_derechocespa"];
		$derechoAdolPai="";
		$derechoAdolPai=$modeloCompDer->consultaPaiDerechoAdol();
		$modeloCompDer->attributes=$derechoAdolPai;
		$modeloCompDer->fecha_estab_compderecho=$derechoAdolPai["fecha_estab_compderecho"];
		//print_r($modeloCompDer->attributes);
		if(!empty($derechoAdolPai)){
			$action="modifDerPai";	
			$funcion='js:modificaRegPai("'.$derecho["id_derechocespa"].'","modificaRegPai","formularioCompDer_")';			
		}
		else{
			$action="creaDerPai";	
			$funcion='js:creaRegPai("'.$derecho["id_derechocespa"].'","creaDerPai","formularioCompDer_")';
		}
		?>
       
        <?php $formPaiCompDer=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioCompDer_'.$derecho["id_derechocespa"],
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
		?>    
        <div class="form-group">
            <div class="col-sm-2">
				<?php echo $derecho["derechocespa"];?>
                <div class='cont-infopai'><?php echo $modeloCompDer->derecho_compderecho;?></div>

                <?php //echo $formPaiCompDer->textArea($modeloCompDer,'derecho_compderecho',array('class'=>'form-control'));?>
                <?php echo $formPaiCompDer->error($modeloCompDer,'derecho_compderecho',array('style' => 'color:#F00'));?>
            </div>
            <div class="col-sm-3">
                <div class='cont-infopai'><?php echo $modeloCompDer->objetivo_compderecho;?></div>
				<?php //echo $formPaiCompDer->textArea($modeloCompDer,'objetivo_compderecho',array('class'=>'form-control'));?>
                <?php echo $formPaiCompDer->error($modeloCompDer,'objetivo_compderecho',array('style' => 'color:#F00'));?>
            </div>
            <div class="col-sm-3">
                <div class='cont-infopai'><?php echo $modeloCompDer->actividades_compderecho;?></div>
				<?php //echo $formPaiCompDer->textArea($modeloCompDer,'actividades_compderecho',array('class'=>'form-control'));?>
				<?php echo $formPaiCompDer->error($modeloCompDer,'actividades_compderecho',array('style' => 'color:#F00'));?>
            </div>
            <div class="col-sm-2">
                <div class='cont-infopai'><?php echo $modeloCompDer->indicadores_compderecho;?></div>
				<?php //echo $formPaiCompDer->textArea($modeloCompDer,'indicadores_compderecho',array('class'=>'form-control'));?>
                <?php echo $formPaiCompDer->error($modeloCompDer,'indicadores_compderecho',array('style' => 'color:#F00'));?>
            </div>
            <div class="col-sm-2">
                <div class='cont-infopai'><?php echo $modeloCompDer->responsable_compderecho;?></div>
				<?php //echo $formPaiCompDer->textArea($modeloCompDer,'responsable_compderecho',array('class'=>'form-control'));?>
                <?php echo $formPaiCompDer->error($modeloCompDer,'responsable_compderecho',array('style' => 'color:#F00'));?>
            </div>
        </div>
		<?php $this->endWidget(); ?>
        <hr />
        <?php endforeach; ?>
</fieldset>
<div id="Mensaje" style="font-size:14px;" ></div>

<fieldset>
<div class="panel-heading color-sdis">PAI-Componente Sanción</div> 
<?php if(empty($infJudicial)):?>
	<p>Aún no se ha registrado la información judicial del adolescente</p>
<?php else:?>
    <div id="Mensaje" style="font-size:14px;" ></div>
        <div class="form-group">
            <div class="col-sm-2">
                Componente/Sanción
            </div>
            <div class="col-sm-3">
                Objetivo
            </div>
            <div class="col-sm-3">
                Actividades
            </div>
            <div class="col-sm-2">
                Indicador
            </div>
            <div class="col-sm-2">
                Responsable
            </div>
    </div>
	<?php foreach($infJudicial as $infJudicialPai):
		$modeloCompSanc->id_inf_judicial=$infJudicialPai["id_inf_judicial"];
		$modeloCompSanc->num_doc=$numDocAdol;
		$modeloCompSanc->creaCompSancion();
		$consCompSancPai=$modeloCompSanc->consultaPaiSancAdol();	
		$modeloCompSanc->attributes=$consCompSancPai;
		
		
		$modeloCompSanc->fecha_establec_compsanc=$consCompSancPai["fecha_establec_compsanc"];
		//print_r($consCompSancPai);
		if(!empty($consCompSancPai)){
			$action="modifSancPai";			
			$funcion='js:modificaRegPaiSanc("'.$modeloCompSanc->id_inf_judicial.'","modificaRegPaiSanc","formularioCompSancPai_")';			
				
		}
		else{
			$action="creaSancPai";	
			$funcion='js:creaRegPaiSanc("'.$modeloCompSanc->id_inf_judicial.'","creaRegPaiSanc","formularioCompSancPai_")';			
		}
	?>
    <?php $formPaiCompSanc=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioCompSancPai_'.$modeloCompSanc->id_inf_judicial,
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array('class' => 'form-horizontal')
		));
		?>
		<div class="form-group">
            <div class="col-sm-2">
            	<div class='cont-infopai'>
				<?php
                    $modeloInfJud->id_inf_judicial=$modeloCompSanc->id_inf_judicial;
                    $delitos=$modeloInfJud->consultaDelito();  
					$consSancion=$modeloInfJud->consultaSancion(); 	
                   // foreach($delitos as $delito):?>
               		<?php
						
						echo $consSancion["tipo_sancion"];
						//echo $delito["del_remcespa"];
					?>
                       
                    
                <?php //endforeach;?>
                </div>
          </div>
            <div class="col-sm-3">
                <div class='cont-infopai'><?php echo $modeloCompSanc->objetivo_compsanc;?></div>
				<?php //	echo $formPaiCompSanc->textArea($modeloCompSanc,'objetivo_compsanc',array('class'=>'form-control'));?>
           		<?php echo $formPaiCompSanc->error($modeloCompSanc,'objetivo_compsanc',array('style' => 'color:#F00'));?>
          </div>
            <div class="col-sm-3">
                <div class='cont-infopai'><?php echo $modeloCompSanc->actividades_compsanc;?></div>
				<?php //echo $formPaiCompSanc->textArea($modeloCompSanc,'actividades_compsanc',array('class'=>'form-control'));?>
           		<?php echo $formPaiCompSanc->error($modeloCompSanc,'actividades_compsanc',array('style' => 'color:#F00'));?>
            </div>
            <div class="col-sm-2">
                <div class='cont-infopai'><?php echo $modeloCompSanc->indicador_compsanc;?></div>
				<?php //echo $formPaiCompSanc->textArea($modeloCompSanc,'indicador_compsanc',array('class'=>'form-control'));?>
           		<?php echo $formPaiCompSanc->error($modeloCompSanc,'indicador_compsanc',array('style' => 'color:#F00'));?>
          </div>
            <div class="col-sm-2">
                <div class='cont-infopai'><?php echo $modeloCompSanc->responsable_compsancion;?></div>
				<?php //echo $formPaiCompSanc->textArea($modeloCompSanc,'responsable_compsancion',array('class'=>'form-control'));?>
                <?php echo $formPaiCompSanc->error($modeloCompSanc,'responsable_compsancion',array('style' => 'color:#F00'));?>
          </div>
          </div>
       <?php $this->endWidget(); ?>	
               <hr />

	<?php endforeach;?>
<?php endif;?>
</fieldset>
</div>
<?php
Yii::app()->getClientScript()->registerScript('scripPaiCons_1','
	$("#formPaiCons").find(":input").attr("disabled","true");
'
,CClientScript::POS_END);
?>
<?php endif;?>