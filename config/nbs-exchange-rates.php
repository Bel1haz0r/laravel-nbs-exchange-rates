<?php

return [
    'driver' => 'soap-xml',

    'soap' => [
        'wsdl' => env('NBS_WSDL', 'https://webservices.nbs.rs/CommunicationOfficeService1_0/ExchangeRateXmlService.asmx?WSDL'),
        'options' => [
            // put SoapClient options here if needed:
            'login' => env('NBS_USER'),
            'password' => env('NBS_PASS'),
        ],
    ],
];
