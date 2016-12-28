<?php
include 'validator_abstract.php';

class RegisterForm extends ValidatorAbstract
{
    protected $fields = array(
        'username' => array(
            'required' => array(
                'message' => 'This field is required'
            ),
        ),
        'password' => array(
            'required' => array(
                'message' => 'This field is required'
            ),
        )
    );
}

return new RegisterForm();