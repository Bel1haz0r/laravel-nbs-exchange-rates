<?php

return [
    'driver' => 'soap-xml',

    'soap' => [
        'wsdl' => env('NBS_WSDL', 'https://webservices.nbs.rs/CommunicationOfficeService1_0/ExchangeRateXmlService.asmx?WSDL'),
        'options' => [
            // NBS authenticates via a SOAP header (AuthenticationHeader), not
            // HTTP transport auth — these are passed through to that header.
            'username' => env('NBS_USER'),
            'password' => env('NBS_PASS'),
            'licence_id' => env('NBS_LICENCE_ID'),
        ],
    ],
];
