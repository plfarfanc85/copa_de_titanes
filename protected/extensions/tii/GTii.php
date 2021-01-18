<?php
class GTii extends CApplicationComponent
{
	public $configModule=false;
	public $cacheID="cache";
	public $paths=array('tii','application.modules');
	public $propertys=array('aliases','theme','modules','components','rules','preload','controllerMap');
	
	private $_ct=1;
	/*public function init()
	{
		Yii::beginProfile('Operation tii extencions','ext.tii.GTii');
		Yii::setPathOfAlias('tii',dirname(__FILE__));
		$this->load()->apply();
		parent::init();
		Yii::endProfile('Operation tii extencions','ext.tii.GTii');
	}*/

	public function load($force=false)
	{
		$this->loadConfigModules($force);
		return $this;
	}
	
	public function loadConfigModules($force=false)
	{
		$hasCache=$this->cacheID!==false && ($cache=Yii::app()->getComponent($this->cacheID))!==null;
		if($hasCache && $force===false)
			$this->configModule=$cache->get("Tii.ext.installer.GTii.configModule");
		if($this->configModule===false)
		{
			foreach($this->paths as $path)
			{
				// load2 all modules
				$modulesPath=Yii::getPathOfAlias($path).DIRECTORY_SEPARATOR;
				if(is_dir($modulesPath))
				{
					foreach(scandir($modulesPath) as $module)
					{
						#if(substr($module,0,1)!=='.')
						if(strpos($module,".")===false && strpos($module," ")===false)
						{
							#echo $module."<br>";
							#echo $realModulesPath=$modulesPath.$module.DIRECTORY_SEPARATOR."{$module}-config.php<br>";
							if(file_exists($realModulesPath=$modulesPath.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR."{$module}-config.php"))
							{
								$m=include($realModulesPath);
								foreach($m as $i => $v)
								{
									#if($path==='application.modules' && $i=='modules')
									#if($i=='weight')
									$this->configModule[$this->_ct]['property']=$i;
									$this->configModule[$this->_ct]['value']=$v;
									$this->configModule[$this->_ct]['origin']=$path.'.'.$module;
									$this->_ct++;
								}
							}
							else
							{
								if($path==='application.modules')
								{
									$this->configModule[$this->_ct]['property']='modules';
									$this->configModule[$this->_ct]['value']=array($module);
									$this->configModule[$this->_ct]['origin']=$path.'.'.$module;
									$this->_ct++;
								
								}
							}
						} 
					}
				}
			}
			if($hasCache && $force===false)
				$cache->set("Tii.ext.installer.GTii.configModule",$this->configModule,(24*3600*360)); // one year haha
		}
	}

	public function apply()
	{
		if($this->configModule!==false)
		{
			foreach($this->configModule as $i => $v)
			{
				if($v['property']=='preload')
					continue;
				else if($v['property']=='rules')	
					Yii::app()->request->addRules($v['value'],false);
				else	
					Yii::app()->{$v['property']}=$v['value'];
			}	
			
			foreach($this->configModule as $i => $v)
			{
				if($v['property']=='preload')
				{
					foreach($v['value'] as $pre)
						Yii::app()->getComponent($pre);
				} 
			}
			Yii::app()->controllerMap=CMap::mergeArray(array('tii'=>array('class'=>'tii.TiiController')),Yii::app()->controllerMap);
		}
		return $this;
	}

	public function getConfigModule()
	{
		$m=include(Yii::app()->basePath.'/config/main.php');
		foreach($m as $i => $v)
		{
			$this->configModule[$this->_ct]['property']=$i;
			$this->configModule[$this->_ct]['value']=$v;
			$this->configModule[$this->_ct]['origin']='application.config';
			$this->_ct++;
		}
		return $this->configModule;
	}

	public function builtMenu()
	{
		$items=array(
            array('label'=>'Home', 'url'=>array('/site/index')),
            #array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
            #array('label'=>'Contact', 'url'=>array('/site/contact')),
     	);

     	 foreach(Yii::app()->getModules() as $name => $config)
     	 {
     	 	if((!YII_DEBUG && $name=="gii") || $name=="catalogos")
     	 		continue;
 	 		if(($module=Yii::app()->getModule($name))!==null && method_exists($module,'getMenu'))
     	 		$items[]=array('label'=>$name, 'url'=>array('/'.$name),'items'=>$module->getMenu(),'visible'=>$module->getVisible());
     	 	else
     	 	 	$items[]=array('label'=>$name, 'url'=>array('/'.$name));
     	 }
 		return $items;
	}
}