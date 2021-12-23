<?php
class User {
    private $id;
    private $username;
    private $hash;

    public function __construct($id=null, $username, $hash) {
        $this->id = $id;
        $this->username = $username;
        $this->hash = $hash;
    }

    public function getID() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getHash() {
        return $this->hash;
    }

    public function getJSON() {
        return json_encode(get_object_vars($this));
    }
}
