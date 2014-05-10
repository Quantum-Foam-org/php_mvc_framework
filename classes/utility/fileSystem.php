<?php

namespace \local\classes\utility;

class FileSystem {
    
    public static function is_writable($file) {
        return is_writable(dirname($file));
    }
}