<?php

/*
 * This file is part of the antoninpamart.fr-V3 project.
 *
 * (c) Antonin <contact@antoninpamart.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

$header = <<<'HEADER'
    This file is part of the antoninpamart.fr-V3 project.

    (c) Antonin <contact@antoninpamart.fr>

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.
    HEADER;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('var')
    ->exclude('node_modules')
    ->notPath('public/build')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
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
