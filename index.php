<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css">
</head>
<body>
    <form action="#" method="post">
        <h2>Sign Up</h2>
        <p>
            <label for="first_name" class="floatLabel">First Name</label>
            <input id="first_name" name="first_name" type="text">
            <span></span>
        </p>
        <p>
            <label for="last_name" class="floatLabel">Last Name</label>
            <input id="last_name" name="last_name" type="text">
            <span></span>
        </p>
        <p>
            <label for="email" class="floatLabel">Email</label>
            <input id="email" name="email" type="text">
            <span></span>
        </p>
        <p>
            <label for="password" class="floatLabel">Password</label>
            <input id="password" name="password" type="password">
            <span></span>
        </p>
        <p>
            <label for="confirm_password" class="floatLabel">Confirm Password</label>
            <input id="confirm_password" name="confirm_password" type="password">
            <span></span>
        </p>
        <p>
            <button data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order" type="submit" id="submit">Create My Account</button>
        </p>
    </form> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        $('form').submit(function(e){
            e.preventDefault();
            $('button#submit').button('loading');
            $('span').text('');
            $.post('register.php',$(this).serializeArray(), (res) => {
                $('button#submit').button('reset');
                if(res.code != 200){
                    toastr["error"]("", "Validation error. Please check the fields and try again!");
                    $.each(res.data, function(index, item) {
                        key = Object.keys(item)[0];
                        $('input[name="'+index+'"]').parent().find('span').text(item[key])
                    });
                }else{
                    $('input').val('');
                    toastr["success"]("", res.data.message);
                }
                console.log(res);
            });
        });
    </script>
</body>
</html>	


