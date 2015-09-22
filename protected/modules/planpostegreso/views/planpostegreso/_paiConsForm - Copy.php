<fieldset>
<legend>Concepto Integral</legend>
<?php 
	echo CHtml::encode($conceptoInt["concepto_integral"]);
?>
</fieldset>
<div id="formPaiCons">
<fieldset>
<legend>PAI-Componente Derecho</legend>
<div id="Mensaje" style="font-size:14px;" ></div>
<table style="width:100%">
	<tr>
    	<td>Componente/Situación</td>
        <td>Objetivo</td>
        <td>Actividades</td>
        <td>Indicador</td>
        <td>Responsable</td>
    </tr></table>  
<?php 
	foreach($derechos as $pk=>$derecho):
		$idPai=$modeloCompDer->id_pai;
		$modeloCompDer->unsetAttributes();
		$modeloCompDer->id_pai=$idPai;
		$modeloCompDer->id_derechocespa=$derecho["id_derechocespa"];
		$derechoAdolPai="";
		$derechoAdolPai=$modeloCompDer->consultaPaiDerechoAdol();
		$modeloCompDer->attributes=$derechoAdolPai;
		$modeloCompDer->fecha_estab_compderecho=$derechoAdolPai["fecha_estab_compderecho"];
		//print_r($modeloCompDer->attributes);
		?>
       
        <?php $formPaiCompDer=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioCompDer_'.$derecho["id_derechocespa"],
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
		));
		?><table>
        <tr>
       	<td><?php echo $derecho["derechocespa"];?><br /> <hr />
            <?php echo $formPaiCompDer->textArea($modeloCompDer,'derecho_compderecho');?>
        	<?php echo $formPaiCompDer->error($modeloCompDer,'derecho_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompDer->textArea($modeloCompDer,'objetivo_compderecho');?>
           	<?php echo $formPaiCompDer->error($modeloCompDer,'objetivo_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompDer->textArea($modeloCompDer,'actividades_compderecho');?>
           	<?php echo $formPaiCompDer->error($modeloCompDer,'actividades_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompDer->textArea($modeloCompDer,'indicadores_compderecho');?>
           	<?php echo $formPaiCompDer->error($modeloCompDer,'indicadores_compderecho',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompDer->textArea($modeloCompDer,'responsable_compderecho');?>
           	<?php echo $formPaiCompDer->error($modeloCompDer,'responsable_compderecho',array('style' => 'color:#F00'));?></td>
        </tr>
        </table><?php $this->endWidget(); ?>
        <?php endforeach; ?>
 
</fieldset>
<div id="Mensaje" style="font-size:14px;" ></div>

<fieldset>
<legend>PAI-Componente Sanción</legend>
<?php if(empty($infJudicial)):?>
	<p>Aún no se ha registrado la información judicial del adolescente</p>
<?php else:?>
<table style="width:100%">
	<tr>
    	<td>Componente/Situación</td>
        <td>Objetivo</td>
        <td>Actividades</td>
        <td>Indicador</td>
        <td>Responsable</td>
    </tr></table>  

	<?php foreach($infJudicial as $infJudicialPai):
		$modeloCompSanc->id_inf_judicial=$infJudicialPai["id_inf_judicial"];
		$modeloCompSanc->num_doc=$numDocAdol;
		$modeloCompSanc->creaCompSancion();
		$consCompSancPai=$modeloCompSanc->consultaPaiSancAdol();	
		$modeloCompSanc->attributes=$consCompSancPai;
		
		
		$modeloCompSanc->fecha_establec_compsanc=$consCompSancPai["fecha_establec_compsanc"];
		//print_r($consCompSancPai);
	?>
    <?php $formPaiCompSanc=$this->beginWidget('CActiveForm', array(
			'id'=>'formularioCompSancPai_'.$modeloCompSanc->id_inf_judicial,
			'enableAjaxValidation'=>false,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
		));
		?><table>
        <tr>
       	<td><?php
			$modeloInfJud->id_inf_judicial=$modeloCompSanc->id_inf_judicial;
			$delitos=$modeloInfJud->consultaDelito();  
			foreach($delitos as $delito){
				echo $delito["del_remcespa"]."<br/>";
			}
		?>
		</td>
        <td><?php echo $formPaiCompSanc->textArea($modeloCompSanc,'objetivo_compsanc');?>
           	<?php echo $formPaiCompSanc->error($modeloCompSanc,'objetivo_compsanc',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompSanc->textArea($modeloCompSanc,'actividades_compsanc');?>
           	<?php echo $formPaiCompSanc->error($modeloCompSanc,'actividades_compsanc',array('style' => 'color:#F00'));?></td>
        <td>
			<?php echo $formPaiCompSanc->textArea($modeloCompSanc,'indicador_compsanc');?>
           	<?php echo $formPaiCompSanc->error($modeloCompSanc,'indicador_compsanc',array('style' => 'color:#F00'));?></td>
        <td><?php echo $formPaiCompSanc->textArea($modeloCompSanc,'responsable_compsancion');?>
           	<?php echo $formPaiCompSanc->error($modeloCompSanc,'responsable_compsancion',array('style' => 'color:#F00'));?></td>
        </tr>
        </table><?php $this->endWidget(); ?>	
	<?php endforeach;?>
<?php endif;?>
</fieldset>
</div>
