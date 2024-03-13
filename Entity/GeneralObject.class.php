<?php 

abstract class GeneralObject {
    protected $id;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->createdAt = new Datetime();
    }

    public function getId(){
        return $this->id;
    }
    public function setId(int $id){
        $this->id=$id;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }
    public function getUpdatedAt(){
        return $this->updatedAt;
    }
    public function setCreatedAt(Datetime $createdAt){
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt(Datetime $updatedAt){
        $this->updatedAt = $updatedAt;
    }

}
