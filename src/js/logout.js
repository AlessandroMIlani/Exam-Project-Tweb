// logout

$(".send-logout").click(logout);

function logout() {
    $.ajax({
        url: "back/logout_manager.php",
        type: "POST",
        success: function (data) {
                window.location.href = "index.php";
    }
});
}