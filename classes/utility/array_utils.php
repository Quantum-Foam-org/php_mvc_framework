<?php

class array_utils {
    
    public static function values_eq_keys($key_vals, $data_array) {
        return ($key_vals != array_keys($data_array));
    }
    
    public static function str_has_len(array $data) {
        $result = TRUE;
        foreach ($data as $d) {
            if (!strlen($d)) {
                $result = FALSE;
                break;
            }
        }
        return $result;
    }
    
}