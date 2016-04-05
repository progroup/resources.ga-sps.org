<?php

field::$methods['quote'] = function($field, $start = '“', $end = '”') {
    $field->value = $start . $field->value . $end;
    return $field;
};
