$(".send-signup").click(signup);

function signup() {
    let username = $("#username").val();
    let password = $("#password").val();
    let confPassword = $("#confPassword").val();

    //check user only letters and numbers
    if (!/^[a-zA-Z0-9]+$/.test(username)) {
        $("#error").html("Username must contain only letters and numbers");
        $("#error").css("display", "block");
        return;
    }

    if (password != confPassword) {
        $("#error").html("Passwords do not match");
        $("#error").css("display", "block");
        return;
    }

    if (password.length < 8) {
        $("#error").html("Password must be at least 8 characters long");
        $("#error").css("display", "block");
        return;
    }

    $.ajax({
        url: "../back/signup_manager.php",
        type: "POST",
        data: {
            username: username,
            password: password,
            confPassword: confPassword
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
            }
        }
    });
}