<?php

include('db.php');

$query = "SELECT * FROM people";
$query_people_info = mysqli_query($connection, $query);

    echo "<option value='none'>none</option>";
while($row = mysqli_fetch_array($query_people_info)) {

    $id = $row['id'];

    echo "<option value='{$id}' class='id-option'>{$id}</option>";

}

?>



<script>
    $(document).ready(function(){
        var id;
        $("#select-id").change(function() {

            id = $(this).val();
            var searchById = "search by id";

            $.ajax({
                type: 'POST',
                url: 'search_people.php',
                data: {value:id, searchById:searchById},
                success: function(data){

                    $("#searched").html(data);

                }
            });

        });

    });


</script>