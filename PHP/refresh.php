<?php
header('Content-Type: application/json');
session_start();
$action = $_GET['action'];
if(isset($action)):
    require_once "database.php";
    switch($action){
        case "captor":
            if(key_exists('name_captor', $_GET)):
                $name_captor = $_GET['name_captor'];

                if($_SESSION[$name_captor] == null)
                    $_SESSION[$name_captor] = "0";

                $id_captor = $_SESSION[$name_captor];
                $jsonRow = getByCaptor($name_captor, $id_captor);
                if(!empty($jsonRow))
                    $_SESSION[$name_captor] = $jsonRow[count($jsonRow)]['ID'];

                echo json_encode(array('params' => [$name_captor, $id_captor, $action], 'value' => $jsonRow));
            endif;
            break;
        case "log":
            $id_log = $_SESSION['id_log'];
            $jsonRow = getLog($id_log);
            echo json_encode(array('params'=>[$id_log, $action], 'value'=>$jsonRow));
            break;
    }
endif;