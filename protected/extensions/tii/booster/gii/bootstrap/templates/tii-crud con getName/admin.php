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
	Yii::t('app','Manage'),
);\n";
?>
$this->header="<?php echo $label;?> <small>".Yii::t('app','Manage')."</small>";
$this->menu=array(
	array('label'=>Yii::t('app','Search'),'url'=>'#','icon'=>'search','itemOptions'=>array('class'=>'search-button')),
	array('label'=>Yii::t('app','List'),'url'=>array('index'),'icon'=>'align-justify'),
	array('label'=>Yii::t('app','Create'),'url'=>array('create'),'icon'=>'file'),
	array('label'=>Yii::t('app','Delete'),'url'=>"#",'icon'=>'trash','itemOptions'=>array('id'=>'delete')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle();
	return false;
});
$('#search-form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->
<?php echo "<?php ";?>

	$cs=Yii::app()->clientScript;
	$cs->registerCoreScript('jquery');
	$cs->registerScript("delete", "
		jQuery('#delete a').live('click',function(e) {
			e.preventDefault();
			if((registers=$(\"input[name='<?php echo $this->class2id($this->modelClass); ?>-id\[\]']:checked\").length)==0) {
				alert('".Yii::t('app','You must select a record')."');
				return false;
			}
			if(!confirm('".Yii::t('app','Are you sure you want to delete the record selected?')."'))
				return false;
			$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
				type:'POST',
				url:'".$this->createUrl("delete")."',
				data:$('#delete-form').serialize(),
				success:function() {
					$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid');
				}
			});
		});
	");	
echo CHtml::beginForm('','post',array('id'=>"delete-form"));
$this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'type'=>'striped condensed hover',
    'selectableRows'=>2, // multiple rows can be selected
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'class'=>'CCheckBoxColumn',
            'id'=>'<?php echo $this->class2id($this->modelClass); ?>-id',
        ),

<?php
$count=0;
$dbType=array();
foreach($this->tableSchema->columns as $column)
{
	if(++$count>=4 && $count<7)
	{
		echo "
		array( // if hidden phone and tablet
			'name'=>'{$column->name}',
			'filterHtmlOptions'=>array('class'=>'hidden-phone'),
			'headerHtmlOptions'=>array('class'=>'hidden-phone'),
			'htmlOptions'=>array('class'=>'hidden-phone'),
		),\n";
		if(preg_match('/(int)/',$column->dbType) && $this->tableSchema->primaryKey!=$column->name)
			$dbType[$column->name]=ucfirst(strtr($column->name,array("_"=>" ")));
	}
	else 
	{
		if($count==7)
			echo "\t\t/*\n";
		if($count==2 || $count==3)
		{
			?>	
		array(
			'class' => 'bootstrap.widgets.TbEditableColumn', // http://ybe.demopage.ru/#EditableColumn
			'name' => '<?php echo $column->name;?>', // http://yii-booster.clevertech.biz/extended-grid.html#gridcolumns
			'editable' => array( // http://yii-booster.clevertech.biz/components.html#editable
				'url' => $this->createUrl('editable'),
			)
		),
		<?php
		}else	
			echo "\t\t'".$column->name."',\n";
	}
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 50px'),
		),
	),
	<?php if($dbType!==array()) { ?>
		<?php #echo $column->dbType;?>
	'chartOptions' => array(
        'data' => array(
            'series' => array(
	<?php 
	foreach($dbType as $index => $value){ 
	?>
				array(
					'name' => '<?php echo $value; ?>',
					'attribute' => '<?php echo $index;?>'
				),
	<?php 
	} ?>
			 )
        ),
        'config' => array(
            'chart'=>array(
                'width'=>400
            )
        )
    ),
	<?php } ?>
)); 
echo CHtml::endForm();
?>
