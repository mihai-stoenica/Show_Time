<?php

namespace App\Controller\User;

use App\Repository\FestivalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FestivalRepository $festivalRepository): Response
    {
        $best_deals = $festivalRepository->getBestDeals();
        $most_featured = $festivalRepository->getMostFeatured();

        return $this->render('index.html.twig', [
            'most_featured' => array_slice($most_featured, 0, 5),
            'best_deals' => array_slice($best_deals, 0, 5),
        ]);
    }
}
