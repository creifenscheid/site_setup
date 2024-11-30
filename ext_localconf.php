<?php

defined('TYPO3') || die();

(static function ($extKey) {

    // Register ViewHelper
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces'][\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToLowerCamelCase($extKey)] = [
        'CReifenscheid\\' . \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey) . '\ViewHelpers',
    ];

    // RTE
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['siteSetup'] = 'EXT:site_setup/Configuration/RTE/Configuration.yaml';
    $GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets'][$extKey]
        = 'EXT:' . $extKey . '/Resources/Public/Css/Abbreviation.css';
        
})('site_setup');
