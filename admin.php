<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="adminPage.css">
    <title>Admin page</title>
</head>
<body>
<?php

$password = strip_tags(isset($_POST["password"])) && ($_POST["password"] !== "") ? $_POST["password"] : "";
if(isset($_SESSION["password"]) && ($_SESSION["password"] !== "")){
    $password = $_SESSION["password"];
} else{
    $password = strip_tags(isset($_POST["password"])) && ($_POST["password"] !== "") ? $_POST["password"] : "";
}

if(md5($password) === "d56963fbad09a2b894c7cf6ed6fe3cd5"){
    if(!isset($_SESSION["password"])){
        session_regenerate_id();
    }
    $_SESSION["password"] = $password;

    ?>
<div>
    <h1>Features</h1>
    <form action="viewOrders.php" method="post">
        <p><input class="clickButton" type="submit" value="View Orders"></p>
    </form>

    <form action="addPainting.php" method="post">
        <p><input class="clickButton" type="submit" value="Add Paintings"></p>
    </form>
</div>
     <?php

} else { ?>
    <form action="admin.php" method="POST">
        <div class="admin">
            <p><input class="password" type="password" name="password" placeholder="Type password">
                <input class="submitButton" type="submit" value="LOGIN"></p>
        </div>
    </form>
<?php
}


?>

</body>
</html>