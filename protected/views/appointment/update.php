<?php
$this->breadcrumbs=array(
	'Appointments'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>Update Appointment <?php echo $model->id; ?></h1>
<hr/>

<?php 
$this->menu=array(
		array('label'=>'Create', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create'), 'linkOptions'=>array()),
                array('label'=>'List', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'), 'linkOptions'=>array()),
                array('label'=>'Update', 'icon'=>'icon-edit', 'url'=>Yii::app()->controller->createUrl('update',array('id'=>$model->id)),'active'=>true, 'linkOptions'=>array()),
	);
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>