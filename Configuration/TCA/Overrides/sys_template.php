<?php

defined('TYPO3') || die();

$extensionKey = 'site_setup';

/**
 * Default TypoScript
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $extensionKey,
    'Configuration/TypoScript',
    'SiteSetup'
);