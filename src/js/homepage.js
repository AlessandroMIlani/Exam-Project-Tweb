// when page loads, call the function

$(document).ready(function () {
    // when button is clicked, call the function
    loadImg();
});


function loadImg() {
    $.ajax({
        url: "/back/profile.php",
        type: "POST",
        data: {
            action: "loadImg"
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            $("#profile").attr("src", data);
        },
        error: function (e) {
            console.log(e.message + " " + e.status);
        }
    });
}


function loadCarousel() {
    // create carousel with 3 items in div with id "carousel"
    $.ajax({
        url: "/back/rand.php",
        type: "POST",
        data: {
            action: "loadCarousel"
        },
        dataType: "json",
        success: function (data) {
            // use data to fill corousel-inner
            console.log(data);
            for (let i = 0; i < data.length; i++) {
                let item = data[i];
                let active = "";
                if (i == 0) {
                    active = "active";
                }
                let html = `<div class="carousel-item ${active}">
                <img src="${item.path}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>${item.filename}</h5>
                    <p>${i} asd</p>
                </div>
            </div>`;
                $("#carousel-inner").append(html);

            }

        },
        error: function (e) {
            console.log(e.message + " succedono cose " + e.status);
        }
    })
};
