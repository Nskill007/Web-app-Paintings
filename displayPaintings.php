<?php

header("Content-Type: text/html");
$post_result = json_decode(stripslashes((file_get_contents('php://input'))));

$currPageNum = $post_result->currPageNum;


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
$paintingNum = $result->num_rows;
$paintingsPerPage = 12;



for ($start = 1; $start <= ($currPageNum*$paintingsPerPage); $start++) {
    if($start < $paintingNum) {
        $row = $result->fetch_assoc();
    }
}

for ($k = 1; $k <= 12; $k++) {
    if($k <= ($paintingNum - $currPageNum*12)) {
        $row = $result->fetch_assoc();?>
        <div class="grid-item">
        <form action="order.php" method="post">
            <?php
            echo "<p>" . '<img class="image" alt="painting" src="data:image/jpeg;base64,'.base64_encode($row['picture']).'"/>' . "</p>" .
                "<p style='text-align: center'><b>" . $row["painting_name"] . "</b><br></p>" .
                '<p class="details"><b>Date of completion:</b> ' . $row["date_of_completion"] . "<br>" .
                "<b>Width (mm):</b> " .$row["width (mm)"] . "<br>" .
                "<b>Height (mm):</b> " .$row["height (mm)"] . "<br>" .
                "<b>Price:</b> £" .$row["price (£)"] . "<br>" .
                "<b>Decription:</b> " .$row["decription"] . "</p>";
            ?>
            <input type="hidden" name="id" value="<?php echo $row["ID"]?>">
            <button class="order-button" type="submit">Order</button></p>
        </form>
        </div>
        <?php
    }
}
$conn->close();
?>
