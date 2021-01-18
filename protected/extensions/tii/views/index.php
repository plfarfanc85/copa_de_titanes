<table class="yiiLog" width="100%" cellpadding="2" style="border-spacing:1px;font:11px Verdana, Arial, Helvetica, sans-serif;background:#EEEEEE;color:#666666;">
	<tbody>
	<tr>
		<th style="background:black;color:white;" colspan="4">
			Configuraciones
		</th>
	</tr>
	<tr style="background-color: #ccc;">
		<th>#</th>
		<th>Origin</th>
	   <th>Property</th>
	   <th>Value</th>
	</tr>
<?php if($dataNew->configModule!==false): ?>
<?php 
$configs=$dataNew->getConfigModule();
foreach($dataNew->propertys as $data ): ?>
	<tr style="background-color: #ccc;border-bottom:solid 1px #666;">
		<th colspan="4" align="center"><?php echo $data;?></th>
	</tr>	
<?php foreach($configs as $i => $v ): ?>
	<?php if($data==$v['property']): ?>
	<?php switch ($v['property']){ 
	
	 case 'aliases': 
	 ?>
		 <?php foreach($v['value'] as $ind => $val): ?>
			<tr style="<?php echo $i%2==0?"background:#FFFFFF;border-bottom:solid 1px #999;":"background:#F5F5F5;border-bottom:solid 1px #999";?>">
				<td><?php echo $i;?></td>
				<td align="center"><?php echo $v['origin'];?></td>
				<td><strong><?php echo $ind;?></strong></td>
				<td><?php echo $val;?></td>
			</tr>
		<?php endforeach; ?>
	<?php break;
	 case 'theme': ?>
	<tr style="<?php echo $i%2==0?"background:#FFFFFF;border-bottom:solid 1px #999;":"background:#F5F5F5;border-bottom:solid 1px #999";?>">
		<td><?php echo $i;?></td>
		<td align="center"><?php echo $v['origin'];?></td>
		<td colspan="2"><strong><?php echo $v['value'];?><?php echo Yii::app()->getTheme()!==null && Yii::app()->getTheme()->name==$v['value']?" (Aplicado)":"";?></strong></td>
	</tr>
	<?php break;

	 case 'modules': 
	 case 'components': 
	 case 'preload': 
	 case 'rules': 
	 case 'controllerMap': 
	 ?>
	<?php foreach($v['value'] as $ind => $val): ?>
	<tr style="<?php echo $i%2==0?"background:#FFFFFF;border-bottom:solid 1px #999;":"background:#F5F5F5;border-bottom:solid 1px #999";?>">
		<td><?php echo $i;?></td>
		<td align="center"><?php echo $v['origin'];?></td>
		<td><strong><?php echo !is_array($val)?$val:$ind;?></strong></td>
		
		<td><?php 
			if(is_array($val))
			{
				echo "<table>";
				foreach($val as $ind1 => $val1)
				{
					if($ind1=='rules')
						$val1="<pre>".CHtml::encode(print_r($val1,1))."</pre>";
					else
						$val1=is_array($val1)?print_r($val1,1):$val1;
					echo "<tr><td>$ind1</td><td>$val1</td></tr>";
				}
				echo "</table>";
			}	
			else
				echo "";
		 
		?></td>
	</tr>
	<?php endforeach; ?>
	<?php break;

	 } ?>
<?php endif; ?>
<?php endforeach; ?>
<?php endforeach; ?>
<?php else: ?>
	<tr style="background:#FFFFFF">
		<td colspan="3" align="center">No existen configuraciones para modulos</td>
	</tr>	
<?php endif; ?>
</tbody>
</table>
<?php /** $dataNew->configExtAll */ ?>