<?php

namespace CReifenscheid\SiteSetup\ViewHelpers;

use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * A ViewHelper to create a table of content of the given page.
 *
 * Examples
 * ========
 *
 * Default
 * -------
 *
 * ::
 *
 *    <siteSetup:toc pageUid="pageUid" maxLevel="4" />
 *
 * Output::
 *
 *    {array}
 *
 */
class TocViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('pageUid', 'int', 'Uid of the page to create ToC for.', true);
        $this->registerArgument('minLevel', 'int', 'Retrieve all headers starting from this level.', false, 2);
        $this->registerArgument('maxLevel', 'int', 'Retrieve all headers until this level.', false, 6);
    }

    /**
     * Returns an array with all headers of the page
     * 
     * @return null|array
     */
    public function render() : ?array
    {
        // VARS
        $pageUid = $this->arguments['pageUid'];
        $minLevel = $this->arguments['minLevel'];
        $maxLevel = $this->arguments['maxLevel'];
        $table = 'tt_content';
        $toc = [];
        
        // QUERYBUILDER
        $queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable($table);
        $contentElements = $queryBuilder
            ->select('uid', 'header', 'header_layout')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pageUid)),
                $queryBuilder->expr()->eq('deleted', $queryBuilder->createNamedParameter(0)),
                $queryBuilder->expr()->eq('hidden', $queryBuilder->createNamedParameter(0)),
                $queryBuilder->expr()->neq('header_layout', $queryBuilder->createNamedParameter(100)),
                $queryBuilder->expr()->lte('header_layout', $queryBuilder->createNamedParameter($maxLevel))
            )
            ->orderBy('sorting')
            ->executeQuery()
            ->fetchAllAssociative();

        // RESULT PROCESSING
        $previousLevel = null;
        $previousElementsByLevel = [];

        foreach ($contentElements as $element) {
            $currentLevel = $element['header_layout'] === '0' ? 2 : (int)$element['header_layout'];

            if ($currentLevel === $minLevel) {

                /**
                 * There is already an element with this level in the storage.
                 * This has to be added to the toc, before it gets overwritten at the end of the loop
                 */
                if (array_key_exists($currentLevel, $previousElementsByLevel)) {

                    /**
                     * Perform a backward loop.
                     * 
                     * Set the counter to the highest level stored and loop until the counter equals the minimum level.
                     * 
                     * Each element has to be added to the parent element,
                     * e.g. element with level 5 has be added to  a subelement key in element with level 4.
                     * 
                     * The element is then stored in there and can be removed.
                     */
                    for ($i = array_key_last($previousElementsByLevel); $i > $minLevel; $i--) {
                        $previousElementsByLevel[($i-1)]['subheader'][$previousElementsByLevel[$i]['uid']] = $previousElementsByLevel[$i];
                        unset($previousElementsByLevel[$i]);
                    }

                    // add the stored element with the minimum level in the toc storage and removed it from the tmp storage
                    $toc[$previousElementsByLevel[$currentLevel]['uid']] = $previousElementsByLevel[$currentLevel];
                    unset($previousElementsByLevel[$currentLevel]);
                }
            } else {
                if ($currentLevel < $previousLevel) {
                    $lastPreviousElementsKey = array_key_last($previousElementsByLevel);

                    // merge previous elements
                    for ($i = $lastPreviousElementsKey; $i >= $currentLevel; $i--) {
                        $uid = $previousElementsByLevel[$i]['uid'] ? : 0;
                        $previousElementsByLevel[($i-1)]['subheader'][$uid] = $previousElementsByLevel[$i];
                        unset($previousElementsByLevel[$i]);
                    }
                }

                $previousElementsByLevel[($currentLevel-1)]['subheader'][$element['uid']] = $element;
            }

            $previousElementsByLevel[$currentLevel] = $element;
            $previousLevel = $currentLevel;
        }

        $lastPreviousElementsKey = array_key_last($previousElementsByLevel);

        // merge previous last elements
        for ($i = $lastPreviousElementsKey; $i > $minLevel; $i--) {
            $previousElementsByLevel[($i-1)]['subheader'][$previousElementsByLevel[$i]['uid']] = $previousElementsByLevel[$i];
            unset($previousElementsByLevel[$i]);
        }

        $toc[$previousElementsByLevel[$minLevel]['uid']] = $previousElementsByLevel[$minLevel];

        return empty($toc) ? null : $toc;
    }
}