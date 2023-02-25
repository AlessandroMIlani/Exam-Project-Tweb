// when document is ready 
$(document).ready(function () {
    $('.add-fav-button').on("click", addToFav);
    $("#start-search").on("click", search);
});

function addToFav() {
    // add distro to fav
    let distro = $(this).attr("id");
    $.ajax({
        url: "/back/finder_manager.php",
        type: "POST",
        data: {
            action: "addFav",
            distro: distro
        },
        dataType: "json",
        success: function (data) {
            switch (data.status) {
                case "present":
                    $("#"+distro).removeClass("btn-outline-primary");
                    $("#"+distro).addClass("btn-outline-info");
                    break;
                case "success":
                    // added to fav
                    $("#"+distro).removeClass("btn-outline-primary");
                    $("#"+distro).addClass("btn-outline-success");
                    break;
                case "error":
                    // error
                    $("#"+distro).removeClass("btn-outline-primary");
                    $("#"+distro).addClass("btn-outline-danger");
                    break;
            }
        }
    });
}

function search() {
    // get value of input
    let base = $("#base").val();
    let region = $("#region").val();
    let name = $("#name").val();

    if (base == "Distro Base")
        base = "";
    if (region == "Distro Region")
        region = "";
    if (name == "Distro Name")
        name = "";

    // call database
    $.ajax({
        url: "/back/finder_manager.php",
        type: "POST",
        data: {
            action: "getDistro",
            base: base,
            region: region,
            name: name
        },
        dataType: "json",
        success: function (data) {

            // remove all card
            $("#res-dx").empty();
            $("#res-sx").empty();
            $("#res-cx").empty();

            if (data.length != 0) {
                $(".remove").css("display", "none");
            } else {
                $(".remove").css("display", "block");
            }

            for (let i = 0; i < data.length; i++) {
                let name = data[i].name.toLowerCase().replace(" ", "");
                img = '../img/distro/' + name + '/' + name + '-small.png';
                //chec if image exist with ajax

                var response = jQuery.ajax({
                    url: img,
                    type: 'HEAD',
                    async: false
                }).status;	
                if (response == 404) {
                    img = '../img/distro/default.png';
                }

                // card icon button add to favorite
                card = `<div class="card mb-3 mx-auto distro-card">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img  src="${img}" class="img-fluid rounded-start" alt="Info Distro ${data[i].name}">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">${data[i].name}</h5>
                        <div class="spacer"></div>
                        <ul>
                            <li>Base: ${data[i].based}</li>
                            <li>Region: ${data[i].region}</li>
                            <li>Architecture: ${data[i].arch}</li>
                        </ul>
                        <div class="row">
                            <div class="col">
                                <a href="/linux.php?distro=${data[i].name.replace(" ", "_")}" class="btn btn-primary">More Info</a>
                            </div>
                                <!-- icon button add to favorite -->
                                <div class="text-end col fav-col-${name}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>`
                switch (i % 3) {
                    case 0:
                        $("#res-sx").append(card);
                        break;
                    case 1:
                        $("#res-cx").append(card);
                        break;
                    case 2:
                        $("#res-dx").append(card);
                        break;
                }
                button = document.createElement("button");
                button.id = data[i].name;
                $(button).addClass("btn btn-outline-primary add-fav-button");
                button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                    </svg>`;
                button.onclick = addToFav;
                $(".fav-col-"+name).append(button);

            }
        }, error: function (e) {
            console.log(e.message + " " + e.status);
            $("#error").html(e.message + " " + e.status);
            // change style of
            $("#error").css("display", "block");
        }
    });
}

class dafaultImg {
    constructor() {
        // change image to default
        this.src = "../img/distro/default.png";
    }
}

