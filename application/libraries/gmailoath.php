<?php

class GmailOath {

    public $oauth_consumer_key;
    public $oauth_consumer_secret;
    public $progname;
    public $debug;
    public $callback;

    function __construct($params) {
        $this->oauth_consumer_key = $params['consumer_key'];
        $this->oauth_consumer_secret = $params['consumer_secret'];
        $this->progname = $params['argarray'];
        $this->debug = $params['debug']; // Set to 1 for verbose debugging output
        $this->callback = $params['callback'];
    }

    ////////////////// global.php open//////////////
    function logit($msg, $preamble=true) {
        //  date_default_timezone_set('America/Los_Angeles');
        $now = date(DateTime::ISO8601, time());
        error_log(($preamble ? "+++${now}:" : '') . $msg);
    }

   
    function do_get($url, $port=80, $headers=NULL) {
        $retarr = array();  // Return value
        $curl_opts = array(CURLOPT_URL => $url,
            CURLOPT_PORT => $port,
            CURLOPT_POST => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true);


        if ($headers) {
            $curl_opts[CURLOPT_HTTPHEADER] = $headers;
        }

        $response = $this->do_curl($curl_opts);

        if (!empty($response)) {
            $retarr = $response;
        }

        return $retarr;
    }

 
    function do_post($url, $postbody, $port=80, $headers=NULL) {
        $retarr = array();  // Return value

        $curl_opts = array(CURLOPT_URL => $url,
            CURLOPT_PORT => $port,
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => $postbody,
            CURLOPT_RETURNTRANSFER => true);

        if ($headers) {
            $curl_opts[CURLOPT_HTTPHEADER] = $headers;
        }

        $response = do_curl($curl_opts);

        if (!empty($response)) {
            $retarr = $response;
        }

        return $retarr;
    }

  
    function do_curl($curl_opts) {

        $retarr = array();  // Return value

        if (!$curl_opts) {
            if ($this->debug) {
                $this->logit("do_curl:ERR:curl_opts is empty");
            }
            return $retarr;
        }


        // Open curl session

        $ch = curl_init();

        if (!$ch) {
            if ($this->debug) {
                $this->logit("do_curl:ERR:curl_init failed");
            }
            return $retarr;
        }

        // Set curl options that were passed in
        curl_setopt_array($ch, $curl_opts);

        // Ensure that we receive full header
        curl_setopt($ch, CURLOPT_HEADER, true);

        if ($this->debug) {
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
        }

        // Send the request and get the response
        ob_start();
        $response = curl_exec($ch);
        $curl_spew = ob_get_contents();
        ob_end_clean();
        if ($this->debug && $curl_spew) {
            $this->logit("do_curl:INFO:curl_spew begin");
            $this->logit($curl_spew, false);
            $this->logit("do_curl:INFO:curl_spew end");
        }

        // Check for errors
        if (curl_errno($ch)) {
            $errno = curl_errno($ch);
            $errmsg = curl_error($ch);
            if ($this->debug) {
                $this->logit("do_curl:ERR:$errno:$errmsg");
            }
            curl_close($ch);
            unset($ch);
            return $retarr;
        }

        if ($this->debug) {
            $this->logit("do_curl:DBG:header sent begin");
            $header_sent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
            $this->logit($header_sent, false);
            $this->logit("do_curl:DBG:header sent end");
        }

        // Get information about the transfer
        $info = curl_getinfo($ch);

        // Parse out header and body
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        // Close curl session
        curl_close($ch);
        unset($ch);

        if ($this->debug) {
            $this->logit("do_curl:DBG:response received begin");
            if (!empty($response)) {
                $this->logit($response, false);
            }
            $this->logit("do_curl:DBG:response received end");
        }

        // Set return value
        array_push($retarr, $info, $header, $body);

        return $retarr;
    }

 
    function json_pretty_print($json, $html_output=false) {
        $spacer = '  ';
        $level = 1;
        $indent = 0; // current indentation level
        $pretty_json = '';
        $in_string = false;

        $len = strlen($json);

        for ($c = 0; $c < $len; $c++) {
            $char = $json[$c];
            switch ($char) {
                case '{':
                case '[':
                    if (!$in_string) {
                        $indent += $level;
                        $pretty_json .= $char . "\n" . str_repeat($spacer, $indent);
                    } else {
                        $pretty_json .= $char;
                    }
                    break;
                case '}':
                case ']':
                    if (!$in_string) {
                        $indent -= $level;
                        $pretty_json .= "\n" . str_repeat($spacer, $indent) . $char;
                    } else {
                        $pretty_json .= $char;
                    }
                    break;
                case ',':
                    if (!$in_string) {
                        $pretty_json .= ",\n" . str_repeat($spacer, $indent);
                    } else {
                        $pretty_json .= $char;
                    }
                    break;
                case ':':
                    if (!$in_string) {
                        $pretty_json .= ": ";
                    } else {
                        $pretty_json .= $char;
                    }
                    break;
                case '"':
                    if ($c > 0 && $json[$c - 1] != '\\') {
                        $in_string = !$in_string;
                    }
                default:
                    $pretty_json .= $char;
                    break;
            }
        }

        return ($html_output) ?
                '<pre>' . htmlentities($pretty_json) . '</pre>' :
                $pretty_json . "\n";
    }





