<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\Type;
use App\Entity\User;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    // /**
    //  * @Route("/admin", name="admin")
    //  */
    // public function index(): Response
    // {
    //     $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

    //     return $this->redirect($routeBuilder->setController(PropertyCrudController::class)->generateUrl());
    // }

    protected $propertyRepository;
    protected $userRepository;

    public function __construct(PropertyRepository $propertyRepository, UserRepository $userRepository)
    {
        $this->propertyRepository = $propertyRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('bundles/EasyAdminBundle/dashboard.html.twig', [
            'countAllUser' => $this->userRepository->countAllUser(),
            'countAllProperties' => $this->propertyRepository->countAllProperties(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="./img/logo2.png" width="150px"></img>')
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de bord', 'fas fa-chart-line');
        yield MenuItem::section('Annonces');
        yield MenuItem::linkToCrud('Annonces', 'fas fa-home', Property::class);
        yield MenuItem::linkToCrud('Catégorie', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Type', 'fas fa-tags', Type::class);
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users-cog', User::class);
        yield MenuItem::section('Poursuivre');
        yield MenuItem::linkToroute('Retour au site', 'fas fa-arrow-left', 'user');
        yield MenuItem::linkToLogout('Deconnexion', 'fas fa-sign-out-alt');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setAvatarUrl('https://www.udaf08.com/wp-content/uploads/2017/04/icon-administrateur-protection-personnes-departemantale-associations-familiales-copie.png')
            ->displayUserAvatar(true)
        ;
    }
}
