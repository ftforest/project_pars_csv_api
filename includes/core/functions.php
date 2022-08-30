<?php

function class_autoload($api = false) {
    if ($api) {
        spl_autoload_register(function($class_name) {
            require('./../includes/core/class_'.strtolower($class_name).'.php');
        });
    } else {
        spl_autoload_register(function($class_name) {
            require('./includes/core/class_'.strtolower($class_name).'.php');
        });
    }
}

function flt_input($var) {
    return str_replace(['\\', "\0", "'", '"', "\x1a", "\x00"], ['\\\\', '\\0', "\\'", '\\"', '\\Z', '\\Z'], $var);
}

function error_response($code, $msg, $data = []) {
    $http_code = 400;
    header($_SERVER['SERVER_PROTOCOL'].' '.$http_code.' Error', true, $http_code);
    $result['error_code'] = $code;
    $result['error_msg'] = $msg;
    if ($data) $result['error_data'] = $data;
    return $result;
}

function response($response) {
    $response = !isset($response['error_code']) ? ['success'=>'true', 'response'=>$response] : ['success'=>'false', 'error'=>$response];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit();
}

function call($method_allow, $method_use, $data, $callback) {
    if ($method_allow != $method_use) response(error_response(1003, 'Application authorization failed: HTTP method is not supported.'));
    $data ? response($callback($data)) : response($callback());
}
