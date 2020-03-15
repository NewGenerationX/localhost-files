<?php

     include("db.php");     

/*  if($connection) {
    
        echo "Yes it is";

    } */


     $search = $_POST['search'];

     if(!empty($search)) {

          $query = "SELECT * FROM cars WHERE cars LIKE '%$search%' ";
          $search_query = mysqli_query($connection,$query);
          $count = mysqli_num_rows($search_query);


          if(!$search_query){
          die('QUERY FAILED' . mysqli_error($connection));
          }

          if($count >= 1){

          while($row = mysqli_fetch_array($search_query)) {

               $cars = $row['cars'];

               ?>

     <ul class="list-unstyled">

          <?php

               echo "<li>{$cars} in stock</li>";

          ?>

     </ul>


<?php     }   

     } else {

          echo "Sorry, we dont have that car available";

     }

}


?>
