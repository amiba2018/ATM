<?php
require_once('./validation/BaseValidation.php');
class DepositValidation extends BaseValidation {
    public function check($input ,$msg = null) {
        $shared_check = $this->sharedCheck($input) ;
        if(!($shared_check)) {
            return false;
        }
        if ($input > atm::DEPOSIT_LIMIT) {
            $msg = '入金限度額を超えています';
            $this->setErrorMessage($msg);
        }
        if ($input == 0) {
            $msg = '最低入金額は1000円です';
            $this->setErrorMessage($msg);
        }
        if ($input % 1000 !== 0) {
            $msg = 'このATMでは小銭はご入金できません';
            $this->setErrorMessage($msg);
        }
        if($msg) {
            return false;
        }
        return true;
    }
}

?>
