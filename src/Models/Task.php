<?php

namespace etask\Models;

class Task
{
    private $id;
    private $name;
    private $description;
    private $status;
    private $urgent;
    private $user_id;


    public function __construct($name, $description, $urgent, $user_id )
    {
        $this->name = $name;
        $this->description = $description;
        $this->urgent = $urgent;
        $this->user_id = $user_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getUrgent()
    {
        return $this->urgent;
    }

    public function setUrgent($urgent)
    {
        $this->urgent = $urgent;
    }


}

