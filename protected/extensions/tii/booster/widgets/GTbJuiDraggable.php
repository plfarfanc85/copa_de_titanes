<?php
/**
 * GTbJuiDraggable class file.
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::import('zii.widgets.jui.CJuiWidget');

/**
 * CJuiDraggable displays a draggable widget.
 *
 * CJuiDraggable encapsulates the {@link http://jqueryui.com/sortable/#connect-lists}
 * plugin.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
 *     // additional javascript options for the draggable plugin
 *     'options'=>array(
 *         'scope'=>'myScope',
 *     ),
 * ));
 *     echo 'Your draggable content here';
 *     
 * $this->endWidget();
 * 
 * </pre>
 *
 * By configuring the {@link options} property, you may specify the options
 * that need to be passed to the JUI Draggable plugin. Please refer to
 * the {@link http://jqueryui.com/demos/draggable/ JUI Draggable} documentation
 * for possible options (name-value pairs).
 *
 * @author Gustavo Salgado <gsalgadotoledo@gmail.com>
 * @version $Id$
 * @package zii.widgets.jui
 * @since 1.1
 */
class GTbJuiDraggable extends CJuiWidget
{
	/**
	 * @var string the name of the Draggable element. Defaults to 'div'.
	 */
	public $tagName='div';
	/*public $options=array(
				'connectWith'=>'.connectedSortable',
				'items'=>' .item',
				#'stop'=>"js:function(event, ui) { jQuery('#sortable1 div.item').addClass('btn-primary'); jQuery('#sortable2 div.item').removeClass('btn-primary'); }",
				#'beforeStop'=>"js:function(event, ui) { jQuery('#mensaje').html('Soy beforeStop'); }",
				#'update'=>"js:function (event, ui) { jQuery('#mensaje').html('Soy update'); } ",
				#'over'=>"js:function(event, ui) { jQuery('#mensaje').html('Soy over'); }",
				#'out'=>"js:function(event, ui){ jQuery('#mensaje').html('Soy out'); }",
				#'receive'=>"js:function(event, ui) { jQuery('#mensaje').html('Soy recibe'); }",
			);*/
	public $sortablesId=array('#not_assigned','#assigned');

	/**
	 * Renders the open tag of the draggable element.
	 * This method also registers the necessary javascript code.
	 */
	public function init(){
		parent::init();
		
		$id=$this->getId();
		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		$options=CJavaScript::encode(CMap::mergeArray($this->options,array('connectWith'=>'.connectedSortable','items'=>' .item')));
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"
			jQuery( '".implode(", ",$this->sortablesId)."' ).sortable({$options}).disableSelection();");

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
	}

	/**
	 * Renders the close tag of the draggable element.
	 */
	public function run(){
		echo CHtml::closeTag($this->tagName);
	}
	
}


/**
$this->widget('zii.widgets.jui.CJuiSortable', array(
    'id'=>'sortable1',
    'htmlOptions'=>array('class'=>'conactadas'),
    'items'=>array(
        'id1'=>'Item 1',
        'id2'=>'Item 2',
        'id3'=>'Item 3',
    ),
    'options'=>array(
        'cursor'=>'n-resize',
        'connectWith'=>'.conactadas',
    ),
));
$this->widget('zii.widgets.jui.CJuiSortable', array(
    'id'=>'sortable2',
    'htmlOptions'=>array('class'=>'conactadas'),
    'items'=>array(
        'id1'=>'Item 4',
        'id2'=>'Item 5',
        'id3'=>'Item 6',
    ),
    'options'=>array(
        'cursor'=>'n-resize',
        'connectWith'=>'.conactadas',
    ),
));

<!-- <div class="row-fluid">
<?php #Yii::app()->clientScript->registerCss("inactive",".inactive a{background-color: #eee;}");?>
  <div class="span12">

    <div class="row-fluid">
      <div  id="sortable1" class="span6 well connectedSortable" style="background-color: #fff;">
      	<h4>Sitios asignados <small>Visibilidad en los siguientes sitios</small></h4>
			<ul class="nav nav-pills nav-stacked">
			  <li class="item active"><a>Home</a></li>
			  <li class="item active"><a>Home</a></li>
			  <li class="item active"><a>Home</a></li>
			</ul>
	  </div>
      <div  id="sortable2" class="span6 well connectedSortable" style="background-color: #fff;">
      	<h4>Sitios sin asignar <small>No visibles en estos sitios</small></h4>
    		<ul class="nav nav-pills nav-stacked">
			  <li class="item inactive"><a>Home</a></li>
			  <li class="item inactive"><a>Home</a></li>
			  <li class="item inactive"><a>Home</a></li>
			  <li class="item inactive"><a>Home</a></li>
			</ul>
	  </div>
    </div>
  
  </div>
</div>
 -->

 <!-- <div class="row-fluid">
  <div class="span12">

    <div class="row-fluid">
      <div  id="sortable1" class="span6 well connectedSortable" style="background-color: #fff;">
      	<h4>Sitios asignados <small>Visibilidad en los siguientes sitios</small></h4>
		  <div class="item alert alert-error" style="min-height: 39px!important;"> <h4>Warning!</h4> Block level button</div>
		  <div class="item alert alert-success" style="min-height: 39px!important;">Block level button</div>
	  </div>
      
      <div id="sortable2" class="span6 well connectedSortable" style="background-color: #fff;">
      	<h4>Sitios sin asignar <small>No visibles en estos sitios</small></h4>
		  <div class="item alert alert-info" style="min-height: 39px!important;">Block level button</div>
		  <div class="item alert alert-block" style="min-height: 39px!important;">Block level button</div>
		  <div class="item alert alert-block" style="min-height: 39px!important;">Block level button</div>
	  </div>
    </div>
  
  </div>
</div>
 -->
*/