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
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump([$content, $conf, $this->cObj], __CLASS__ . '::' . __FUNCTION__ . ':' . __LINE__);

        // TODO
        /**
         * - extract marker with regex
         * - get typoscript
         * - lookup marker in typoscript lib.marker
         * - replace marker with typoscript content
         */

        return $content;
    }
}
