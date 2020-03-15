<?php

include('db.php');

    $query = "SELECT * FROM people";
    $query_people_info = mysqli_query($connection ,$query);

    if(!$query_people_info) {

        die("QUERY FAIL" . mysqli_error($connection));

    }

    echo "<tr><th>id</th><th></th><th>name</th><th></th><th>birth_date</th><th></th><th>address</th><th></th><th>job</th></tr>";
    while($row = mysqli_fetch_array($query_people_info)){

        echo "<tr>";

            echo "<td class='id' id='".$row['id']."'>{$row['id']}</td>";

            echo "<td>&nbsp;&nbsp;</td>";

            echo "<td class='name'>{$row['name']}</td>";

            echo "<td>&nbsp;&nbsp;</td>";

            echo "<td class='birth-date'>{$row['birth_date']}</td>";

            echo "<td>&nbsp;&nbsp;</td>";

            echo "<td class='address'>{$row['address']}</td>";

            echo "<td>&nbsp;&nbsp;</td>";
            
            echo "<td class='job'>{$row['job']}</td>";


            echo "<td><button class='edit-btn'>click to edit</button></td>";
            echo "<td class='btn-parents hide submit-btn'><button class='green display-inline-block'>Submit</button></td>";
            echo "<td class='btn-parents hide'><button class='red display-inline-block cancel-submit-btn'>Cancel</button></td>";
            
            echo "<td class='right js-delete'><div class='css-delete'><div class='rotate'>+</div></div></td>";

        echo "</tr>";
    }

?>


<script>
    $(document).ready(function() {

        // defined in edit btn function but used in cancel function too
        var id;
        var name;
        var birthDate;
        var address;
        var job;

        var $btnParent;
        var $id;
        var $name;
        var $birthDate;
        var $address;
        var $job;
        var $cancelAndSubmitBtn;
        var $form;

        var $Parent;

        /************** Changes info into edit mode **************/
        $(".edit-btn").click(function(){

            //looks for a sibling of parent of the parent of the edit btn and checks if it has the class "clicked"
            $clicked = $(this).parent().parent().siblings().hasClass("clicked");

            /* cancels edit on previous row you pressed edit on in case you press
            ** edit on 2 or more rows, only one can be in edit mode at a time
            */
            if($clicked) {

                cancelEdit();

            };

            // btnParent selects the parent element to the button, and the rest of the variables select an individual sibling
            $btnParent = $(this).parent();           
            $id = $btnParent.siblings(".id");
            $name = $btnParent.siblings(".name");
            $birthDate = $btnParent.siblings(".birth-date");
            $address = $btnParent.siblings(".address");
            $job = $btnParent.siblings(".job");
            $cancelAndSubmitBtn = $btnParent.siblings(".btn-parents");

            //parent of btnParent
            $Parent = $btnParent.parent();

            // takes values of selected siblings
            id = $id.text();
            name = $name.text();
            birthDate = $birthDate.text();
            address = $address.text();
            job = $job.text();

            //leads to hideBtnParent function
            hideBtnParent();

            var inpName = "name";
            var inpNameBirth = "birth date";
            var inpNameAddress = "address";
            var inpNameJob = "job";

            //leads to change function

                change($name, inpName, name);
                change($birthDate, inpNameBirth, birthDate);
                change($address, inpNameAddress, address);
                change($job, inpNameJob ,job);

            showSubmitAndCancelBtn();
            addClickedClass();

        }); //end of edit-btn click function

        //hides edit botton and td it is when clicked and
        function hideBtnParent() {

            $btnParent.addClass("hide");

        };

        //shows Submit and Cancel button
        function showSubmitAndCancelBtn() {

            $($cancelAndSubmitBtn).removeClass("hide").addClass("display-inline-block");

        }

        /* adds clicked class to parent element of all of the "<td>"s which we will
        ** later use to make sure there is only 1 row in edit mode at a time
        */ 
        function addClickedClass() {

            $($Parent).addClass("clicked");

        }

        //changes info like name for example: "Danijel" to input tag with value of "Danijel"
        function change(element,inpClass, value) {

            $(element).html("<input type='text' placeholder='name' class='" + inpClass + "' value='" + value +"'>");

        }

        /********* Changes info out of edit mode without submitting the changes *********/
        $(".cancel-submit-btn").click(function() {

            cancelEdit();

        });

        // returns back from edit function
        function cancelEdit() {



            toInfoState($name, name);
            toInfoState($birthDate, birthDate);
            toInfoState($address, address);
            toInfoState($job, job);

            hideSubmitAndCancelBtn();
            showBtnParent();
            removeClickedClass();

        }

        function endForm() {

            

        }

        // returns inputs to text
        function toInfoState(element, value) {

            $(element).text(value);

        }

        // hides submit and cancel button
        function hideSubmitAndCancelBtn(){

            $($cancelAndSubmitBtn).removeClass("display-inline-block").addClass("hide");

        }

        // shows button parent
        function showBtnParent() {

            $btnParent.removeClass("hide");

        }

        // removes the clicked class from '<tr>'s
        function removeClickedClass() {

            $($Parent).removeClass("clicked");

        }

        // removes a table from the database
        $(".js-delete").click(function() {

            var $newId = $(this).siblings(".id");
            var newId = $newId.text();

            var $remove = $(this).parent();

            $.ajax({
                type: 'POST',
                url: 'delete.php',
                data: {id:newId},
                success: function(){

                    $($remove).addClass("hide");

                } 
            });

        });

        // submits changes made to the info
            $(".submit-btn").click(function() {
            
            var $submitNameTd = $(this).siblings(".name");
            var $submitBirthDateTd = $(this).siblings(".birth-date");
            var $submitAddressTd = $(this).siblings(".address");
            var $submitJobTd = $(this).siblings(".job");

            var $submitNameInput = $submitNameTd.children();
            var $submitBirthDateInput = $submitBirthDateTd.children();
            var $submitAddressInput = $submitAddressTd.children();
            var $submitJobInput = $submitJobTd.children();

            var submitNameValue = $submitNameInput.val();
            var submitBirthDateValue = $submitBirthDateInput.val();
            var submitAddressValue = $submitAddressInput.val();
            var submitJobValue = $submitJobInput.val();

            //checks if the user left an empty field anywhere
            if(submitNameValue.length > 0 && submitBirthDateValue.length > 0 && submitAddressValue.length > 0 && submitJobValue.length > 0) {

                //checks to see if any values have been changed, and if yes, uploads them to the server
                if(submitNameValue === name && submitBirthDateValue === birthDate && submitAddressValue === address && submitJobValue === job) {

                cancelEdit();

                } else {
                
                submitChanges(submitNameValue, submitBirthDateValue, submitAddressValue, submitJobValue);

                }
            } else {

                alert("you left an empty string");

            }
        });// end of submit btn on click event


        // submits changes to the server trough a php file
        function submitChanges(nameVal, birthDateVal, addressVal, jobVal) {

            var update = 'update';

            $.ajax({
                type: 'POST',
                url: 'submit_changes.php',
                data: {name:nameVal, birthDate:birthDateVal, address:addressVal, job:jobVal, id:id, update:update},
                success: function() {

                    cancelEdit();

                    $name.text(nameVal);
                    $birthDate.text(birthDateVal);
                    $address.text(addressVal);
                    $job.text(jobVal);

                }
            });
        };// end of submitChanges function

        

    });

</script>