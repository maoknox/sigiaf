<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<hr />
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
           	Error <?php echo $code; ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-3 text-center">
                <img src="/login_sdis/public/img/logo.svg" />
            </div>
            <div class="col-lg-9 text-justify">
                <?php echo CHtml::encode($message); ?>
            </div>
        </div>
    </div>
</div>
<hr />