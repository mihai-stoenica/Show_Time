<?php

namespace App\Controller\User;

use App\Entity\Festival;
use App\Repository\FestivalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(FestivalRepository $festivalRepository): Response
    {
        $festivals = $festivalRepository->findAll();

        $best_deals = $festivals;
        $most_featured = $festivals;

        usort($most_featured, function (Festival $a, Festival $b) {
            return count($b->getBookings()) <=> count($a->getBookings());
        });

        usort($best_deals, function (Festival $a, Festival $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        return $this->render('index.html.twig', [
            'most_featured' => array_slice($most_featured, 0, 5),
            'best_deals' => array_slice($best_deals, 0, 5),
        ]);
    }
}
