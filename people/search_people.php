<?php

    include('db.php');

    $search = $_POST['value'];

    if(!empty($search)){
        
        if(isset($_POST['searchByName'])){

            $query = "SELECT * FROM people WHERE name LIKE '$search%' ";
            $search_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($search_query);

            if(!$search_query) {

                die("QUERY FAIL" . mysqli_error($connection));

            }
        }

        if(isset($_POST['searchById'])){

            $query = "SELECT * FROM people WHERE id = $search ";
            $search_query = mysqli_query($connection, $query);
            $count = 2;

            if(!$search_query) {

                die("QUERY FAIl" . mysqli_error($connection));

            }

        }


    if($count >= 1) {

        while($row = mysqli_fetch_array($search_query)) {

            $name = $row['name'];
            $id = $row['id'];

            ?> 

    <ul>

        <?php

            echo "<li><a rel=".$id." class='displayed-name' href='javascript:void(0)'>{$name}</a></li>";

        ?>

    </ul>

<?php
            }

        }
    
    }

?>


<script>

$(document).ready(function() {

    var id;

    $(".displayed-name").click(function() {

        id = $(this).attr('rel');

        find()

    });

    function find() {

        var $objectChild = $("#"+ id);
        var $object = $objectChild.parent();

        show($object);

    }

    function show($object) {
        
        $object.addClass("transparent-red");
        Timer($object);

    }

    function Timer($object) {

        setTimeout(function(){

            hideColour($object);
        
        }, 1750);

        function hideColour($object) {

            $object.removeClass("transparent-red");

        }

    }
});

</script>