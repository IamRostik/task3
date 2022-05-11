<?php
function debug($arr, $die = false){
    echo '<pre>' . print_r($arr, 1) . '</pre>';
    if ($die) die;
}