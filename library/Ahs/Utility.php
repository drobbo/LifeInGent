<?php

abstract class Ahs_Utility
{
    public static function hash($data, $algo = 'sha256')
    {
        $key = 'Dit is mijn geheime sleutel';

        // Hash-based Message Authentication Code
        return hash_hmac($algo, $data, $key);
    }
}