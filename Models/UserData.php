<?php

class UserData
{
    /**
     * @var int $id
     * @var string $username
     * @var string $name
     * @var string $pwd
     * @var string $photo
     * @var string $phoneNo
     */
    protected $id, $username, $name , $pwd , $photo, $phoneNo;

    /** Retrieving User information
     * @param $dbRow
     */
    public function __construct($dbRow) {
        $this->id = $dbRow['idUsers'];
        $this->username = $dbRow['Username'];
        $this->name = $dbRow['Realname'];
        $this->photo = $dbRow['ProfilePhoto'];

        //hashing password for security

        $this->phoneNo = $dbRow['PhoneNo'];
    }


    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhoneNo() {
        return $this->phoneNo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $phoneNo
     */
    public function setPhoneNo($phoneNo)
    {
        $this->phoneNo = $phoneNo;
    }
    
    



}