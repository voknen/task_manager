<?php
include_once '../functions.php';
?>
<?php 
if(isset($_COOKIE['is_logged'])){
    header("Location: index.php");
    exit();
}

get_header();
?>
        <form id="login-form" action="../library/ajax.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Enter your username"><br/>
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter your password"><br/>
            <input type="hidden" name="action" value="login_form_action">
            <input type="submit" value="Log in"><br/>
            <a href="/task_manager/views/register.php">You are new?</a>
        </form>
<?php
include_stylesheets();
include_scripts(); 
get_footer();
?>