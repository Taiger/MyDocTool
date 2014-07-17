  <div class="row">
    <div class="col-md-12">
      <h2><?php print $title; ?></h2>

        <?php echo validation_errors(); ?>


    <?php echo form_open('guide/createdoc', array('class' => 'sg-guide-createnew')); ?>

    <div class="control-group">
      <label for="type" class="control-label">Category: </label>
      <div class="form-control">
        <label for="type-0" class="radio radio-inline">
          <input type="radio" checked="checked" value="general" id="type-0" name="type">
          General
        </label>
        <label for="type-1" class="radio radio-inline">
          <input type="radio" value="tech" id="type-1" name="type">
          Tech
        </label>
      </div>
    </div>
    <br>

    <input class="form-control" type="input" id="title" name="title" autofocus placeholder="Title" value="<?php set_value('title'); ?>" /><br />

    <textarea id="ckedit1" class="form-control" id="text" name="text" placeholder="Content" ><?php if(isset($form_default_text)) echo $form_default_text; ?></textarea><br />

    <input type="submit" name="submit" value="Create New Doc" class="btn btn-lg btn-primary btn-block" />

    <?php echo form_close(); ?>
  </div>
</div><!-- /.row -->