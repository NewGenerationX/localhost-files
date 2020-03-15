$(document).ready(function() {

    $("#search").keyup(function() {

        var search = $('#search').val();

        /* alert($search); */

        $.ajax({
            type: 'POST',
            url: 'search.php',
            data:{search:search},
            success: function(data){

                if(!data.error) {

                    $('#result').html(data);
                }

            }
        }); // end of ajax 'POST' request


    }); // end of .keyup function

     $("#add-car-form").submit(function(e){

        e.preventDefault();

        var postData = $(this).serialize();

        var url = $(this).attr('action');

        $.post(url, postData, function(php_table_data){


            $("#car-result").html(php_table_data);

            $(".form-control").val('');
        });

    }); // add car code end


    setInterval(function(){

        updateCars();


    }, 1000);


    $("#action-container").hide();


    /*
    **update cars table display with time 
    */
    function updateCars() {

    $.ajax({

        type: "POST",
        url: 'display_cars.php',
        success: function(show_cars){

            if(!show_cars.error){

                $("#show-cars").html(show_cars);

            }

        }
    });

        }

}); 