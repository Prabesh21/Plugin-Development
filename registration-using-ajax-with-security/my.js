jQuery(document).ready(function($) {
    jQuery('#register-button').on('click', function(e) {
        e.preventDefault();
        var reg_nonce = $('#vb_new_user_nonce').val();
        var newUserName = $('#new-username').val();
        var newUserEmail = jQuery('#new-useremail').val();
        var newUserPassword = jQuery('#new-userpassword').val();
        $.ajax({
            type: "POST",
            url: my_scripts.my_ajax_url,
            data: {
                action: "register_user_front_end",
                nonce: reg_nonce,
                new_user_name: newUserName,
                new_user_email: newUserEmail,
                new_user_password: newUserPassword
            },
            success: function(results) {
                console.log(results);
                jQuery('.register-message').text(results.data.message).css({ "color": "red" }).show();
                if (results.success) {
                    $('.register-form')[0].reset();
                }
            },
            error: function(results) {}
        });
    });
});