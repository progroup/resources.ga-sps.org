<?php
  $tagcloud = tagcloud(
    page('resources'), [
      'limit' => 200,
      'children' => 'all',
      'sort' => 'tag'
    ]
  )
?>
<ul>
<?php foreach($tagcloud as $tag): ?>
    <li><a href="<?php echo $tag->url() ?>"><?php echo $tag->name() ?></a></li>
<?php endforeach ?>
</ul>
