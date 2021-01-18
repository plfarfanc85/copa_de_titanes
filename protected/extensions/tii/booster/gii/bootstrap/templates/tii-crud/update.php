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
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	Yii::t('app','Update'),
);\n";
?>
$this->header="<?php echo $label;?> #{$model-><?php echo $this->tableSchema->primaryKey;?>} <small>".Yii::t('app','Update')."</small>";
$this->menu=array(
	array('label'=>Yii::t('app','Create'),'url'=>array('create'),'icon'=>'file'),
	array('label'=>Yii::t('app','View'),'url'=>array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey;?>),'icon'=>'eye-open'),
	array('label'=>Yii::t('app','List'),'url'=>array('index'),'icon'=>'align-justify'),
	array('label'=>Yii::t('app','Manage'),'url'=>array('admin'),'icon'=>'list'),
);
?>
<?php echo "<?php echo \$this->renderPartial('_form',array('model'=>\$model)); ?>"; ?>