<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<li>
	<a href="<?php echo "<?php echo \$this->createUrl('view',array('id'=>\$data->{$this->tableSchema->primaryKey}));?>\">";?>
<?php
echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";
echo "\t<?php echo CHtml::encode(\$data->{$this->tableSchema->primaryKey}); ?>\n\t<br />\n\n";
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if($column->isPrimaryKey)
		continue;
	if(++$count==7)
		echo "\t<?php /*\n";
	echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";
	echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
}
if($count>=7)
	echo "\t*/ ?>\n";
?>

	</a>
</li>