<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container default">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <? //snippet('breadcrumb') ?>
      <div class="page-header">
        <h1><?= $page->title()->html() ?></h1>
      </div>
      <?= $page->text()->kirbytext() ?>

      <ul class="list-unstyled">

        <? foreach ($page->files() as $file): ?>
          <li style="margin-bottom:1em">
            <a href="<?= $file->url() ?>">
              <? // echo str::upper($file->title()->or($file->name())) ?>
              <?= titlecase(tagunslug($file->title()->or($file->name()))) ?>
            </a><br>
            <?= $file->description() ?>
            <time>
              <?= $file->modified('l jS \of F Y h:i:s A') ?>
            </time>
          </li>

          <li>
            <? if (str::contains($file->extension(), 'doc')): ?>
              <i class="fa fa-file-word-o"></i>
            <? endif ?>

            <? if ($file->extension() == "pdf"): ?>
              <i class="fa fa-file-pdf-o"></i>
            <? endif ?>

            <? if (str::contains($file->extension(), 'xls')): ?>
              <i class="fa fa-file-excel-o"></i>
            <? endif ?>

            <? if (str::contains($file->extension(), 'ppt')): ?>
              <i class="fa fa-file-excel-o"></i>
            <? endif ?>

            <a href="<?= $file->url() ?>">
              <? if ($file->type() == 'image'): ?>
                <img src="<?= $file->url() ?>" style="width: 100%">
              <? else: ?>
                <?= titlecase(tagunslug($file->name())) ?>
              <? endif ?>
            </a><br>
            <?= $file->description() ?>
            <time>
              <?= $file->modified('l jS \of F Y h:i:s A') ?>
            </time>
          </li>
        <? endforeach ?>
      </ul>
    </div>
    <div class="col-md-3 col-md-pull-9">
      <? snippet('sidebar') ?>
    </div>
  </div>
</div>
<? snippet('footer') ?>
