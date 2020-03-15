<?php

include('db.php');

$query = "SELECT * FROM cars";
    $query_car_info = mysqli_query($connection ,$query);

    if(!$query_car_info) {

        die("Query Failed" . mysqli_error($connection));

    }


    while($row = mysqli_fetch_array($query_car_info)) {

        echo "<tr>";

        echo "<td>{$row['id']}</td>";
        echo "<td><a rel='".$row['id']."' class='title-link' href='javascript:void(0)'>{$row['cars']}</a></td>";

        echo "</tr>";

    }


?>


<script>
$(document).ready(function() {

    $(".title-link").click(function() {

        $("#action-container").show();

        var id = $(this).attr("rel");

        $.ajax({
            type: 'POST',
            url: 'process.php',
            data: {id:id},
            success: function(data) {

                $("#action-container").html(data);

            }
        });

    });

});
</script>