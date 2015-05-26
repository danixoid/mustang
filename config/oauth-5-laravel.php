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
            'scope'         => ['email','read_custom_friendlists','user_about_me'],
        ],

        'Google' => [
            'client_id'     => '794016713921-tiinncut6k3ondqk6spifqd3g04i2ru6.apps.googleusercontent.com',
            'client_secret' => 'hrMRKQNT163tuvFamtVbgudw',
            'scope'         => ['userinfo_email', 'userinfo_profile'],
        ],
    ]

];