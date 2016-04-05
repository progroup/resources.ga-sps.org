<?php if(!defined('KIRBY')) exit ?>

title: Post
pages:false
files:
  sortable:true
fields:
  title:
    label: Title
    type:  text
  date:
    label: Date
    type: date
    width: 1/2
    format: Y-m-d
    default: now
    width: 1/2
  author:
    label: Author
    type: user
    width: 1/2
  coverimage:
    label: Coverimage
    type: select
    options: images
    width: 1/2
  category:
    label: Primary Category
    type: select
    width: 1/2
    options:
      introduction-to-app: Introduction to App
      webinars: Webinars
      tools: Tools
      spf: Strategic Prevention Framework
      app-strategies: App Strategies
      suicide-prevention: Suicide Prevention
      genrx: GenRX
      admin: Admin
  tags:
    label: Tags
    type: tags
    lowercase: true
  text:
    label: Text
    type: textarea
    requiered: true

