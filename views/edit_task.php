<?php
include_once '../functions.php';
include_once '../database/DBconnect.php';
include_once '../classes/TaskDB.php';

if (!isset($_COOKIE['is_logged'])) {
    header("Location: login.php");
    exit();
}
get_header();

$taskDB = new TaskDB();

$task = array();

if (is_numeric($_GET['id'])) {
    $task = $taskDB->selectTasks(htmlspecialchars($_GET['id']));

    if (!empty($task)) {
        $task = $task[0];
    }
}
?>
        <div class="main_menu_user">

        </div>

        <form id="edit-task" action="../library/ajax.php" method="post" class="form-position">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Enter task title" value="<?php echo isset($task->title) ? $task->title : ''; ?>"><br/>
            <label for="deadline">Deadline</label>
            <input type="text" name="deadline" id="deadline" placeholder="Enter task deadline" value="<?php echo isset($task->deadline) ? $task->deadline : ''; ?>"><br/>
            <label for="info">Additional Info</label>
            <textarea name="info" placeholder="Enter additional task info" ><?php echo isset($task->info) ? $task->info : ''; ?></textarea><br/>
            <label for="status">Status</label>
            <select name="status">
                <option value="new" <?php echo isset($task->status) && $task->status == 'new' ? 'selected' : '' ?>>New</option> 
                <option value="overdue" <?php echo isset($task->status) && $task->status == 'overdue' ? 'selected' : '' ?>>Overdue</option>
                <option value="finished" <?php echo isset($task->status) && $task->status == 'finished' ? 'selected' : '' ?>>Finished</option>       
            </select><br/>
            <input type="hidden" name="id" value="<?php echo is_numeric($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?>">
            <input type="hidden" name="action" value="edit_task_action">
            <input type="submit" value="Edit"><br/>
        </form>
<?php
include_stylesheets();
include_scripts(); 
get_footer();
?>