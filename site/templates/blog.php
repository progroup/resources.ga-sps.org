<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <? foreach($articles as $article): ?>
      <!-- the code for each article goes here -->
      <? endforeach ?>

      <nav class="pagination">

        <? if($pagination->hasPrevPage()): ?>
        <a href="<?= $pagination->prevPageUrl() ?>">previous articles</a>
        <? endif ?>

        <? if($pagination->hasNextPage()): ?>
        <a href="<?= $pagination->nextPageUrl() ?>">next articles</a>
        <? endif ?>

      </nav>
    </div>
    <div class="col-md-3 col-md-pull-9">
      <? // snippet('tagcloud') ?>
      <? snippet('sidebar') ?>
    </div>
  </div>
</div>
<? snippet('footer') ?>
