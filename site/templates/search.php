<? snippet('header') ?>
<? snippet('banner') ?>
<? $query = get('q'); ?>
<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <div class="page-header">
          <h1>Search Results: <?= $query; ?></h1>
      </div>
      <?= $page->text()->kirbytext() ?>
      <? $results = $site->search($query, ['words' => true])->paginate(500) ?>
      <? snippet('resources-table', [ 'results' => $results ]) ?>
    </div>
    <div class="col-md-3 col-md-pull-9">
      <? snippet('sidebar') ?>
    </div>
  </div>
</div>
<? // snippet('footer') ?>
<? snippet('footer', ['class' => 'blog']) ?>
