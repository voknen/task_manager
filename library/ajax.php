<?php

require '../classes/UserDB.php';
require '../classes/TaskDB.php';

if ($_POST['action'] == 'register_form_action') {
    $post_data = $_POST;
    unset($post_data['action']);
    register_action($post_data);
} else if ($_POST['action'] == 'login_form_action') {
    $post_data = $_POST;
    unset($post_data['action']);
    login_action($post_data);
} else if ($_POST['action'] == 'add_task_action') {
    $post_data = $_POST;
    unset($post_data['action']);
    add_task_action($post_data);
} else if ($_POST['action'] == 'edit_task_action') {
    $post_data = $_POST;
    unset($post_data['action']);
    edit_task_action($post_data);
} else if ($_POST['action'] == 'complete_task_action'){
    $post_data = $_POST;
    unset($post_data['action']);
    complete_task_action($post_data);
}

function login_action($data)
{
    $validator = include 'validator/login_form.php';

    if ($validator->isValid($data)) {
        
        $userDB = new UserDB();
        $success = $userDB->selectUser($data);

        if (!$success['loginPassword']) {
            http_response_code(400);
            $json_string = json_encode(array(
                "username" => array(
                    "exists" => "Username or password are wrong"
                ),
                "password" => array(
                    "exists" => "Username or password are wrong"
                )
            ));
            echo $json_string;
        } else {
            http_response_code(200);
            $json_string = json_encode(array(
                "user_id"   => $success['user_id'],
                "is_logged" => true
            ));
            echo $json_string;            
        }
    } else {
        http_response_code(400);
        $json_string = json_encode($validator->getErrors());
        echo $json_string;
    }
    header('Content-type: application/json');
}

function register_action($data)
{    
    $validator = include 'validator/register_form.php';
    
    if ($validator->isValid($data)) {
        $userDB = new UserDB();

        if ($userDB->isUserExists($data['username'])) {
            http_response_code(400);
            $json_string = json_encode(array("username" => array("exists" => "Already registered")));
            echo $json_string;
        } else {
            $userDB->addUser($data);
            http_response_code(200);
            $json_string = json_encode(array("success" => "Your registration is successful"));
            echo $json_string;
        }           

    } else {
        http_response_code(400);
        $json_string = json_encode($validator->getErrors());
        echo $json_string;
    }
    header('Content-type: application/json');
}

function add_task_action($data)
{
    $validator = include 'validator/add_task_form.php';
    
    if ($validator->isValid($data)) {
        $data['userId'] = $_COOKIE['id'];
        $data['status'] = 'new';

        $taskDB = new TaskDB();
        $taskDB->addTask($data);

        http_response_code(200);
        $json_string = json_encode(array("success" => "Your task is added successfully"));
        echo $json_string;            
    } else {
        http_response_code(400);
        $json_string = json_encode($validator->getErrors());
        echo $json_string;
    }
    header('Content-type: application/json');
}

function edit_task_action($data)
{
    if ($data['id'] != '') {
        $validator = include 'validator/edit_task_form.php';
        if ($validator->isValid($data)) {

            $taskDB = new TaskDB();

            if (!$taskDB->editTask($data)) {
                http_response_code(400);
                $json_string = json_encode(array("title" => array("exists" => "Wrong ID or same data")));
                echo $json_string;
            } else {
                http_response_code(200);
                $json_string = json_encode(array("success" => "Your task is edited successfully"));
                echo $json_string;            
            }
        } else {
            http_response_code(400);
            $json_string = json_encode($validator->getErrors());
            echo $json_string;
        }
    } else {
        http_response_code(400);
        $json_string = json_encode(array("title" => array("exists" => "Wrong ID")));
        echo $json_string;
    }
    
    header('Content-type: application/json');
}

function complete_task_action($data)
{
    $taskDB = new TaskDB();
    $taskDB->completeTask($data);

    http_response_code(200);
    $json_string = json_encode(array("success" => true));
    echo $json_string;
    header('Content-type: application/json');
}