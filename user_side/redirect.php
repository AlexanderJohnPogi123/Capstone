<?php

if(isset($_GET['property'])){

    $property = $_GET['property'];

    header("Location: " . $property);
    exit();

}

header("Location: index.php");

?>