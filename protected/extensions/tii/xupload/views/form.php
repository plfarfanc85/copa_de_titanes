<!-- The file upload form used as target for the file upload widget -->
<?php echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="row<?php echo Yii::app()->hasComponent('bootstrap') && Yii::app()->getComponent('bootstrap')->responsiveCss===true?"-fluid":""; ?> fileupload-buttonbar">
	<div class="span7">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button"> <i class="icon-plus icon-white"></i> <span>Add files...</span>
			<?php
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
	        if($this->params!==null)
	        {
		        foreach($this->params as $name =>$value)
		        	echo CHtml::hiddenField($name, $value) . "\n";
	        }
     		?>
		</span>
		<button type="submit" class="btn btn-primary start">
			<i class="icon-upload icon-white"></i>
			<span>Start upload</span>
		</button>
		<button type="reset" class="btn btn-warning cancel">
			<i class="icon-ban-circle icon-white"></i>
			<span>Cancel upload</span>
		</button>
		<button type="button" class="btn btn-danger delete">
			<i class="icon-trash icon-white"></i>
			<span>Delete</span>
		</button>
		<input type="checkbox" class="toggle">
	</div>
	<div class="span5">
		<!-- The global progress bar -->
		<div class="progress progress-success progress-striped active fade">
			<div class="bar" style="width:0%;"></div>
		</div>
	</div>
</div>
<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<!-- The table listing the files available for upload/download -->
<table class="table table-striped">
	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
	
	<?php if ($this->hasModel()): ?>
	<?php foreach($this->result as $data): ?>

	<tr class="template-download fade in" style="height: 75px;">
		<td class="preview">
			<a download="<?php echo $data->name;?>" rel="gallery" title="<?php echo $data->name;?>" href="/administrator/images/actividades/<?php echo $data->name;?>"><img src="/administrator/images/actividades/<?php echo $data->name;?>"></a>
		</td>
		<td class="name">
			<span><?php echo "( ".$data->width."px X ".$data->height."px ) ";?></span><a download="<?php echo $data->name;?>" rel="gallery" title="<?php echo $data->name;?>" href="/administrator/images/actividades/<?php echo $data->name;?>"><?php echo $data->name;?></a>
		</td>
		<td class="size"><span><?php echo $data->getReadableFileSize()?></span></td>
		<td colspan="2"></td>
        
        <td class="delete">
            <button data-url="<?php echo $this->controller->createUrl('upload',array('_method'=>'delete','id'=>$data->id));?>" data-type="POST" class="btn btn-danger">
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" value="1" name="delete">
        </td>
        <td class="actualizar" style="text-align: center">
      <!--   	<div class="btn-group">
  <button class="btn">Action</button>
  <button class="btn dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
  		<li><a href="#">Opcion 1</a></li>
  		<li><a href="#">Opcion 2</a></li>
  		<li><a href="#">Opcion 3</a></li>
  </ul>
</div> -->
        	<?php 
        	if($this->params['img_id']==$data->id)
        	{
        		$class="disabled";
	        	$activo="ok";
	        	$imagenMain="Imagen main";
        	}
        	else
        	{
        		$class="";
	        	$activo="remove";
	        	$imagenMain="Seleccionar";
        	}
        	$this->widget('bootstrap.widgets.TbButton', array('id'=>$data->id,'buttonType'=>'link', 'type'=>'info', 'label'=>$imagenMain,'icon'=>$activo.' white','url'=>'javascript:void(0)','htmlOptions'=>array('class'=>$class))); ?>
		</td>
    </tr>

	<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
<?php echo CHtml::endForm();?>
<?php
Yii::app()->clientScript->registerCss("preview","
		td.preview a img {
			width: 160px;
			hetight: 105px;
		}
");

Yii::app()->clientScript->registerScript("imgMain","
		jQuery('tbody.files').on('click','.actualizar a',function(){
			jQuery(this).parent().addClass('grid-view-loading');
			var id=jQuery(this).attr('id');
			jQuery.ajax({
				data: {
					id: id,
					ppa_id: ".$this->params['ppa_id'].",
					action: 'update',
				},
				type: 'GET',
				dataType: 'json',
				url: '".$this->url."',
				success: function(data){
					if(data)
					{
						jQuery('.actualizar a').removeClass('disabled');
						jQuery('.actualizar a').empty().append('<i class=\"icon-remove icon-white\"></i> Seleccionar');
						jQuery('#'+id).empty().append('<i class=\"icon-ok icon-white\"></i> Imagen main');
						
						jQuery('#'+id).addClass('disabled');
						jQuery('#'+id).parent().removeClass('grid-view-loading');
					}
				}
			});
		});
");

?>