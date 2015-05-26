<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.05.15
 * Time: 16:59
 */
return [

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => 'Session',

    /**
     * Consumers
     */
    'consumers' => [

        /**
         * Facebook
         */
        'Facebook' => [
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => [],
        ],

    ]

];