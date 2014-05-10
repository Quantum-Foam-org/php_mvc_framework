<?php

function filter_date($date) {
    $numbers = explode('/', $date);
    $numbers = array_map('trim', $numbers);
	
    if (count($numbers) == 3 && array_utils::str_has_len($numbers) && checkdate($numbers[0], $numbers[1], $numbers[2])) {
        $result = $date;
    } else {
        $result = FALSE;
    }
    
    return $result;
}
