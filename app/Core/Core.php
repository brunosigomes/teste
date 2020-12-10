<?php

class Core
{
	private $url;
	private $controller;
	private $method;
	private $params = array();

	public function __construct() {

	}

	public function start($request)
	{
		if(isset($request['url'])) {
			$this->url = explode('/', $request['url']);

			if(isset($this->url[0])) {
				$this->controller = ucfirst($this->url[0]).'Controller';
			}

			if(isset($this->url[1])) {
				$this->method = $this->url[1];
			} else {
				$this->method = 'index';
			}

			if(isset($this->url[2])) {
				$this->params = $this->url[2];
			}
		} else {
			$this->controller = 'HomeController';
			$this->method = 'index';
		}

		if(!class_exists($this->controller) || !method_exists($this->controller, $this->method)) {
			$this->controller = 'ErroController';
			$this->method = 'index';	
		}

		call_user_func(array(new $this->controller, $this->method), $this->params);
	}
}