<?php foreach ($results as $result) : ?>
    <?php foreach ($result->files()->sortBy('modified', 'desc') as $file) : ?>
        <option>
            <?php echo $file->title()->titlecase()->or($file->page()->title()->titlecase()) ?>
        </option>
    <?php endforeach ?>
<?php endforeach ?>
