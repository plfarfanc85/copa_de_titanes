<?php
class GClearUrlManager extends CBehavior
{

	/**
	 * Parses the user request.
	 * @param CHttpRequest $request the request application component
	 * @return string the route (controllerID/actionID) and perhaps GET parameters in path format.
	 */
	public function testParseUrl($request)
	{
		if($this->getOwner()->getUrlFormat()===CUrlManager::PATH_FORMAT)
		{
			$rawPathInfo=$request->getPathInfo();
			$pathInfo=$this->getOwner()->removeUrlSuffix($rawPathInfo,$this->getOwner()->urlSuffix);
			foreach($this->getOwner()->rules as $i=>$rule)
			{
				if(is_array($rule))
					$this->getOwner()->rules[$i]=$rule=Yii::createComponent($rule);
				else
					$rule=$this->createUrlRule($i,$rule,$this->getOwner());
				if(($r=$rule->parseUrl($this->getOwner(),$request,$pathInfo,$rawPathInfo))!==false)
				{
					if(isset($_GET[$this->getOwner()->routeVar]))
						$echo=" ".CVarDumper::dump($rule,100)." ".$_GET[$this->getOwner()->routeVar];
					else
						$echo=" ".CVarDumper::dump($rule,100,true)." ".$r;
					return $echo;
				}
			}
			if($this->getOwner()->useStrictParsing)
				throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
					array('{route}'=>$pathInfo)));
			else
				return "No se aplico ninguna ".$pathInfo;
		}
		else if(isset($_GET[$this->getOwner()->routeVar]))
			return $_GET[$this->getOwner()->routeVar];
		else if(isset($_POST[$this->getOwner()->routeVar]))
			return $_POST[$this->getOwner()->routeVar];
		else
			return '';
	}


	/**
	 * Creates a URL rule instance.
	 * The default implementation returns a CUrlRule object.
	 * @param mixed $route the route part of the rule. This could be a string or an array
	 * @param string $pattern the pattern part of the rule
	 * @return CUrlRule the URL rule instance
	 * @since 1.1.0
	 */
	protected function createUrlRule($route,$pattern,$manager)
	{
		if(is_array($route) && isset($route['class']))
			return $route;
		else
			return new $manager->urlRuleClass($route,$pattern);
	}
}