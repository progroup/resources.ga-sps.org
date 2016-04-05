<?=
  page('resources')->children()->not('rss')->flip()->limit(10)->feed([
    'title' => $page->title(),
    'description' => $page->description(),
    'link' => 'resources',
  ])
?>
