
// function create card from favs get like argument 
$(document).ready(function () {
  $(".drag-zone").droppable({
    drop: removeFav
  });
  createCardForFavs();
}
);


function createCardForFavs() {
  // use  favs json to create card
  // remove all card
  $("#fav-dx").empty();
  $("#fav-sx").empty();
  $("#fav-cx").empty();

  $.ajax({
    url: "/back/favs_manager.php",
    type: "POST",
    data: {
      action: "getFavs"
    },
    dataType: "json",
    success: function (data) {
      // if favs is empty show message
      switch (data.status) {
        case "empty":
          $("#title").html("No Favs Distros Found");
          break;
        case "success":
          for (var i = 0; i < data.favs.length; i++) {
            var card = createCard(data.favs[i]);
            switch (i % 3) {
              case 0:
                $("#fav-sx").append(card);
                break;
              case 1:
                $("#fav-cx").append(card);
                break;
              case 2:
                $("#fav-dx").append(card);
                break;
            }
          }
          $(".distro-card").draggable({
            revert: revertFunction
          });
          break;
        case "error":
          $("#title").html("Error, please retry later");
          break;
      }
    }, error: function (e) {
      console.log(e.message + " " + e.status);
      $("#error").html(e.message + " " + e.status);
    }
  });
}


function createCard(data) {

  var name = data.name.toLowerCase().replace(" ", "");

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


  return card =
    `<div class="card mb-3 mx-auto distro-card ">
    <div class="card-body gap-2 mx-auto">
      <div class="row">
        <div class="col img-col">
          <img  src="${img}" class="img-fluid rounded-start" alt="Info Distro ${data.name}">
        </div>
        <div class="col-7">
          <h5 class="card-title">${data.name}</h5>
          <div class="spacer"></div>
          <ul>
            <li>Base: ${data.based}</li>
            <li>Region: ${data.region}</li>
            <li>Architecture: ${data.arch}</li>
            <li>Last Version: ${data.version}</li>
            <li>website: <a href="${data.web}">${data.web}</a></li>
          </ul>
          <div class="text-end">
            <a href="/linux.php?distro=${data.name.toLowerCase().replace(" ", "")}" class="btn btn-primary">Extra</a>
          </div>
        </div>
      </div>
    </div>
  </div>`
}



function revertFunction(event, ui) {
  $(this).data("uiDraggable").originalPosition = {
    top: 50,
    left: 0,
  };
  // return boolean
  return !event;
}

function removeFav(event, ui) {
  var distro = ui.draggable[0].innerText;
  //save first line
  distro = distro.split("\n")[0];
  ui.draggable[0].style.top = "50px";
  ui.draggable[0].style.left = "0px";
  $.ajax({
    url: "/back/favs_manager.php",
    type: "POST",
    data: {
      distro: distro,
      action: "remove"
    },
    dataType: "json",
    success: function (data) {
      switch (data.status) {
        case "success":
          $("#fav-info").html(distro + " removed from favs");
          $(".drag-zone").css("border-color", "blue")
          ui.draggable[0].remove();
          break;
        case "error":
          $("#fav-info").html("Error removing distro from favs");
          $(".drag-zone").css("border-color", "red");
          break;
      }
      if (data.empty == "true") {
        $("#title").html("No Favs Distros Found");
      }
    }, error: function (e) {
      $("#fav-info").html("Error removing distro from favs");
    }
  })
}
