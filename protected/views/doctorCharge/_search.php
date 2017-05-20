<?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'search-doctor-charge-form',
    'type'=>'inline',
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
));  ?>


<?php echo $form->textFieldRow($model,'dcid',array('class'=>'span2')); ?>

<?php echo $form->textFieldRow($model,'eid',array('class'=>'span2')); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'search white', 'label'=>'Search')); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset'))); ?>

<?php $this->endWidget(); ?>


<?php $cs = Yii::app()->getClientScript();
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    $cs->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap/jquery-ui.css');
?>
<script>
    $(".btnreset").click(function(){
        $(":input","#search-doctor-charge-form").each(function() {
            var type = this.type;
            var tag = this.tagName.toLowerCase(); // normalize case
            if (type == "text" || type == "password" || tag == "textarea") this.value = "";
            else if (type == "checkbox" || type == "radio") this.checked = false;
            else if (tag == "select") this.selectedIndex = "";
        });
    });
</script>

