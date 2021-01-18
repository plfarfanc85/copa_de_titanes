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
	\"$label\",
);\n";
?>
$this->header="<?php echo $label;?> <small>".Yii::t('app','List')."</small>";
$this->menu=array(
	array('label'=>Yii::t('app','Create'),'url'=>array('create'),'icon'=>'file'),
	array('label'=>Yii::t('app','Manage'),'url'=>array('admin'),'icon'=>'list'),
);
?>
<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'itemsCssClass'=>'nav nav-tabs nav-stacked',
	'itemsTagName'=>'ul',
	'template'=>"{summary}\n{items}\n{pager}",
)); ?>
