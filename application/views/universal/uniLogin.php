<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/adminAssets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/adminAssets/css/sb-admin-2.min.css');?>" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome !</h1>
                                    </div>
                                    <form id="loginFormId" class="loginFrom" method="POST" action="<?= base_url('log') ?>">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="loginId" name="loginId" aria-describedby="emailHelp"
                                                placeholder="Enter login id...">
                                        </div>
                                        <div id="err_loginId"></div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="pswdId" name="loginPswd" placeholder="Password">
                                        </div>
                                        <div id="err_pswd"></div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block" onclick="return validateUniLogin();">Login</button>
                                        <hr>
                                        <hr>
                                    </form>

                                    <!-- Open player button or Form -->

                                    <form id="openId" class="openForm" method="POST" action="<?php echo base_url('openPlayer');?>">
                                        <input type="submit" class="btn btn-secondary btn-user btn-block" value="Enter as Open Player"/>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/adminAssets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/adminAssets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/adminAssets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/adminAssets/js/sb-admin-2.min.js'); ?>"></script>

    <script>

        function validateUniLogin(){

            // Login Id as Email

            var cAdminLogin = document.getElementById('loginId').value;
            var err_loginId = document.getElementById('err_loginId');
            var patternLoginId = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if(cAdminLogin.match(patternLoginId))
            {
                err_loginId.innerHTML = "";    
                
            }else{
                document.getElementById('loginId').focus();
                err_loginId.style.fontSize = "12px";                      
                err_loginId.style.color = "red";
                err_loginId.innerHTML = "Wrong";  
                return false;
            }
            
            // Login Password

            var cAdminPswd = document.getElementById('pswdId').value;
            var err_pswd = document.getElementById('err_pswd');
            var patterncAdminPswd = /([a-zA-Z0-9-]){3,15}$/g;

            if(cAdminPswd.match(patterncAdminPswd))
            {              
                err_pswd.innerHTML = "";                 
            }else{
                document.getElementById('pswdId').focus();
                err_pswd.style.fontSize = "12px";                      
                err_pswd.style.color = "red";
                err_pswd.innerHTML = "Wrong";
                return false;                
            }
        }

    </script>

</body>

</html>