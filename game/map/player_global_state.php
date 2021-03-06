<?php

//constants
define ("map_drow_size", 50);//map heigt & wind draw
define ("map_x_max", 512);//pixel map lenght
define ("map_y_max", 512);//pixel map hight

session_start();
if(!$_SESSION['user_name']){
    exit(header('Location: ../../index.php'));
}
include("../../database/database.php");
$user_name = $_SESSION['user_name'];
$form_user = "user_$user_name";

$select = mysql_query("SELECT * FROM `$form_user` WHERE `cell_id` = '1001'");
$player_coord = mysql_fetch_array($select);

$_SESSION['x'] = $player_coord['health'];
$_SESSION['y'] = $player_coord['health_max'];

$global_x = $_SESSION['x'];
$global_y = $_SESSION['y'];

if($global_x < 0){
    mysql_query("UPDATE `$form_user` SET `health` = '0' WHERE `$form_user`.`cell_id` = 1001;");
    $_SESSION['x'] = 0;
}else if($global_x > 512099099){
    mysql_query("UPDATE `$form_user` SET `health` = '512099099' WHERE `$form_user`.`cell_id` = 1001;");
    $_SESSION['x'] = 512099099;
}

if($global_y < 0){
    mysql_query("UPDATE `$form_user` SET `health_max` = '0' WHERE `$form_user`.`cell_id` = 1001;");
    $_SESSION['y'] = 0;
}else if($global_y > 512099099){
    mysql_query("UPDATE `$form_user` SET `health_max` = '512099099' WHERE `$form_user`.`cell_id` = 1001;");
    $_SESSION['y'] = 512099099;
}

$global_x = $_SESSION['x'];
$global_y = $_SESSION['y'];

$player_x = (int)($global_x / 1000000);
$player_y = (int)($global_y / 1000000);

if((int)($player_x - map_drow_size/2) < 0){
    $x_min = 0;
    $x_max = map_drow_size;
}else if((int)($player_x + map_drow_size/2) > map_scale_max){
    $x_max = map_scale_max;
    $x_min = $player_x - map_drow_size;
}else{
    $x_max = (int)($player_x + map_drow_size/2);
    $x_min = (int)($player_x - map_drow_size/2);
}
    
if((int)($player_y - map_drow_size/2) < 0){
    $y_min = 0;
    $y_max = map_drow_size;
}else if((int)($player_y + map_drow_size/2) > map_scale_max){
    $y_max = map_scale_max;
    $y_min = $player_y - map_drow_size;
}else{
    $y_max = (int)($player_y + map_drow_size/2);
    $y_min = (int)($player_y - map_drow_size/2);
}

$select = mysql_query("SELECT * FROM `data_map` WHERE `x` BETWEEN '$x_min' AND '$x_max' AND `y` BETWEEN '$y_min' AND '$y_max'");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blacksmith</title>
</head>
<body align = "center">
    <div>
    <a href="../exit.php">EXIT</a>
    <br><a href="../home/blacksmith_home.php">Blacksmith home</a>
    </div>
    <div style='line-height: 0.9'>
    <?
    while($point = mysql_fetch_array($select)){

        $r = $point['r'];
        $g = $point['g'];
        $b = $point['b'];

        if($point['x'] == $player_x && $point['y'] == $player_y){
            echo "<a href = 'map_generator_100.php'><img src='../../images/player.png' height='14px' width='14px'></a>";
        }else{
            echo "<a style='background-color: RGB(".$r.",".$g.",".$b.")'>&#11036</a>";
        }
        if($point['x']>$x_max-1){
            echo "<br>";
        }

    }
    ?>
    </div>
</body>
</html>