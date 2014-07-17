  <div class="row">
    <div class="col-md-6 col-md-offset-3">
<h2><?php print $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open('guide/create', array('class' => 'sg-guide-createnew')); ?>

<div class="control-group">
  <label for="radios" class="control-label">Category: </label>
  <div class="form-control">
    <label for="radios-0" class="radio radio-inline">
      <input type="radio" checked="checked" value="general" id="radios-0" name="radios">
      General
    </label>
    <label for="radios-1" class="radio radio-inline">
      <input type="radio" value="tech" id="radios-1" name="radios">
      Tech
    </label>
  </div>
</div>
<br>

  <input class="form-control" type="input" id="title" name="title" autofocus placeholder="Title" value="<?php set_value('title'); ?>" /><br />

  <textarea id="ckedit1" class="form-control" id="text" name="text" placeholder="Content" value="<?php set_value('text'); ?>" ></textarea><br />

  <input type="submit" name="submit" value="Create New Doc" class="btn btn-lg btn-primary btn-block" />

<?php echo form_close(); ?>
</div>
</div><!-- /.row -->