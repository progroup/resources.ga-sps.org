<?php foreach ($results as $result) : ?>
    <?php foreach ($result->files()->sortBy('modified', 'desc') as $file) : ?>
|Resource|<?php echo $file->page()->category()?>|<?php echo $file->title()->titlecase()->or($file->page()->title()->titlecase()) ?>|<?php echo $file->description()->or($file->page()->description()) ?>|[<?php echo $file->tags()->or($file->page()->tags()) ?>]|
    <?php endforeach ?>
<?php endforeach ?>
