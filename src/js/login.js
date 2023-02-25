//check login
$(document).ready(function () {
    $("#send-login").on("click", checkLogin);
});

function checkLogin() {
    let username = $("#username").val();
    let password = $("#password").val();

    $.ajax({
        url: "/back/login_manager.php",
        type: "POST",
        data: {
            username: username,
            password: password
        },
        dataType: "json",
        success: function (data) {
            switch (data.status) {
                case "success":
                    window.location.href = "/index.php";
                    break;
                case "error":
                    $("#error").html(data.message);
                    // change style of
                    $("#error").css("display", "block");
                    break;
            }
        },
        error: function (e) {
            console.log(e.message + " " + e.status);
            $("#error").html(e.message + " " + e.status);
            // change style of
            $("#error").css("display", "block");
        }
    });
}