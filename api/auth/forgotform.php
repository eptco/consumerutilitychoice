<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $apiObj->getSetting('site_name'); ?></title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../../css/animate.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    
</head>
<body class="gray-bg">
<div class="passwordBox animated fadeInDown">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                <h2 class="font-bold">Forgot password</h2>
                <p>
                    Enter your email address and your password will be reset and emailed to you.
                </p>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" role="form" action="forgot" method="post">
                            <div class="form-group">
                                <input type="email" id="user_0_email" name="user_0_email" class="form-control" placeholder="Email address" required="">
                            </div>
                            <button type="submit" class="btn btn-primary block full-width m-b">Send new password</button>
                        </form>
                         <p class="text-muted text-center"><small>Do not have an account?</small></p>
                        <a class="btn btn-sm btn-white btn-block" href="signup">Create an account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
</div>
</body>
</html>