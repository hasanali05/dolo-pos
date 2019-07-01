<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/')}}/template/assets/images/favicon.png">
    <title>Employee login</title>
    <!-- Custom CSS -->
    <link href="{{asset('/')}}/template/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url({{asset('/')}}/template/assets/images/big/auth-bg.jpg) no-repeat center center;">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <span class="db"><img src="{{asset('/')}}/template/assets/images/logos/logo-icon.png" alt="logo" /></span>
                        <h5 class="font-medium mb-3">Sign In to Employee</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12" id="login">
                            <div v-if="errors.length" class="alert alert-danger">
                                <b>Please correct the following error(s):</b>
                                <ul>
                                    <li v-for="error in errors">@{{ error }}</li>
                                </ul>
                            </div>
                            <form class="form-horizontal mt-3" action="{{ route('employee.login') }}" method="POST" id="signin-form">
                                {{csrf_field()}}
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" ><i class="ti-user"></i></span>
                                    </div>
                                    <input type="email" class="form-control form-control-lg" placeholder="Email" aria-label="email" aria-describedby="basic-addon1" name="email" v-model="email">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="password" id="password" v-model="password">
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-xs-12 pb-3">
                                        <button class="btn btn-block btn-lg btn-info" type="submit" @click.prevent="validation()">@{{ button }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{asset('/')}}/template/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('/')}}/template/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{asset('/')}}/template/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{asset('/')}}/js/vue.js"></script>
    <script src="{{asset('/')}}/js/axios.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    </script>

    <script type="text/javascript">
        const app = new Vue({
            el: '#login',
            data: {
                errors: [],
                email: '',
                password: '',
                button: 'Log in'
            },
            mounted: function mounted() {
                var _this = this;   
            },
            methods: {      
                validation: function validation() {
                    var _this = this; 
                    _this.errors = [];  
                    _this.button = 'Loading';
                    let count = 0; 

                    if (!_this.email) {
                        _this.errors.push('Email required.');
                        count++;
                    }
                    if( count == 0) {
                        let data = {
                            email: _this.email, 
                            password: _this.password
                        };

                        axios.post('{{route("employee.emailCheck")}}', data)
                        .then(function (response) {
                            if(response.data.success==false ){
                                _this.errors.push('Email not Found!.');
                                _this.button = 'Log in'; 
                            } else {
                                _this.button = 'Checked';
                                const signinForm = document.getElementById('signin-form');
                                signinForm.submit();
                                //submit form
                            }
                        })
                        .catch(function (error) {
                            if (error.response.status == 422){
                                for (var key in error.response.data.errors) {
                                    error.response.data.errors[key].forEach(function(element) {
                                        _this.errors.push(element);
                                    });
                                }
                            }
                            _this.button = 'Log in';
                        })

                        _this.button = 'Log in'; 
                    }
                },
                wait: function wait(ms){
                    var start = new Date().getTime();
                    var end = start;
                    while(end < start + ms) {
                        end = new Date().getTime();
                    }
                }
            }
        });

    </script>
</body>

</html>