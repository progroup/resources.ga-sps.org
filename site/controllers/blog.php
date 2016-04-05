<?php

return function($site, $pages, $page) {

  // get all articles and add pagination
  $articles = $page->children()->visible()->flip()->paginate(20);

  // add a tag filter
  if($tag = param('tag')) {
    $articles = $articles->filterBy('tags', '=', urldecode($tag), ',');
  }

  // create a shortcut for pagination
  $pagination = $articles->pagination();

  // pass $articles and $pagination to the template
  return compact('articles', 'pagination');

};
