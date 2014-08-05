  <div class="row">
    <div class="col-md-16">
  <h2><?php //print $title; ?></h2>

  <h1>Edit Page</h1>
  <div><em>Now editing file <?php echo $file_to_edit; ?>.html </em><a class="" href="<?php echo $base_url .'guide/'. $file_to_edit; ?>">cancel</a></div>
  <hr>

  <?php echo validation_errors(); ?>

  <?php echo form_open('guide/edit/' . $file_to_edit, array('class' => 'sg-guide-edit')); ?>


  <textarea id="ckedit1" class="form-control" name="text" placeholder="Content" ><?php if(isset($form_default_text)) echo $form_default_text; ?></textarea>

  <br />

  <input type="submit" name="submit" value="Update" class="btn btn-lg btn-primary btn-block" />

</form>
</div>
</div><!-- /.row -->
