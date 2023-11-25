<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="viewOrder.css">
    <title>View Orders</title>
</head>
<body>
<?php
    $host = "devweb2022.cis.strath.ac.uk";
    $user = "njb20143";
    $pass = "keTei0aiL1ku";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $ordNum = strip_tags(isset($_POST["ordNum"])) && ($_POST["ordNum"] !== "") && is_numeric($_POST["ordNum"]) ? $_POST["ordNum"] : 0;
        if($ordNum){
            echo "<div class='successMessage'><p>You have successfully removed an order</p>";
            echo "<p class='homepage'><a href='admin.php'>Return to the admin page</p></div>";

            $sql = "DELETE FROM `painting_Orders` WHERE `painting_Orders`.`ID` = '$ordNum'";

            if($conn->query($sql)){
            } else {
                die ("query failed " . $conn->error);
            }
    } else { ?>
<div class="table-container">
    <table class="table">
        <tr id="header">
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Postal Address</th>
            <th>Painting</th>
            <th>Name of Painting</th>
            <th>Completion date</th>
            <th>Size</th>
            <th>Price</th>
            <th>Description</th>
        </tr>

        <?php
        $host = "devweb2022.cis.strath.ac.uk";
        $user = "njb20143";
        $pass = "keTei0aiL1ku";
        $dbname = $user;
        $conn = new mysqli($host, $user, $pass, $dbname);

        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM `painting_Orders`";


        $result = $conn->query($sql);

        if($result->num_rows>0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>" .
                    "<td>" . $row["ID"] . "</td>" .
                    "<td>" . $row["name"] . "</td>" .
                    "<td>" . $row["phone_number"] . "</td>" .
                    "<td>" . $row["email"] . "</td>" .
                    "<td>" . $row["postal_address"] . "</td>" .
                    "<td>" . '<img class="image" src="data:image/jpeg;base64,'.base64_encode($row['painting']).'"/>' . "</td>" .
                    "<td>" . $row["name_of_painting"] . "</td>" .
                    "<td>" . $row["completion_date"] . "</td>" .
                    "<td>" . $row["size"] . "</td>" .
                    "<td>" . $row["price"] . "</td>" .
                    "<td>" . $row["description"] . "</td>" .
                    "</tr>";
            }
        }

        $conn->close();
        ?>
    </table>
    <div class="removeOrder">
        <form action="viewOrders.php" method="post">
            <p><b>Remove Order (ID): </b><input class="input" type="text" name="ordNum">
                <input class="button" type="submit" value="Remove"></p>
        </form>
    </div>
</div>
            <?php
        }
?>
</body>
</html>