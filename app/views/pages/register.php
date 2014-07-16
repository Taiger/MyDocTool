<div class="row">
  <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 col-xs-10 col-xs-offset-1">
    <?php echo validation_errors(); ?>
    <div class="form-signin">
      <?php echo form_open('login/register_user'); ?>
      <h2 class="form-signin-heading">Register</h2>
      <h3>DISABLED FOR NOW.</h3>

      <input type="text" autofocus="" required="" placeholder="Username" class="form-control">
      <br>
      <input type="password" required="" placeholder="Password" class="form-control">
      <br>
       <!--<label class="checkbox">
        <input type="checkbox" value="remember-me"> Remember me
      </label> -->

      <button type="submit" value="Submit" class="btn btn-md btn-primary disabled">Register</button>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>