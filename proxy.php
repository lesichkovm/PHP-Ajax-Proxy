<?php

function request($url) {
    /* START: Data */
    if (strpos($url, '://') === false) {
        $url = 'http://' . $url;
    }
    $url = parse_url($url);
    $host = isset($url["host"]) ? $url["host"] : '';
    $path = isset($url["path"]) ? $url["path"] : '/';
    $query = isset($url["query"]) ? $url["query"] : '';
    $query = str_replace(' ', '+', $query);
    $user = isset($url["user"]) ? $url["user"] : '';
    $pass = isset($url["pass"]) ? $url["pass"] : '';
    /* END: Data */

    /* START: Prepare the POST and GET string */
    $post = array();
    foreach ($_POST as $field => $value) {
        $post[] = $field . '=' . urlencode(stripslashes($value));
    }
    $post = implode("&", $post);
    $get = array();
    foreach ($_GET as $field => $value) {
        $get[] = $field . '=' . urlencode(stripslashes($value));
    }
    $get = implode("&", $get);
    /* END: Prepare the POST and GET string */

    /* START: Prepare header */
    if (count($_POST) > 0) {
        if ($get != '')
            $path .= '?' . $get;
        $header = "POST " . $path . " HTTP/1.0\r\n";
    } else {
        if ($get != '')
            $path .= '?' . $get;
        $header = "GET " . $path . " HTTP/1.0\r\n";
    }
    $header .= "Host: " . $host . "\r\n";
    $header.= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
    if ($user != '') {
        $header .= 'Authorization: Basic ' . base64_encode($user . ':' . $pass) . "\r\n";
    }
    if (count($_POST) > 0) {
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($post) . "\r\n";
    }
    $header .= "Connection: close\r\n\r\n";
    if (count($_POST) > 0) {
        $header .= $post . "\r\n\r\n";
    }
    /* END: Prepare header */

    /* START: Send request */
    $fp = fsockopen($host, "80", $err_num, $err_str, 30);
    if ($fp === false) {
        echo "No Connection";
        exit;
    }
    $result = "";
    fputs($fp, $header);
    while (!feof($fp)) {
        $result .= fgets($fp, 128);
    }
    fclose($fp);
    /* END: Send request */

    //var_dump($err_num);var_dump($err_str);
    list($http_headers, $http_body) = split("\r\n\r\n", $result, 2);
    return $http_body;
}

if (count($_POST) > 0) {
    $url = (isset($_POST['url_to_fetch']) == false) ? '' : $_POST['url_to_fetch'];
    if (isset($_POST['url_to_fetch'])) {
        unset($_POST['url_to_fetch']);
    }
} else {
    $url = (isset($_GET['url_to_fetch']) == false) ? '' : $_GET['url_to_fetch'];
    if (isset($_GET['url_to_fetch'])) {
        unset($_GET['url_to_fetch']);
    }
}

if ($url == '') {
    die('No url param supplied');
}

$response = request($url);
die($response);
?>
