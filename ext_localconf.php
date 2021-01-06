<?php

defined('TYPO3_MODE') || die();

(function ($extKey) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
        @import "EXT:' . $extKey . '/Configuration/TSConfig/Page.tsconfig"
    ');
    
})('site_setup');