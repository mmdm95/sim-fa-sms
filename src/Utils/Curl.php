<?php

namespace Sim\SMS\Utils;

use Sim\SMS\SMSFactory;

class Curl
{
    /**
     * @param string $url
     * @param array $data
     * @param string $method
     * @param array $extra_options
     * @return array in following format
     * [
     *   'error' => curl error code,
     *   'message' => curl error message,
     *   'response' => curl response,
     * ]
     */
    public static function request(string $url, array $data, string $method = SMSFactory::METHOD_POST, array $extra_options = [])
    {
        // open curl
        $handle = curl_init();

        // curl options
        curl_setopt_array($handle, array_merge([
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => $data,
        ], $extra_options));

        // execute curl
        $response = curl_exec($handle);

        // decode executed curl to an object
        $response = json_decode($response);

        // convert object to array
        $response = self::objectToArray($response);

        if (curl_errno($handle)) {
            $response = null;
        }

        $error = curl_errno($handle);
        $message = curl_error($handle);

        // close curl resource
        curl_close($handle);

        return [
            'error' => $error,
            'message' => $message,
            'response' => $response,
        ];
    }

    /**
     * @param $obj
     * @return array
     */
    protected static function objectToArray($obj)
    {
        if (!is_array($obj) && !is_object($obj)) {
            return $obj;
        }

        if (is_object($obj)) {
            $obj = get_object_vars($obj);
        }

        return array_map('self::objectToArray', $obj);
    }
}