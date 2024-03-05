<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    public function index(CategoryRepository $repository, Request $request): Response
    {
        $categories = $repository->findAllAlphabeticallyWithContactCount();

        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    #[Route('/category/{id}', name: 'app_category_id')]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig', ['category' => $category, 'search' => 'Search']);
    }
}
