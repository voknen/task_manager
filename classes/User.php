<?php 

class User
{
    private $id;
    private $username;
    private $password;
    private $createdAt;

    public function exchangeArray($data)
    {
        $this->username = (isset($data['username'])) ? $data['username'] : '';
        $this->password = (isset($data['password'])) ? $data['password'] : '';
        $this->createdAt = (isset($data['createdAt'])) ? $data['createdAt'] : '';
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}