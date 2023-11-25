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

    $paintingNum = $result->num_rows;
    $paintingsPerPage = 12;
    $maxPageCount=floor(($result->num_rows)/$paintingsPerPage);

    $conn->close();
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <title>Homepage</title>
</head>
<body>
<script>
    function displayPaintings(){
        let currPageNum = document.getElementById("pageNumber").getAttribute("value");
        const pictures = document.getElementById("pictures");
        const pageLimit = document.getElementById("pageLimit");

        fetch("displayPaintings.php", {
            headers:{
                'Content-type': 'text/html'
            },
            method: "POST",
            body: JSON.stringify({"currPageNum":currPageNum})
        })
        .then(resp => {
            if(resp.status !== 200) {
                alert("Something went wrong!");
            }
            else
                return resp.text();
        })
        .then(text => {
                pictures.innerHTML = text.toString();
            })
        .catch(error => {
                alert(error);
            })
        if(currPageNum - 1 < 0)
            document.getElementById("back").disabled = true;
        else
            document.getElementById("back").disabled = false;
        if(currPageNum + 1 > pageLimit.getAttribute("value"))
            document.getElementById("next").disabled = true;
        else
            document.getElementById("next").disabled = false;
        }

    function prevPage(){
        const pageNum = document.getElementById("pageNumber");
        let prevPageNum = parseInt(pageNum.getAttribute("value")) - 1;
        pageNum.setAttribute("value", prevPageNum.toString());
        displayPaintings();
    }

    function nextPage(){
        const pageNum = document.getElementById("pageNumber");
        let prevPageNum = parseInt(pageNum.getAttribute("value")) + 1;
        pageNum.setAttribute("value", prevPageNum.toString());
        displayPaintings();
    }
</script>
<header>Cara's Paintings</header>
<div id = "pictures" class="grid-container"> </div>
<div>
    <input type="hidden" id="pageLimit" value="<?php echo $maxPageCount?>">
    <input type="hidden" id="pageNumber" value="0">
    <div class="end">
        <button class="page-buttons" id="back" onclick="prevPage()">< Previous</button>
    <button class="page-buttons" id="next" onclick="nextPage()">Next ></button>
    </div>
</div>
<script>
    window.addEventListener("load", displayPaintings);
</script>
</body>
</html>