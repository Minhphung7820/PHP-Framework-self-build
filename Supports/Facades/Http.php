<?php

namespace Supports\Facades;

use Supports\Facades\Base\Http as BaseHttp;

class Http extends BaseHttp
{
    protected static $headers = [];

    public static function get($url, $data = [])
    {
        $queryString = http_build_query($data);
        $url = $url . '?' . $queryString;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        self::setHeaders($curl);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public static function post($url, $data = [])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        self::setHeaders($curl);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public static function put($url, $data = [])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        self::setHeaders($curl);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public static function patch($url, $data = [])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        self::setHeaders($curl);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public static function delete($url, $data = [])
    {
        $queryString = http_build_query($data);
        $url = $url . '?' . $queryString;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        self::setHeaders($curl);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public static function withHeaders(array $headers)
    {
        self::$headers = $headers;
        return new self();
    }

    protected static function setHeaders($curl)
    {
        if (!empty(self::$headers)) {
            $formattedHeaders = [];
            foreach (self::$headers as $key => $value) {
                $formattedHeaders[] = $key . ': ' . $value;
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $formattedHeaders);
        }
    }
}
