<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'search-form',
	'action'=>Yii::app()->createUrl(\$this->route),
	'type'=>'horizontal',
	'method'=>'get',
)); ?>\n"; ?>

<?php 
echo "<div class=\"row-fluid\">\n";
$x=0;
foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<?php 
	if($x%4==0 && $x!=0)
	{
		echo "</div>\n";
		echo "<div class=\"row-fluid\">\n";
	}
	?>
	<?php echo "<div class=\"span3\">\n"; ?>
	<?php echo "<?php echo ".$this->generateActiveRow($this->modelClass,$column,12,true)."; ?>\n"; ?>
	<?php echo "</div>\n"; 
	$x++;
	?>

<?php endforeach; 
echo "</div>\n";
?>	
	<div class="row-fluid">
		<div class="span5 offset7">
		<?php echo "
			<?php \$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'label'=>Yii::t('app','See all'),'size'=>'small','icon'=>'refresh','url'=>'#','htmlOptions'=>array('id'=>'all'))); ?>
			<?php \$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'inverse', 'label'=>Yii::t('app','Print'),'size'=>'small','icon'=>'print white','url'=>'#','htmlOptions'=>array('id'=>'print','onclick'=>'window.print();','class'=>'hidden-tablet hidden-phone'))); ?>
			<?php \$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'info', 'label'=>Yii::t('app','Email'),'size'=>'small','icon'=>'envelope white','url'=>'#','htmlOptions'=>array('id'=>'email','class'=>'hidden-tablet hidden-phone'))); ?>
			<?php \$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'success', 'label'=>Yii::t('app','Excel'),'size'=>'small','icon'=>'th-large white','url'=>'#','htmlOptions'=>array('id'=>'excel','class'=>'hidden-tablet hidden-phone'))); ?>
			<?php \$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'link', 'type'=>'danger', 'label'=>Yii::t('app','Pdf'),'size'=>'small','icon'=>'arrow-down white','url'=>'#','htmlOptions'=>array('id'=>'pdf','class'=>'hidden-tablet hidden-phone'))); ?>
			<?php \$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>Yii::t('app','Search'),'size'=>'small','icon'=>'search white')); ?>\n"; ?>
		</div>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
<br style="clear:both">
<?php echo "<?php
//see all records
\$cs=Yii::app()->clientScript; 
\$cs->registerScript(\"all\",\"
		jQuery('#all').live('click',function(e) {
			e.preventDefault();
			   $('#search-form').each(function(){
			   		this.reset();
			   });
			$.fn.yiiGridView.update('".$this->class2id($this->modelClass)."-grid',{
				 type:'GET',
				 url:'\".Yii::app()->createUrl(\$this->route).\"',
				 data:[],
			});
		});
	\");
?>
<?php \$this->widget('bootstrap.widgets.admin.GAdminExcel',array('id'=>'excel','searchForm'=>'#search-form')); ?>
<?php \$this->widget('bootstrap.widgets.admin.GAdminPdf',array('id'=>'pdf','searchForm'=>'#search-form')); ?>
<?php \$this->widget('bootstrap.widgets.admin.GAdminEmail',array('id'=>'email','model'=>\$model)); ?>";?>