<?php

/*
 * This file is part of the FileManager project.
 *
 * (c) Mezcalito <contact@mezcalito.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

$header = <<<'HEADER'
    This file is part of the Pamart_PortfolioV3 project.

    (c) Antonin <contact@antoninpamart.fr>

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.
    HEADER;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        '**vendor**',
        '**var**',
    ])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP83Migration' => true,
        '@PHPUnit84Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'declare_strict_types' => true,
        'header_comment' => [
            'header' => $header,
            'location' => 'after_open',
        ],
    ])
    ->setFinder($finder);
