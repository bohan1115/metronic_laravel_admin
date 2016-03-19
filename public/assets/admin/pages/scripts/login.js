var Login = function() {

    var handleLogin = function() {

        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {

                //form.submit(); // form validation success, call ajax form submit
                var username = $("#username").val();
                var password = $("#password").val();
                var remember = $("#remember").val();
                $.ajax({
                    url:'/account/loginAjax',
                    type:'POST',
                    dataType:'json',
                    async:false,
                    data:{username:username,password:password,remember:remember},
                    success:function(data){
                        if(data.code == 200){
                            location.href="/";
                        }else{
                            $('.alert-danger', $('.login-form')).text(data.msg);
                            $('.alert-danger', $('.login-form')).show();
                        }
                    }
                });
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
    }


    return {
        //main function to initiate the module
        init: function() {

            handleLogin();

        }

    };

}();