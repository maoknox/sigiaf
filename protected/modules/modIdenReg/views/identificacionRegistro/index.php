<?php
$tablist=array("Red","Green","Blue");
foreach($tablist as $tabs){
    $css='';
        if($tabs=='Red'){$css='color:red;';}
        else if($tabs=='Green'){$css='color:green;';}
        else if($tabs=='Blue'){$css='color:blue';}  
        $tabarray["<span id='tab-$tabs' style='$css'>$tabs</span>"]="$tabs Color";
}
?>
<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>$tabarray,
    // additional javascript options for the accordion plugin
    'options' => array(
        'collapsible' => true,        
    ),
    'id'=>'MyTab-Menu1'
));
?>