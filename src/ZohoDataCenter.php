<?php

namespace MarJose123\ZohoCliqAlert;

enum ZohoDataCenter: string
{
    case US = 'us';
    case UK = 'uk';
    case CA = 'ca';
    case EU = 'eu';
    case IN = 'in';
    case AU = 'au';
    case JP = 'jp';
    case SA = 'sa';

    public function getBaseUrl(): string
    {
        return match ($this) {
            self::US => 'https://cliq.zoho.com',
            self::UK => 'https://cliq.zoho.uk',
            self::CA => 'https://cliq.zohocloud.ca',
            self::EU => 'https://cliq.zoho.eu',
            self::IN => 'https://cliq.zoho.in',
            self::AU => 'https://cliq.zoho.com.au',
            self::JP => 'https://cliq.zoho.jp',
            self::SA => 'https://cliq.zoho.sa',
        };
    }

    public function getOauthBaseUrl(): string
    {
        return match ($this) {
            self::US => 'https://accounts.zoho.com',
            self::UK => 'https://accounts.zoho.uk',
            self::CA => 'https://accounts.zohocloud.ca',
            self::EU => 'https://accounts.zoho.eu',
            self::IN => 'https://accounts.zoho.in',
            self::AU => 'https://accounts.zoho.com.au',
            self::JP => 'https://accounts.zoho.jp',
            self::SA => 'https://accounts.zoho.sa',
        };
    }
}
