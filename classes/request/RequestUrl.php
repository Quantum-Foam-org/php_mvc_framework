<?php

namespace \local\classes\request;

use \common\url\Main as url;


class RequestUrl extends url {
	
	public function isReferrer() {
		$url = new url($_SERVER['REFERER']);
		
		return $this->compare($url);
	}
	
	public function isCurrent() {
		$url = new url($_SERVER['REQUEST_URI']);
		
		return $this->compare($url);
	}
}
