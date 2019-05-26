<?php

class Router {
    private $routes;
    
	public function __construct() {
		$routesPath = Root . '/config/routes.php';
		$this -> routes = include_once ($routesPath);
    }
    
	public function run() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			$uri = trim($_SERVER['REQUEST_URI'], '/');
		}
		foreach ($this->routes as $uriPattern => $path) {
			if (preg_match("~$uriPattern~", $uri)) {
				$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
				$segments = explode('/', "$internalRoute");
				$controllerName = ucfirst(array_shift($segments) . 'Controller');
				$actionName = 'action' . ucfirst(array_shift($segments));
				$parameters = $segments;
				$controllerFile = Root . '/controllers/' . $controllerName . '.php';
				if (file_exists($controllerFile)) {
					include_once ($controllerFile);
                }
                
				$controllerObject = new $controllerName;
				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
				if ($result != null) {
					break;
				}
			}
		}
	}
}

?>