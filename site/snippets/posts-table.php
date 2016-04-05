<table class="table resources-table">
  <thead>
    <tr>
      <th data-orderable="false">Type</th>
      <th>Resource</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($results as $result) : ?>
      <? foreach ($result->files()->sortBy('modified', 'desc') as $file) : ?>
        <tr>
          <td class="file-type">
            <? if (str::contains($file->extension(), 'doc')) : ?>
              <span>Word</span>
              <i class="fa fa-file-word-o"></i>
            <? endif ?>
            <? if ($file->extension() == 'pdf') : ?>
              <span>PDF</span>
              <i class="fa fa-file-pdf-o"></i>
            <? endif ?>
            <? if (str::contains($file->extension(), 'xls')) : ?>
              <span>Excel</span>
              <i class="fa fa-file-excel-o"></i>
            <? endif ?>
            <? if (str::contains($file->extension(), 'ppt')) : ?>
              <span>Powerpoint</span>
              <i class="fa fa-file-powerpoint-o"></i>
            <? endif ?>
            <? if ($file->type() == 'image') : ?>
              <span>Image</span>
              <i class="fa fa-file-image-o"></i>
            <? endif ?>
            <? if ($file->type() == 'video') : ?>
              <span>Video</span>
              <i class="fa fa-file-video-o"></i>
            <? endif ?>
          </td>
          <td class="resource">
            <a href="<?= $file->url() ?>">
              <?= $file->title()->titlecase()->or($file->page()->title()->titlecase()) ?>
            </a>
            <br>
            <?= $file->description()->or($file->page()->description()) ?><br>
            <?
              snippet('resource-footer', [
                'post' => $result,
                'author' => false,
                'tags' => false,
                'category' => false
              ])
            ?>
          </td>

          <td class="date">
            <? //= $file->modified('m/d/Y') ?>
            <?
              if ( $result->date('m/d/Y')) {
                echo $result->date('m/d/Y');
              } else {
                echo $file->modified('m/d/Y');
              }
            ?>
          </td>
        </tr>
      <? endforeach ?>
    <? endforeach ?>
  </tbody>
</table>
<? if($results->pagination()->hasPages()) : ?>
  <nav>
    <ul class="pager">
    <? if($results->pagination()->hasPrevPage()) : ?>
      <li class="previous">
        <a class="prev" href="<?= $results->pagination()->prevPageURL() ?>">
          <span aria-hidden="true">&larr;</span> Previous
        </a>
      </li>
    <? endif ?>
    <? if($results->pagination()->hasNextPage()) : ?>
      <li class="next">
        <a class="next" href="<?= $results->pagination()->nextPageURL() ?>">
          Next <span aria-hidden="true">&rarr;</span>
        </a>
      </li>
    <? endif ?>
    </ul>
  </nav>
<? endif ?>
