<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'calendar-form',
	'enableAjaxValidation'=>false,
        'method'=>'post',
	'type'=>'inline',
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data'
	)
)); ?>
     	<fieldset>

	<?php  /*echo $form->errorSummary($model,'Opps!!!', null,array('class'=>'alert alert-error span12')); */?>

   <div class="control-group">
<!--			<div class="span4">-->
<?php $box = $this->beginWidget('bootstrap.widgets.TbBox',array(
    'title'=>'Create Schedule for PID = '.Yii::app()->controller->actionParams['id'],
    'headerIcon'=>'icon-user',
    'htmlOptions'=>array('class'=>'bootstrap-widget-table'),
));?>
<table class="table">
    <tbody>
    <tr>
        <td>Patient&nbsp;ID</td>
<!--        <td>-->
<!--            <div class="row">-->
<!--                --><?php //echo $form->labelEx($model,'Pid'); ?>
<!--                --><?php //echo $form->textField($model,'Pid'); ?>
<!--                --><?php //echo $form->error($model,'Pid'); ?>
<!--            </div>-->
<!---->
<!---->
<!--        </td>-->
    </tr>
    <tr>
        <td>Patient&nbsp;ID</td>
        <td><?php $session = Yii::app()->session;
                echo $form->textFieldRow($model,'Subject',array('class'=>'span5','maxlength'=>1000,'value'=>'PID '.$_GET['id'].' '.'['.$session['pFName'].' '.$session['pMName'].' '.$session['pLName'].']','readOnly'=>true)); ?></td>
    </tr>
    <tr>
        <td>Type</td>
        <td><?php echo $form->dropDownList($model,'Location',array(''=>'Select One','Annual'=>'Annual','Monthly'=>'Monthly','Weekly'=>'Weekly','New'=>'New'),array('class'=>'span5','maxlength'=>200)); ?></td>
    </tr>
    <tr>
        <td>Reason</td>
        <td><?php echo $form->textAreaRow($model,'Description',array('class'=>'span5','maxlength'=>255)); ?></td>
    </tr><tr>
        <td>Start&nbsp;Time</td>
        <td><?php $this->widget('application.extensions.timepicker.EJuiDateTimePicker',array(
                'model'=>$model,
                'attribute'=>'StartTime',
                'options'=>array(
                    'hourGrid' => 2,
                    'minuteGrid'=>15,
                    'dateFormat'=>'yy-mm-dd',
                    'timeFormat' => 'hh:mm:ss',
                    'changeYear' => false,
                    'showAnim'=>'drop',
                ),
                'htmlOptions'=>array('size'=>8,'maxlength'=>8,'placeholder'=>'Start Time' ),
            ));
            ?></td>
    </tr><tr>
        <td>End&nbsp;Time</td>
        <td><?php $this->widget('application.extensions.timepicker.EJuiDateTimePicker',array(
                'model'=>$model,
                'attribute'=>'EndTime',
                'options'=>array(
                    'controlType'=>'select',
                    'hourGrid' => 2,
                    'minuteGrid'=>15,
                    'dateFormat'=>'yy-mm-dd',
                    'timeFormat' => 'hh:mm:ss',
                    'changeYear' => false,
                    'showAnim'=>'drop',
                ),
                'htmlOptions'=>array('size'=>8,'maxlength'=>8,'placeholder'=>'End Time' ),
            ));
            ?></td>
    </tr><tr style="display: none;">
        <td>isalldayevent</td>
        <td><?php echo $form->textFieldRow($model,'IsAllDayEvent',array('class'=>'span5','value'=>0)); ?></td>
        <td>color</td>
        <td><?php echo $form->textFieldRow($model,'Color',array('class'=>'span5','maxlength'=>200)); ?></td>
        <td>recurringRule</td>
        <td><?php echo $form->textFieldRow($model,'RecurringRule',array('class'=>'span5','maxlength'=>500,'value'=>$_GET['id'])); ?></td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">
            <div class="pull-right">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'primary',
                    'icon'=>'ok white',
                    'label'=>$model->isNewRecord ? 'Create' : 'Save',
                )); ?>
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'reset',
                    'icon'=>'remove',
                    'label'=>'Reset',
                )); ?>
            </div>
        </td>
    </tr>
    </tfoot>
</table>
<?php $this->endWidget(); ?>
<!--            </div>-->
  </div>


</fieldset>

<?php $this->endWidget(); ?>

</div>
