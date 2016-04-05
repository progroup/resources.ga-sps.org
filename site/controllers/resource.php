<?php

return function($site, $pages, $page) {

  // rename page to resource to be consistent
  $resource = $page;

  // pass all variables to the template
  return compact('resource');

};

?>
