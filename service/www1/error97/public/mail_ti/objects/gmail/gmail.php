<?php
$path = $_SERVER["DOCUMENT_ROOT"];

use PHPMailer\PHPMailer\PHPMailer;

require_once($path . '/static/lib/PHPMailer-master/src/Exception.php');
require_once($path . '/static/lib/PHPMailer-master/src/PHPMailer.php');
require_once($path . '/static/lib/PHPMailer-master/src/SMTP.php');

class Gmail
{
    private $table_name = "ex_sns_mail";

    public $gm_idx;
    public $gm_subject;
    public $gm_from;
    public $gm_to;
    public $gm_date;
    public $gm_message_id;
    public $gm_references;
    public $gm_reply_to;
    public $gm_size;
    public $gm_uid;
    public $gm_msgno;
    public $gm_recent;
    public $gm_flagged;
    public $gm_answered;
    public $gm_deleted;
    public $gm_seen;
    public $gm_draft;
    public $gm_udate;
    public $gm_content;
    public $gm_file;
    public $gm_mbox;

    function mailer()
    {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";
        $mail->Username = 'test@gmail.com';
        $mail->Password = 'test password';
        $mail->SMTPDebug = 2;
        $mail->CharSet = "utf-8";
        $mail->SetFrom($this->gm_from);
        $mail->AddAddress($this->gm_to);
        $mail->Subject = $this->gm_subject;
        if ($this->gm_references != NULL || $this->gm_references != "") $mail->addCC($this->gm_references);
        $mail->isHtml(true);
        $mail->Body = $this->gm_content;

        if ($this->gm_file != NULL || $this->gm_file != "") {
            $path = $_SERVER['DOCUMENT_ROOT'];
            $gm_file_arr = explode(',', $this->gm_file);
            foreach ($gm_file_arr as $key => $value) {
                $mail->addAttachment($path . '/static/file/' . $value);
            }
        }

        if ($mail->send()) {
            $this->gm_date = $mail->header_arr['Date'];
            $this->gm_message_id = $mail->header_arr['Message-ID'];
            return true;
        } else {
            return false;
        }
    }

    function insertData($db, $param)
    {
        if ($db->insert($this->table_name, $param)) {
            return true;
        } else {
            return false;
        }
    }

    function selectData($db, $row, $join = null, $where, $limit = null)
    {
        if ($result = $db->select($this->table_name, $row, $join, $where, ' gm_udate desc', $limit)) {
            return $result;
        } else if (count($result) == 0) {
            return "no result";
        } else {
            return false;
        }
    }

    function updateData($db, $param, $where)
    {
        if ($db->update($this->table_name, $param, $where)) {
            return true;
        } else {
            return false;
        }
    }

}

?>

