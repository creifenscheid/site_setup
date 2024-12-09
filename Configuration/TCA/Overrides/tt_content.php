<?php

defined('TYPO3') || die();

$extensionKey = 'site_setup';
$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey);
    
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

// EXT:container registrations
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('container')) {
    $cType = 'site-setup-2cols';
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
        (
            new \B13\Container\Tca\ContainerConfiguration(
                $cType,
                'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:content.' . $cType,
                'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:content.' . $cType . '.description',
                [
                    [
                        ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.left', 'colPos' => 201],
                        ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.right', 'colPos' => 203],
                    ],
                ]
            )
        )
        ->setIcon('EXT:' . $extensionKey . '/Resources/Public/Icons/' . $cType . '.svg')
    );

    $cType = 'site-setup-3cols';
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
        (
            new \B13\Container\Tca\ContainerConfiguration(
                $cType,
                'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:content.' . $cType,
                'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:content.' . $cType . '.description',
                [
                    [
                        ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.left', 'colPos' => 201],
                        ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.center', 'colPos' => 202],
                        ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.right', 'colPos' => 203],
                    ],
                ]
            )
        )
        ->setIcon('EXT:' . $extensionKey . '/Resources/Public/Icons/' . $cType . '.svg')
    );
}