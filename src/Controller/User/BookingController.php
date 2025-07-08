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
}
