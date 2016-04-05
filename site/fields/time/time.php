<?php

class TimeField extends InputField {

    public $override = false;

    public function __construct() {
        $this->icon   = 'clock-o';
        $this->format = 24;
    }

    public function format() {
        return ($this->format === 12) ? 'h:i A' : 'H:i';
    }

    public function value() {
        if ($this->override()) {
            $value = $this->default();
        } else {
            $value = parent::value();
        }

        if (empty($value) || $value === 'now') {
            return date($this->format(), time());   
        }

        return date($this->format(), strtotime($value));
    }

    public function maxlength() {
        return ($this->format === 12) ? 8 : 5;
    }

    public function input() {
        $input = parent::input();
        $input->attr('maxlength', $this->maxlength());

        return $input;
    }

    public function validate() {
        $pattern = ($this->format === 12)
            ? '/^(0[0-9]|1[0-2]):[0-5][0-9] (AM|PM)$/'
            : '/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/';

        return preg_match($pattern, $this->value());
    }
}