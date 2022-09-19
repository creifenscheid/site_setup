<?php

namespace CReifenscheid\SiteSetup\ViewHelpers;

use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * A ViewHelper to create a table of content of the given page based on content elements. RTE headings are ignored.
 *
 * Example
 * ========
 *
 * Default
 * -------
 *
 * ::
 *    Create toc with all headings from h2 to h4
 *    <siteSetup:toc pageUid="666" minLevel="2" maxLevel="4" />
 *
 * Output::
 *
 *    {array}
 *
 */
class TocViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Stores ladt treated element of each heading level
     * @var array
     */
    private $previousElementsByLevel = [];
    
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
            ->select('uid', 'pid', 'header', 'header_layout')
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

        if (!empty($contentElements)) {
            foreach ($contentElements as $element) {
                $currentLevel = $element['header_layout'] === '0' ? 2 : (int)$element['header_layout'];
    
                if ($currentLevel === $minLevel) {
    
                    /**
                     * There is already an element with this level in the storage.
                     * This has to be added to the toc, before it gets overwritten at the end of the loop
                     */
                    if (array_key_exists($currentLevel, $this->previousElementsByLevel)) {
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
                        for ($i = array_key_last($this->previousElementsByLevel); $i > $minLevel; $i--) {
                            $this->previousElementsByLevel[($i-1)]['subheader'][$this->previousElementsByLevel[$i]['uid']] = $this->previousElementsByLevel[$i];
                            unset($this->previousElementsByLevel[$i]);
                        }
                        
                        // add the stored element with the minimum level in the toc storage and removed it from the tmp storage
                        $toc[$this->previousElementsByLevel[$currentLevel]['uid']] = $this->previousElementsByLevel[$currentLevel];
                        unset($this->previousElementsByLevel[$currentLevel]);
                    }
                } else {
                    if ($currentLevel < $previousLevel) {
                        $lastPreviousElementsKey = array_key_last($this->previousElementsByLevel);
    
                        // merge previous elements
                        for ($i = $lastPreviousElementsKey; $i >= $currentLevel; $i--) {
                            $uid = $this->previousElementsByLevel[$i]['uid'] ? : 0;
                            $this->previousElementsByLevel[($i-1)]['subheader'][$uid] = $this->previousElementsByLevel[$i];
                            unset($this->previousElementsByLevel[$i]);
                        }
                    }
    
                    $this->previousElementsByLevel[($currentLevel-1)]['subheader'][$element['uid']] = $element;
                }
    
                $this->previousElementsByLevel[$currentLevel] = $element;
                $previousLevel = $currentLevel;
            }
        }
 
        // get the last stored elements
        if(!empty($this->previousElementsByLevel)) {
            for ($i = array_key_last($this->previousElementsByLevel); $i > $minLevel; $i--) {
                $this->previousElementsByLevel[($i-1)]['subheader'][$this->previousElementsByLevel[$i]['uid']] = $this->previousElementsByLevel[$i];
                unset($this->previousElementsByLevel[$i]);
            }
            $toc[$this->previousElementsByLevel[$minLevel]['uid']] = $this->previousElementsByLevel[$minLevel];
        }

        if (empty($toc) || (count($toc) === 1 && !array_key_exists('subheader', $toc[array_key_first($toc)]))) {
            return null;
        }

        return $toc;
    }
}