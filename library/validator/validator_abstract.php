<?php

class ValidatorAbstract
{
    protected $errors = array();
    protected $data = array();

    public function isValid($data)
    {
        foreach($this->fields as $field => $rules) {
            foreach($rules as $rule => $ruleData) {
                $params = isset($ruleData['params']) ? $ruleData['params'] : null;
                $value = isset($data[$field]) ? $data[$field] : null;

                if(method_exists($this, $rule)) {
                    if($rule == 'equals') {
                        $params['token'] = $data[$params['token']];
                    }

                    $isValid = $this->{$rule}($value, $params);
                    if($isValid) {
                        $this->data[$field] = $value;
                    } else {
                        $this->errors[$field][] = $rule;
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getErrors()
    {
        $errors = array();
        foreach($this->errors as $field => $rules) {
            foreach($rules as $rule) {
                // Getting only 1 error per field
                $rule = current($rules);
                if(isset($this->fields[$field][$rule])) {
                    $errors[$field][$rule] = $this->fields[$field][$rule]['message'];
                }
                if(isset($this->files[$field][$rule])) {
                    $errors[$field][$rule] = $this->files[$field][$rule]['message'];
                }
            }
        }

        return $errors;
    }

    // rules
    protected function required($value)
    {
        // Check if the form value is array (birthdate)
        if(is_array($value)) {
            foreach($value as $val) {
                if(empty($val)) {
                    return false;
                }
            }

            return true;
        } elseif(is_string($value)) {
            $value = trim($value);
            return !!strlen($value);
        } else {
            return !empty($value);
        }
    }

    protected function digits($value)
    {
        return preg_match('/^[+\d -]+$/',$value);
    }
}