<?php if ($page->uid() == 'resources' || $page->uid() == 'search' ) : ?>
    <div class="banner banner-resources"></div>
<?php elseif($page->uid() == 'about') : ?>
    <div class="banner banner-about"></div>
<?php elseif($page->uid() == 'training') : ?>
    <div class="banner banner-training"></div>
<?php elseif($page->uid() == 'calendar') : ?>
    <div class="banner banner-calendar"></div>
<?php elseif($page->uid() == 'help') : ?>
    <div class="banner banner-help"></div>
<?php elseif($page->uid() == 'learn') : ?>
    <div class="banner banner-learn"></div>
<?php else : ?>
    <div class="banner banner-default"></div>
<?php endif ?>
