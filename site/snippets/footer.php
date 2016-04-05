</main>

<footer class="site-footer">
  <?php snippet('footer-links') ?>
  <?php snippet('rss-link') ?>
  <div class="container small">
    <?php echo $site->disclaimer()->kirbytext() ?>
  </div>
</footer>

<?php include_once("analyticstracking.php") ?>

<?php echo js('//code.jquery.com/jquery-1.11.3.min.js') ?>
<?php echo js('//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js') ?>
<?php echo js('//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js') ?>
<?php echo js('//s3.amazonaws.com/scripts.hellobar.com/db5100bd0d00d770fd80b188dbabf1529f1e4ff7.js') ?>

<?php if ($page->isHomePage()) : ?>
  <?php echo js('assets/royalslider/jquery.royalslider.min.js') ?>
  <?php echo js('assets/js/home.js') ?>
<?php endif ?>

<?php echo js('/assets/js/bootstrap-datepicker.js') ?>
<?php echo js('assets/js/app.js') ?>
<?php echo js('assets/js/jquery.cbpNTAccordion.min.js') ?>

<script>
  $(function() {
    $('#cbp-ntaccordion').cbpNTAccordion();
  });
</script>

<?php
  if($q = get('q')) {
    $results = $site->index()->search($q, 'tags')->invisible()->filterBy('template', 'resource');
    // $results = $pages->search($q)->visible()->filterBy('template', 'article');

    echo $results;
  }
?>

<?php
  // $tags = page('resources')->children()->pluck('tags', ',', true);
  // $tags = array_map(function($tag) {
  //   $count = page('resources')->children()->filterBy('tags', $tag, ',')->count();
  //   return array('name' => $tag, 'count' => $count);
  // }, $tags);
?>

<!-- <ul> -->
<?php // foreach($tags as $tag): ?>
    <!-- <li> -->
        <?php // echo $tag['name'] ?>
        <!-- ( <?php // echo $tag['count'] ?> ) -->
    <!-- </li> -->
<?php // endforeach ?>
<!-- </ul> -->

</body>
</html>
