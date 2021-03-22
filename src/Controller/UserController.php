<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\User;
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
     * @Route("/user/{id}/edit", name="user_profil_edit")
     */
    public function editProfile(User $user = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$user) { // Si il n'y a pas de nouvel property = null
            $user = new User(); // Alors on créer une property
        }

        $user = $this->security->getUser(); // on récupère l'user dans l'entity et on le stock dans la variable $user
        $form = $this->createForm(EditProfileType::class, $user); // on crée le formulaire a partir du type EditProfileType::class
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Profil mis à jour');

            // return $this->redirectToRoute('user', ['id' => $user->getId()]);
        }

        return $this->render('user/edit-profil.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/property/create", name="user_create")
     * @Route("/user/property/{id}", name="user_edit", methods="GET|POST")
     */
    public function createAndEdit(Property $property = null, Request $request, EntityManagerInterface $entityManager): Response
    // On passe en param REQUEST = la requête http (les données quel contient), les infos du formulaire envoyer par la request
    {
        if (!$property) { // Si il n'y a pas de nouvel annonce qui est = null
            $property = new Property(); // Alors on créer une annonce
        }
        $form = $this->createForm(PropertyType::class, $property);
        // Créer une formulaire qui est lié a PopertyType, Si y a modification affiche le formulaire de l'id correspondant
        $form->handleRequest($request); // Analyse les infos de la request
        if ($form->isSubmitted() && $form->isValid()) {// Si le formulaire est remplie et valide et soumis
            $property->setCreatedAt(new \DateTime()); // On donne une info supplémentaire (sa date de création) au formulaire
            $modif = null !== $property->getId(); // Si dans l"annonce, il y a déjà un ID, alors sa sera une modif
            $user = $this->security->getUser(); // On récupère donc l'utilisateur
            $property->setAuthor($user); // On donne une info supplémentaire (son auteur) au formulaire
            $entityManager->persist($property); // On fait persité l'annonce
            $entityManager->flush(); // Si tout est OK on balance la requête
            $this->addFlash('success', ($modif) ? 'La modification a été effectué' : "L'ajout a été effectué");
            // On renvoie un message de succès cela le mode du formulaire, ajout ou modif
            return $this->redirectToRoute('user'); // Redirige vers la page "annonce"
        }

        return $this->render('user/create.html.twig', [// On retourne une réponse / l'affichage
            'property' => $property,
            'form' => $form->createView(), // On lui passe le résultat de la fonction createView de ce formulaire
            'isModification' => null !== $property->getid(),
            // Si isModification est = null, alors on sera sur modification, sinon l'inverse
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

            return $this->redirectToRoute('user');
        }
    }
}
