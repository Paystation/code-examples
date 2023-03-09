<?php
/**
 *  This is a sample page
 */
$query_string = $_SERVER['QUERY_STRING'];
parse_str($query_string, $data);

if (isset($data['code'])) {
    // Add code here to display result
    // Do not update transaction status here because query strings can be manipulated
    // Do a transaction lookup instead to verify the results. Check documentation for more details.
    if ($data['code'] == '0') {
        echo 'Transaction ok: ' . $data['message'];
    } else {
        echo 'Transaction failed: ' . $data['message'];
    }
}