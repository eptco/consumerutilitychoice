<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $apiObj->getSetting('site_name'); ?></title>
        <link href="<?php echo $apiObj->getSetting('base_uri'); ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $apiObj->getSetting('base_uri'); ?>font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo $apiObj->getSetting('base_uri'); ?>css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="<?php echo $apiObj->getSetting('base_uri'); ?>css/animate.css" rel="stylesheet">
        <link href="<?php echo $apiObj->getSetting('base_uri'); ?>css/style.css" rel="stylesheet">
        <link href="<?php echo $apiObj->getSetting('base_uri'); ?>assets/custom.css" rel="stylesheet">
    </head>
    <body class="gray-bg">
        <div class="color-line"></div>
        <div class="middle-box text-center loginscreen   animated fadeInDown">
            <div class="row">
                <div class="col-md-12"><img src="<?php echo $apiObj->getSetting('base_uri'); ?>img/logo-large.png" alt="Consumer utility choice - logo"/></div>
            </div>
            <div>
                <h3  style="font-weight: 300;text-align: center;" class="m-b-md">Register to CRM</h3>
                <p>Create account to see it in action.</p>
                <div class="ibox">
                    <div class="ibox-content">                
                        <form method="post" class="m-t" role="form" action="register">
                            <div class="form-group">
                                <input name="firstname" type="text" class="form-control" placeholder="First Name" required="">
                            </div>
                            <div class="form-group">
                                <input name="lastname" type="text" class="form-control" placeholder="Last Name" required="">
                            </div>
                            <div class="form-group">
                                <input name="email"  type="email" class="form-control" placeholder="Email" required="">
                            </div>
                            <div class="form-group">
                                <input name="phone"  type="tel" class="form-control phone_us" placeholder="Phone" required="">
                            </div>
                            <div class="form-group">
                                <input name="password"  type="password" class="form-control" placeholder="Password" required="">
                            </div>
                            <div class="form-group">
                                <input name="passwordConf"  type="password" class="form-control" placeholder="Confirm Password" required="">
                            </div>
                            <div class="form-group">
                                <input name="code"  type="text" class="form-control" placeholder="code"  value="">
                            </div>
                            <div class="form-group">
                                <div class="checkbox i-checks"><label> <input name="agreeToTerms" value="Y" type="checkbox"><i></i> Agree the terms and policy </label></div
                            </div>
                            <button type="submit" class="btn btn-success block full-width m-b">Register</button>
                            <p class="text-muted text-center"><small>Already have an account?</small></p>
                            <a class="btn btn-sm btn-white btn-block" href="login">Login</a>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        2016 Copyright Consumerutilitychoice
                    </div>
                </div>
            </div>
        </div>
        <!-- Mainly scripts -->
        <script src="<?php echo $apiObj->getSetting('base_uri'); ?>js/jquery-2.1.1.js"></script>
        <script src="<?php echo $apiObj->getSetting('base_uri'); ?>js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo $apiObj->getSetting('base_uri'); ?>js/plugins/iCheck/icheck.min.js"></script>
        <script src="<?php echo $apiObj->getSetting('base_uri'); ?>assets/vendor/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.phone_us').mask('(000) 000-0000');
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
        </script>
    </body>
</html>