<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $repository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $contacts = $repository->search($search);

        return $this->render('contact/index.html.twig', ['contacts' => $contacts, 'search' => '' == $search ? 'Search' : $search]);
    }

    #[Route('/contact/create', name: 'app_contact_create')]
    #[IsGranted('ROLE_ADMIN')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_id', ['id' => $contact->getId()]);
        }

        return $this->render('contact/create.html.twig', ['form' => $form]);
    }

    #[Route('/contact/{id}', name: 'app_contact_id', requirements: ['id' => '\d+'])]
    public function show(#[MapEntity(expr: 'repository.findWithCategory(id)')] Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }

    #[Route('/contact/{id}/delete', name: 'app_contact_delete', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(#[MapEntity(expr: 'repository.findWithCategory(id)')] Contact $contact, Request $request, ContactRepository $repository): Response
    {
        $form = $this->createFormBuilder($contact)
            ->add('goback', SubmitType::class, ['label' => 'Annuler'])
            ->add('delete', SubmitType::class, ['label' => 'Supprimmer'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $repository->deleteContact($contact->getId());

                return $this->redirectToRoute('app_contact');
            } else {
                return $this->redirectToRoute('app_contact_id', ['id' => $contact->getId()]);
            }
        }

        return $this->render('contact/delete.html.twig', ['contact' => $contact, 'form' => $form]);
    }

    #[Route('/contact/{id}/update', name: 'app_contact_update', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    public function update(#[MapEntity(expr: 'repository.findWithCategory(id)')] Contact $contact, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_id', ['id' => $contact->getId()]);
        }

        return $this->render('contact/update.html.twig', ['form' => $form, 'contact' => $contact]);
    }
}
