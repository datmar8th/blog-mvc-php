$(document).ready(function () {
	//disable button Comment
	$(".comment-btn").attr("disabled", true);
	$("#message").on("input", function() {
		$(".comment-btn").prop("disabled", $(this).val().trim() === "");
	});
	//disable button Reply
	$(".reply-button").attr("disabled", true);
	$(".reply-content").on("input", function() {
		let parentReplyComment = $(this).closest(".reply-comment");
		let replyButton = parentReplyComment.find(".reply-button");
		replyButton.prop("disabled", $(this).val().trim() === "");
	});
	//disable button edit
	$(".edit-button").attr("disabled", true);
	$(".edit-content").on("input", function() {
		let parentReplyComment = $(this).closest(".edit-comment");
		let replyButton = parentReplyComment.find(".edit-button");
		replyButton.prop("disabled", $(this).val().trim() === "");
	});
	//display reply form
	$(".comment-ances").on("click", '.reply-btn', function(e) {
		e.preventDefault();
		let replyCmt = $(".reply-comment" + alt($(this).attr("value")));
		let editCmt = $(".edit-comment" + alt($(this).attr("value")));
		if (replyCmt.css("display") === "none") {
			replyCmt.css("display", "block");
			$(".reply-content" + alt($(this).attr("value"))).focus();

			editCmt.css("display", "none");
			$(".edit-content" + alt($(this).attr("value"))).val("");
		}
	});
	$(".cancel-reply-btn").on("click", function(e) {
		e.preventDefault();
		let replyCmt = $(this).closest(".reply-comment"); // Find the closest parent with class "reply-comment"
		replyCmt.css("display", "none");
		$(".reply-content").val("");
	});
	//display edit form
	$(".comment-ances").on("click", ".edit-btn", function(e) {
		e.preventDefault();
		let idCmt = $(this).attr("value");
		console.log(idCmt);
		let commentContent = $(".media" + alt(idCmt) + " p").first().text();
		console.log(commentContent);
		$(".edit-content" + alt(idCmt)).val(commentContent);
		let editCmt = $(".edit-comment" + alt(idCmt));
		let replyCmt = $(".reply-comment" + alt(idCmt));

		if (editCmt.css("display") === "none") {
			editCmt.css("display", "block");
			$(".edit-content" + alt(idCmt)).focus();

			replyCmt.css("display", "none");
			$(".reply-content" + alt(idCmt)).val("");
		}
	});
	$(".cancel-edit-btn").on("click", function(e) {
		e.preventDefault();
		let thisCmt = $(this).closest(".edit-comment"); // Find the closest parent with class "reply-comment"
		thisCmt.css("display", "none");
		$(".edit-content").val("");
	});
	//post comment
	$(".comment-form").on("click", ".comment-btn", function(e) {
		e.preventDefault();
		let comment_content = $("#message").val();
		let id_blog = $(this).data('blog');
		let url = rootURL + 'index.php?ctl=comments&act=add&id=' + id_blog;
		//let url = $(this).attr("alt");
		$.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			data: {
				comment_content: comment_content,
			}
		})
		.done(function (data) {
			if (data.status === true) {
				let html = renderComment(data.result, "likes", "comments", "add", "reply", "&id=" + data.result.id);
				$(".comment-ances").append(html);
				$("#message").val('');
				updateCommentCount();
			} else {
				alert("Error!!!");
			}
		})
	});
	//update comment count
	const updateCommentCount = (increment = true) => {
		let currentCmtCount = parseInt($("#comment-count").text());
		let change = increment ? 1 : -1;
		let newCmtcount = currentCmtCount + change;
		$("#comment-count").text(newCmtcount + " Comments");
	}
	//reply cmt
	$(".comment-ances").on("click", ".reply-button", function(e) {
		e.preventDefault();
		idCmt = $(this).attr("value");
		let reply_comment_content = $(".reply-content" + alt(idCmt)).val();
		let url = rootURL + 'index.php?ctl=comments&act=reply';
		let id_blog = $(this).data('blog');
		$.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			data: {
				reply_comment_content: reply_comment_content,
				blog_id: id_blog,
				parentId: idCmt
			}
		})
		.done(function (data) {
			if (data.status === true) {
				let html = renderComment(data.result, "likes", "comments", "add", "reply", "&id=" + data.result.id);
				path = data.result.path;
				pathDots = (path.split(".")).length - 1;
				if (pathDots <= 2) {
					pathParent = parseInt(path.slice(path.length - 11, path.length - 6));
				} else {
					pathParent = parseInt(path.slice(12, 17));
				}
				$(".comment-ances .comment-reply" + alt(pathParent)).append(html);
				$(".reply-content" + alt(idCmt)).val("");
				$(".reply-comment" + alt(idCmt)).css("display", "none");
				updateCommentCount();
			} else {
				alert("Error!!!");
			}
		})
	})
	//edit comment
	$(".comment-ances").on("click", ".edit-button", function(e) {
		e.preventDefault();
		idCmt = $(this).attr("value");
		let edit_comment_content = $(".edit-content" + alt(idCmt)).val();
		console.log(edit_comment_content );
		let url =rootURL + 'index.php?ctl=comments&act=edit';
		$.ajax({
			url: url,
			type: "POST",
			dataType: 'json',
			data: {
				edit_comment_content: edit_comment_content,
				comment_id: idCmt,
			}
		})
		.done(function(data) {
			if (data.status === true) {
				let commentSelector = ".media" + alt(idCmt) + " p";
				$(commentSelector).first().html(data.result.comment_content);
				let editCommentSelector = ".edit-comment" + alt(idCmt);
				$(editCommentSelector).css("display", "none");
			} else {
				alert("Error!!!");
			}
		})
	})

	//delete  comment
	$(".comment-ances").on('click',".media ul .delete-btn",function(e){
		e.preventDefault();
		idCmt = $(this).attr("value");
		let url =rootURL + 'index.php?ctl=comments&act=delete&id=' + idCmt;
		var confirmDel = confirm("Bạn có chắc muốn xóa?");
		if (confirmDel == true) {
			$.ajax({
				url : url ,
				type: "POST",
				dataType:"json",
				data: {
					blog_id: blog_id,
				}
			})
			.done(function(data) {
				if(data.status == true) {
					let commentSelector = ".media" + alt(idCmt);
					console.log(commentSelector);
					//$(commentSelector).remove();
					$(commentSelector).html("").css({"border": "none", "padding": "0"});
					updateCommentCount(false);
				}
			})
		}
		return false;
	})
	//render comment
	const renderComment = (data, ctl_like, ctl_comment, act_like, act_reply, params) => {
		avtURL = "media/upload/users/" + auth_avt;
		let html = `<div class="media d-flex flex-column" alt="${data.id}">\
						<div class="d-flex flex-row">\
							<a class="pull-left" href="#"><img class="w-75 h-75 rounded-circle" src="${avtURL}"></a>\
							<div class="media-body flex-grow-1">\
								<h4 class="media-heading">${auth_fullname}</h4>\
								<p>  ${data.comment_content} </p>\
								<div class="flex-row justify-content-between">\
									<ul class="list-unstyled list-inline media-detail d-flex">\
										<li><i class="fa fa-calendar"></i><span>${data.created}</span></li>\
										<li class="like-group" alt="${data.id}">\
											<i class="fa fa-thumbs-up like-icon"></i>\
											<span alt="${data.id}">${data.like_count}</span>\
										</li>\
									</ul>\
									<br>\
									<ul class="list-unstyled list-inline media-detail d-flex">\
										<li>\
											<a class="like-btn" href="" value="${data.id}" alt="">\
												<i class="fa-regular fa-thumbs-up"></i>\
											</a>\
										</li>\
										<li>\
											<a class="reply-btn" value="${data.id}">\
												<i class="fa-regular fa-message-dots"></i>\
											</a>\
										</li>\
										<li>\
										<a class="edit-btn" value="${data.id}" >\
										<i class="fa-solid fa-pen-to-square"></i>\
										</a>\
										</li>\
										<li>\
											<a class="delete-btn" value="${data.id}" alt="">\
												
												<i class="fa-solid fa-trash-can"></i>\
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
											<img class="w-75 h-75 rounded-circle" src="${avtURL}">\
										</div>\
										<div class="form-group col-xs-12 col-sm-9 col-lg-10">\
											<textarea name="reply_comment_content" class="reply-content form-control" alt="${data.id}" placeholder="Your comment" required></textarea>\
										</div>\
									</div>\
								</fieldset>\
								<div class="d-flex justify-content-end">\
									<button class="btn btn-light cancel-reply-btn">Cancel</button>\
									<button name="reply" id="test_btn" type="button" class="btn btn-custom-auth text-light reply-button" value="${data.id}" data-blog="${blog_id}">Reply</button>\
									
								</div>\
							</form>\
						</div>\
						<div class="edit-comment" alt="${data.id}">\
							<form name="edit-form" class="edit-form ps-5 mt-3">\
								<h3 class="ps-4">Edit</h3>\
								<fieldset>\
									<div class="row">\
										<div class="col-sm-3 col-lg-2">\
											<img class="w-75 h-75 rounded-circle" src="${avtURL}">\
										</div>\
										<div class="form-group col-xs-12 col-sm-9 col-lg-10">\
											<textarea name="edit_comment_content" class="edit-content form-control" alt="${data.id}" placeholder="Your comment" required></textarea>\
										</div>\
									</div>\
								</fieldset>\
								<div class="d-flex justify-content-end">\
									<button class="btn btn-light cancel-edit-btn">Cancel</button>\
									<button name="edit" type="button" class="btn btn-custom-auth text-light edit-button" value="${data.id}">Edit</button>\
								</div>\
							</form>\
						</div>\
						<div class="comment-reply ps-5" alt="${data.id}">\
						</div>\
					</div>`;
		return html;
	}

	const alt = (id) => {
		return `[alt = "${id}"]`;
	}

});