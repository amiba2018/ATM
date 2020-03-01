<?php
class BaseValidation { 
    private $error_messages = array();
    public function sharedCheck($input) {
        if($input === '') {
            $msg = '入力が確認できませんでした。';
            $this->setErrorMessage($msg);
            return false;
        }
        if(!(is_numeric($input))) {
            $msg = '数字を入力して下さい(半角)';
            $this->setErrorMessage($msg);
            return false;
        }
        return true;
    }

    public function setErrorMessage($msg) {
        $this->error_messages[] = $msg;
        return;
    }

    public function getErrorMessages() {
            return $this->error_messages;
    }
}
?>