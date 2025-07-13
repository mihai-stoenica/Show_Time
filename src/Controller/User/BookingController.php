<?php

namespace App\Controller\User;

use App\Entity\Booking;
use App\Entity\Festival;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/booking')]
final class BookingController extends AbstractController
{
    #[Route('/new/{id}', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Festival $festival): Response
    {
        $booking = new Booking();
        $formOptions = [];

        if ($this->getUser()) {
            $booking->setEmail($this->getUser()->getEmail());
            $this->getUser()->addBooking($booking);
            $formOptions['hide_email'] = true;
        }

        $form = $this->createForm(BookingType::class, $booking, $formOptions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setFestival($festival);
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('booking/new.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking,
        ]);
    }

    #[Route('/', name: 'app_booking_user_index', methods: ['GET'])]
    public function show(): Response
    {
        if ($this->getUser()) {
            $pending_bookings = $this->getUser()->getPendingBookings();
            $successful_bookings = $this->getUser()->getSuccessfulBookings();
            $totalPrice = $this->getUser()->computeTotalPrice();

            return $this->render('booking/user_bookings.html.twig', [
                'pending_bookings' => $pending_bookings,
                'successful_bookings' => $successful_bookings,
                'totalPrice' => $totalPrice,
                'stripe_public_key' => $_ENV['STRIPE_PUBLIC_KEY'],
            ]);
        }
        return $this->redirectToRoute('app_login');
    }

    #[Route('/cancel/{id}', name: 'app_booking_user_cancel', methods: ['POST'])]
    public function cancel(Booking $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            $bookings = $this->getUser()->getBookings();
            if ($bookings->contains($booking)) {
                $entityManager->remove($booking);
                $entityManager->flush();

                return $this->redirectToRoute('app_booking_user_index');
            }
        }
        return $this->redirectToRoute('app_login');
    }
}
