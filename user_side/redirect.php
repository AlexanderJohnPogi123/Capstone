<?php

if(isset($_GET['property'])){

    $property = $_GET['property'];

    header("Location: ../user_side/" . $property);
    exit();

}

header("Location: /index.php");

?>