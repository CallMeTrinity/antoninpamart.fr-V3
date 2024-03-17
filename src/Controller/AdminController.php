<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Tag;
use App\Form\ProjectType;
use App\Form\TagType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
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
        $projects = $this->entityManager->getRepository(Project::class)->findAll();
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
        }

        return $this->render('admin/project_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/admin/project/delete/{id}', name: 'project_delete')]
    public function projectDelete(int $id):void
    {
        $this->entityManager->getRepository(Project::class)->deleteProject($id);
        $this->redirectToRoute('admin_projects');
    }

    #[Route('/admin/tags', name: 'admin_tags')]
    public function manageTags(Request $request): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagName = $tag->getName();
            $existingTag = $this->entityManager->getRepository(Tag::class)->findOneBy(['name' => $tagName]);

            if (!$existingTag){
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
        ]);
    }


}
