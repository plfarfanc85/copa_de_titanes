<!--Send for mail-->
<?php $this->controller->beginWidget('bootstrap.widgets.TbModal', array('id'=>'sendMail','htmlOptions'=>array("style"=>"display: none"))); ?>
<div class="modal-header hidden-tablet hidden-phone">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Send for mail</h4>
</div>
<div class="modal-body hidden-tablet hidden-phone">
    <?php /** @var BootActiveForm $form */
    $form = $this->controller->beginWidget('bootstrap.widgets.TbActiveForm', array(
	    'id'=>'email-form',
        'action'=>$this->formAction,
        'type'=>'vertical',
        'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
	 <?php echo $form->errorSummary($sendForm); ?>
	<fieldset>
		<p>Fields with <span class="required">*</span> are required.</p>
	    <?php echo $form->textFieldRow($sendForm, 'email');?>
	    <?php echo $form->textFieldRow($sendForm,'subject',array('size'=>60,'maxlength'=>128)); ?>
	    <?php echo $form->textAreaRow($sendForm, 'body',array('rows'=>4)); ?>
	</fieldset>
	<?php $this->controller->endWidget(); ?>
</div>
<div class="modal-footer hidden-tablet hidden-phone">
    <?php $this->controller->widget('bootstrap.widgets.TbButton', array(
        'url'=>'#',
        'type'=>'primary',
        'label'=>'Send mail',
        'htmlOptions'=>array('id'=>'emailGo'),
    )); ?>
    <?php $this->controller->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
<?php $this->controller->endWidget(); ?>