<?php
    function dd()
    {
        foreach (func_get_args() as $arg) {
            if (is_array($arg)) {
                echo '<pre>';
                print_r($arg);
                echo '</pre>';
            } else {
                echo $arg;
            }
        }
        exit();
    }

    // Load environment variables and set them in the global scope
    function loadEnvVars($envPath)
    {
        if (file_exists($envPath)) {
            $envVars = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($envVars as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue; // Skip comments
                }
                list($name, $value) = explode('=', $line, 2);
                $_ENV[$name] = $value; // Load into the environment
            }
        }
    }

    // Determining the protocol (HTTP or HTTPS) to ensure proper URL formation
    // Returns base URL and current URL
    function getUrlInfo()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $base_url = $protocol . $_SERVER['HTTP_HOST'] . "/";
        $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return [$base_url, $current_url];
    }

    // Determine and return the content file path based on the request
    function getContentFilePath()
    {
        list($requestPath) = explode('?', trim($_SERVER['REQUEST_URI'], '/'), 2);
        if ($_ENV['DEV_MODE']) $requestPath = empty($requestPath) || ($requestPath === 'fleboxin-site') ? 'home' : $requestPath;
        else $requestPath = empty($requestPath) ? 'home' : $requestPath;
        // dd($requestPath);
        $contentFilePath = 'content/';
        $pathParts = explode('/', $requestPath);
        foreach ($pathParts as $index => $part) {
            $contentFilePath .= $part;
            $contentFilePath .= ($index < count($pathParts) - 1) ? '/' : (is_dir($contentFilePath) ? '/index.php' : '.php');
        }
        return $contentFilePath;
    }

    //Handle Newsletter signups and Contact Submissions
    function handleFormSubmission() {
        dd($_POST);
        $formType = isset($_POST['form_type']) ? htmlspecialchars($_POST['form_type']) : '';
        $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';
        $errors = [];
        $redirectTo = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/'; // Fallback to home if HTTP_REFERER not set
        // Validate based on form type
        if ($formType === 'newsletter') {
            if (!$email) $errors[] = 'Email-ul este necesar pentru abonarea la newsletter.';
        } elseif ($formType === 'contact') {
            if (!$name) $errors['name'] = 'Numele este obligatoriu!';
            if (!$email) $errors['email'] = 'Email-ul este obligatoriu!';
            if (!$message) $errors['message'] = 'Messajul este obligatoriu!';
        } else {
            $errors['unauthorized'] = 'Invalid form type submitted.';
        }

        if (empty($errors)) {
            $to = $_ENV['CONTACT_FORM_EMAIL'];
            $subject = $formType === 'newsletter' ? 'Newsletter Sign-up' : 'Contact Form Submission';
            $body = $formType === 'newsletter' ? "Newsletter sign-up from: $name <$email>" : "Name: $name\nEmail: $email\nMessage: $message";
            $headers = "From: $email";
            mail($to, $subject, $body, $headers); // Ensure your server is configured to send mail

            // Redirect back with success
            header('Location: ' . $redirectTo . '?success=1');
            exit;
        } else {
            // Redirect back with errors
            $query = http_build_query(['errors' => $errors]);
            header('Location: ' . $redirectTo . '?' . $query);
            exit;
        }
    }

    // Send HTTP success response
    function sendHttpSuccessResponse($data) {
        if (is_array($data)) echo json_encode($data, JSON_FORCE_OBJECT);
        else echo $data;
    }

    // Send HTTP error response
    function sendHttpErrorResponse($error) {
        return header("HTTP/1.0 {$error['code']} {$error['msg']}");
    }

    // replace romanian diacritics
    function ro2clean($string) {
        $pattern = [
            "\xC4\x82", "\xC4\x83", "\xC3\x82", "\xC3\xA2", "\xC3\x8E", "\xC3\xAE", "\xC8\x98", 
            "\xC8\x99", "\xC8\x9A", "\xC8\x9B", "\xC5\x9E", "\xC5\x9F", "\xC5\xA2", "\xC5\xA3"
        ];
        $replace = ["A", "a", "A", "a", "I", "i", "S", "s", "T", "t", "S", "s", "T", "t"];
        return str_replace($pattern, $replace, $string);
    }
?>