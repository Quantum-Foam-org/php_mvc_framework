<?php

namespace mvc\controller;

class ActionGroup extends Main {

    public function header404() {
        $this->getView('');
    }
}
