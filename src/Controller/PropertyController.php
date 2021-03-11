<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="property")
     */
    public function index(PropertyRepository $repo): Response // PropertyRepository = Injection de dépendance
    {
        $property = $repo->findAll();

        return $this->render('property/property.html.twig', [
            'property' => $property,
        ]);
    }

    /**
     * @Route("/property/{id}", name="property_show")
     *
     * @param mixed $id
     */
    public function show(Property $property): Response // PropertyRepository = Injection de dépendance
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }
}
