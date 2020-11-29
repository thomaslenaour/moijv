<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\GameRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="category")
     * @Route("/category/{slug}/{page}", name="category_paginated")
     */
    public function games(Category $category, GameRepository $gameRepository, PaginatorInterface $paginator, $page = 1): Response
    {
        $games = $gameRepository->getLatestPaginatedGamesByCategory($paginator, $category->getId(), $page);
        $games->setUsedRoute('category_paginated');

        return $this->render('category/games.html.twig', [
            'category' => $category,
            'games' => $games
        ]);
    }
}
