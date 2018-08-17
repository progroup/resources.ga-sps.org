<?php
header('Content-type: application/json; charset=utf-8');

$resources = $pages->find('resources')->children()->flip();
$json = array();

foreach($resources as $resource) {
    foreach ($resource->files()->sortBy('modified', 'desc') as $file) {

        if (str::contains($file->extension(), 'doc')) { $filetype = 'Word'; }
        if ($file->extension() == 'pdf') { $filetype = 'PDF'; }
        if (str::contains($file->extension(), 'xls')) { $filetype = 'Excel'; }
        if (str::contains($file->extension(), 'ppt')) { $filetype = 'PowerPoint'; }
        if ($file->type() == 'image') { $filetype = 'Image'; }
        if ($file->type() == 'video') { $filetype = 'Video'; }

        $json[] = array(
            'channel' => 'Resources',
            'category' => (string)$file->page()->category(),
            'url'   => (string)$file->url(),
            'title' => (string)$resource->title()->titlecase(),
            'description'  => (string)$resource->description(),
            'filetype' => (string)$filetype,
            '_tags' => (array)str::split($resource->tags()->titlecase()),
            'date'  => (string)$resource->date(),
        );
    }
}

echo json_encode($json);

?>
