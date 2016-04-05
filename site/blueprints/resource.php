<?php if(!defined('KIRBY')) exit ?>

title: Resource
pages: false
preview: parent
files:
  fields:
    title:
      label: Title
      type: text
    description:
      label: Description
      type: textarea
    tags:
      label: Tags
      type: tags
fields:
  title:
    label: Title
    type:  text
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
  date:
    label: Published Date
    type: date
    width: 1/2
    format: Y-m-d
    default: now
  description:
    label: Description
    type:  textarea
  tags:
    label: Tags
    type: tags
    # width: 1/2
    lower: true
  author:
    label: Author
    type: user
    width: 1/2
    default: editor

  # authors:
  #   label: Authors
  #   type: users
  # date:
  #   label: Date
  #   type: date
  #   width: 1/2
  #   default: today
