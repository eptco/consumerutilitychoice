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
        <div class="middle-box loginscreen  animated fadeInDown">
            <div class="row">
                <div class="col-md-12"><img src="<?php echo $apiObj->getSetting('base_uri'); ?>img/logo-large.png" alt="Consumer utility choice - logo"/></div>
            </div>
            <div>

                <h3 style="font-weight: 300;text-align: center;" class="m-b-md">Please Login</h3>
                <?php
                $messages = $apiObj->getMessage("success");
                if (!empty($messages)) {
                    foreach ($messages as $key => $value) {
                        echo "<h3>" . $value . "</h3>";
                    }
                } else {
                    ?>
                    <?php
                }
                ?>
                <div class="ibox">
                    <div class="ibox-content">
                        <form method="post" class="" role="form" action="loginnow" style="margin-bottom: 1em">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" required="" value="<?php echo trim($apiObj->getFormValue('email')); ?>">
                                <?php echo $apiObj->getFormError('email'); ?>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required="">
                                <?php echo $apiObj->getFormError('password'); ?>
                            </div>
                            <button type="submit" class="btn btn-success block full-width">Login</button>
                            <a href="signup" class="btn btn-white block full-width" style="margin-top: 5px">Register</a>
                            <a href="forgot" style="color: #34495e;font-size: 13px!important">Forgot Password</a>

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
    </body>
</html>