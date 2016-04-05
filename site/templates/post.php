<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container default">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <section id="post">
        <article>
          <header>
            <h1>
              <a href="<?= getPostUrl($post) ?>">
                <?= $post->title()->html() ?>
              </a>
            </h1>
          </header>
          <?
            snippet('post-footer', [
              'post' => $post,
              'author' => true,
              'avatar' => true,
              'tags' => true,
              'categories' => true
            ])
          ?>
          <?= getCoverImage($post) ?>

          <?= $post->text()->kirbytext() ?>
        </article>
        <?= snippet('nav-pager') ?>
      </section>
    </div>
    <div class="col-md-3 col-md-pull-9">
      <? snippet('sidebar') ?>
    </div>
  </div>
</div>
<? snippet('footer') ?>
