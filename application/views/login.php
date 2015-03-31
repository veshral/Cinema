<html class="gt-ie8 gt-ie9 not-ie pxajs"><!--<![endif]--><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Open Sans font from Google CDN -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">

    <!-- Pixel Admin's css -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/css/pixel-admin.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/css/pages.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/css/rtl.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/css/themes.min.css') ?>" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
        <script src="assets/javascripts/ie.min.js"></script>
    <![endif]-->

</head>


<!-- 1. $BODY ======================================================================================
    
    Body

    Classes:
    * 'theme-{THEME NAME}'
    * 'right-to-left'     - Sets text direction to right-to-left
-->
<body class="theme-dust page-signin" style="">

    <!-- Container -->
    <div class="signin-container">

        <!-- Left side -->
        <div class="signin-info">
            <a href="<?php echo site_url('welcome/index') ?>" class="logo">
                <img src="<?php echo base_url('assets/demo/logo_sign_in.png') ?>" alt="" style="margin-top: -5px; height : 80px">&nbsp;
                Cinemaster
            </a> <!-- / .logo -->
            <div class="slogan">
                Simple. Flexible. Powerful.
            </div> <!-- / .slogan -->
            <ul>
                <li><i class="fa fa-sitemap signin-icon"></i> Flexible modular structure</li>
                <li><i class="fa fa-file-text-o signin-icon"></i> LESS &amp; SCSS source files</li>
                <li><i class="fa fa-outdent signin-icon"></i> RTL direction support</li>
                <li><i class="fa fa-heart signin-icon"></i> Crafted with love</li>
            </ul> <!-- / Info list -->
        </div>
        <!-- / Left side -->

        <!-- Right side -->
        <div class="signin-form">

            <!-- Form -->
            <form action="<?php echo site_url('welcome/login'); ?>" method="post"  id="signin-form_id">
                <div class="signin-text">
                    <span>Sign In to your account</span>
                </div> <!-- / .signin-text -->

                 <?php if(isset($error)) { ?>
                            <div class="alert alert-warning alert-dark"><?php echo $error; ?></div>
                <?php } ?>
                <div class="form-group w-icon">
                    <input type="text" name="login" pattern="^.{3,}$" class="form-control" placeholder="Username or email " required value="<?php echo set_value('login'); ?>">
                        <span class="fa fa-user signin-form-icon"></span>
                            <?php echo form_error('login', '<div class="alert alert-dark alert-danger">
                                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>   
                        <!-- / Username -->

                <div class="form-group w-icon">
                    <input type="password" name="password" pattern="^.{6,}$" class="form-control" placeholder="Your password" required>
                        <span class="fa fa-lock signin-form-icon"></span>
                            <?php echo form_error('password', '<div class="alert alert-dark alert-danger">
                                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>

                </div> <!-- / Password -->

                <div class="form-actions">
                    <input type="submit" value="SIGN IN" class="signin-btn bg-primary">
                        <a href="#" class="forgot-password" id="forgot-password-link">Forgot your password?</a>
                </div> <!-- / .form-actions -->
            </form>
            <!-- / Form -->

            <!-- "Sign In with" block -->
            <div class="signin-with">
                <!-- Facebook -->
                <a href="index.html" class="signin-with-btn" style="background:#4f6faa;background:rgba(79, 111, 170, .8);">Sign In with <span>Facebook</span></a>
            </div>
            <!-- / "Sign In with" block -->

            <!-- Password reset form -->
            <div class="password-reset-form" id="password-reset-form">
                <div class="header">
                    <div class="signin-text">
                        <span>Password reset</span>
                        <div class="close">×</div>
                    </div> <!-- / .signin-text -->
                </div> <!-- / .header -->
                
                <!-- Form -->
                <form action="index.html" id="password-reset-form_id" novalidate="novalidate">
                    <div class="form-group w-icon">
                        <input type="text" name="password_reset_email" id="p_email_id" class="form-control input-lg" placeholder="Enter your email">
                        <span class="fa fa-envelope signin-form-icon"></span>
                    </div> <!-- / Email -->

                    <div class="form-actions">
                        <input type="submit" value="SEND PASSWORD RESET LINK" class="signin-btn bg-primary">
                    </div> <!-- / .form-actions -->
                </form>
                <!-- / Form -->
            </div>
            <!-- / Password reset form -->
        </div>
        <!-- Right side -->
    </div>
    <!-- / Container -->

    <div class="not-a-member">
        Not a member? <a href="pages-signup.html">Sign up now</a>
    </div>

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
    <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script><script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!-- <![endif]-->
<!--[if lte IE 9]>
    <script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/pixel-admin.min.js') ?>"></script>

<script type="text/javascript">
    // Resize BG
    init.push(function () {
        var $ph  = $('#page-signin-bg'),
            $img = $ph.find('> img');

        $(window).on('resize', function () {
            $img.attr('style', '');
            if ($img.height() < $ph.height()) {
                $img.css({
                    height: '100%',
                    width: 'auto'
                });
            }
        });
    });

    // Show/Hide password reset form on click
    init.push(function () {
        $('#forgot-password-link').click(function () {
            $('#password-reset-form').fadeIn(400);
            return false;
        });
        $('#password-reset-form .close').click(function () {
            $('#password-reset-form').fadeOut(400);
            return false;
        });
    });

    // Setup Sign In form validation
    init.push(function () {
        $("#signin-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });
        
        // Validate username
        $("#username_id").rules("add", {
            required: true,
            minlength: 3
        });

        // Validate password
        $("#password_id").rules("add", {
            required: true,
            minlength: 6
        });
    });

    // Setup Password Reset form validation
    init.push(function () {
        $("#password-reset-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });
        
        // Validate email
        $("#p_email_id").rules("add", {
            required: true,
            email: true
        });
    });

    window.PixelAdmin.start(init);
</script>