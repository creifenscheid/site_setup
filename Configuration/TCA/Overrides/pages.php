<?php
defined('TYPO3_MODE') || die();

call_user_func(function()
{
    /**
     * Extension key
     */
    $extensionKey = 'site_setup';
    
    $GLOBALS['TCA']['pages']['types'][1]['columnsOverrides']['media']['config']['overrideChildTca']['columns']['crop']['config'] = [
        'cropVariants' => [
            'desktop' => [
                'title' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:cropvariants.desktop.title',
                'cropArea' => [
                    'x' => 0.1,
                    'y' => 0.1,
                    'width' => 0.8,
                    'height' => 0.8,
                ],
                'allowedAspectRatios' => [
                    'default' => [
                        'title' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:cropvariants.ratios.default',
                        'value' => 1920 / 500
                    ]
                ]
            ],
            'tablet' => [
                'title' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:cropvariants.tablet.title',
                'cropArea' => [
                    'x' => 0.1,
                    'y' => 0.1,
                    'width' => 0.8,
                    'height' => 0.8,
                ],
                'allowedAspectRatios' => [
                    '3:2' => [
                        'title' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:cropvariants.ratios.3_2',
                        'value' => 3 / 2
                    ]
                ]
            ],
            'mobile' => [
                'title' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:cropvariants.mobile.title',
                'cropArea' => [
                    'x' => 0.1,
                    'y' => 0.1,
                    'width' => 0.8,
                    'height' => 0.8,
                ],
                'allowedAspectRatios' => [
                    '1:1' => [
                        'title' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:cropvariants.ratios.1_1',
                        'value' => 1 / 1
                    ]
                ]
            ]
        ]
    ];
});