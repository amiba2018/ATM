<?php
require_once('./validation/BaseValidation.php');
class MenuValidation extends BaseValidation {
    public function check($input) {
        $shared_check = $this->sharedCheck($input);
        if(!($shared_check)) {
            return false;
        }
        if (!($input >= 1 && $input <= 3)) {
            if (!($input == 9)) {
                $msg = '[1, 2, 3, 9]を入力してください。';
                $this->setErrorMessage($msg);
                return false;
            }
        }
        return true;
    }
}
?>