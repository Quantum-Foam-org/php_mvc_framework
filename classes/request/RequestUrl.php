<?php

namespace \local\classes\request;

use \common\url\Main as url;


class RequestUrl extends url {
	
	public function isReferrer() {
		$url = new urll($_SERVER['REFERER']);
		
		return $this->compare($url);
	}
}
