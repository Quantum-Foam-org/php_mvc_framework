<?php

namespace \local\classes\utility;

class Page {
    
    public static function check_page_ref($page) {
        if (PageRef::obj($page)){
            $result = TRUE;
        } else {
            $result = FALSE;
        }
        return $result;
    }
    
    public static function check_post_group(array $btns, $one = TRUE) {
        $result = TRUE;
        foreach ($btns as $btn_name => $btn_texts) {
            foreach ($btn_texts as $btn_text) {
                $tmp = self::check_post($btn_name, $btn_text);
                if ($one) {
                    $result = $tmp;
                    if ($result == TRUE) {
                        break 2;
                    }
                } else if($one == FALSE) {
                    $result = $result&$tmp;
                }
            }
        }
        
        return (boolean)$result;
    }
    
    public static function check_post($name, $text) {
        $rq = \local\classes\request\Vars::obj();
        return (isset($rq->post[$name]) && $rq->post[$name] == $text);
    }
    
}