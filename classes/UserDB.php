<?php

require 'User.php';
require '../database/DBconnect.php';

class UserDB extends User
{
    public function addUser($data)
    {
        $user = new User();
        $user->exchangeArray($data);
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);//hashes the password 
        $user->setPassword($hashedPassword);
        $user->setCreatedAt(date("Y-m-d"));//assign to the date of registration the current date
        $databaseConnect = new DBConnect();
        $connection = $databaseConnect->connect();
        
        $stmt = $connection->prepare("INSERT INTO users(username, password, created_at) 
                                      VALUES(:username, :hashedPassword, :createdAt);");
        $stmt->bindParam(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindParam(':hashedPassword', $user->getPassword(), PDO::PARAM_STR);
        $stmt->bindParam(':createdAt', $user->getCreatedAt(), PDO::PARAM_STR);
        $stmt->execute();
    } 

    public function selectUser($data)
    {   
        $user = new User();
        $user->exchangeArray($data);

        $databaseConnect = new DBConnect();
        $connection = $databaseConnect->connect();

        $login = array('loginPassword' => false);

        $stmt = $connection->prepare("SELECT id, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if (password_verify($user->getPassword(), $result->password) == true) {
            $login = array(
                'loginPassword' => true,
                'user_id'       => $result->id
            );
        }

        return $login;
    }

    public function isUserExists($username)
    {
        $exists = false;

        $user = new User();
        $user->setUsername($username);

        $databaseConnect = new DBConnect();
        $connection = $databaseConnect->connect();

        $stmt = $connection->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            $exists=true;
        }
        
        return $exists;
    }
}