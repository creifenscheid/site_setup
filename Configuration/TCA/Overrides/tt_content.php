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

/**
 * CE: carousel
 */
// registration
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang.xlf:carousel.label',
        'sitesetup_carousel',
        'content-carousel-image',
        'default',
    ],
    'image',
    'after'
);
// table extension
$carouselColumns = [
    'tx_sitesetup_carousel_slides_to_show' => [
        'label' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_ttcontent.xlf:tx_sitesetup_carousel_slides_to_show',
        'config' => [
            'default' => 1,
            'type' => 'number',
            'size' => 30,
            'max' => 1,
            'eval' => 'trim',
        ],
    ],
    'tx_sitesetup_carousel_autoslide' => [
        'label' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_ttcontent.xlf:tx_sitesetup_carousel_autoslide',
        'onChange' => 'reload',
        'config' => [
            'default' => 0,
            'type' => 'check',
            'renderType' => 'checkboxToggle',
        ],
    ],
    'tx_sitesetup_carousel_duration' => [
        'label' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_ttcontent.xlf:tx_sitesetup_carousel_duration',
        'description' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/TCA/locallang_ttcontent.xlf:tx_sitesetup_carousel_duration.description',
        'displayCond' => 'FIELD:tx_sitesetup_carousel_autoslide:=:1',
        'config' => [
            'default' => '5',
            'type' => 'number',
            'size' => 30,
            'max' => 2,
            'eval' => 'trim',
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $carouselColumns
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'carouselSettings',
        'tx_sitesetup_carousel_autoslide, tx_sitesetup_carousel_duration'
);
// backend fields
$GLOBALS['TCA']['tt_content']['types']['sitesetup_carousel'] = [
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;header,
            tx_sitesetup_carousel_slides_to_show,
            --palette--;;carouselSettings,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.images,image,image_zoom,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
    ',
];

/**
 * CE: plugins
 */
// configuration
$plugins = [
    'LimitedPages' => [
        'icon' => 'actions-sort-amount-down',
        'flexform' => true,
    ],
];

// registration
foreach ($plugins as $pluginName => $pluginConfig) {
    $pluginSignature = strtolower($extensionName) . '_' . strtolower($pluginName);
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $extensionName,
        $pluginName,
        'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/Plugins/locallang.xlf:' . strtolower($pluginName) . '.label',
            $pluginConfig['icon'],
    );

    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,frame_class,space_before_class,space_after_class,sectionIndex,linkToTop,pages,recursive';
    // FlexForm configuration
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
     \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/' . $pluginName . 'FlexForm.xml');
}

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