<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label='{$this->name}';
echo "\$this->breadcrumbs=array(
	\"$label\"=>array('index'),
	Yii::t('app','Create'),
);\n";
?>
$this->header="<?php echo $label;?> <small>".Yii::t('app','Create')."</small>";
$this->menu=array(
	array('label'=>Yii::t('app','List'),'url'=>array('index'),'icon'=>'align-justify'),
	array('label'=>Yii::t('app','Manage'),'url'=>array('admin'),'icon'=>'list'),
);
?>
<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>