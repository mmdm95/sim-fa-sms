<?php

namespace Sim\SMS;

use Sim\SMS\Factories\NiazPardaz;

class SMSFactory
{
    const LIBRARY_SUCCESS_CODE = 0;

    // Method constants
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const METHOD_CONNECT = 'CONNECT';

    // NiazPardaz sms panel constants
    const NIAZPARDAZ_SEND_SUCCESSFUL = 0;

    // SMS panels constants
    const PANEL_NIAZPARDAZ = 1;

    /**
     * @param int $type
     * @return NiazPardaz|null
     */
    public static function instance(int $type)
    {
        switch ($type) {
            case self::PANEL_NIAZPARDAZ:
                return new NiazPardaz();
            default:
                return null;
        }
    }
}