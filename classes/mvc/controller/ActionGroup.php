<?php

namespace mvc\controller;

class ActionGroup extends Main {

    public function page404() {
        $this->getView('');
    }
    
    public function page500() {
        $this->getView('');
    }
}
