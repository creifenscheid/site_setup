<?php

defined('TYPO3') || die();

(static function ($extKey) {
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

    // RTE
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['default'] = 'EXT:site_setup/Configuration/RTE/Configuration.yaml';
    $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets'][$extKey]
        = 'EXT:' . $extKey . '/Resources/Public/Css/Abbreviation.css';

})('site_setup');
