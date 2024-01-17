"use strict";

var Comment = {
  GLOBAL: {},
  CONSTS: {},
  SELECTORS: {},
  init: function init() {
    Comment.addComment();
  },
  addComment: function addComment() {
    $("form.comment-form").on("click", "div button.comment-btn", function (event) {
      event.stopPropagation();
      tc = $(this);
      var cf = confirm("Are you sure!"); // host = 'http://' + window.location.host;

      if (cf == true) {
        url = tc.attr("alt");
        $.ajax({
          url: url,
          type: "POST",
          data: {
            content: $("textarea#message").val()
          },
          dataType: "json"
        }).done(function (data) {
          console.log(data);
          imgURL = "media/upload/users/" + auth_img;
          var html = "<div class=\"media d-flex flex-row\">\t\t\t\t\t\t\t\t\t\t\t<a class=\"pull-left\" href=\"#\"><img class=\"w-75 rounded-circle\" src=\"".concat(imgURL, "\" alt=\"\"></a>\t\t\t\t\t\t\t\t\t\t\t<div class=\"media-body flex-grow-1\">\t\t\t\t\t\t\t\t\t\t\t\t<h4 class=\"media-heading\">").concat(auth_name, "</h4>\t\t\t\t\t\t\t\t\t\t\t\t<p>  ").concat(data.comment_content, " </p>\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"d-flex flex-row justify-content-between\">\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"list-unstyled list-inline media-detail d-flex\">\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li><i class=\"fa fa-calendar\"></i>").concat(data.created, "</li>\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li><i class=\"fa fa-thumbs-up\"></i>").concat(data.like_count, "</li>\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"list-unstyled list-inline media-detail d-flex\">\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"\"><a href=\"\">Like</a></li>\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"\"><a href=\"\">Reply</a></li>\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>\t\t\t\t\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t\t</div>");
          $("#comments div.comment-contain").append(html);
        }).fail(function (xhr, status, errorThrown) {
          alert("Sorry, there was a problem!");
          console.log("Error: " + errorThrown);
          console.log("Status: " + status);
          console.dir(xhr);
        });
        return false;
      }
    });
  }
};
$(document).ready(function () {
  Comment.init();
});