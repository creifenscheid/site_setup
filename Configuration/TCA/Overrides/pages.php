<?php

defined('TYPO3') || die();

call_user_func(static function () {
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
                        'value' => 1920 / 500,
                    ],
                ],
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
                        'value' => 3 / 2,
                    ],
                ],
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
                        'value' => 1,
                    ],
                ],
            ],
        ],
    ];
    $GLOBALS['TCA']['pages']['columns']['slug']['config']['generatorOptions'] = [
        'fields' => [
            [
                'nav_title',
                'title',
            ],
        ],
        'prefixParentPageSlug' => true,
        'replacements' => [
            '&shy;' => '',
        ],
    ];
    /**
     * Table extension
     */
    $additionalColumns = [
        'tx_sitesetup_toc_disabled' => [
            'label' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_pages.xlf:tx_sitesetup_toc_disabled',
            'onChange' => 'reload',
            'config' => [
                'default' => 0,
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'tx_sitesetup_toc_min' => [
            'label' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_pages.xlf:tx_sitesetup_toc_min',
            'displayCond' => 'FIELD:tx_sitesetup_toc_disabled:REQ:false',
            'config' => [
                'default' => 2,
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [],
            ],
        ],
        'tx_sitesetup_toc_max' => [
            'label' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_pages.xlf:tx_sitesetup_toc_max',
            'displayCond' => 'FIELD:tx_sitesetup_toc_disabled:REQ:false',
            'config' => [
                'default' => 6,
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [],
            ],
        ],
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'pages',
        $additionalColumns
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'pages',
        'tocSettings',
        'tx_sitesetup_toc_min,tx_sitesetup_toc_max'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'pages',
        '--div--;LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_pages.xlf:tab.toc, tx_sitesetup_toc_disabled, --palette--;;tocSettings',
        '1'
    );
});
