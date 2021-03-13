<?php
require_once "imap_cls.php";

Class Gmail_imap extends Imap_cls
{

    //connection
    public $conn;

    // 배열 선언
    public $html;
    public $file = [];
    public $mix = [];

    // Gmail 가져오기
    public function import_mail($mbox)
    {
        $result = [];
        // mailbox에 따른 imap connect
        $this->imap_conn->connectIMAP($mbox);
        $this->conn = $this->imap_conn->conn;

        // connect한 mail함의 전체 메일 개수
        $emailData = imap_search($this->conn, 'ALL');

        // 메일이 존재하는 경우
        if (!empty($emailData)) {

            // emailData = 총 메일 개수, email = 각 이메일의 번호
            foreach ($emailData as $email) {
                $gm_file = "";
                $overview = imap_fetch_overview($this->conn, $email, 0);  //  메일 정보 가져오기
                $gm_subject = imap_utf8($overview[0]->subject);  //  제목
                $gm_from = $this->imap_decode->emailFormat(imap_utf8($overview[0]->from));  //  발신자
                $gm_to = $this->imap_decode->emailFormat(imap_utf8($overview[0]->to));  //수신자
                $gm_date = date("d F, Y", strtotime($overview[0]->date));  //보낸날짜
                $gm_message_id = $overview[0]->message_id;
                $gm_size = $overview[0]->size;
                $gm_uid = $overview[0]->uid;
                $gm_msgno = $overview[0]->msgno;
                $gm_recent = $overview[0]->recent;
                $gm_flagged = $overview[0]->flagged;
                $gm_answered = $overview[0]->answered;
                $gm_deleted = $overview[0]->deleted;
                $gm_seen = $overview[0]->seen;
                $gm_draft = $overview[0]->draft;
                $gm_udate = $overview[0]->udate;
                $hText = imap_fetchbody($this->conn, $gm_uid, '0', FT_UID);
                $headers = imap_rfc822_parse_headers($hText);
                $header = json_encode($headers);
                $header = json_decode($header, true);
                $gm_references = isset($header['ccaddress']) ? $this->imap_decode->emailFormat($header['ccaddress']) : NULL;  // 참조
                $gm_reply_to = isset($header['reply_toaddress']) ? $this->imap_decode->emailFormat(imap_utf8($header['reply_toaddress'])) : NULL;  // 답장보내는 곳

                if ($mbox == "INBOX") {
                    $gm_mbox = 0;
                } else if ($mbox == mb_convert_encoding("[Gmail]/스팸함", "UTF7-IMAP", "utf-8")) {
                    $gm_mbox = 1;
                }

                $struct = imap_fetchstructure($this->conn, $email);  // 메일구조
                $subtype = $struct->subtype;  // 메일타입 (대분류)

                // switch 시작 : subtype으로 나눔
                switch ($subtype) {

                    case "PLAIN":
                        $gm_content = $this->extract_text($email, $struct, 1);
                        str_replace("\n", "<br>", $gm_content);
                        break;

                    case "ALTERNATIVE":
                        $gm_content = $this->trans_alternative($email, $struct);
                        break;

                    case "MIXED":
                        $mix = $this->trans_mixed($email, $struct);
                        $gm_content = $mix['gm_content'];
                        $gm_file = $mix['file_name'];
                        break;

                    case "RELATED":
                        $gm_content = $this->trans_related($email, $struct);
                        break;

                } // --switch 끝--
                $result[$email] = compact("gm_subject", "gm_from", "gm_to", "gm_date", "gm_message_id", "gm_references", "gm_reply_to", "gm_size", "gm_uid", "gm_msgno", "gm_recent", "gm_flagged", "gm_answered", "gm_deleted", "gm_seen", "gm_draft", "gm_udate", "gm_content", "gm_file", "gm_mbox");
            } // --foreach(emailData) 끝--
        } // --if 메일이 존재하는 경우 끝--
        return $result;
    } // --FUNC : selectIMAP 끝--

    function extract_text($email, $struct, $section)
    {
        $body = imap_fetchbody($this->conn, $email, $section, FT_PEEK);
        $body = $this->imap_decode->bodyDecode($struct->encoding, $body);
        return str_replace('"', '\"', $body);
    }

    //본문 func : extract_body
    function extract_body($email, $part, $section = "", $j)
    {
        // ** struct 내의 parts 의 j번째 (PLAIN,HTML,RELATED) // ** stdClass Object -> Array()
        $subtype = $part->subtype;
        if ($subtype == "PLAIN" || $subtype == "HTML") {
            $gm_content = $this->extract_text($email, $part, $section . ($j + 1));
        } else if ($subtype == "RELATED") {
            $gm_content = $this->trans_related($email, $part, $section . ($j + 1));
        } else if ($subtype == "ALTERNATIVE") {
            $gm_content = $this->trans_alternative($email, $part, $section . ($j + 1));
        }
        return $gm_content;
    }

    // subtype : ALTERNATIVE
    function trans_alternative($email, $l_part, $section = "")
    {
        $gm_content = "";
        if ($section != "") $section = (string)$section . ".";
        // struct 내의 parts 갯수만큼 반복 (PLAIN,HTML)
        for ($j = 0; $j < count($l_part->parts); $j++) {
            $m_part = (($l_part->parts)[$j]);
            $gm_content = $this->extract_body($email, $m_part, $section, $j);
        } // --for 문 끝--
        return $gm_content;
    } // --FUNC : trans_alternative 끝--

    // subtype : RELATED
    function trans_related($email, $l_part, $section = "")
    {
        if ($section != "") $section = (string)$section . ".";
        for ($l = 0; $l < count($l_part->parts); $l++) {
            $m_part = (($l_part->parts)[$l]);
            if (!isset($m_part->dparameters)) {
                $this->html = $this->extract_body($email, $m_part, $section, $l);
            } else {
                $this->file['id'] = str_replace(array("<", ">"), "", $m_part->id);
                //파일
                $file_data = imap_fetchbody($this->conn, $email, $section . ($l + 1));
                $this->file['file_data'] = "data:" . $this->imap_decode->bodyType($m_part->type) . "/" . strtolower($m_part->subtype) . ";" . $this->imap_decode->encodeType($m_part->encoding) . "," . $file_data;
                $this->html = str_replace("cid:" . $this->file['id'], $this->file['file_data'], $this->html);
            }
        }
        $this->file = [];
        return $this->html;
    } // --FUNC : trans_related 끝--

    // subtype : MIXED
    function trans_mixed($email, $l_part, $section = "")
    {
        $this->mix = [];
        $this->file = [];
        if ($section != "") $section = (string)$section . ".";
        for ($m = 0; $m < count($l_part->parts); $m++) {
            $m_part = (($l_part->parts)[$m]);
            if (!isset($m_part->dparameters)) {
                $this->mix['gm_content'] = $this->extract_body($email, $m_part, $section, $m);
            } else {
                array_push($this->file, $this->fileDown($email, $m_part, $section . ($m + 1)));
            }
        }
        $this->mix['file_name'] = implode(",", $this->file);
        return $this->mix;
    } // --FUNC : trans_mixed 끝--

    function fileDown($email, $m_part, $section)
    {
        $attachments = array(
            'is_attachment' => false,
            'filename' => '',
            'name' => '',
            'attachment' => ''
        );

        if ($m_part->ifdparameters) {
            foreach ($m_part->dparameters as $object) {
                if (strtolower($object->attribute) == "filename") {
                    $attachments['is_attachment'] = true;
                    $attachments['filename'] = $object->value;
                }
            }
        }

        if ($m_part->ifparameters) {
            foreach ($m_part->parameters as $object) {
                if (strtolower($object->attribute) == "name") {
                    $attachments['is_attachment'] = true;
                    $attachments['name'] = $object->value;
                }
            }
        }

        if ($attachments['is_attachment']) {
            $attachments['attachment'] = imap_fetchbody($this->conn, $email, $section, FT_PEEK);
            if ($m_part->encoding == 3) { // 3 = BASE64
                $attachments['attachment'] = base64_decode($attachments['attachment']);
            } else if ($m_part->encoding == 4) { // 4 = QUOTED-PRINTABLE
                $attachments['attachment'] = quoted_printable_decode($attachments['attachment']);
            }
        }

        $file_name = time() . "_" . imap_utf8($attachments['name']);
        $file_name = preg_replace("/\s+/", "", $file_name);
        $file_data = $attachments['attachment'];
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/static/file/" . $file_name, $file_data);
        return $file_name;
    }


    function send_mail()
    {

        //imap_mail 함수 사용
        //('받는사람','제목','내용')
        //내용은 iamp_mail_compose 함수 사용
        //(envelope,body)
        //envelope : remail,return_path,date,from,reply_to,in_reply_to,subject,to,cc,bcc,message_id,custom_headers
        //body : type, encoding, charset,type.parameters,subtype,id,description,disposition.type

    }


}


?>