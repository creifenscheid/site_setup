<?php

namespace CReifenscheid\SiteSetup\DataProcessing;

use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Frontend\ContentObject\Exception\ContentRenderingException;
use PDO;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

use function array_key_exists;

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
class PageCategoriesProcessor implements DataProcessorInterface
{
    /**
     * Returns categories of the current page
     *
     * @param ContentObjectRenderer $cObj                       The data of the content element or page
     * @param array                 $contentObjectConfiguration The configuration of Content Object
     * @param array                 $processorConfiguration     The configuration of this processor
     * @param array                 $processedData              Key/value store of processed data (e.g. to be passed to a Fluid View)
     *
     * @return array the processed data as key/value store
     * @throws \Doctrine\DBAL\DBALException
     * @throws Exception
     * @throws ContentRenderingException
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData): array
    {
        $as = array_key_exists('as', $processorConfiguration) ?: 'categories';

        $request = $cObj->getRequest();
        $routing = $request->getAttribute('routing');
        $pageUid = $routing->getPageId();

        $table = 'sys_category';

        // init querybuilder
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);

        // set up querybuilder
        $processedData[$as] = $queryBuilder
            ->select('sys_category.*')
            ->from($table)
            ->join(
                $table,
                'sys_category_record_mm',
                'mm',
                $queryBuilder->expr()->eq('mm.uid_local', $queryBuilder->quoteIdentifier('sys_category.uid'))
            )->where($queryBuilder->expr()->eq('mm.uid_foreign', $queryBuilder->createNamedParameter($pageUid, PDO::PARAM_INT)))->executeQuery()
            ->fetchAllAssociative();

        return $processedData;
    }
}
