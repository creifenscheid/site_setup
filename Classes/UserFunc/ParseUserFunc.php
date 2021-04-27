<?php

namespace CReifenscheid\SiteSetup\UserFunc;

/**
 * *************************************************************
 *
 * Copyright notice
 *
 * (c) 2021 C. Reifenscheid
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * *************************************************************
 */

/**
 * Class ParseUserFunc
 *
 * @package CReifenscheid\SiteSetup\UserFunc
 * @author  C. Reifenscheid
 */
class ParseUserFunc
{
    /**
     * Reference to the parent (calling) cObject set from TypoScript
     */
    public $cObj;

    /**
     * Function to replace marker in rte content with corresponding typoscrip lib content
     *
     * @param       string          When custom methods are used for data processing (like in stdWrap functions), the $content variable will hold the value to be processed. When methods are meant to just return some generated content (like in USER and USER_INT objects), this variable is empty.
     * @param       null|array           TypoScript properties passed to this method.
     * @return      string  The input string reversed. If the TypoScript property "uppercase" was set, it will also be in uppercase. May also be linked.
     */
    public function replaceMarker(string $content, ?array $conf) : string
    {
        // define pattern to extract content enclosed in {}
        $pattern = '/\{([^\}]*)\}/';

        // extract marker from content
        preg_match_all($pattern, $content, $matches);

        // if matches are
        if (!empty($matches[1])) {

            // loop through extracted markers
            foreach ($matches[1] as $marker) {
                $markerConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(':', $marker);

                switch ($markerConfiguration[0]) {
                    case 'forYears':
                        $thisYear = date('Y', time());
                        $markerContent = $thisYear - $markerConfiguration[1];
                        
                        if ($markerContent > 0) {
                            if ($markerContent == 1) {
                                $prefix = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:site_setup/Resources/Private/Language/locallang.xlf:tt_content.parser.year', 'SiteSetup');
                            } else {
                                $prefix = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:site_setup/Resources/Private/Language/locallang.xlf:tt_content.parser.years', 'SiteSetup');
                            }

                            $content = str_replace ('{' . $marker . '}', $markerContent . ' ' . $prefix, $content);
                        }
                        break;
                }
            }
        }

        return $content;
    }
}
