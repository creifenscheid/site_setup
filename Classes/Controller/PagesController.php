<?php

namespace CReifenscheid\SiteSetup\Controller;

use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use Doctrine\DBAL\Driver\Exception;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

use function in_array;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2023 Christian Reifenscheid
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class PagesController
 */
class PagesController extends ActionController
{
    /**
     * @var string
     */
    protected const L10N = 'LLL:EXT:dates/Resources/Private/Language/Frontend/locallang.xlf:';

    protected array $requiredSettings = [
        'startingpoints',
        'orderBy',
        'orderDirection',
        'limit',
        'listPage',
    ];

    protected ?ContentObjectRenderer $contentObject = null;

    public function __construct(protected ConnectionPool $connectionPool)
    {
    }

    public function initializeListAction(): void
    {
        $settings = [];

        foreach ($this->settings as $key => $value) {
            if (in_array($key, $this->requiredSettings, true)) {
                $settings[$key] = $value;
            }
        }

        $this->settings = $settings;
    }

    /**
     * @throws InvalidQueryException
     */
    public function listAction(): ResponseInterface
    {
        $this->assignTtContentData();

        $this->view->assignMultiple([
            'l10n' => self::L10N,
            'pages' => $this->getPages(),
        ]);

        return $this->htmlResponse();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws Exception
     */
    private function getPages(): array
    {
        $table = 'pages';
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable($table);

        return $queryBuilder
            ->select($table . '.uid', $table . '.title', $table . '.description')
            ->from($table)
            ->where(
                $queryBuilder->expr()->in($table . '.pid', GeneralUtility::trimExplode(',', $this->settings['startingpoints']))
            )
            ->orderBy($table . '.' . $this->settings['orderBy'], $this->settings['orderDirection'])
            ->setMaxResults($this->settings['limit'])
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function assignTtContentData(): void
    {
        $contentObject = $this->request->getAttribute('currentContentObject');
        $this->view->assign('ttContentData', $contentObject->data);
    }
}
