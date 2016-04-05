# Kirby custom date field

Custom time form field for kirby that doesn’t use a datepicker.

## Installation

`git submodule add https://github.com/iksi/KirbyDateField.git site/fields/date`  
Or place a `date` folder in `/site/fields` with the repository’s contents.

## Usage

You can define the date field in your blueprint as follows:

```YAML
date:
  label: Date
  type: date
  format: Y-m-d
  default: now
```

Unlike the default date field it uses date formatting like php’s [date function](http://php.net/manual/en/function.date.php).