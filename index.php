<?php
require_once('./User.php');
require_once('./validation/MenuValidation.php');
require_once('./validation/DepositValidation.php');
require_once('./validation/WithdrawValidation.php');
require_once('./validation/IdValidation.php');
require_once('./validation/PasswordValidation.php');

class Atm {
    //ログインユーザー
    private $select_user;
    //暗証番号のエラー限度回数（数値入力のみ）
    private const PASSWORD_COUNT = 3;
    private const MENU_LIST = "1お預け入れ 2お引き出し 3残高照会 9終了" . PHP_EOL;
    //メニュー: 1入金 2出金 3残高確認
    private const MENU_TYPE_DEPOSIT = 1;
    private const MENU_TYPE_WITHDRAWAL = 2;
    private const MENU_TYPE_BALANCE = 3;
    //メニュー: 9終了
    private const MENU_TYPE_END = 9;
    //ユーザー情報
    private const NAME ='name';
    private const ID ='id';
    private const PASSWORD = 'password';
    private const BALANCE = 'balance';
    
    private const MENU = 'menu';
    private const DEPOSIT = 'deposit';
    private const WITHDRAW = 'withdraw';
    //入金限度額、出金限度額
    public const DEPOSIT_LIMIT = 200000;
    public const WITHDRAW_LIMIT = 200000;
    //ユーザー数
    public const USER_COUNT = 2;

    public function  __construct() {
        $this->login();
        echo $this->select_user[self::NAME] . '様、ご希望のメニュー番号を入力してください。' . PHP_EOL;
    }

    private function login() {       
        echo 'ユーザーIDを入力してください。' . PHP_EOL;
        $id = $this->input(self::ID);
        //idと番号を合わせたキー番号でユーザーのデータを取得
        $this->select_user = User::getUserById($id);
        $this->checkPassword();
        return;
    }
    //暗証番号チェック
    public function checkPassword() {
        for ($i=1; $i <= self::PASSWORD_COUNT; $i++) {
            echo '暗証番号を入力してください' . PHP_EOL;
            $password = $this->input(self::PASSWORD);
            if($this->select_user[self::PASSWORD] !== $password)  {
                echo '暗証番号が違います。' . PHP_EOL;
            }
            if ($this->select_user[self::PASSWORD] === $password) {
                return true;
            }
            if ($i === self::PASSWORD_COUNT) {
                exit('強制終了します。' .PHP_EOL);
            }
        }
    }

    //基本メニュー
    public function play() {
        echo self::MENU_LIST;
        echo ': ';
        $selectMenu = $this->input(self::MENU);
        if ($selectMenu == self::MENU_TYPE_DEPOSIT) {
            $this->deposit();
            return $this->play();
        }
        if ($selectMenu == self::MENU_TYPE_WITHDRAWAL) {
            $this->atmWithdraw();
            return $this->play();
        }
        if ($selectMenu == self::MENU_TYPE_BALANCE) {
            $this->atmShow();
            return $this->play();
        }
        if ($selectMenu == self::MENU_TYPE_END) {
            $this->atmEnd();
            return $this->play();
        }
    }
    //入力
    public function input($type) {
        $input = trim(fgets(STDIN));
        if($type === self::MENU) {
            $validation = new MenuValidation();
            $check = $validation->check($input);
        }
        if($type === self::DEPOSIT) {
            $validation = new DepositValidation();
            $check = $validation->check($input);
        }
        if($type === self::WITHDRAW) {
            $validation = new WithdrawValidation();
            $check = $validation->check($input);
        }
        if($type === self::ID) {
            $validation = new IdValidation();
            $check = $validation->check($input);
        }
        if($type === self::PASSWORD) {
            $validation = new PasswordValidation();
            $check = $validation->check($input);
        }
        if(!$check) {
            $msgs = $validation->getErrorMessages();
            $this->showErrorMessages($msgs);
            return $this->input($type);
        }
        return $input;
    }
    //入金
    public function deposit() {
        $this->select_user[self::BALANCE];
        echo '入金額を入力してください。' . PHP_EOL;
        echo ': ';
        $depositMoney = $this->input(self::DEPOSIT);
        $this->select_user[self::BALANCE] += $depositMoney;
        echo number_format($depositMoney);
        echo '円お預かりしました。' . PHP_EOL;
        return;
    }
    //出金
    public function atmWithdraw() {
        $this->checkPassword();
        $this->select_user[self::BALANCE];
        echo '出金額を入力してください。' . PHP_EOL;
        echo ': ';
        $withdrawMoney = $this->input(self::WITHDRAW);
        if ($this->select_user[self::BALANCE] < $withdrawMoney) {
            echo '引き出し金額が残高を超えています。' .PHP_EOL;
            return $this->input(self::WITHDRAW);
        }
        $this->select_user[self::BALANCE] -= $withdrawMoney;
        echo number_format($withdrawMoney);
        echo '円です。取り忘れにご注意ください。' . PHP_EOL;
        return;
    }
    //残高照会
    public function atmShow() {
        $balance = $this->select_user[self::BALANCE];
        echo "¥" . number_format($balance) .PHP_EOL;
        return;
    }
    //終了
    public function atmEnd() {
        exit('ご利用、ありがとうございました。' . PHP_EOL);
    }
    //エラー表示
    public function showErrorMessages($msgs) {
        foreach($msgs as $msg) {
            echo $msg . PHP_EOL;
        }
    }
}

$ATM = new ATM();
$ATM -> play();
?>