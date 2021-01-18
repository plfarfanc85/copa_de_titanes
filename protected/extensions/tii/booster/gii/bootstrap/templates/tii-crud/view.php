<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->class2name($this->modelClass);
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>
$this->header="<?php echo $label;?> #{$model-><?php echo $this->tableSchema->primaryKey; ?>} <small>".Yii::t('app','View')."</small>";
$this->menu=array(
	array('label'=>Yii::t('app','Create'),'url'=>array('create'),'icon'=>'file'),
	array('label'=>Yii::t('app','Update'),'url'=>array('update','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'icon'=>'pencil'),
	array('label'=>Yii::t('app','Delete'),'url'=>"#",'icon'=>'trash','linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>Yii::t('app','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('app','List'),'url'=>array('index'),'icon'=>'align-justify'),
	array('label'=>Yii::t('app','Manage'),'url'=>array('admin'),'icon'=>'list'),
);
?>
<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbEditableDetailView',array(
	'data'=>$model,
	'url' => $this->createUrl('editable'),
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); 
/**
	how to use, here http://ybe.demopage.ru/#EditableDetailView
*/
?>
