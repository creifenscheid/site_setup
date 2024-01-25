<?php

defined('TYPO3') || die();

(function ($extKey) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
        @import "EXT:' . $extKey . '/Configuration/TSConfig/Page.tsconfig"
    ');

    // Register ViewHelper
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces'][\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToLowerCamelCase($extKey)] = [
        'CReifenscheid\\' . \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey) . '\ViewHelpers',
    ];

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey),
        'LimitedPages',
        [
            \CReifenscheid\SiteSetup\Controller\PagesController::class => 'list'
        ]
    );
})('site_setup');