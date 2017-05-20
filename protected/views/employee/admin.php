<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Employee','url'=>array('index')),
	array('label'=>'Create Employee','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employee-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Employees</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'employee-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'fName',
		'mName',
		'lName',
		'gender',
		/*
		'dob',
		'sStreet',
		'sWardNo',
		'sCity',
		'sDistrict',
		'sZone',
		'pStreet',
		'pWardNo',
		'pCity',
		'pDistrict',
		'pZone',
		'Country',
		'eContact',
		'ePhone',
		'homePhone',
		'mobilePhone',
		'email',
		'stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
