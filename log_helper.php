<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
log_message('debug', 'Helper loaded: log_helper');

if (!function_exists('log_post')) {

    function log_post($level = 'debug', $array = NULL) {
        if (empty($array)) {
            /* @var $CI CI_Controller */
            $CI = & get_instance();
            $array = $CI->input->post();
        }

        if (empty($array)) {
            log_message($level, 'Nenhum conteúdo em $_POST.');
            return FALSE;
        }

        return log_message($level, '$_POST em "' . $CI->uri->uri_string() . '" = ' .
                        trim(string_to_log(var_export($array, TRUE))) . ';');
    }

}

if (!function_exists('string_to_log')) {

    function string_to_log($string) {
        if (empty($string))
            return FALSE;

        $padding = "\t\t\t\t\t";

        $result = NULL;

        foreach (explode("\n", trim($string)) as $line)
            $result .= "{$padding}{$line}\n";

        return trim($result);
    }

}

if (!function_exists('log_query')) {

    function log_query($level = 'debug', $uri = FALSE) {
        $message = 'Query';
        if ($uri) {
            $uri = get_instance()->uri->uri_string();
            $message .= ' em "';
            $message .= empty($uri) ? 'DEFAULT_CONTROLLER/index' : $uri;
            $message .= '"';
        }
        $message .= ': ' . string_to_log(get_instance()->db->last_query());

        return log_message($level, $message);
    }

}

if (!function_exists('log_uri')) {

    function log_uri($level = 'debug') {
        /* @var $CI CI_Controller */
        $CI = & get_instance();
        return log_message($level, 'URI STRING: "' . $CI->uri->uri_string() .
                        '" (' . $CI->router->fetch_class() . '->' .
                        $CI->router->fetch_method() . ')');
    }

}

if (!function_exists('log_var')) {

    function log_var($expression, $level = 'debug') {
        return log_message($level, string_to_log(var_export($expression, TRUE)));
    }

}

if (!function_exists('log_db_error')) {

    function log_db_error($level = 'error') {
        $number = get_instance()->db->_error_number();
        if (empty($number))
            $number = 'NULL';
        $message = get_instance()->db->_error_message();
        if (empty($message))
            $message = 'NULL';
        return log_message($level, string_to_log("Database Error Number: " .
                                "{$number}\n" .
                                "Database Error Message: {$message}"));
    }

}

if (!function_exists('log_error')) {

    function log_error($msg) {
        return log_message('error', $msg);
    }

}
?>