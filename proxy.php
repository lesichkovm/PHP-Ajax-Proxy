<?php

/**
 * URL to be used if the 'url_to_fetch' parameter is not sent
 * @var string
 */
$defaultUrl = '';

// 1. URL to fetch
$url = urlToFetch($defaultUrl);

// 2. If no URL set, display error message
if ($url == '') {
    die('No url param supplied');
}

// 3. Do the request
$response = request($url);

// 4. Display response
die($response);

// ========================= START: FUNCTIONS ========================= //

/**
 * Proxies the requests to the specified URL
 * @param string $url the URL the request to be sent to
 * @return string the response body
 */
function request($url) {
    /* START: Data */
    if (strpos($url, '://') === false) {
        $url = 'http://' . $url;
    }
    $url = parse_url($url);
    $scheme = isset($url["scheme"]) ? $url["scheme"] : 'http';
    $host = isset($url["host"]) ? $url["host"] : '';
    $path = isset($url["path"]) ? $url["path"] : '/';
    $query = isset($url["query"]) ? $url["query"] : '';
    $query = str_replace(' ', '+', $query);
    $user = isset($url["user"]) ? $url["user"] : '';
    $pass = isset($url["pass"]) ? $url["pass"] : '';
    $port = $scheme == "https" ? "443" : "80";
    /* END: Data */
    /* START: Prepare the POST and GET string */
    $post = http_build_query($_POST);
    $get = http_build_query($_GET);
    /* END: Prepare the POST and GET string */
    /* START: Prepare header */
    if (count($_POST) > 0) {
        if ($get != '') {
            $path .= '?' . $get;
        }
        $header = "POST " . $path . " HTTP/1.0\r\n";
    } else {
        if ($get != '') {
            $path .= '?' . $get;
        }
        $header = "GET " . $path . " HTTP/1.0\r\n";
    }
    $header .= "Host: " . $host . "\r\n";
    $header .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
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
    if ($scheme == "https") {
        $host = "ssl://" . $host;
    }
    $fp = fsockopen($host, $port, $err_num, $err_str, 30);
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
    list($http_headers, $http_body) = explode("\r\n\r\n", $result, 2);
    return $http_body;
}

/**
 * Find the URL to be fetched by checking for 'url_to_fetch parameter
 * @param string $default
 * @return string
 */
function urlToFetch($default = "") {
    $url = (isset($_REQUEST['url_to_fetch']) == false) ? '' : $_REQUEST['url_to_fetch'];
    if (isset($_POST['url_to_fetch'])) {
        unset($_POST['url_to_fetch']);
    }
    if (isset($_GET['url_to_fetch'])) {
        unset($_GET['url_to_fetch']);
    }
    return $url !== "" ? $url : $default;
}

// ========================== END: FUNCTIONS ========================== //
