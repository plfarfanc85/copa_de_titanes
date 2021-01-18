<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

<p class="help-block"><?php echo "<?php echo Yii::t('app','Fields with');?>"; ?> <span class="required">*</span> <?php echo "<?php echo Yii::t('app','are required.');?>"; ?></p>
<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>
<?php echo "<?php \$this->widget('bootstrap.widgets.TbTabs', array(
    'tabs'=>array(
	    	array(
	            'active'=>true,
	            'label'=>Yii::t('app','General'),
	            'content'=>";?>
<?php
$x=0;
$ai=0;
$cant=count($this->tableSchema->columns);
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement || substr($column->name, strpos($column->name, "_at"),strlen($column->name))==="_at")
	{
		$ai++;
		continue;
	}
?>
			<?php echo ($x+$ai)==($cant-1)?$this->generateActiveRow($this->modelClass,$column)."\n":$this->generateActiveRow($this->modelClass,$column).".\n"; ?>
<?php
$x++;
}
?>
<?php echo "      ),
        ),
)); ?>";?>
	<div class="form-actions">
		<?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>\$model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),
		)); ?>\n"; ?>
		<?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link','url'=>array(\"admin\"), 'label'=>Yii::t('app','Cancel'))); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>