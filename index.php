<?php
    require_once __DIR__ . '/src/init.php';

    // Establishing the base path for consistent file inclusion
    list($base_url, $current_url) = getUrlInfo();
    $contentFilePath = getContentFilePath();

    ob_start();
    $page_path = BASE_PATH . DS . $contentFilePath;
    if ($_ENV['DEV_MODE']) $page_path = str_replace('content/fleboxin-site', 'content', $page_path);
    file_exists($page_path) ? include $page_path : include BASE_PATH . DS . 'content/404.php';
    $content = ob_get_clean();

    if ( !function_exists('curl_version') )
    {
        echo 'Curl is not installed';
    }
?>
<?php include BASE_PATH . DS . 'partials' . DS . 'head.php'; ?>
<div class="wrapper">
    <?php include BASE_PATH . DS . 'partials' . DS . 'header.php'; ?>
    <?php echo $content; ?>
</div>
<?php include BASE_PATH . DS . 'partials' . DS . 'footer.php'; ?>