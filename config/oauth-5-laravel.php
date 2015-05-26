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
            'client_id'     => '836370199744963',
            'client_secret' => 'e1c320ace18d6bf34efe1649bcbcbec1',
            'scope'         => ['email','read_friendlists','user_online_presence'],
        ],

    ]

];