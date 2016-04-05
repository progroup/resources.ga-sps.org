<?php

kirbytext::$tags['iframe'] = array(
    'attr' => array(
        'height'
    ),
    'html' => function($tag) {
        $url    = $tag->attr('iframe');
        $height = $tag->attr('height', '100px');
	    return '<iframe style="width:100%;border-width:0;height:' . $height . '" src="' . $url . '" frameborder="0" scrolling="no"></iframe>';    
    }
);