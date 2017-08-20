<?php if(!defined('KIRBY')) exit ?>

title: FAQ
pages: false
preview: parent
fields:
  question:
    label: Question
    type:  text
  answer:
    label: Answer
    type:  textarea
  topic:
    label: Primary Topic
    type: select
    width: 1/2
    options:
      ecco: Using ECCO
      asapp: Alcohol and Substance Abuse Prevention Project
      suicide-prevention: Suicide Prevention
      red-ribbon-week: Red Ribbon Week
      contracts: Contracts
      genrx: Prescription Drug Abuse Prevention (GENRx)
      dbhdd-obhp: DBHDD/OBHP
      ceus: Continuing Education
  date:
    label: Published Date
    type: date
    width: 1/2
    format: Y-m-d
    default: now
  tags:
    label: Tags
    type: tags
    # width: 1/2
    lower: true
