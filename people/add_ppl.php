<?php

    include('db.php');

    if(isset($_POST['job'])){
    $name = $_POST['name'];
    $birth_date = $_POST['birthDate'];
    $address = $_POST['address'];
    $job = $_POST['job'];
    $query = "INSERT INTO people(name, birth_date, address, job) VALUES ('$name', '$birth_date', '$address', '$job')";
    $query_add_people = mysqli_query($connection, $query);
    
    if(!$query_add_people) {

        die("QUERY FAIL" . mysqli_error($connection));

    }

}

?>