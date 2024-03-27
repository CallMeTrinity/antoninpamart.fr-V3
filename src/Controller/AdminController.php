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

use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\Tag;
use App\Exception\ProjectNotFoundException;
use App\Exception\SkillNotFoundException;
use App\Exception\TagNotFoundException;
use App\Form\ProjectType;
use App\Form\SkillType;
use App\Form\TagType;
use App\Form\TrinityType;
use App\Repository\MoiRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepository $projectRepository,
        private readonly TagRepository $tagRepository,
        private readonly SkillRepository $skillRepository,
        private readonly MoiRepository $moiRepository,
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function renderHome(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/admin/projects', name: 'admin_projects')]
    public function manageProjects(Request $request): Response
    {
        $projects = $this->projectRepository->findAll();
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($project);
            $this->entityManager->flush();

            $this->addFlash('success', 'Projet ajouté avec succès.');

            return $this->redirectToRoute('admin_projects');
        }

        return $this->render('admin/admin_projects.html.twig', [
            'form' => $form->createView(),
            'projects' => $projects,
        ]);
    }

    #[Route('/admin/project/edit/{id}', name: 'project_edit')]
    public function projectEdit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Le projet a été mis à jour avec succès.');

            return $this->redirectToRoute('admin_projects');
        }

        return $this->render('admin/project_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws ProjectNotFoundException
     */
    #[Route('/admin/project/delete/{id}', name: 'project_delete')]
    public function projectDelete(int $id): Response
    {
        $project = $this->entityManager->getRepository(Project::class)->find($id);
        $this->projectRepository->deleteProject($project->getId());
        $this->addFlash('success', 'Projet supprimé : '.$project->getName());

        return $this->redirectToRoute('admin_projects');
    }

    #[Route('/admin/tags', name: 'admin_tags')]
    public function manageTags(Request $request): Response
    {
        $tags = $this->entityManager->getRepository(Tag::class)->findAll();

        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagName = $tag->getName();
            $existingTag = $this->entityManager->getRepository(Tag::class)->findOneBy(['name' => $tagName]);

            if (!$existingTag) {
                $this->entityManager->persist($tag);
                $this->entityManager->flush();

                $this->addFlash('success', 'Tag ajoutés avec succès.');
            } else {
                $this->addFlash('error', 'Tag existe déjà.');
            }

            return $this->redirectToRoute('admin_tags');
        }

        return $this->render('admin/admin_tags.html.twig', [
            'form' => $form->createView(),
            'tags' => $tags,
        ]);
    }

    /**
     * @throws TagNotFoundException
     */
    #[Route('/admin/tags/delete/{id}', name: 'tag_delete')]
    public function tagDelete(int $id): Response
    {
        $this->tagRepository->deleteTag($id);

        return $this->redirectToRoute('admin_tags');
    }

    #[Route('admin/skills', name: 'admin_skills')]
    public function manageSkills(Request $request): Response
    {
        $skills = $this->skillRepository->findAll();

        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skillName = $skill->getName();
            $existingSkill = $this->skillRepository->findOneBy(['name' => $skillName]);

            if (!$existingSkill) {
                $this->entityManager->persist($skill);
                $this->entityManager->flush();

                $this->addFlash('success', 'Compétence ajoutés avec succès.');
            } else {
                $this->addFlash('error', 'Compétence existe déjà.');
            }

            return $this->redirectToRoute('admin_skills');
        }

        return $this->render('admin/admin_skills.html.twig', [
            'form' => $form->createView(),
            'skills' => $skills,
        ]);
    }

    /**
     * @throws SkillNotFoundException
     */
    #[Route('/admin/skills/delete/{id}', name: 'skill_delete')]
    public function deleteSkill(int $id): Response
    {
        $this->skillRepository->deleteSkill($id);

        return $this->redirectToRoute('admin_skills');
    }

    #[Route('admin/me', name: 'admin_me')]
    public function manageTrinity(Request $request): Response
    {
        $me = $this->moiRepository->findOneBy(['name' => 'Antonin']);
        $form = $this->createForm(TrinityType::class, $me);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Le profil a été mis à jour avec succès.');

            return $this->redirectToRoute('admin_me');
        }

        return $this->render('admin/admin_trinity.html.twig', [
            'me' => $me,
            'form' => $form->createView(),
        ]);
    }
}
