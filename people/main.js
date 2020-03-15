$(document).ready(function() {
// Global variables
var jsNameBtn;

var $selectId;
var $selectName;
var $peopleInfo;
var $jsBtn;
var $nameLabel;
var $idLabel;
var $addBtn;
var $addPersonBtn;
var $nameInput;
var $birthDateInput;
var $addressInput;
var $jobInput;
var $infoInput;
var $closeBtn;
var $searched;
var $addBtnLabelAndBr;

    //sets values from the global variables
    function variables() {

        jsNameBtn = "js-name-btn";

        $selectId = $("#select-id");
        $selectName = $("#select-name");
        $peopleInfo = $(".people-info");
        $jsBtn = $("#js-btn");
        $nameLabel = $('#name-label');
        $idLabel = $('#id-label');
        $addBtn = $("#add-btn");
        $addPersonBtn = $("#add-person-btn");
        $nameInput = $("#name-input");
        $birthDateInput = $("#birth-date-input");
        $addressInput = $("#address-input");
        $jobInput = $("#job-input");
        $infoInput = $(".info-input");
        $closeBtn = $("#close-btn");
        $searched = $("#searched");
        $addBtnLabelAndBr = $(".labelAndBr--add-btn");

    }

    variables();

    // will display names and other info on the screen
    function updatePeople() {

        $.ajax({
            type: 'POST',
            url: 'display_people.php',
            success: function(show_info) {
                
                $peopleInfo.html(show_info);

            }
        });
    }; //end of updateInfo function

    function UpdateId(){

        $.ajax({
            type: 'POST',
            url: "id's for selector.php",
            success: function(data) {

                $selectId.html(data);

            }
        });

    };

    // Updates the function displaying people on screen, and the id's in id selector
    function updateInfo(){

        updatePeople()
        UpdateId();

    };

    updateInfo();

    /* the button will switch users from searching by name and by id and the other way around */
    $jsBtn.click(function() {

        //switches id and name search
        $selectName.toggleClass("hide");
        $selectId.toggleClass("hide");

        //switches the labels for id and name
        $nameLabel.toggleClass("hide");
        $idLabel.toggleClass("hide");

        updateInfo();


        if($jsBtn.hasClass(jsNameBtn)) {
            $jsBtn.removeClass(jsNameBtn).val("click here to search by name");
        } else {
            $jsBtn.addClass(jsNameBtn).val("click here to select by id");
        }
    }); // end of js-btn click function

    // searches for matching names on key pressed
    $selectName.keyup(function() {

        var nameValue = $(this).val();

        var searchByName = "search by name";

        $.ajax({
            type: 'POST',
            url: 'search_people.php',
            data: {value:nameValue, searchByName:searchByName},
            success: function(data) {

                $searched.html(data);

            }
        });


    });// end of #select-name keyup function

/* when pressing on add-btn, 4 new inputs will show up, and 2 new buttons, while the old button will hide,
** but when pressing close, the inputs will close, buttons dissapear, and add-btn will show up again
*/    
function addPerson(e) {

    e.preventDefault();
    $(".info-input, .info-btn").toggleClass("hide");

}
    // will go to addPerson and add 4 inputs and 2 new buttons
    // while hiding add button, and it will hide the label on top of it
    $addBtn.click(function(e){

        addPerson(e);
        $addBtnLabelAndBr.addClass("hide");

    });

    // will send a ajax request to a php folder that will add that data to the server
    $addPersonBtn.click(function(e){

        // takes values out of input fields that will be sent with ajax
        var name = $nameInput.val();
        var birthDate = $birthDateInput.val();
        var address = $addressInput.val();
        var job = $jobInput.val();
                
        e.preventDefault();

        
        // if no inputs are empty, will send a ajax request, else alert that there is an empty field
        if(name.length >= 1 && birthDate.length >= 1 && address.length >= 1 && job.length >= 1) {

        $.ajax({
            type: 'POST',
            url: 'add_ppl.php',
            data: {name:name, birthDate:birthDate, address:address, job:job},
            success: function(){

                $infoInput.val('');
                updateInfo();

            }
        });
        } else {
            alert("you left an empty input, please fill it up!")
        }
    });

    // will go to addPerson and remove 4 inputs and 2 buttons
    //  and show add-btn, and it will show the label on top of it
    $closeBtn.click(function(e){

        addPerson(e);
        $infoInput.val('');
        $addBtnLabelAndBr.removeClass("hide");


    });

});