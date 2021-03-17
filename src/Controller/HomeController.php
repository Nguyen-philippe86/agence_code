<?php

namespace App\Controller;

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
        $property = $repository->findAll();

        return $this->render('home/home.html.twig', [
            'property' => $property,
        ]);
    }
}
