<?php
require_once('./validation/BaseValidation.php');
class IdValidation extends BaseValidation {
    public function check($input) {
        $shared_check = $this->sharedCheck($input);
        if(!($shared_check)) {
            return false;
        }
        if(!User::checkUserList($input)) {
            $msg = '登録したid番号を入力してください';
            $this->setErrorMessage($msg);
            return false;
        }
        return true;
    }
}
?>