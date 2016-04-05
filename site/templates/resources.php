<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <div class="page-header">
        <h1><?= $page->title()->html() ?></h1>
      </div>
      <?= $page->text()->kirbytext() ?>
      <? $results = $page->children()->paginate(300) ?>
      <? snippet('resources-table', [ 'results' => $results ]) ?>
    </div>
    <div class="col-md-3 col-md-pull-9">
      <? // snippet('tagcloud') ?>
      <? snippet('sidebar') ?>
    </div>
  </div>
</div>
<? snippet('footer') ?>
