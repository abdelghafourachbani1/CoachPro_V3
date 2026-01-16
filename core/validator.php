<?php

class Validator {

    private $errors = [];

    public function required($field, $value, $message = null) {
        if (empty($value)) {
            $this->errors[$field] = $message ?? "Le champ $field est requis.";
        }
        return $this;
    }

    public function email($field, $value, $message = null) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?? "L'email n'est pas valide.";
        }
        return $this;
    }

    public function minLength($field, $value, $min, $message = null) {
        if (strlen($value) < $min) {
            $this->errors[$field] = $message ?? "Le champ $field doit contenir au moins $min caracteres.";
        }
        return $this;
    }

    public function maxLength($field, $value, $max, $message = null) {
        if (strlen($value) > $max) {
            $this->errors[$field] = $message ?? "Le champ $field ne peut pas dépasser $max caracteres.";
        }
        return $this;
    }

    public function match($field, $value1, $value2, $message = null) {
        if ($value1 !== $value2) {
            $this->errors[$field] = $message ?? "Les champs ne correspondent pas.";
        }
        return $this;
    }

    public function numeric($field, $value, $message = null) {
        if (!is_numeric($value)) {
            $this->errors[$field] = $message ?? "Le champ $field doit être un nombre.";
        }
        return $this;
    }

    public function date($field, $value, $message = null)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);
        if (!$date || $date->format('Y-m-d') !== $value) {
            $this->errors[$field] = $message ?? "Le champ $field n'est pas une date valide.";
        }
        return $this;
    }

    public function fails() {
        return !empty($this->errors);
    }

    public function errors() {
        return $this->errors;
    }

    public function firstError() {
        return !empty($this->errors) ? reset($this->errors) : null;
    }
}
