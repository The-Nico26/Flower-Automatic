<?php
$dbname='base.db';
$exist = file_exists($dbname);

try{
    $base = new PDO('sqlite:'.$dbname);
}catch (Exception $e){
    var_dump($e);
}
$base->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

if(!$exist):
    echo "created";
    $base->exec("CREATE TABLE captor (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    name_captor varchar(50) NOT NULL,
    value_captor varchar(100) NOT NULL,
    date_captor TEXT NOT NULL
);");
    $base->exec("CREATE TABLE log (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    name_id VARCHAR(50) NOT NULL,
    log TEXT NOT NULL,
    date_log TEXT NOT NULL
);");

endif;

function addCaptorValue($name, $value){
    global $base;
    $date = new DateTime();
    $dateStr = $date->getTimestamp();
    $base->exec("INSERT INTO captor(name_captor, value_captor, date_captor) VALUES ('$name', '$value', '$dateStr')");
}

function addLog($name, $log){
    global $base;
    $date = new DateTime();
    $dateStr = $date->getTimestamp();
    $base->exec("INSERT INTO log(name_id, log, date_log) VALUES ('$name', '$log', '$dateStr')");
}

function getByCaptor($name, $id = 0){
    global $base;
    return $base->query("SELECT * FROM captor WHERE name_captor = '$name' and ID > $id ORDER BY ID DESC LIMIT 0, 10")->fetchAll();
}

function getLog($id = 0){
    global $base;
    return $base->query("SELECT * FROM log WHERE ID > $id ORDER BY ID DESC LIMIT 0,20")->fetchAll();
}