<?
include("../../../database/database.php");
$select = mysql_query("SELECT * FROM `data_tools`");

if(!isset($_GET['msg'])){
    $_GET['msg']='';
}
if(!isset($_GET['err'])){
    $_GET['err']='';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blacksmith</title>
</head>
<body>
    <a href="../craft.php">Back</a>
    <br>
    <br><?=$_GET['err'].$_GET['msg']?>
    <br>
    <form action="craft_tools_choise_component.php" method = "post">
        <select name="must_craft">
            <option selected desabled>Choise what create</option>
            <?
            while($element = mysql_fetch_array($select)){
                echo "<option value = '".$element['tools_id']."'>".$element['tools_name']."</option>";
            }
            ?>
        </select>
        <input type="submit" value = "craft">
    </form>
</body>
</html>