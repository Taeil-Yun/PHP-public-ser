<?php
require_once "imap_conn.php";
require_once "imap_decode.php";

class Imap_cls
{
    public $imap_conn;
    public $imap_decode;

    public function __construct()
    {
        $this->imap_conn = new Imap_conn();
        $this->imap_decode = new Imap_decode();
    }
}

?>