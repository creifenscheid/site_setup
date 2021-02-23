<?php
defined('TYPO3_MODE') || die();

call_user_func(function()
{
    /**
     * Extension key
     */
    $extensionKey = 'site_setup';
    
    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('container')) {
        
        $cType = 'site-setup-2cols';
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
            (
                new \B13\Container\Tca\ContainerConfiguration(
                    $cType, // CType
                    'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:content.' . $cType,
                    'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:content.' . $cType . '.description',
                    [
                        [
                            ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.left', 'colPos' => 201],
                            ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.right', 'colPos' => 203]
                        ]
                    ]
                    )
                )
            // set an optional icon configuration
            ->setIcon('EXT:' . $extensionKey . '/Resources/Public/Icons/' . $cType . '.svg')
        );
        
        $cType = 'site-setup-3cols';
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
            (
                new \B13\Container\Tca\ContainerConfiguration(
                    $cType, // CType
                    'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:content.' . $cType,
                    'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:content.' . $cType . '.description',
                    [
                        [
                            ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.left', 'colPos' => 201],
                            ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.center', 'colPos' => 202],
                            ['name' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf:backendlayouts.columns.right', 'colPos' => 203]
                        ]
                    ]
                    )
                )
            // set an optional icon configuration
            ->setIcon('EXT:' . $extensionKey . '/Resources/Public/Icons/' . $cType . '.svg')
        );
    }
});