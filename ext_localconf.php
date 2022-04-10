<?php

defined('TYPO3_MODE') || die();

(function ($extKey) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
        @import "EXT:' . $extKey . '/Configuration/TSConfig/Page.tsconfig"
    ');

    // Register ViewHelper
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces'][\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToLowerCamelCase($extKey)] = [
        'CReifenscheid\\' . \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey) . '\ViewHelpers',
    ];
    
})('site_setup');