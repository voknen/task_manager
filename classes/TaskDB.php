<?php

require 'Task.php';

class TaskDB extends Task
{
    public function addTask($data)
    {
        $task = new Task();
        $task->exchangeArray($data);
        
        $databaseConnect = new DBConnect();
        $connection = $databaseConnect->connect();

        $stmt = $connection->prepare("INSERT INTO tasks(title, info, deadline, status, user_id) 
                                      VALUES(:title, :info, :deadline, :status, :user_id);");
        $stmt->bindParam(':title', $task->getTitle(), PDO::PARAM_STR);
        $stmt->bindParam(':info', $task->getInfo(), PDO::PARAM_STR);
        $stmt->bindParam(':deadline', $task->getDeadline(), PDO::PARAM_STR);
        $stmt->bindParam(':status', $task->getStatus(), PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $task->getUserId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function selectTasks($taskId = null)
    {
        $databaseConnect = new DBConnect();
        $connection = $databaseConnect->connect();

        $query = "SELECT id, title, deadline, info, status FROM tasks";

        if ($taskId) {
            $query .= " WHERE id = '" . $taskId . "' AND user_id = :user_id";
        } else {
            $query .= " WHERE user_id = :user_id ORDER BY deadline DESC ";
        }

        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user_id', $_COOKIE['id'], PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function editTask($data)
    {   
        $task = new Task();
        $task->exchangeArray($data);

        $task->setUserId($_COOKIE['id']);

        $databaseConnect = new DBConnect();
        $connection = $databaseConnect->connect();

        $stmt = $connection->prepare("UPDATE tasks SET title = :title, info = :info, deadline = :deadline, status = :status WHERE user_id = :user_id AND id = :id;");  
        $stmt->bindParam(':title', $task->getTitle(), PDO::PARAM_STR);
        $stmt->bindParam(':info', $task->getInfo(), PDO::PARAM_STR);
        $stmt->bindParam(':deadline', $task->getDeadline(), PDO::PARAM_STR);
        $stmt->bindParam(':status', $task->getStatus(), PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $task->getUserId(), PDO::PARAM_INT);
        $stmt->bindParam(':id', $task->getId(), PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->rowCount();
    }

    public function completeTask($data)
    {
        $task = new Task();
        $task->exchangeArray($data);

        $task->setUserId($_COOKIE['id']);

        $databaseConnect = new DBConnect();
        $connection = $databaseConnect->connect();

        $stmt = $connection->prepare("UPDATE tasks SET status = 'finished' WHERE id = :id AND user_id = :user_id;");
        $stmt->bindParam(':id', $task->getId(), PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $task->getUserId(), PDO::PARAM_INT);
        $stmt->execute();
    }
}