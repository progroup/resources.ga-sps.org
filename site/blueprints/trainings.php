<?php if(!defined('KIRBY')) exit ?>

title: Training
pages: false
files: false
preview: parent
deletable: false
fields:
  title: Training
    label: Title
    type: text
  trainings:
    label: Training
    type: structure
    entry: >
      <b>Date:</b> {{date}}<br>
      <b>Training:</b> {{training}}<br>
      <b>Modality:</b> {{modality}}<br>
      <b>CEUS:</b> {{ceus}}<br>
      <b>Archived:</b> {{archived}}<br>
      <b>Description:</b><br> {{description}}<br>
      <b>Logistics:</b><br> {{logistics}}
    fields:
      date:
        label: Date
        type: text
        width: 1/2
      modality:
        label: Modality
        type: text
        width: 1/2
      training:
        label: Training
        type: text
      description:
        label: Description
        type: textarea
        size: small
      logistics:
        label: Logistics
        type: textarea
      ceus:
        label: CEUs
        type: text
        width: 1/2
      archived:
        label: Archived
        type: text
        width: 1/2
