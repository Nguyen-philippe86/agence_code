<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(PropertyRepository $repository): Response
    {
        $repository = $this->getDoctrine()->getRepository(Property::class);

        $property = $repository->findBy([], ['id' => 'DESC'], 3);

        return $this->render('home/home.html.twig', [
            'property' => $property,
        ]);
    }
}
