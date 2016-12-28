<?php 

class Task
{
    private $id;
    private $title;
    private $info;
    private $deadline;
    private $userId;
    private $status;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : '';
        $this->title = (isset($data['title'])) ? $data['title'] : '';
        $this->info = (isset($data['info'])) ? $data['info'] : '';
        $this->deadline = (isset($data['deadline'])) ? $data['deadline'] : '';
        $this->userId = (isset($data['userId'])) ? $data['userId'] : '';
        $this->status = (isset($data['status'])) ? $data['status'] : '';
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getStatus()
    {
        return $this->status;
    }
}