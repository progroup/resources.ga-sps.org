<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-push-3">

      <? // snippet('posts') ?>
      <section>
        <?= $page->text()->kirbytext() ?>
        <? $results = $page->children()->visible()->paginate(300) ?>
        <? snippet('posts-table', [ 'results' => $results ]) ?>
      </section>

    </div>
    <div class="col-md-3 col-md-pull-9">
      <? // snippet('tagcloud') ?>
      <? snippet('sidebar') ?>
      <?
        // snippet('archives', [
        //   'dates' => true,
        //   'authors' => true,
        //   'tags' => true,
        //   'categories' => true])
      ?>
    </div>
  </div>
</div>
<? snippet('footer') ?>
