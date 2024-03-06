<?php

namespace CReifenscheid\SiteSetup\ViewHelpers;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

use function array_key_exists;
use function array_key_first;
use function array_key_last;
use function count;
use function preg_match;
use function str_contains;

/**
 * A ViewHelper to create a table of content of the given page based on content elements. RTE headings are ignored.
 *
 * Example
 * ========
 *
 * Default
 * -------
 *
 * EXAMPLE::
 *    Create toc with all headings from h2 to h4
 *    <siteSetup:toc pageUid="666" minLevel="2" maxLevel="4" />
 *
 * Output::
 *
 *    {array}
 */
class TocViewHelper extends AbstractViewHelper
{
    /**
     * Stores last treated element of each heading level
     */
    private array $previousElementsByLevel = [];

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('pageUid', 'int', 'Uid of the page to create ToC for.', true);
        $this->registerArgument('minLevel', 'int', 'Retrieve all headers starting from this level.', false, 2);
        $this->registerArgument('maxLevel', 'int', 'Retrieve all headers until this level.', false, 6);
    }

    /**
     * Returns an array with all headers of the page
     *
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\DBALException
     */
    public function render(): ?array
    {
        // VARS
        $pageUid = $this->arguments['pageUid'];
        $minLevel = $this->arguments['minLevel'];
        $maxLevel = $this->arguments['maxLevel'];
        $table = 'tt_content';
        $toc = [];

        // QUERYBUILDER
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);

        $whereExpressions = [
            $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pageUid)),
            $queryBuilder->expr()->neq('header', $queryBuilder->createNamedParameter('')),
            $queryBuilder->expr()->neq('header_layout', $queryBuilder->createNamedParameter(100)),
            $queryBuilder->expr()->lte('header_layout', $queryBuilder->createNamedParameter($maxLevel)),
        ];

        if ($minLevel <= 2) {
            $whereExpressions[] = $queryBuilder->expr()->or(
                $queryBuilder->expr()->eq('header_layout', $queryBuilder->createNamedParameter(0)),
                $queryBuilder->expr()->gte('header_layout', $queryBuilder->createNamedParameter($minLevel))
            );
        } else {
            $whereExpressions[] = $queryBuilder->expr()->gte('header_layout', $queryBuilder->createNamedParameter($minLevel));
        }

        $queryBuilder
            ->select('uid', 'pid', 'header', 'header_layout', 'CType')
            ->from($table)
            ->where(...$whereExpressions)
            ->orderBy('sorting');

        $contentElements = $queryBuilder->executeQuery()
            ->fetchAllAssociative();

        // RESULT PROCESSING
        $previousLevel = null;
        foreach ($contentElements as $element) {
            if (!$this->hasHeaderLayout($element['CType'])) {
                continue;
            }

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
                    for ($i = array_key_last($this->previousElementsByLevel); $i > $minLevel; --$i) {
                        $uid = $this->previousElementsByLevel[$i]['uid'] ?: 0;
                        $this->previousElementsByLevel[($i - 1)]['subheader'][$uid] = $this->previousElementsByLevel[$i];
                        unset($this->previousElementsByLevel[$i]);
                    }

                    // add the stored element with the minimum level in the toc storage and removed it from the tmp storage
                    $uid = $this->previousElementsByLevel[$currentLevel]['uid'] ?: 0;
                    $toc[$uid] = $this->previousElementsByLevel[$currentLevel];
                    unset($this->previousElementsByLevel[$currentLevel]);
                }
            } else {
                if ($currentLevel < $previousLevel) {
                    $lastPreviousElementsKey = array_key_last($this->previousElementsByLevel);

                    // merge previous elements
                    for ($i = $lastPreviousElementsKey; $i >= $currentLevel; --$i) {
                        $uid = $this->previousElementsByLevel[$i]['uid'] ?: 0;
                        $this->previousElementsByLevel[($i - 1)]['subheader'][$uid] = $this->previousElementsByLevel[$i];
                        unset($this->previousElementsByLevel[$i]);
                    }
                }

                $this->previousElementsByLevel[($currentLevel - 1)]['subheader'][$element['uid']] = $element;
            }

            $this->previousElementsByLevel[$currentLevel] = $element;
            $previousLevel = $currentLevel;
        }

        // get the last stored elements
        if ($this->previousElementsByLevel !== []) {
            for ($i = array_key_last($this->previousElementsByLevel); $i > $minLevel; --$i) {
                $uid = $this->previousElementsByLevel[$i]['uid'] ?: 0;
                $this->previousElementsByLevel[($i - 1)]['subheader'][$uid] = $this->previousElementsByLevel[$i];
                unset($this->previousElementsByLevel[$i]);
            }

            $toc[$this->previousElementsByLevel[$minLevel]['uid']] = $this->previousElementsByLevel[$minLevel];
        }

        if ($toc === [] || (count($toc) === 1 && !array_key_exists('subheader', $toc[array_key_first($toc)]))) {
            return null;
        }

        return $toc;
    }

    private function hasHeaderLayout(string $ctype): bool
    {
        $items = $this->getShowitemOfType($ctype);

        if (str_contains($items, 'header_layout')) {
            return true;
        }

        $pattern = '/--palette--;([^,;]*);headers/';
        preg_match($pattern, $items, $result);
        if ($result !== []) {
            return true;
        }

        $pattern = '/--palette--;([^,;]*);header/';
        preg_match($pattern, $items, $result);

        return $result !== [];
    }

    private function getShowitemOfType(string $ctype): string
    {
        return array_key_exists($ctype, $GLOBALS['TCA']['tt_content']['types']) ? $GLOBALS['TCA']['tt_content']['types'][$ctype]['showitem'] : '';
    }
}
