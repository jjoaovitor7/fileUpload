<?php
class File {
    private $id;
    private $file__name;
    private $file;
    private $mime__type;
    private $owner__id;

    public function __construct($id=null, $file__name, $file, $mime__type, $owner__id) {
        $this->id = $id;
        $this->file__name = $file__name;
        $this->file = $file;
        $this->mime__type = $mime__type;
        $this->owner__id = $owner__id;
    }

    public function getID() {
        return $this->id;
    }

    public function getFileName() {
        return $this->file__name;
    }

    public function getFile() {
        return $this->file;
    }

    public function getMimeType() {
        return $this->mime__type;
    }

    public function getOwnerID() {
        return $this->owner__id;
    }

    public function getJSON() {
        return json_encode(get_object_vars($this));
    }
}
