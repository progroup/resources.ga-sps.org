<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <h2>Latest Projects</h2>

      <ul>
        <? foreach(page('projects')->children()->visible()->limit(3) as $project): ?>
        <li>
          <a href="<?= $project->url() ?>">
            <img src="<?= $project->cover()->url() ?>" alt="<?= $project->title() ?>" />
          </a>
        </li>
        <? endforeach ?>
      </ul>
    </div>
    <div class="col-md-3 col-md-pull-9">
      <? // snippet('tagcloud') ?>
      <? snippet('sidebar') ?>
    </div>
  </div>
</div>
<? snippet('footer') ?>
