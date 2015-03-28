<?php
use \bariew\postModule\widgets\CategoryMenu;

$this->beginContent('@app/views/layouts/main.php');
?>
<div class="container">
    <div class="row clearfix">
      <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 menu-col">
          <?= CategoryMenu::widget() ?>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 menu-col-2"> 
          <?php echo $content ?>
      </div>
    </div>
</div>

<?php $this->endContent() ?>