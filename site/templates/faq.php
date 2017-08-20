<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container default">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <? //snippet('breadcrumb') ?>
      <div class="page-header">
        <h1><?= $page->title()->html() ?></h1>
      </div>
      <?= $page->question()->kirbytext() ?>
      <?= $page->answer()->kirbytext() ?>

    </div>
    <div class="col-md-3 col-md-pull-9">

    </div>
  </div>
</div>
<? snippet('footer') ?>
