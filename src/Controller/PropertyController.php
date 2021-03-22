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
        // $property = $repo->findAll();
        $property = $repo->findBy([], ['id' => 'DESC']);

        return $this->render('property/property.html.twig', [
            'property' => $property,
        ]);
    }

    /**
     * @Route("/property/{id}", name="property_show") // route paramétrée, on lui passe en param l'ID
     *
     * @param mixed $id
     */
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }
}
