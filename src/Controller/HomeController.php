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

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    #[Route('/', name: 'homepage')]
    public function renderHome(): Response
    {
        $projects = $this->projectRepository->findLast4Projects();

        return $this->render('home.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/cv', name: 'cv')]
    public function download(): BinaryFileResponse
    {
        return $this->file('.././public/media/pdf/CV 2024 PAMART.pdf');
    }


}
