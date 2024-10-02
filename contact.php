<?php
    require_once __DIR__ . '/src/init.php';
    
    try {
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) throw new Exception('Not authorized!', 401);
        if (empty($_POST['name'])) throw new Exception('Numele este obligatoriu!', 400);
        if (preg_match_all("/[^a-zA-Z\s]/", $_POST['name'])) throw new Exception('Numele poate contine doar litere si spatii!', 400);
        if (empty($_POST['phone'])) throw new Exception('Numarul e telefon este obligatoriu!', 400);
        if (preg_match_all("/[^0-9\+]/", $_POST['phone'])) throw new Exception('Numarul de telefon trebuie sa fie numeric!', 400);
        if (strlen($_POST['phone']) < 10) throw new Exception('Numarul de telefon nu are formatul corespunzator! Va rugam introduce-ti inclusiv prefixul.', 400);
        if (empty($_POST['email'])) throw new Exception('Adresa de email este obligatorie!', 400);
        if (!preg_match_all("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $_POST['email'])) {
            throw new Exception('Va rugam introduceti o adresa de Email valida!', 400);
        }
        
        if ( $_SERVER["REQUEST_METHOD"]=="POST" && ( !empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email']) ) )
        {
            Database::insert("INSERT INTO `leads` (`name`, `phone`, `email`) VALUES ('{$_POST['name']}', '{$_POST['phone']}', '{$_POST['email']}')");
            sendHttpSuccessResponse([
                'msg' => 'success',
            ]);
        }
    } catch (\Throwable $th) {
        // throw $th;
        sendHttpErrorResponse([
            'msg' => $th->getMessage(),
            'code' => $th->getCode(),
        ]);
    }
?>