<?php

class exAuth extends \local\classes\session\Main {

    
    public static function login($username, $password) {
        $db = db::obj();
        
        $id = $db->get_val('SELECT id FROM users WHERE username = ?'
                .' AND password = MD5(?) AND active = 1', array($username, $password));

        if ($id) {
            $st = $db->prepare('UPDATE users SET accessed = CURRENT_TIMESTAMP WHERE username = ?'
                    .' AND password = MD5(?)');
            $st->execute(array($username, $password));

            if ($st->rowCount() != 1) {
                $id = FALSE;
                logger::obj()->write('Unable to verify authentication for user: ' . __CLASS__ . '::login error on update');
            }
        }

        if ($id != FALSE) {
            $login = self::obj();
            $login->session_set('ex_auth', array(
                'id' => (int)$id
                    )
            );
        }
        
        return $id;
    }

    public static function is_valid() {
        if (!isset($_SESSION['ex_auth']['id']) || is_int($_SESSION['ex_auth']['id'])) {
           $valid = FALSE; 
        } else {
            $db = db::obj();
            if (!$db->get_val('SELECT id FROM users WHERE active = 1 AND id = ?', array($_SESSION['ex_auth']['id']))) {
                $login = self::obj();
                $login->destroy();
                $valid = FALSE;
            } else {
                $valid = TRUE;
            }
        }
        
        return $valid;
    }

}
