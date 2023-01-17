<?php

namespace CReifenscheid\SiteSetup\ViewHelpers;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A ViewHelper to retrieve the timestamp were the page or its content has been edited at last.
 *
 * Example
 * ========
 *
 * Default
 * -------
 *
 * ::
 *    Returns timestamp of last change
 *    This can either be the timestamp of the page itself or
 *    the timestamp of the last edited tt_content element
 *    <siteSetup:lastPageEdit pageUid="666" />
 *
 * Output::
 *
 *    {integer}
 *
 */
class LastPageEditViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('pageUid', 'int', 'Uid of the page to get the last edit timestamp.', true);
    }

    public function render() : integer
    {
        // VARS
        $ttContentTable = 'tt_content';
        $lastEditPage

        // QUERYBUILDER
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($pagesTable);

        $whereExpressions = [
            $
        ];
        

        

        return $toc;
    }
    
    private function getLastPageEdit() : int
    {
        $table = 'pages';
        
        $pagesQueryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        
        $pagesQueryBuilder
            ->select('tstamp')
            ->from($table)
            ->where([
                $pagesQueryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($this->arguments['pageUid']))
            ]);

        $result = $pagesQueryBuilder->executeQuery()
            ->fetchAllAssociative();
            
        // goon 
    }
}