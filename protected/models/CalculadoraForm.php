<?php
class CalculadoraForm extends CFormModel{  
	public $operando1;  
    public $operando2;  
    public $operador; 
	public function attributeLabels()  
    {  
        return array(  
            'operando1' => 'A',  
            'operando2' => 'B'  
        );  
    }  
	public function rules()  
    {  
        return array(  
            array('operando1', 'required'),  
            array('operando1', 'type', 'type' => 'float'),  
            array('operando2', 'required'),  
            array('operando2', 'type', 'type' => 'float'),  
            array('operador',  'in', 'range' => array('+', '-', '*', '/')),  
            array('operando2', 'validarDivCero')  
        );  
    }  
    public function validarDivCero($attribute, $params)  
    {  
        if($this -> operador == '/' && $this -> operando2 == 0)  
            $this -> addError('operando2', 'El denominador de una división no puede ser cero.');  
    } 
	public function safeAttributes()  
    {  
        return array(  
            'operando1, operando2, operador'  
        );  
    }  
	public function operador()  
    {  
        $r = 0;  
        switch ($this -> operador)  
        {  
            case '+': $r = $this -> operando1 + $this -> operando2;  
                      break;  
            case '-': $r = $this -> operando1 - $this -> operando2;  
                      break;  
            case '/': $r = $this -> operando1 / $this -> operando2;  
                      break;  
            case '*': $r = $this -> operando1 * $this -> operando2;  
                      break;  
        }  
        return $r;  
    } 
	public function toString()  
    {  
        if($this -> operando1 === null || $this -> operando2 === null)  
            return "Operación indefinida!";  
        return "{$this -> operando1} {$this -> operador} {$this -> operando2}";  
    }    
}  
?>