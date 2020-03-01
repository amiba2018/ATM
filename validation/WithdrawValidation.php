<?php
require_once('./validation/BaseValidation.php');
class WithdrawValidation extends BaseValidation {
    public function check($input, $msg = null) {
        $shared_check = $this->sharedCheck($input) ;
        if(!($shared_check)) {
            return false;
        }
        if ($input > atm::WITHDRAW_LIMIT) {
            $msg = '引き出し金額が上限を超えています。';
            $this->setErrorMessage($msg);
        }
        if ($input == 0) {
            $msg = '最低引き出し額は1000円です';
            $this->setErrorMessage($msg);
        }
        if ($input  % 1000 !== 0) {
            $msg = 'このATMでは小銭はお引き出しできません';
            $this->setErrorMessage($msg);
        }
        if($msg) {
            return false;
        }
        return true;
    }
}

?>
