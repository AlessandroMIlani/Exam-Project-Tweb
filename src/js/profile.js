$(document).ready(function () {
    $('#cancel').on("click", reset);
    $("#save").on("click", save);
});


function save() {
    //check password 8 char and same
    let pswd1 = $('#pswd1').val();
    let pswd2 = $('#pswd2').val();
    let url = $('#url').val();

    if((pswd1 == "" && pswd2 != "") || (pswd1 != "" && pswd2 == "")){
        //show messag on div with id "error"
        remove_class()
        $('#error').addClass("alert-danger");
        $('#error').html("complete both password fields");
        $('#error').css("display", "block");
        return;
    }


    if(pswd1 != "" && pswd2 != ""){
        if (pswd1.length < 8) {
            //show messag on div with id "error"
            remove_class()
            $('#error').addClass("alert-danger");
            $('#error').html("password must be at least 8 characters");
            $('#error').css("display", "block");
            return;
        }
        if (pswd1 != pswd2) {
            //show messag on div with id "error"
            remove_class()
            $('#error').addClass("alert-danger");
            $('#error').html("passwords are not the same");
            $('#error').css("display", "block");
            return;
        }

        $.ajax({
            url: "/back/profile_manager.php",
            type: "POST",
            data: {
                action: "changePswd",
                pswd1: pswd1,
                pswd2: pswd2

            },
            dataType: "json",
            success: function (data) {
                switch (data.status) {
                    case "success":
                        //show messag on div with id "error"
                        remove_class()
                        $('#error').addClass("alert-success");
                        $('#error').html(data.message);
                        $('#error').css("display", "block");
                        break;
                    case "error":
                        //show messag on div with id "error"
                        remove_class()
                        $('#error').addClass("alert-danger");
                        $('#error').html(data.message);
                        $('#error').css("display", "block");
                        break;
                }
            }
        });
    }

    if(!url == ""){
        // check url sintax with or without www
        var urlregex = new RegExp("^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})");
        if (!urlregex.test(url)) {
            //show messag on div with id "error"
            remove_class()
            $('#error').addClass("alert-danger");
            $('#error').html("url syntax not valid");
            $('#error').css("display", "block");
            return;
        }
        // check url ajax
        var response = jQuery.ajax({
            url: url,
            type: 'HEAD',
            async: false
        }).status;	
        if (response != 200) {
            //show messag on div with id "error"
            remove_class()
            $('#error').addClass("alert-danger");
            $('#error').html("url not found");
            $('#error').css("display", "block");
            return;
        }else{ $.ajax({
            url: "/back/profile_manager.php",
            type: "POST",
            data: {
                action: "changeUrl",
                url: url
            },
            dataType: "json",
            success: function (data) {
                switch (data.status) {
                    case "success":
                        //show messag on div with id "error"
                        remove_class()
                        $('#error').addClass("alert-success");
                        $('#error').html(data.message);
                        $('#error').css("display", "block");
                        break;
                    case "error":
                        //show messag on div with id "error"
                        remove_class()
                        $('#error').addClass("alert-danger");
                        $('#error').html(data.message);
                        $('#error').css("display", "block");
                        break;
                }
            }
        });
        }
    }
        

}


function reset() {
    // svuoto i campi
    $('#pswd1').val("");
    $('#pswd2').val("");
    $('#url').val("");

    //show messag on div with id "error"
    remove_class();
    $('#error').addClass("alert-info");
    $('#error').html("input fields cleared");
    $('#error').css("display", "block");

}

function remove_class(){
    $('#error').removeClass("alert-danger");
    $('#error').removeClass("alert-success");
    $('#error').removeClass("alert-info");
//
}