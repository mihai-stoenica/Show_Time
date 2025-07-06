<?php

namespace App\Controller\User;

use App\Repository\FestivalRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FestivalsController extends AbstractController
{
    #[Route('/festivals', name: 'app_festivals_user')]
    public function index(Request $request, FestivalRepository $festivalRepository, LoggerInterface $logger): Response
    {
        $nameParam = $request->query->get('search');
        $sortByNameParam = $request->query->get('sort');
        $startDateParam = $request->query->get('startDate');
        $endDateParam = $request->query->get('endDate');

        $festivals = $festivalRepository->getBySearchParam($nameParam, $sortByNameParam, $startDateParam, $endDateParam);

        return $this->render('festivals/index.html.twig', [
            'festivals' => $festivals,
        ]);
    }
}
