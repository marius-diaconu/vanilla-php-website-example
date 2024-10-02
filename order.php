<?php
    require_once __DIR__ . '/src/init.php';
    
    try {
        if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) throw new Exception('Not authorized!', 401);
        if (empty($_POST['name'])) throw new Exception('Numele este obligatoriu!', 400);
        if (preg_match_all("/[^a-zA-Z\s]/", $_POST['name'])) throw new Exception('Numele poate contine doar litere si spatii!', 400);
        if (empty($_POST['phone'])) throw new Exception('Numarul e telefon este obligatoriu!', 400);
        if (preg_match_all("/[^0-9\+]/", $_POST['phone'])) throw new Exception('Numarul de telefon trebuie sa fie numeric!', 400);
        if (strlen($_POST['phone']) < 10) throw new Exception('Numarul de telefon nu are formatul corespunzator! Va rugam introduce-ti inclusiv prefixul.', 400);
        
        $endpoint = $_ENV['DR_CASH_ENDPOINT'];
        $ch = null;
        $headers = null;
        $post_fields = [];
        $response = null;
        $http_code = null;
        $header_size = null;
        $body = null;
        $uuid = null;
        
        if ( $_SERVER["REQUEST_METHOD"]=="POST" && ( !empty($_POST['name']) && !empty($_POST['phone']) ) )
        {
            $_SESSION['order_id'] = rand(9000000, 9999999);
            $_SESSION['order_name'] = $_POST['name'];
            
            // Required params
            $token = $_ENV['DR_CASH_TOKEN'];
            $stream_code = $_ENV['DR_CASH_STREAM_CODE'];

            // Fields to send
            $post_fields = [
                'stream_code'   => $stream_code,    // required
                'client'        => [
                    'phone'     => $_POST['phone'], // required
                    'name'      => $_POST['name'],
                    // 'surname'   => $_POST['surname'],
                    // 'email'     => $_POST['email'],
                    // 'address'   => $_POST['address'],
                    // 'ip'        => $_POST['ip'],
                    // 'country'   => $_POST['country'],
                    // 'city'      => $_POST['city'],
                    // 'postcode'  => $_POST['postcode'],
                ],
                'sub1'      => !empty($_POST['sub1']) ? $_POST['sub1'] : null,
                'sub2'      => !empty($_POST['sub2']) ? $_POST['sub2'] : null,
                'sub3'      => !empty($_POST['sub3']) ? $_POST['sub3'] : null,
                'sub4'      => !empty($_POST['sub4']) ? $_POST['sub4'] : null,
                'sub5'      => !empty($_POST['sub5']) ? $_POST['sub5'] : null,
            ];

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ];

            if (!$_ENV['DEV_MODE']) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $endpoint);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, true);
    
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $body = json_decode(substr($response, $header_size));
                $uuid = $body->uuid;
                
                curl_close ($ch);
                Database::insert("INSERT INTO `leads` (`name`, `phone`, `order_uuid`) VALUES ('{$_POST['name']}', '{$_POST['phone']}', '{$uuid}')");
    
                if ($http_code != 200) {
                    throw new Exception($response, $http_code);
                }
                if ($http_code == 200) {
                    sendHttpSuccessResponse('./thanks');
                }
            }

            if ($_ENV['DEV_MODE']) {
                sendHttpSuccessResponse([
                    'action' => 'redirect',
                    'redirectTo' => './thanks'
                ]);
            }
        }
    } catch (\Throwable $th) {
        // throw $th;
        sendHttpErrorResponse([
            'msg' => $th->getMessage(),
            'code' => $th->getCode(),
        ]);
    }
?>