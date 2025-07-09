<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\BookingRepository;
use App\Repository\FestivalRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository, UserRepository $userRepository, FestivalRepository $festivalRepository): Response
    {
        $bookingCount = $bookingRepository->count();
        $totalRevenue = $bookingRepository->computeTotalRevenue();

        $mediumRevenue = $totalRevenue / $bookingCount;

        $userCount = $userRepository->count();
        $nonGuestRevenue = $bookingRepository->getNonGuestRevenue();

        $mediumUserRevenue = $nonGuestRevenue / $userCount;

        $guestCount = $bookingRepository->getGuestCount();

        $loggedUserPercent = $userCount / ($guestCount + $userCount) * 100;

        $mostFeatured = array_slice($festivalRepository->getMostFeatured(), 0, 5);

        return $this->render('dashboard/index.html.twig', [
            'totalRevenue' => $totalRevenue,
            'mediumRevenue' => $mediumRevenue,
            'mediumUserRevenue' => $mediumUserRevenue,
            'loggedUserPercent' => $loggedUserPercent,
            'mostFeatured' => $mostFeatured,
            'bookingCount' => $bookingCount,
            'guestCount' => $guestCount,
        ]);
    }
}
