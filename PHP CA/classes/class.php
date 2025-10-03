<?php
class todo{
    public string $title;
    public string $dueDate;
    public bool $status = false ;
    public function __construct(string $title,string $dueDate) {
        $this->title = $title;
        $this->dueDate = $dueDate;
    }

    public function markAsCompleted(){

        $this->status = true;
        return $this;
    }

}