    function oauth_http_build_query($params, $excludeOauthParams=false) {

        $query_string = '';
        if (!empty($params)) {

            // rfc3986 encode both keys and values
            $keys = $this->rfc3986_encode(array_keys($params));
            $values = $this->rfc3986_encode(array_values($params));
            $params = array_combine($keys, $values);


            uksort($params, 'strcmp');

   
            $kvpairs = array();
            foreach ($params as $k => $v) {
                if ($excludeOauthParams && substr($k, 0, 5) == 'oauth') {
                    continue;
                }
                if (is_array($v)) {
                    // If two or more parameters share the same name,
                    // they are sorted by their value. OAuth Spec: 9.1.1 (1)
                    natsort($v);
                    foreach ($v as $value_for_same_key) {
                        array_push($kvpairs, ($k . '=' . $value_for_same_key));
                    }
                } else {
                    // For each parameter, the name is separated from the corresponding
                    // value by an '=' character (ASCII code 61). OAuth Spec: 9.1.1 (2)
                    array_push($kvpairs, ($k . '=' . $v));
                }
            }

            // Each name-value pair is separated by an '&' character, ASCII code 38.
            // OAuth Spec: 9.1.1 (2)
            $query_string = implode('&', $kvpairs);
        }
        return $query_string;
    }


    function oauth_parse_str($query_string) {
        $query_array = array();

        if (isset($query_string)) {

            // Separate single string into an array of "key=value" strings
            $kvpairs = explode('&', $query_string);

            // Separate each "key=value" string into an array[key] = value
            foreach ($kvpairs as $pair) {
                list($k, $v) = explode('=', $pair, 2);

                // Handle the case where multiple values map to the same key
                // by pulling those values into an array themselves
                if (isset($query_array[$k])) {
                    // If the existing value is a scalar, turn it into an array
                    if (is_scalar($query_array[$k])) {
                        $query_array[$k] = array($query_array[$k]);
                    }
                    array_push($query_array[$k], $v);
                } else {
                    $query_array[$k] = $v;
                }
            }
        }

        return $query_array;
    }


    function build_oauth_header($params, $realm='') {
        $header = 'Authorization: OAuth';
        foreach ($params as $k => $v) {
            if (substr($k, 0, 5) == 'oauth') {
                $header .= ',' . $this->rfc3986_encode($k) . '="' . $this->rfc3986_encode($v) . '"';
            }
        }
        return $header;
    }

  
    function oauth_compute_plaintext_sig($consumer_secret, $token_secret) {
        return ($consumer_secret . '&' . $token_secret);
    }


    public function oauth_compute_hmac_sig($http_method, $url, $params, $consumer_secret, $token_secret) {

        $base_string = $this->signature_base_string($http_method, $url, $params);
        $signature_key = $this->rfc3986_encode($consumer_secret) . '&' . $this->rfc3986_encode($token_secret);
        $sig = base64_encode(hash_hmac('sha1', $base_string, $signature_key, true));
        if ($this->debug) {
            $this->logit("oauth_compute_hmac_sig:DBG:sig:$sig");
        }
        return $sig;
    }

    /**
     * Make the URL conform to the format scheme://host/path
     * @param string $url
     * @return string the url in the form of scheme://host/path
     */
    function normalize_url($url) {
        $parts = parse_url($url);

        $scheme = $parts['scheme'];
        $host = $parts['host'];
        $port = isset($parts['port']) ? $parts['port'] : false ;
        $path = $parts['path'];

        if (!$port) {
            $port = ($scheme == 'https') ? '443' : '80';
        }
        if (($scheme == 'https' && $port != '443')
                || ($scheme == 'http' && $port != '80')) {
            $host = "$host:$port";
        }

        return "$scheme://$host$path";
    }

    /**
     * Returns the normalized signature base string of this request
     * @param string $http_method
     * @param string $url
     * @param array $params
     * The base string is defined as the method, the url and the
     * parameters (normalized), each urlencoded and the concated with &.
     * @see http://oauth.net/core/1.0/#rfc.section.A.5.1
     */
    function signature_base_string($http_method, $url, $params) {
        // Decompose and pull query params out of the url
        $query_str = parse_url($url, PHP_URL_QUERY);
        if ($query_str) {
            $parsed_query = $this->oauth_parse_str($query_str);
            // merge params from the url with params array from caller
            $params = array_merge($params, $parsed_query);
        }

        // Remove oauth_signature from params array if present
        if (isset($params['oauth_signature'])) {
            unset($params['oauth_signature']);
        }

        // Create the signature base string. Yes, the $params are double encoded.
       
        $base_string = $this->rfc3986_encode(strtoupper($http_method)) . '&' .
                $this->rfc3986_encode($this->normalize_url($url)) . '&' .
                $this->rfc3986_encode($this->oauth_http_build_query($params));

        $this->logit("signature_base_string:INFO:normalized_base_string:$base_string");

        return $base_string;
    }

    /**
     * Encode input per RFC 3986
     * @param string|array $raw_input
     * @return string|array properly rfc3986 encoded raw_input
     * If an array is passed in, rfc3896 encode all elements of the array.
     * @link http://oauth.net/core/1.0/#encoding_parameters
     */
    function rfc3986_encode($raw_input){

        if (is_array($raw_input)) {
            //return array_map($this->rfc3986_encode, $raw_input);
            return array_map(array($this, 'rfc3986_encode'), $raw_input);

            // return $this->rfc3986_encode($raw_input);
        } else if (is_scalar($raw_input)) {
            return str_replace('%7E', '~', rawurlencode($raw_input));
        } else {
            return '';
        }
    }
    function rfc3986_decode($raw_input) {
        return rawurldecode($raw_input);
    }
}
?>