<!DOCTYPE html>
<html>
  <head>
    <title>Admin Login</title>
    <?php $url_prefix = $this->webspice->settings()->site_url_prefix; ?>
    <!-- Bootstrap -->
    <link href="<?php $url_prefix; ?>global/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php $url_prefix; ?>global/admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<?php $url_prefix; ?>global/admin/assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?php $url_prefix; ?>global/admin/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">

      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>

        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <input type="email" id="user_email" class="input-block-level" name="user_email" value="<?php echo set_value('user_email'); ?>" placeholder="Email address" required>
        <span class="fred"><?php echo form_error('user_email'); ?></span>

        <input type="password" class="input-block-level" id="user_password" name="user_password" value="" placeholder="Password" required>
        <span class="fred"><?php echo form_error('user_email'); ?></span>

        <!-- <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->

        <input type="submit" class="btn btn-large btn-primary" value="Sign in" />

      </form>

    </div> <!-- /container -->
    <script src="<?php $url_prefix; ?>global/admin/vendors/jquery-1.9.1.min.js"></script>
    <script src="<?php $url_prefix; ?>global/admin/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>