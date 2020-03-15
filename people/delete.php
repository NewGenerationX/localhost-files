<?php

    include('db.php');

    $id = mysqli_real_escape_string($connection, $_POST['id']);

    $id = $_POST['id'];

    $query = "DELETE FROM people WHERE id = $id ";

    $result_set = mysqli_query($connection, $query);

    if(!$result_set) {

        die("QUERY FAIL" . mysqli_error($connection));

    }


?>