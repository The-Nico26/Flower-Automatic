<?php
require_once "database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['key']) && $_GET['key'] == "ERASMUS_FLOWER"):
    switch($_GET['action']){
        case "captor":
            addCaptorValue($_GET['name'], $_GET['value']);
            break;
        case "log":
            addLog($_GET['name'], $_GET['value']);
            break;
    }
endif;