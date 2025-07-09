<!DOCTYPE html>
<html lang="en">
<head>
    <title>Apparel Management</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="description" content="Apparel Management - Stock, Inventory, and Supply Management" />
    <meta name="author" content="Your Company Name" />
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/login/animate.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/styles-responsive.css') }}">

    <style>
       .login {
                background: url('https://png.pngtree.com/thumb_back/fw800/background/20240103/pngtree-denim-garment-texture-image_13909023.png') center/cover no-repeat;
                height: 100vh;
                display: flex;
                align-items: center;
                position: relative;
            }
        .box-login {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-top: 4px solid #b5151c;
        }
        .btn-green {
            background-color: #b5151c;
            border-color: #a01319;
            color: white;
        }
        .btn-green:hover {
            background-color: #a01319;
            border-color: #8a1116;
            color: white;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 10px;
            top: 10px;
            color: #999;
        }
        .form-control {
            padding-left: 35px;
            border-radius: 3px;
        }
        .form-control:focus {
            border-color: #b5151c;
            box-shadow: 0 0 0 0.2rem rgba(181, 21, 28, 0.25);
        }
        .copyright {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body class="login">
    <div class="container">
        <div class="row">
            <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <!-- start: LOGIN BOX -->
                <div class="box-login animated fadeIn">
                    <center>
                        <h2 style="margin-bottom: 5px;">
                            <b style="font-family: 'Times New Roman'; color: #b5151c;">
                                Apparel Management
                            </b>
                        </h2>
                    </center>
                    <br>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle"></i> 
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> 
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <fieldset>
                            <div class="form-group">
                                <span class="input-icon">
                                  <input  id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="username" autofocus placeholder="Email or Username"/>
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <div class="form-group form-actions">
                                <span class="input-icon">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Password" name="password" required autocomplete="current-password"/>
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-green btn-block">
                                    Login <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </fieldset>
                    </form>
                    <div class="copyright">
                        <h6 style="color: #555; margin-top: 0;">HR, ACCOUNTS, PRODUCTION, INVENTORY AND ALL</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}"></script>
    
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/login/bootstrap/js/bootstrap.min.js') }}"></script>
    
    <!-- Form Validation -->
    <script src="{{ asset('assets/login/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/login.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Add basic form validation
                    $('form').validate({
                            rules: {
                    login: {  // Changed from 'email' to 'login'
                        required: true,
                        minlength: 3
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    login: {  // Changed from 'email' to 'login'
                        required: "Please enter your email or username",
                        minlength: "Your username must be at least 3 characters long"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    }
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                    // Add the 'help-block' class to the error element
                    error.addClass("help-block");
                    error.insertAfter(element.parent());
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                }
            });
            
            // Focus on email field on page load
            $('#email').focus();
        });
    </script>
</body>
</html>