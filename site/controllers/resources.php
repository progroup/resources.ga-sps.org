<?php
    return function($site, $pages, $page) {

      // get all resources
      $resources = $page->children()->visible()->flip();

      // add pagination
      $resources = $resources->paginate(c::get('pagination-posts'));
      $pagination = $resources->pagination();

      // pass all variables to the template
      return compact('resources', 'pagination');
    }
?>
