<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User(); // On crée un nouvel utilisateur
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request); // On récupère la requête que l'utilisateur envoie

        if ($form->isSubmitted() && $form->isValid()) { // Condition si le formulaire est soumis ET valide
            $hash = $encoder->encodePassword($user, $user->getPassword()); // On encode le mot de passe dans la BDD
            $user->setPassword($hash); //On lie l'encodage avec le mdp de l'utilisateur
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(), // Renvoye le formulaire a la vue
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $util): Response
    {
        return $this->render('security/login.html.twig', [
            'lastUsername' => $util->getLastUsername(), // On envoie les derniers infos de l'user
            'error' => $util->getLastAuthenticationError(), // On envoie l'erreur à la vue
        ]);

        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
    }
}
