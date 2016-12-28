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

$tasks = $taskDB->selectTasks();
?>
        <div class="main_menu_user">
        </div>

        <div class="table-position">
            <?php if (!empty($tasks)) : ?>
                <table>
                    <th>№</th>
                    <th>Title</th>
                    <th>Deadline</th>
                    <th>Info</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                    <?php foreach ($tasks as $key => $task) : ?>
                        <tr>
                            <td><?php echo $key + 1 ; ?></td>
                            <td><?php echo $task->title; ?></td>
                            <td><?php echo $task->deadline; ?></td>
                            <td><?php echo $task->info; ?></td>
                            <td>
                                <p class="<?php echo $task->status; ?>">
                                    <strong><?php echo $task->status; ?></strong>
                                </p>
                            </td>
                            <td><a href="/task_manager/views/edit_task.php?id=<?php echo $task->id; ?>">Edit</a></td>
                            <?php if ($task->status != 'finished') : ?>
                                <td>
                                    <a href="javascript: void(0);" class="complete-task" data-task-id="<?php echo $task->id; ?>" onclick = "return confirm('Are you sure to complete the task?')">Complete</a>
                                </td>
                            <?php endif; ?>    
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>    
        </div>

<?php
include_stylesheets();
include_scripts(); 
get_footer();
?>