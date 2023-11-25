<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="order.css">
    <title>Order Form</title>
</head>
<body>
        <?php
        $name = strip_tags(isset($_POST["name"])) && ($_POST["name"] !== "") ? $_POST["name"] : "";
        $phoneNum = strip_tags(isset($_POST["phoneNumber"])) && ($_POST["phoneNumber"] !== "") && is_numeric($_POST["phoneNumber"]) ? $_POST["phoneNumber"] : 0;
        $email = strip_tags(isset($_POST["email"])) && ($_POST["email"] !== "") && filter_var($_POST["email"],FILTER_VALIDATE_EMAIL) ? $_POST["email"] : "";
        $postalAddress = strip_tags(isset($_POST["address"])) && ($_POST["address"] !== "") ? $_POST["address"] : "";
        $id = strip_tags(isset($_POST["id"])) && ($_POST["id"] !== "") && is_numeric($_POST["id"]) ? $_POST["id"] : 0;

        if($name && $phoneNum && $email && $postalAddress) {

            echo "<div class='successMessage'><p>You have successfully ordered a painting</p>";
            echo "<p class='homepage'><a href='index.php'>Return to the homepage</p></div>";
            $host = "devweb2022.cis.strath.ac.uk";
            $user = "njb20143";
            $pass = "keTei0aiL1ku";
            $dbname = $user;
            $conn = new mysqli($host, $user, $pass, $dbname);

            if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM `paintingsInfo`";
            $result = $conn->query($sql);

            if($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    if($row["ID"] == $id) {
                        $paintingName = $row["painting_name"]; $dateofCompletion = $row["date_of_completion"];
                        $price = $row["price (£)"]; $decription = $row["decription"]; $size = $row["height (mm)"] . "x" .$row["height (mm)"];
                        $painting = addslashes($row["picture"]);

                        $sql3 = "INSERT INTO `painting_Orders` (`ID`, `name`, `phone_number`, `email`, `postal_address`, `painting`, `name_of_painting`, `completion_date`, `size`, `price`, `description`)
                                    VALUES (NULL, '$name', '$phoneNum', '$email', '$postalAddress', '$painting'
                                   , '$paintingName', '	$dateofCompletion', '$size', '$price', '$decription')";

                        if($conn->query($sql3)){
                        } else {
                            die ("query failed " . $conn->error);
                        }
                    }
                }
            $conn->close();
            }
        }
        else{ ?>
    <div class="center">
    <h1>Order Form</h1>
    <form action="order.php" method="post">
        <div class="text_field">
            <input type="text" name="name" required>
            <span></span>
            <label>Full Name</label>
        </div>
        <div class="text_field">
            <input type="text" name="phoneNumber" required>
            <span></span>
            <label>Phone number</label>
        </div>
        <div class="text_field">
            <input type="text" name="email" required>
            <span></span>
            <label>Email</label>
        </div>
        <div class="text_field">
            <input type="text" name="address" required>
            <span></span>
            <label>Postal address</label>
        </div>
        <p><b>Painting info:</b></p>
        <?php
        $host = "devweb2022.cis.strath.ac.uk";
        $user = "njb20143";
        $pass = "keTei0aiL1ku";
        $dbname = $user;
        $conn = new mysqli($host, $user, $pass, $dbname);

        if($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM `paintingsInfo`";
        $result = $conn->query($sql);
        $id = strip_tags(isset($_POST["id"])) && ($_POST["id"] !== "") && is_numeric($_POST["id"]) ? $_POST["id"] : 0;
        if($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                if($row["ID"] == $id) {
                    $paintingName = $row["painting_name"];
                    $dateofCompletion = $row["date_of_completion"];
                    $price = $row["price (£)"];
                    $decription = $row["decription"];
                    $size = $row["height (mm)"] . "x" . $row["height (mm)"];
                    echo '<img class="image" src="data:image/jpeg;base64,'.base64_encode($row['picture']).'"/>'.
                         "<p><b>Name</b>: " . $row["painting_name"] . "</p>" .
                         "<p><b>Date of completion:</b> " . $row["date_of_completion"] . "</p>" .
                         "<p><b>Width (mm):</b> " . $row["width (mm)"] . "</p>" .
                         "<p><b>Height (mm):</b> " . $row["height (mm)"] . "</p>" .
                         "<p><b>Price: </b>£" . $row["price (£)"] . "</p>" .
                         "<p><b>Decription:</b> " . $row["decription"] . "</p>";
                }
            }
        }
        $conn->close();
        ?>
        <input type="hidden" name="id" value="<?php echo $id?>">
        <p><input type="submit" value="Order"></p>
    </form>
    </div>
        <?php }
        ?>
</body>
</html>