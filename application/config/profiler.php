<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Profiler Sections
| -------------------------------------------------------------------------
| This file lets you determine whether or not various sections of Profiler
| data are displayed when the Profiler is enabled.
| Please see the user guide for info:
|
|    http://codeigniter.com/user_guide/general/profiling.html
|
*/

$config['benchmarks']            = TRUE;        // Elapsed time of Benchmark points and total execution time.
$config['config']                = TRUE;        // CodeIgniter Config variables.
$config['controller_info']        = TRUE;        // The Controller class and method requested.
$config['get']                    = TRUE;        // Any GET data passed in the request.
$config['http_headers']            = TRUE;        // The HTTP headers for the current request.
$config['memory_usage']            = TRUE;        // Amount of memory consumed by the current request, in bytes.
$config['post']                    = TRUE;        // Any POST data passed in the request.
$config['queries']                = TRUE;        // Listing of all database queries executed, including execution time.
$config['uri_string']            = TRUE;        // The URI of the current request.
$config['session_data']         = TRUE;     // Data stored in the current session.
$config['query_toggle_count']    = 25;        // The number of queries after which the query block will default to hidden.

/**
 * ------------------------------------------------------------------------
 * Filename: profiler.php
 * Location: ./application/config/profiler.php
 * ------------------------------------------------------------------------
 */ 