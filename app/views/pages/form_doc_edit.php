  <div class="row">
    <div class="col-md-6 col-md-offset-3">
  <h2><?php //print $title; ?></h2>

  <?php echo validation_errors(); ?>

  <?php echo form_open('guide/editdoc', array('class' => 'sg-guide-edit')); ?>


  <h2><?php if(isset($editing_message)) echo $editing_message; ?></h2>


  <textarea id="ckedit1" class="form-control" name="text" placeholder="Content" ><?php if(isset($form_default_text)) echo $form_default_text; ?></textarea>

  <br />

  <input type="submit" name="submit" value="Update" class="btn btn-lg btn-primary btn-block" />

</form>
</div>
</div><!-- /.row -->