<?php if(!defined('KIRBY')) exit ?>

title: Page
pages: true
files: false
fields:
  title:
    label: Title
    type:  text
  text:
    label: Text
    type:  textarea
  date:
    label: Published Date
    type: date
    width: 1/2
    format: Y-m-d
    default: now
