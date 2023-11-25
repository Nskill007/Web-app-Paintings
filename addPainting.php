<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="order.css">
    <title>Add Paintings</title>
</head>
<body>
     <?php

     $allowTypes = array('jpg','png','jpeg','gif');
     $fileUse = false;

     function validateDate($date, $format = 'Y-m-d')
     {
         $d = DateTime::createFromFormat($format, $date);
         return $d && $d->format($format) === $date;
     }

     $painting_name = strip_tags(isset($_POST["name"])) && ($_POST["name"] !== "") ? $_POST["name"] : "";
     $width = strip_tags(isset($_POST["width"])) && ($_POST["width"] !== "") && is_numeric($_POST["width"]) ? $_POST["width"] : 0;
     $height = strip_tags(isset($_POST["height"])) && ($_POST["height"] !== "") && is_numeric($_POST["height"]) ? $_POST["height"] : 0;
     $price = strip_tags(isset($_POST["price"])) && ($_POST["price"] !== "") && is_numeric($_POST["price"]) ? $_POST["price"] : 0;
     $description = strip_tags(isset($_POST["description"])) && ($_POST["description"] !== "") ? $_POST["description"] : "";
     $isDate = strip_tags(isset($_POST["dateOfCompletion"])) && ($_POST["dateOfCompletion"] !== "") && validateDate($_POST["dateOfCompletion"]);
     $filename = strip_tags(isset($_FILES["img_uploaded"]["name"])) && ($_FILES["img_uploaded"]["name"] !== "") ? $_FILES["img_uploaded"]["name"] : "";
     if($filename){
         $fileType = pathinfo($filename, PATHINFO_EXTENSION);
        if(in_array($fileType, $allowTypes)) {
            $tempImage = $_FILES['img_uploaded']['tmp_name'];
            $imgContent = addslashes(file_get_contents($tempImage));
            $fileUse = true;
        }
     }

     if($painting_name && $width && $height && $price && $description && $isDate && $fileUse){

         echo "<div class='successMessage'><p>You have successfully added a painting</p>";
         echo "<p class='homepage'><a href='admin.php'>Return to the admin page</p></div>";

         $date = $_POST["dateOfCompletion"];

         $host = "devweb2022.cis.strath.ac.uk";
         $user = "njb20143";
         $pass = "keTei0aiL1ku";
         $dbname = $user;
         $conn = new mysqli($host, $user, $pass, $dbname);

         if($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }


         $sql2 = "INSERT INTO `paintingsInfo` (`ID`, `painting_name`, `date_of_completion`, `width (mm)`, `height (mm)`, `price (£)`, `decription`, `picture`)
                    VALUES (NULL, '$painting_name', '$date', '$width', '$height', '$price', '$description', '$imgContent')";

         if($conn->query($sql2)){
         } else {
             die ("query failed " . $conn->error);
         }
     }
    else{?>
    <div class="center">
         <h1>Add Painting: </h1>
         <form action="addPainting.php" method="post" enctype="multipart/form-data">
             <div class="text_field">
                 <input type="text" name="name" required>
                 <span></span>
                 <label>Name</label>
             </div>
             <div class="text_field">
                 <input type="text" name="width" required>
                 <span></span>
                 <label>Width (mm)</label>
             </div>
             <div class="text_field">
                 <input type="text" name="height" required>
                 <span></span>
                 <label>Height (mm)</label>
             </div>
             <div class="text_field">
                 <input type="text" name="price" required>
                 <span></span>
                 <label>Price (£)</label>
             </div>
             <div class="text_field">
                 <input type="text" name="description" required>
                 <span></span>
                 <label>Decription</label>
             </div>
             <div>
                 <label>Date of completion</label>
                 <input type="date" name="dateOfCompletion" required>
             </div> <br>
             <div>
                 <label>Pick Image</label>
                 <input type="file" name="img_uploaded" required>
             </div>
             <p><input type="submit" value="Add"></p>
         <?php
    }
    ?>
        </form>
    </div>
</body>
</html>