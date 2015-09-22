    <h2>Calculadora Simple</h2>  
    <br />  
    <div>  
        <?= CHtml::form(CHtml::normalizeUrl(array('calculadora/operador'))); ?>
        <?= CHtml::errorSummary($calc); ?>
		<?= CHtml::activeLabel($calc, 'operando1'); ?>  
        <?= CHtml::activeTextField($calc, 'operando1'); ?>  
        <?= CHtml::activeDropDownList($calc, 'operador', array('+' => '+','-' => '-','*' => '*','/' => '/')); ?>  
        <?= CHtml::activeLabel($calc, 'operando2'); ?>  
        <?= CHtml::activeTextField($calc, 'operando2'); ?>  
        <?= CHtml::submitButton('='); ?>  
		
        </form> 
        <span style='font-size: 20px'>  
        	<?= (isset($resultado)) ? $resultado : ""; ?>  
    	</span>  
        <span style='font-weight: bolder;'>Operación: </span>  
   	 	<?= $calc -> toString(); ?> =
   	 	<?= (isset($resultado)) ? $resultado : ""; ?> 
    </div>
       
    