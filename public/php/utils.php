<?php

function count_errors($errArray) {
    $res = 0;
    foreach ($errArray as $key => $value) {
        if ($value == "") {
            $res++;
        }
    }
    return $res;
}