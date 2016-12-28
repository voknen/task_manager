<?php
include_once '../functions.php';

if (!isset($_COOKIE['is_logged'])) {
    header("Location: login.php");
    exit();
}
get_header();
?>
        <div class="main_menu_user">

        </div>

        <form id="add-task" action="../library/ajax.php" method="post" class="form-position">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Enter task title"><br/>
            <label for="deadline">Deadline</label>
            <input type="text" name="deadline" id="deadline" placeholder="Enter task deadline"><br/>
            <label for="info">Additional Info</label>
            <textarea name="info" placeholder="Enter additional task info"></textarea><br/>
            <input type="hidden" name="action" value="add_task_action">
            <input type="submit" value="Add"><br/>
        </form>
<?php
include_stylesheets();
include_scripts(); 
get_footer();
?>