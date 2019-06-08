<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "database.php";
require_once "action.php";
?>
<html>
    <head>
        <title>Project Flower</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <link href="//fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
        <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
        <link href="design/pure-min.css" rel="stylesheet" type="text/css">
        <link href="design/design.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="pure-g">
            <div class="pure-u-1-3">
                <div class="panel">
                    <div class="title color-grey">
                        Captor Humidity
                    </div>
                    <div class="description color-white">
                        <table class="pure-table" style="min-width: 100%" id="humiTable">
                            <thead>
                            <tr>
                                <th>
                                    Value
                                </th>
                                <th>
                                    Datetime
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach(getByCaptor('era_humi') as $row){
                                $date = new DateTime();
                                $date->setTimestamp($row['date_captor']);
                                $_SESSION['era_humi'] = $row['ID'];
                                ?>
                                <tr>
                                    <td><?= $row['value_captor'] ?></td>
                                    <td><?= $date->format("F j, Y, g:i a") ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pure-u-1-3">
                <div class="panel">
                    <div class="title color-grey">
                        Captor Temperature
                    </div>
                    <div class="description color-white">
                        <table class="pure-table" style="min-width: 100%" id="tempTable">
                            <thead>
                            <tr>
                                <th>
                                    Value
                                </th>
                                <th>
                                    Datetime
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach(getByCaptor('era_temp') as $row){
                                $date = new DateTime();
                                $date->setTimestamp($row['date_captor']);
                                $_SESSION['era_temp'] = $row['ID'];
                                ?>
                                <tr>
                                    <td><?= $row['value_captor'] ?></td>
                                    <td><?= $date->format("F j, Y, g:i a") ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pure-u-1-3">
                <div class="panel">
                    <div class="title color-grey">
                        Captor Flower Water
                    </div>
                    <div class="description color-white">
                        <table class="pure-table" style="min-width: 100%" id="waterTable">
                            <thead>
                            <tr>
                                <th>
                                    Value
                                </th>
                                <th>
                                    Datetime
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach(getByCaptor('era_water') as $row){
                                $date = new DateTime();
                                $date->setTimestamp($row['date_captor']);
                                $_SESSION['era_water'] = $row['ID'];
                                ?>
                                <tr>
                                    <td><?= $row['value_captor'] ?></td>
                                    <td><?= $date->format("F j, Y, g:i a") ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pure-u-1-4"></div>
            <div class="pure-u-1-2">
                <div class="panel">
                    <div class="title color-grey">
                        Log
                    </div>
                    <div class="description color-white">
                        <table class="pure-table" style="min-width: 100%" id="logTable">
                            <thead>
                            <tr>
                                <th>
                                    Value
                                </th>
                                <th>
                                    Datetime
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach(getLog() as $row){
                                    $date = new DateTime();
                                    $date->setTimestamp($row['date_log']);
                                    $_SESSION['id_log'] = $row['ID'];
                                    ?>
                                    <tr>
                                        <td><?= $row['log'] ?></td>
                                        <td><?= $date->format("F j, Y, g:i a") ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="design/jquery-3.4.0.min.js"></script>
        <script src="design/refresh.js"></script>
        <script>
            $(function(){
                function r(){
                    setTimeout(function(){
                        refreshAjax('#tempTable', 'action=captor&name_captor=era_temp');
                        refreshAjax('#waterTable', 'action=captor&name_captor=era_water');
                        refreshAjax('#humiTable', 'action=captor&name_captor=era_humi');
                        r();
                    }, 4000);
                }
                //r();
            })
        </script>
    </body>
</html>
