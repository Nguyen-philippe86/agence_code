<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\EditProfileType;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // /**
    //  * @Route("/user/property", name="user_property")
    //  */
    // public function index(PropertyRepository $repository): Response //PropertyRepository = $repository qui affiche tout du PropertyRepository
    // {
    //     $property = $repository->findAll();

    //     return $this->render('user/user.html.twig', [ //retourne le résultat sur la page "user.html.twig"
    //         'property' => $property,
    //     ]);
    // }

    /**
     * @Route("/user", name="user")
     */
    public function profil()
    {
        return $this->render('user/user.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/property/create", name="user_create")
     * @Route("/user/property/{id}", name="user_edit", methods="GET|POST")
     */
    public function createAndEdit(Property $property = null, Request $request, EntityManagerInterface $entityManager): Response // On passe en param REQUEST = la requête
    {
        if (!$property) {
            $property = new Property(); // ajout d'un nouvel property
        }
        $form = $this->createForm(PropertyType::class, $property); //appelle du formulaire PopertyType, Si y a madification affiche le formulaire de l'id correspondant
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire est valide et soumis
            $property->setCreatedAt(new \DateTime());
            $modif = null !== $property->getId();
            $user = $this->security->getUser();
            $property->setAuthor($user);
            $entityManager->persist($property);
            $entityManager->flush();
            $this->addFlash('success', ($modif) ? 'La modification a été effectué' : "L'ajout a été effectué");

            return $this->redirectToRoute('user_property'); //Redirige vers la page "property"
        }

        return $this->render('user/create.html.twig', [//Si y a création retourne l'affichage de création sur la page "create.html.twig"
            'property' => $property,
            'form' => $form->createView(),
            'isModification' => null !== $property->getid(),
        ]);
    }

    /**
     * @Route("/user/profil/edit", name="user_profil_edit")
     */
    public function editProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser(); // on récupère l'user dans l'entity et on le stock dans la variable $user
        $form = $this->createForm(EditProfileType::class, $user); // on crée le formulaire a partir du type EditProfileType::class
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Profil mis à jour');

            return $this->redirectToRoute('user_property');
        }

        return $this->render('user/edit-profil.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/property/{id}", name="user_delete", methods="delete")
     */
    public function delete(Property $property, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('SUP'.$property->getId(), $request->get('_token'))) {
            $entityManager->remove($property);
            $entityManager->flush();
            $this->addFlash('success', 'La suppression a été effectué');

            return $this->redirectToRoute('user_property');
        }
    }
}
