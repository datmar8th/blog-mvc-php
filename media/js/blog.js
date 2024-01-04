var Comment = {
	GLOBAL: {},

	CONSTS: {},

	SELECTORS: {
		comment_ances: 		".comment-contain .comment-ances",
		comment_media:		".comment-ances .media",
		comment_contain: 	"#comments .comment-contain",
		comment_form: 		"form.comment-form",
		comment: 			"textarea#message",
		comment_button: 	"div button.comment-btn",
		comment_reply: 		".comment-ances .comment-reply",
		like_button: 		".media ul .like-btn",
		like_group: 		".media ul .like-group",
		like_count: 		".media ul .like-group span",
		like_icon: 			".media ul .like-icon",
		reply_button: 		".media ul .reply-btn",
		reply_comment: 		".media .reply-comment",
		reply_form: 		"form.reply-form",
		reply_submit: 		"div button.reply-button",
		reply_content: 		"textarea.reply-content",
		delete_button:		".media ul .delete-btn",
		edit_button: 		".media ul .edit-btn",
		edit_comment:		".media .edit-comment",
		edit_form:			"form.edit-form",
		edit_submit:		"div button.edit-button",
		edit_content:		"textarea.edit-content",
	},

	init: function () {
		Comment.like();
		Comment.addComment();
		Comment.replyComment();
		Comment.editComment();
		Comment.deleteComment();
		Comment.showFormReply();
		Comment.showFormEdit();
	},

	addComment: function () {
		$(Comment.SELECTORS.comment_form).on("click", Comment.SELECTORS.comment_button,	function (event) {
			event.stopPropagation();
			tc = $(this);
			//var cf = confirm("Are you sure!");
			// host = 'http://' + window.location.host;
			//if (cf == true) {
			url = tc.attr("alt");

			$.ajax({
				url: url,
				type: "POST",
				data: {
					content: $(Comment.SELECTORS.comment).val(),
				},
				dataType: "json",
			})
			.done(function (data) {
				let html = Comment.renderComment(data, "likes", "comments", "add", "reply", "&comment_id="+data.id );				
				$(Comment.SELECTORS.comment_ances).prepend(html);
				$(Comment.SELECTORS.comment).val("");
				//Comment.showFormReply();
			})

			.fail(function (xhr, status, errorThrown) {
				alert("Sorry, there was a problem!");
				console.log("Error: " + errorThrown);
				console.log("Status: " + status);
				console.dir(xhr);
			});
			return false;
		});
	},

	like: function () {
		$(Comment.SELECTORS.comment_ances).on("click", Comment.SELECTORS.like_button, function (event) {
			event.stopPropagation();
			tc = $(this);
			url = tc.attr("alt");
			$.ajax({
				url: url,
				type: "POST",
				dataType: "json",
			})
			.done(function (response) {
				let alt = Comment.alt(tc.attr("value"));
				console.log(response);
				if ($(Comment.SELECTORS.like_group + alt).hasClass("liked")) {
					$(Comment.SELECTORS.like_group + alt).removeClass("liked");
				} else {
					$(Comment.SELECTORS.like_group + alt).addClass("liked");
				}
				$(Comment.SELECTORS.like_count + alt).html(response);
			})
			.fail(function (xhr, status, errorThrown) {
				alert("Sorryyy, there was a problem!");
				console.log("Error: " + errorThrown);
				console.log("Status: " + status);
				console.dir(xhr);
			});
			return false;
		});
	},

	showFormReply: function () {
		$(Comment.SELECTORS.comment_ances).on( "click", Comment.SELECTORS.reply_button, function (event) {
			event.stopPropagation();
			tc = $(this);
			let thisComment = $(Comment.SELECTORS.reply_comment + Comment.alt(tc.attr("value")));
			if (thisComment.css("display") === "none") {
				thisComment.css("display", "block");
				$(Comment.SELECTORS.reply_content + Comment.alt(tc.attr("value"))).focus();
			} else {
				thisComment.css("display", "none");
			}
		});
	}, 

	showFormEdit: function () {
		$(Comment.SELECTORS.comment_ances).on( "click", Comment.SELECTORS.edit_button, function (event) {
			event.stopPropagation();
			tc = $(this);
			let thisComment = $(Comment.SELECTORS.edit_comment + Comment.alt(tc.attr("value")));
			if (thisComment.css("display") === "none") {
				thisComment.css("display", "block");
				valText = $(Comment.SELECTORS.comment_media + Comment.alt(tc.attr("value")) + " p").html();
				$(Comment.SELECTORS.edit_content + Comment.alt(tc.attr("value"))).html(valText).focus();
			} else {
				thisComment.css("display", "none");
			}
		});
	},

	replyComment: function () {
		$(Comment.SELECTORS.comment_ances).on("click", Comment.SELECTORS.reply_submit, function (event) {
			event.stopPropagation();
			tc = $(this);
			url = tc.attr("alt");
			idCmt = tc.attr("value");
			$.ajax({
				url: url, 
				type: "POST",
				data: {
					blog_id: blog_id,
					content: $(Comment.SELECTORS.reply_content + Comment.alt(idCmt)).val(),
					parentId: idCmt
				},
				dataType: "json",
			})
			.done(function (data) {
				let html = Comment.renderComment(data, "likes", "comments", "add", "reply", "&comment_id="+data.id ),
					path = data.path,
				 	pathDots = (path.split(".")).length -1,
					pathParent = 0;
				if (pathDots <= 2) {
					pathParent = parseInt(path.slice(path.length-11, path.length-6));
				} else {
					pathParent = parseInt(path.slice(12, 17));
				}
				$(Comment.SELECTORS.comment_reply + Comment.alt(pathParent)).append(html);
				$(Comment.SELECTORS.reply_content + Comment.alt(idCmt)).val("");
				$(Comment.SELECTORS.reply_comment + Comment.alt(idCmt)).css("display", "none");
			})

			.fail(function (xhr, status, errorThrown) {
				alert('Sorry, vcccctoo many bugs');
				console.log("Error: " + errorThrown);
				console.log("Status: " + status);
				console.dir(xhr);
			});
			return false;
		});
	},

	editComment: function() {
		$(Comment.SELECTORS.comment_ances).on("click", Comment.SELECTORS.edit_submit, function (event) {
			event.stopPropagation();
			tc = $(this);
			url = tc.attr("alt");
			idCmt = tc.attr("value");
			$.ajax({
				url: url,
				type: "POST", 
				data: {
					comment_id: idCmt,
					content: $(Comment.SELECTORS.edit_content + Comment.alt(idCmt)).val(),
				},
				dataType: "json",
			})
			.done( function(response) {
				$(Comment.SELECTORS.comment_media + Comment.alt(idCmt) + " p").html(response.comment_content);
				$(Comment.SELECTORS.edit_comment + Comment.alt(tc.attr("value"))).css("display", "none");
			})
			.fail(function (xhr, status, errorThrown) {
				alert("Sorryyy, there was a problem!");
				console.log("Error: " + errorThrown);
				console.log("Status: " + status);
				console.dir(xhr);
			});
			return false;
		});
	},

	deleteComment: function() {
		$(Comment.SELECTORS.comment_ances).on("click", Comment.SELECTORS.delete_button, function (event) {
			event.stopPropagation();
			tc = $(this);
			url = tc.attr("alt");
			let cf = confirm("Are you sure!");
			if (cf == true) {
				$.ajax({
					url: url,
					type: "POST",
					data: {
						blog_id: blog_id,
					}
				})
				.done(function(response){
					$(Comment.SELECTORS.comment_media + Comment.alt(tc.attr("value"))).html("").css({"border": "none", "padding": "0"});
				})
				.fail(function (xhr, status, errorThrown) {
					alert("Sorryyy, there was a problem!");
					console.log("Error: " + errorThrown);
					console.log("Status: " + status);
					console.dir(xhr);
				});
			}
			return false;
		});
	},

	renderComment: function (data, ctl_like, ctl_comment, act_like, act_reply, params) {
		imgURL = "media/upload/users/" + auth_img;
		let html = `<div class="media d-flex flex-column" alt="${data.id}">\
						<div class="d-flex flex-row">\
							<a class="pull-left" href="#"><img class="w-75 rounded-circle" src="${imgURL}"></a>\
							<div class="media-body flex-grow-1">\
								<h4 class="media-heading">${auth_name}</h4>\
								<p>  ${data.comment_content} </p>\
								<div class="d-flex flex-row justify-content-between">\
									<ul class="list-unstyled list-inline media-detail d-flex">\
										<li><i class="fa fa-calendar"></i><span>${data.created}</span></li>\
										<li class="like-group" alt="${data.id}">\
											<i class="fa fa-thumbs-up like-icon"></i>\
											<span alt="${data.id}">${data.like_count}</span>\
										</li>\
									</ul>\
									<ul class="list-unstyled list-inline media-detail d-flex">\
										<li>\
											<a class="like-btn" href="" value="${data.id}" alt="index.php?ctl=${ctl_like}&act=${act_like+params}">\
												Like\
											</a>\
										</li>\
										<li>\
											<a class="reply-btn" value="${data.id}">\
												Reply\
											</a>\
										</li>\
										<li>\
											<a class="delete-btn" href="" value="${data.id}" alt="index.php?ctl=${ctl_comment}&act=delete${params}">\
												Delete\
											</a>\
										</li>\
                                        <li>\
                                            <a class="edit-btn" value="${data.id}" >\
                                                Edit\
                                            </a>\
                                        </li>\
									</ul>\
								</div>\
							</div>\
						</div>\
						<div class="reply-comment" alt="${data.id}">\
							<form name="reply-form" class="reply-form ps-5 mt-3">\
								<h3 class="ps-4">Reply</h3>\
								<fieldset>\
									<div class="row">\
										<div class="col-sm-3 col-lg-2">\
											<img class="img-responsive w-50 rounded-circle" src="${imgURL}">\
										</div>\
										<div class="form-group col-xs-12 col-sm-9 col-lg-10">\
											<textarea class="reply-content form-control" alt="${data.id}" placeholder="Your comment" required></textarea>\
										</div>\
									</div>\
								</fieldset>\
								<div class="d-flex justify-content-end">\
									<button name="reply" id="test_btn" type="button" class="btn btn-custom-auth text-light reply-button" value="${data.id}" alt="index.php?ctl=${ctl_comment}&act=${act_reply}">Reply</button>\
								</div>\
							</form>\
						</div>\
						<div class="edit-comment" alt="${data.id}">
							<form name="edit-form" class="edit-form ps-5 mt-3">
								<h3 class="ps-4">Edit</h3>
								<fieldset>
									<div class="row">
										<div class="col-sm-3 col-lg-2">
											<img class="img-responsive w-50 rounded-circle" src="${imgURL}">
										</div>
										<div class="form-group col-xs-12 col-sm-9 col-lg-10">
											<textarea class="edit-content form-control" alt="${data.id}" placeholder="Your comment" required></textarea>
										</div>
									</div>
								</fieldset>
								<div class="d-flex justify-content-end">
									<button name="edit" type="button" class="btn btn-custom-auth text-light edit-button" value="${data.id}" alt="index.php?ctl=${ctl_comment}&act=edit">Edit</button>
								</div>
							</form>
						</div>
						<div class="comment-reply ps-5" alt="${data.id}">\
						</div>\
					</div>`;
					return html;
	},

	alt: function (id) {
		return `[alt = "${id}"]`;
	}
};

$(document).ready(function () {
	Comment.init();
});
