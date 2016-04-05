<section id="posts">
  <? foreach($posts as $post): ?>
    <article>
      <header>
        <h3>
          <a href="<?= getPostUrl($post) ?>">
            <?= $post->title()->html() ?>
          </a>
        </h3>
      </header>

      <?
        snippet('post-footer', [
          'post' => $post,
          'author' => true,
          'tags' => true,
          'category' => true
        ])
      ?>

      <?= getCoverImage($post) ?>
      <?= $post->text()->kirbytext() ?>
    </article>
  <? endforeach ?>
  <? snippet('nav-pagination') ?>
</section>
