<?php

class Imap_conn
{
    private $server = "{imap.gmail.com:993/imap/ssl}";
    private $email = "test@gmail.com";
    private $password = "test password";

    public $conn;
    public $selected;

    //소멸자
    public function __destruct()
    {
        $this->closeIMAP();
    }

    public function connectIMAP($mbox)
    {
        $this->selected = $this->server . $mbox;
        $this->conn = imap_open($this->selected, $this->email, $this->password) or die('Cannot connect to Gmail: ' . imap_last_error());
    }

    function closeIMAP()
    {
        imap_close($this->conn);
    }


}

?>
