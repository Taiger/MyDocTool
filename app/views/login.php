<div class="row">
  <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 col-xs-10 col-xs-offset-1">

       <?php if (isset($error) && $error): ?>
      <div class="alert alert-error">
      <a class="close" data-dismiss="alert" href="#">×</a>Incorrect Username or Password!
      </div>
      <?php endif; ?>

    <div class="form-signin">
      <?php echo form_open('login/login_user'); ?>
      <h2 class="form-signin-heading">Please sign in</h2>


       <input id="username" name="username" type="text" autofocus="" required="" placeholder="Username" class="form-control">
      <br>
      <input id="password" name="password" type="password" required="" placeholder="Password" class="form-control">
      <br>

       <!--<label class="checkbox">
        <input type="checkbox" value="remember-me"> Remember me
      </label> -->

      <button type="submit" value="Submit" class="btn btn-md btn-primary">Sign in</button>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>