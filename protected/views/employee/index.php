<?php
$this->breadcrumbs=array(
	'Employees',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
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

<?php 
$this->menu=array(
		array('label'=>'Add Employee', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create'), 'linkOptions'=>array()),
        array('label'=>'List Employee', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
    array('label'=>'List Authorised Users', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('/User/index'),'linkOptions'=>array()),
    array('label'=>'Manage Roles', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('/rights/assignment'),'linkOptions'=>array()),
    array('label'=>'Change Password', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('/User/index'),'linkOptions'=>array()),

    /*array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
    array('label'=>'Export to PDF', 'icon'=>'icon-download', 'url'=>Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
    array('label'=>'Export to Excel', 'icon'=>'icon-download', 'url'=>Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),*/
	);
?>



<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true,
        'fade' => true,
        'closeText' => '&times;', // false equals no close link
        'events' => array(),
        'htmlOptions' => array(),
        'userComponentId' => 'user',
        'alerts' => array( // configurations per alert type
// success, info, warning, error or danger
            'success' => array('closeText' => '&times;'),
            'info', // you don't need to specify full config
            'warning' => array('block' => false, 'closeText' => false),
            //'error' => array('block' => false, 'closeText' => 'AAARGHH!!')
        ),
    ));
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'employee-grid',
	'dataProvider'=>$model->search(),
        'type'=>'striped bordered condensed',
        'template'=>'{summary}{items}{pager}',
	'columns'=>array(
		'id',
        array(
            'header'=>'<a>Name</a>',
            'value'=>'$data->fName." ".$data->mName." ".$data->lName',
            'type'=>'raw',
        ),
//		'title',
//		'fName',
//		'mName',
//		'lName',
        'homePhone',
        'mobilePhone',
        'email',
//		'gender',
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
		'stat',
		*/
       array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
           'header'=>'<a>Actions</a>',
			'template' => '{view} {update} {assign}',
			'buttons' => array(
			      'view' => array(
					'label'=> 'View',
					'options'=>array(
						'class'=>'btn btn-small view'
					)
				),	
                              'update' => array(
					'label'=> 'Update',
					'options'=>array(
						'class'=>'btn btn-small update'
					)
				),
				/*'delete' => array(
					'label'=> 'Delete',
					'options'=>array(
						'class'=>'btn btn-small delete'
					)
				),*/
                'assign'=>array(
                    'label'=>'Assign Role',
                    'url'=>'Yii::app()->controller->createUrl("User/create",array("eid"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small'
                    ),
                ),

			),
            'htmlOptions'=>array('nowrap'=>'nowrap'),
           )
	),
)); ?>

