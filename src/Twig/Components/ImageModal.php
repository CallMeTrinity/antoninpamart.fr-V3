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

namespace App\Twig\Components;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Finder\Finder;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ImageModal extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public array $images = [];
    #[LiveProp]
    public ?string $parameter = null;
    private string $root;

    public function __construct(private Filesystem $filesystem)
    {
        $this->filesystem = new Filesystem();
    }

    public function getImages(): array
    {
        $this->root = $this->getParameter($this->parameter);

        $finder = new Finder();

        $files = $finder
            ->in($this->root)
            ->depth(0)
        ;

        foreach ($files as $item) {
            $this->images[] = $item->getBasename();
        }

        return $this->images;
    }

    #[LiveAction]
    public function delete(#[LiveArg] $name): void
    {
        $this->images = [];
        $this->root = $this->getParameter($this->parameter);
        $fullPath = Path::join($this->root, $name);
        $this->filesystem->remove($fullPath);
        $this->addFlash('success', sprintf('Removed %s', $name));
    }
}
