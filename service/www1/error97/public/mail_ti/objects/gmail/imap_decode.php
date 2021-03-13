<?php

class Imap_decode
{
    //  bodyDecode($encoding,body) - 인코딩 타입에 따라 body 값을 Decode
    //  bodyType($type) - bodyType을 string으로 변환
    //  encodeType($encoding) - encodingType을 string으로 변환
    //  emailFormat($string) - string에 <,>가 포함되지 않은 경우 앞뒤로 더해서 반환

    function bodyDecode($encoding, $body)
    {
        switch ($encoding) {
            case 0: // 7bit
            case 1: // 8bit
                $body = imap_base64(imap_binary(imap_qprint(imap_8bit($body))));
                break;
            case 2: // binary
                $body = imap_base64(imap_binary($body));
                break;
            case 3: // base64
                $body = imap_base64($body);
                break;
            case 4: // quoted-print
                $body = imap_base64(imap_binary(imap_qprint($body)));
                break;
            case 5: // other
                exit;
        }
        return $body;
    }

    function bodyType($type)
    {
        switch ($type) {
            case 0:
                $type = "text";
                break;
            case 1:
                $type = "multipart";
                break;
            case 2:
                $type = "message";
                break;
            case 3:
                $type = "application";
                break;
            case 4:
                $type = "audio";
                break;
            case 5:
                $type = "image";
                break;
            case 6:
                $type = "video";
                break;
            case 7:
                $type = "model";
                break;
            case 8:
                $type = "other";
                break;
            default:
                exit;
        }
        return $type;
    }

    function encodeType($encoding)
    {
        switch ($encoding) {
            case 0:
                $encoding = "7bit";
                break;
            case 1:
                $encoding = "8bit";
                break;
            case 2:
                $encoding = "binary";
                break;
            case 3:
                $encoding = "base64";
                break;
            case 4:
                $encoding = "quoted-printable";
                break;
            case 5:
                $encoding = "other";
                exit;
        }
        return $encoding;
    }

    function emailFormat($string)
    {
        if (strpos($string, "<") !== false) {
            return $string;
        } else {
            return "<" . $string . ">";
        }
    }
}

?>