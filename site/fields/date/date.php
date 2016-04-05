<?php

class DateField extends InputField {

    public $override = false;

    public function __construct()
    {
        $this->type   = 'date';
        $this->icon   = 'calendar';
        $this->label  = l::get('fields.date.label', 'Date');
        $this->format = 'd-m-Y';
    }

    public function value() {
        if ($this->override()) {
            $this->value = $this->default();
        }

        if (empty($this->value)) {
            return date($this->format, time());
        }

        return date($this->format, strtotime($this->value));
    }

    public function validate() {
        return v::date($this->result());
    }
}