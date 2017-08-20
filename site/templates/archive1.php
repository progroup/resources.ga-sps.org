<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <section id="blog">
        <header>
          <h1>Archive<? e(isset($archiveTitle), $archiveTitle) ?>:</h1>
        </header>

        <? if($posts->count()): ?>

        <?
        $tmpDate = getdate(0);
        foreach($posts as $post): ?>
          <? if(!isset($year)): ?>
            <?
              $date = getdate($post->date());
              if ($tmpDate['year'] != $date['year']): ?>
                <header class="archive-year">
                  <h2>
                    <?= $date['year'] ?>
                  </h2>
                </header>
            <? endif ?>
          <? endif ?>

          <article>
            <header>
              <h1>
                <a href="<?= getPostUrl($post) ?>">
                  <?= $post->title()->html() ?>
                </a>
              </h1>
            </header>

            <? snippet('post-footer', ['post' => $post]) ?>

          </article>
        <?
        if(!isset($year)) $tmpDate = $date;
        endforeach ?>

        <? else: ?>

          <?= $page->noposts()->kirbytext() ?>

        <? endif ?>

        <? snippet('nav-pagination') ?>

      </section>

      <?
        snippet('archives', [
          'dates' => true,
          'authors' => true,
          'tags' => true,
          'categories' => true
        ])
      ?>
    </div>
    <div class="col-md-3 col-md-pull-9">
      <? // snippet('tagcloud') ?>
      <? snippet('sidebar') ?>
    </div>
  </div>
</div>
<? snippet('footer') ?>
