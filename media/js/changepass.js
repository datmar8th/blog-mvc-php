$(document).ready(function () {
    $(".changepass-form").submit(function(event) {
        let tc = $(this);
        if($('.old-pass').val() === ""){
            $(".password-error").html("Please enter password");
            $(".password-error").css('display', 'block');
            event.preventDefault();
            return false;
        }
        if($('.new-pass').val() === ""){
            $(".new-pass-error").html("Please enter new password");
            $(".new-pass-erro").css('display', 'block');
            event.preventDefault();
            return false;
        }
        if($('.confirm-pass').val() === ""){
            $(".confirm-pass-error").html("Please enter password");
            $(".confirm-pass-error").css('display', 'block');
            event.preventDefault();
            return false;
        }

        if($('.confirm-pass').val() !== $('.new-pass').val()) {
            $(".confirm-pass-error").html("New password and confirm password do not match !!!");
            $(".confirm-pass-error").css('display', 'block');
            event.preventDefault();
            return false;
        }
    })

    $(".close").click((event) => {
        $(".error-change").css('display', 'none');
        event.preventDefault();
    })
});
