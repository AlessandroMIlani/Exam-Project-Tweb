$(document).ready(function () {

    $("#load-distro-data").on("click", loadDistroData);
    $("#edit").on("click", saveDistroData);

}
);

function loadDistroData() {
    if ($("#distros").val() == "Distro to Edit") {
        return;
    }
    $("#data-form").empty();
    $.ajax({
        url: "/back/admin_manager.php",
        type: "POST",
        data: {
            action: "loadDistroData",
            distro: $("#distros").val()
        },
        dataType: "json",
        success: function (data) {
            switch (data[0].status) {
                case "success":
                    // load data in form
                    dis = data[0].name;
                    // to lower case and replace spaces with dashes
                    dis = dis.toLowerCase().replace(" ", "");
                    img = "img/distro/" + dis + "/" + dis + ".png";
                    // if img not found, use default
                    if (!$.ajax({ url: img, type: 'HEAD', async: false }).status == 200) {
                        img = "img/extra_logo/generic_logo.png";
                    }

                    for (var field in data[0]) {
                        switch (field) {
                            case "status":
                                html="";
                                break;
                            case "name":
                                html = `
                                <img src="${img}" class="img-fluid" height="100" alt="Responsive image">
                                <div class="spacer"></div>
                                <div class="from-group col">
                                <label for="distro-${field}" class="form-label">${field}</label>
                                <input type="text" class="form-control-plaintext" id="distro-${field}" value="${data[0][field]}">
                                </div>`;
                                break;
                            case "desc":
                                html = `
                                <div class="from-group col">
                                <label for="distro-name" class="form-label">${field}</label>
                                <textarea class="form-control" id="distro-desc" rows="4" >${data[0][field]}</textarea>
                                </div>`;
                                break;
                            default:
                                html = `
                                <div class="from-group col">
                                <label for="distro-${field}" class="form-label">${field}</label>
                                <input type="text" class="form-control" id="distro-${field}" value="${data[0][field]}">
                                </div>`;
                                break;
                        }
                        $("#data-form").append(html);
                    }
                    $("#data-form").append(`<div class="spacer"></div>`);
                    button = document.createElement("button");
                    button.id = "edit";
                    $(button).addClass("btn btn-primary");
                    button.innerHTML = "edit";
                    button.onclick = saveDistroData;
                    $("#data-form").append(button);
                    break;
                case "error":
                    $("#error").text("Error loading distro data");
                    $("#error").addClass("alert-danger");
                    $("#error").removeClass("alert-success");
                    $("#error").css("display", "block");
                    break;
            }
        },
        error: function (e) {
            console.log(e.message + " " + e.status);
        }
    });
}

function saveDistroData() {
    // create json
    var distro = [
        {
            name: $("#distro-name").val(), based: $("#distro-based").val(),
            region: $("#distro-region").val(), arch: $("#distro-arch").val(),
            desc: $("#distro-desc").val(), web: $("#distro-web").val(),
            version: $("#distro-version").val()
        }
    ]

    $.ajax({
        url: "/back/admin_manager.php",
        type: "POST",
        data: {
            action: "saveDistroData",
            data: distro[0]
        },
        dataType: "json",
        success: function (data) {
            // load data in form
            if (data.status == "success") {
                $("#error").text(data.message);
                $("#error").removeClass("alert-danger");
                $("#error").addClass("alert-success");
                $("#error").css("display", "block");
            } else {
                $("#error").text(data.message);
                $("#error").addClass("alert-danger");
                $("#error").removeClass("alert-success");
                $("#error").css("display", "block");
            }
        },
        error: function (e) {
            console.log(e.message + " " + e.status);
        }
    });

}
