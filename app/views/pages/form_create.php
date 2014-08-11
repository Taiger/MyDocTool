  <div class="row">
    <div class="col-md-12">
      <h2><?php print $title; ?></h2>

        <?php echo validation_errors(); ?>


    <?php echo form_open('pattern/createpat', array('class' => 'sg-createnew')); ?>

    <div class="control-group">
      <label for="type" class="control-label">Category: </label>
      <div class="form-control">
        <label for="type-0" class="radio radio-inline">
          <input type="radio" checked="checked" value="atoms" id="type-0" name="type">
          Atom
        </label>
        <label for="type-1" class="radio radio-inline">
          <input type="radio" value="molecules" id="type-1" name="type">
          Molecule
        </label>
        <label for="type-2" class="radio radio-inline">
          <input type="radio" value="components" id="type-2" name="type">
          Component
        </label>
        <label for="type-3" class="radio radio-inline">
          <input type="radio" value="templates" id="type-3" name="type">
          Template
        </label>
        <label for="type-4" class="radio radio-inline">
          <input type="radio" value="pages" id="type-4" name="type">
          Page
        </label>
      </div>
    </div>
    <br>

    <input class="form-control" type="input" id="title" name="title" placeholder="Title" value="<?php set_value('title'); ?>" /><br />

    <div style="height:300px; width:100%; position:relative;">
      <pre style="height:300px; width:100%; position:absolute;" id="aceeditor"></pre><br />
    </div>

    <textarea id="text" class="form-control" id="text" name="text" placeholder="Content" ><?php if(isset($form_default_text)) echo $form_default_text; ?></textarea><br />

    <input type="submit" name="submit" value="Create New" class="btn btn-lg btn-primary btn-block" />

    <?php echo form_close(); ?>
  </div>
</div><!-- /.row -->
