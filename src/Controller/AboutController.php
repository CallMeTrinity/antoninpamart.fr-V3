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

namespace App\Controller;

use App\Repository\MoiRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutController extends AbstractController
{
    public function __construct(private readonly SkillRepository $skillRepository, private readonly MoiRepository $moiRepository)
    {
    }

    #[Route('/a_propos', name: 'about')]
    public function renderAbout(): Response
    {
        return $this->render('/pages/a_propos.html.twig', [
            'advanced' => $this->skillRepository->advancedSkills(),
            'intermediate' => $this->skillRepository->intermediateSkills(),
            'basic' => $this->skillRepository->baseSkills(),
            'info' => $this->moiRepository->findAll()[0],
        ]
        );
    }
}
