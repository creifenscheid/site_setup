<?php

defined('TYPO3') || die();

$extensionKey = 'site_setup';
    
// table extension
$ttContentFields = [
    'tx_sitesetup_header_sr_only' => [
        'label' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_ttcontent.xlf:tx_sitesetup_header_sr_only',
        'description' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_ttcontent.xlf:tx_sitesetup_header_sr_only.description',
        'config' => [
            'default' => 0,
            'type' => 'check',
            'renderType' => 'checkboxToggle',
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $ttContentFields
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'headers',
    'tx_sitesetup_header_sr_only,--linebreak--',
    'after:header_layout'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'header',
    'tx_sitesetup_header_sr_only,--linebreak--',
    'after:header_layout'
);