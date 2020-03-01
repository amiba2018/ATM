<?php
require_once('./validation/BaseValidation.php');
class PasswordValidation extends BaseValidation {
    public function check($input) {
        $shared_check = $this->sharedCheck($input);
        if(!($shared_check)) {
            return false;
        }
        return true;
    }
}
?>