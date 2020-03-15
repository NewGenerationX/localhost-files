<?php

include('db.php');

    if(isset($_POST['id'])) {

    $id =   mysqli_real_escape_string($connection, $_POST['id']);

    $query = "SELECT * FROM cars WHERE id = {$id}";
    $query_car_info = mysqli_query($connection ,$query);

    if(!$query_car_info) {

        die("Query Failed" . mysqli_error($connection));

    }


    while($row = mysqli_fetch_array($query_car_info)) {

        
        echo "<p id='feedback' class='bg-success'></p>";
        echo "<input rel=".$row['id']." type='text' class='form-control car_id' value=".$row['cars'].">";
        echo "<input type='button' class='btn btn-success update' value='Update'>";
        echo "<input type='button' class='btn btn-danger delete' value='Delete'>";
        echo "<input type='button' class='btn remove' value='Close'> ";
        

        
    }

}

/************** Updating function ***************/

if(isset($_POST['updatethis'])) {

    $id =   mysqli_real_escape_string($connection, $_POST['id']);
    $tittle =   mysqli_real_escape_string($connection, $_POST['title']);

    $id = $_POST['id'];
    $title = $_POST['title'];

    $query = "UPDATE cars SET cars = '$title' WHERE id = $id "; 

    $result_set = mysqli_query($connection, $query);

    if(!$result_set){

        die("QUERY FAIL" . mysqli_error($connection));

    }

}

/************** Deleting function ***************/

if(isset($_POST['deletethis'])) {

    $id = mysqli_real_escape_string($connection, $_POST['id']);

    $id = $_POST['id'];

    $query = "DELETE FROM cars WHERE id = $id ";

    $result_set = mysqli_query($connection, $query);

    if(!$result_set) {

        die("QUERY FAIL" . mysqli_error($connection));

    }

}


?>



<script>
$(document).ready(function() {

    var id;
    var title;
    var updatethis = "update";
    var deletethis = "delete";

/**************Extract id and title ***************/

    $(".car_id").on('input', function() {

        id = $(this).attr('rel');
        title = $(this).val();


        

/************** Update button functionality ***************/

        

        });


        $(".update").click(function(){
            
          $.ajax({
                type: 'POST',
                url: 'process.php',
                data: {id: id, title: title, updatethis: updatethis},
                success: function(data) {
                    
                    $("#feedback").text("Record Updated Successfully");

                }
            });


    }); // end of update function

/************** Delete button functionality ***************/

    $(".delete").click(function() {

        id = $(".car_id").attr('rel');

        $.ajax({
            type: "POST",
            url: "process.php",
            data: {id: id, deletethis: deletethis},
            success: function(){

                $("#action-container").hide();

            }
        });


    }); // end of delete function 

/************** Remove button functionality ***************/

    $(".remove").click(function(){

        $("#action-container").hide();

    });


});
</script>