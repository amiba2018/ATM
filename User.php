<?php
class User {
    private static $user_list = array(
        1 => array(
            "id" => "1",
            "password" => "1111",
            "name" => "アミバ",
            "balance" => "600000"
        ),
        2 => array(
            "id" => "2",
            "password" => "2222",
            "name" => "ジャキ",
            "balance" => "1000000"
        ),
    );

    public function checkUserList($id) {
        for($i = 1; $i <= atm::USER_COUNT; $i++) {
            if(self::$user_list[$i]['id'] === $id) {
                return true;
            }
        }
        return false;
    }

    public function getUserById($id) {
        return self::$user_list[$id];
    }
}

?>
