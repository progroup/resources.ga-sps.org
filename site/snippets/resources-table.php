<table class="table resources-table">
    <thead>
        <tr>
            <th data-orderable="false">Type</th>
            <th>Resource</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $result) : ?>
            <?php foreach ($result->files()->sortBy('modified', 'desc') as $file) : ?>
                <tr>
                    <td class="file-type">
                        <?php if (str::contains($file->extension(), 'doc')) : ?>
                            <span>Word</span>
                            <i class="fa fa-file-word-o"></i>
                        <?php endif ?>
                        <?php if ($file->extension() == 'pdf') : ?>
                            <span>PDF</span>
                            <i class="fa fa-file-pdf-o"></i>
                        <?php endif ?>
                        <?php if (str::contains($file->extension(), 'xls')) : ?>
                            <span>Excel</span>
                            <i class="fa fa-file-excel-o"></i>
                        <?php endif ?>
                        <?php if (str::contains($file->extension(), 'ppt')) : ?>
                            <span>Powerpoint</span>
                            <i class="fa fa-file-powerpoint-o"></i>
                        <?php endif ?>
                        <?php if ($file->type() == 'image') : ?>
                            <span>Image</span>
                            <i class="fa fa-file-image-o"></i>
                        <?php endif ?>
                        <?php if ($file->type() == 'video') : ?>
                            <span>Video</span>
                            <i class="fa fa-file-video-o"></i>
                        <?php endif ?>
                    </td>
                    <td class="resource">
                        <a href="<?php echo $file->url() ?>">
                            <?php echo $file->title()->titlecase()->or($file->page()->title()->titlecase()) ?>
                        </a>
                        <br>
                        <?php echo $file->description()->or($file->page()->description()) ?>
                    </td>
                    <td class="date">
                        <?php // echo $file->modified('m/d/Y') ?>
                        <?php
                            if ( $result->date('m/d/Y')) {
                                echo $result->date('m/d/Y');
                            } else {
                                echo $file->modified('m/d/Y');
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endforeach ?>
    </tbody>
</table>
<?php if($results->pagination()->hasPages()) : ?>
    <nav>
        <ul class="pager">
        <?php if($results->pagination()->hasPrevPage()) : ?>
            <li class="previous">
                <a class="prev" href="<?php echo $results->pagination()->prevPageURL() ?>">
                    <span aria-hidden="true">&larr;</span> Previous
                </a>
            </li>
        <?php endif ?>
        <?php if($results->pagination()->hasNextPage()) : ?>
            <li class="next">
                <a class="next" href="<?php echo $results->pagination()->nextPageURL() ?>">
                    Next <span aria-hidden="true">&rarr;</span>
                </a>
            </li>
        <?php endif ?>
        </ul>
    </nav>
<?php endif ?>
