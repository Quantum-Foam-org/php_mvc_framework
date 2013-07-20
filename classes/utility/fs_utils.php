<?php



class fs_utils {
    
    public static function is_writable($file) {
        return is_writable(dirname($file));
    }
}