<?php

/**
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

return array(
    'code' => '683',
    'patterns' => array(
        'national' => array(
            'general' => '/^[1-5]\\d{3}$/',
            'fixed' => '/^[34]\\d{3}$/',
            'mobile' => '/^[125]\\d{3}$/',
            'emergency' => '/^999$/',
        ),
        'possible' => array(
            'general' => '/^\\d{4}$/',
            'emergency' => '/^\\d{3}$/',
        ),
    ),
);
