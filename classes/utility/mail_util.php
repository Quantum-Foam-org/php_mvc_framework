<?php
require_once 'Mail.php';
require_once 'Mail/mime.php';

class mail_util {

    private $host = '';
    private $port = '';
    private $user = '';
    private $password = '';
    private $from = '';
    private $to = '';
    private $subject = '';
    private $body = '';

    public function __construct($host, $port, $user, $password) {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
    }

    public function set_from($from) {
        $this->from = filter_var($from, FILTER_VALIDATE_EMAIL);
        if (!$this->from) {
            logger::obj()->write('Invalid from: ' . $from, -1);
        }
        return $this;
    }

    public function set_to($to) {
        $this->to = filter_var($to, FILTER_VALIDATE_EMAIL);
        if (!$this->to) {
            logger::obj()->write('Invalid to: ' . $to, -1);
        }
        return $this;
    }

    public function set_subj($subject) {
        $this->subject = $subject;
        return $this;
    }

    public function set_body($text, $html = null) {
        $headers = array(
            'From' => $this->from,
            'To' => $this->to,
            'Subject' => $this->subject
        );

        $mime = new Mail_mime(array('eol' => "\r\n"));

        $mime->setTxtBody($text);
        if ($html) {
            $mime->setHTMLBody($html);
        }

        $this->body = $mime->get();
        $this->headers = $mime->headers($headers);
        return $this;
    }

    public function send() {
        if ($this->from !== FALSE && $this->to !== FALSE) {
            $mail = Mail::factory('smtp', array('host' => $this->host, 'port' => $this->port, 'username' => $this->user, 'password' => $this->password, 'auth' => 'PLAIN'));
            if (PEAR::isError($mail->send($this->to, $this->headers, $this->body))) {
                logger::obj()->write('Unable to send email', -1);
                $result = FALSE;
            } else {
                $result = TRUE;
            }
        } else {
            $result = FALSE;
        }
        
        return $result;
    }
}
