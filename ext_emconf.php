<?php

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2020 C. Reifenscheid
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

$EM_CONF[$_EXTKEY] = [
    'title' => 'Site setup',
    'description' => 'Basic site setup',
    'category' => 'template',
    'author' => 'Christian Reifenscheid',
    'version' => '12.2.0',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.8-12.4.99',
            'rte_ckeditor' => '12.4.8-12.4.99',
            'container' => '2.1.0-2.9.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'CReifenscheid\\SiteSetup\\' => 'Classes',
        ],
    ],
];
