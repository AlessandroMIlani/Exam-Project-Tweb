// load comments when page is loaded
$(document).ready(function () {
    loadComments();
    $("#add").on("click", addComment);
});

function loadComments() {
    $.ajax({
        url: "/back/comments_manager.php",
        type: "POST",
        data: {
            // pass the html element with id "distro-title"
            distro: $("#distro-title").html(),
            action: "loadComments"
        },
        dataType: "json",
        success: function (data) {
            switch (data.status) {
                case "success":
                    if (data.comments.length == 0) {
                        $("#comments").append("<p id='nocom' >There are no comments yet.</p>");
                    }
                    else {
                        for (let i = 0; i < data.comments.length; i++) {
                            card = commnetCard(data.comments[i]);
                            $("#comments").append(card);
                        }
                    }
                    break;
                case "error":
                    $("#comments").append("<p id='nocom' >Comments unavailable.</p>");
                    break;
            }
        },
        error: function (e) {
            console.log("error comments" + e.message + " " + e.status);
            $("#comments").append("<p id='nocom' >Comments unavailable.</p>");
        }
    });
};

function addComment() {
    comment = $("#comment").val();
    $("#nocom").remove();
    // check if comment empty or is only spaces
    if (comment.trim() != "") {
        $.ajax({
            url: "/back/comments_manager.php",
            type: "POST",
            data: {
                distro: $("#distro-title").html(),
                comment: comment,
                action: "addComment"
            },
            dataType: "json",
            success: function (data) {
                switch (data.status) {
                    case "success":
                        card = commnetCard(data);
                        $("#comments").append(card);
                    break;
                    case "error":
                        $("#comments").append("<p id='nocom' >" + data.message + "</p>");
                    break;
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }

}

function commnetCard(data) {
    return card = `<div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row align-items-center">
                                    <img src="${data.img}"
                                    alt="avatar" width="25" height="25" />
                                    <p class="small mb-0 ms-2">${data.username}</p>
                                </div>
                                <p class="small mb-0 ms-2 text-end">${data.date}</p>
                            </div>
                            <p>${data.comment}</p>
                        </div>
                    </div>`
}