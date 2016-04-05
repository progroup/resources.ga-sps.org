<? // $query = get('q'); ?>
<? // echo $page->text()->kirbytext() ?>
<? // $results = $site->search($query, ['words' => true])->paginate(500) ?>
<? // snippet('resources-table', [ 'results' => $results ]) ?>

<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <section id="search">

      <? if($query): ?>

        <div class="page-header">
          <h1>Search Results: <? echo $query; ?></h1>
        </div>

        <h1><?= $page->resultTitle() ?> "<?= $query ?>"</h1>

          <section id="searchresults">
          <? if($results != "" ): ?>

            <? foreach($results as $result): ?>
              <article>

                    <? if($result->template() == 'post'): ?>
                      <header>
                        <h1>
                          Post:
                          <a href="<?= getPostUrl($result) ?>">
                            <?= $result->title()->html() ?>
                          </a>
                        </h1>
                      </header>

                      <? snippet('post-footer', array('post' => $result)) ?>

                    <? else: ?>
                      <header>
                        <h1>
                          Page:
                          <a href="<?= $result->url() ?>">
                            <?= $result->title()->html() ?>
                          </a>
                        </h1>
                      </header>
                    <? endif ?>


              </article>

            <? endforeach ?>

        <? else: ?>
          <?= $page->noposts()->kirbytext() ?>
        <? endif ?>
        </section>
      <? else: ?>
       <h1><?= $page->title() ?></h1>
       <?= $page->nosearch()->kirbytext() ?>
      <? endif ?>

      </section>

    </div>
    <div class="col-md-3 col-md-pull-9">
      <? snippet('sidebar') ?>
    </div>
  </div>
</div>
<? snippet('footer', ['class' => 'blog']) ?>
