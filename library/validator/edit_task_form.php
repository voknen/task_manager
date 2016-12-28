<?php
include 'validator_abstract.php';

class EditTaskForm extends ValidatorAbstract
{
    protected $fields = array(
        'title' => array(
            'required' => array(
                'message' => 'This field is required'
            )
        ),
        'deadline' => array(
            'required' => array(
                'message' => 'This field is required'
            ),
        ),
        'info' => array(
            'required' => array(
                'message' => 'This field is required'
            ),
        ),
        'status' => array(
            'required' => array(
                'message' => 'This field is required'
            ),
        )
    );
}

return new EditTaskForm();