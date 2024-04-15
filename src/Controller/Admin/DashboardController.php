<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Media;
use App\Entity\Contact;
use App\Entity\Message;
use App\Controller\Admin\PostCrudController;
use App\Entity\Competence;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    // on crée le construct qui prende en paramétre le service / une instance de AdminUrlGenerator
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // on donne l'entité que l'on veut afficher au tableau de bord
        $url = $this->adminUrlGenerator
            ->setController(PostCrudController::class)
            ->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        // Titre du tableau de bord + logo
        return Dashboard::new()
            ->setTitle('<img src="/images/user.png" alt="logo" style="width: 40px; height: 40px;"><span class="text-small"> Kigo Back Office</span>')
            ->setFaviconPath('/images/user.png');
    }

    public function configureMenuItems(): iterable
    {
        // Liste des menus
        yield MenuItem::section('Gestion Projets');

        // Liste des menus
        yield MenuItem::subMenu('Gestion des messages', 'fa fa-message')->setSubItems([
            MenuItem::linkToCrud('Ajouter un message', 'fa fa-plus', Message::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des messages', 'fa fa-list', Message::class),
        ]);

        yield MenuItem::subMenu('Gestion des contacts', 'fa fa-users')->setSubItems([
            MenuItem::linkToCrud('Ajouter un contact', 'fa fa-plus', Contact::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des contacts', 'fa fa-list', Contact::class),
        ]);

        yield MenuItem::subMenu('Gestion des types de contact', 'fa fa-users')->setSubItems([
            MenuItem::linkToCrud('Ajouter un type de contact', 'fa fa-plus', Type::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des types de contact', 'fa fa-list', Type::class),
        ]);

        yield MenuItem::subMenu('Gestion des médias', 'fa fa-link')->setSubItems([
            MenuItem::linkToCrud('Ajouter un média', 'fa fa-plus', Media::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des médias', 'fa fa-list', Media::class),
        ]);

        yield MenuItem::subMenu('Gestion des posts', 'fa fa-clipboard')->setSubItems([
            MenuItem::linkToCrud('Ajouter un post', 'fa fa-plus', Post::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des posts', 'fa fa-list', Post::class),
        ]);

        yield MenuItem::subMenu('Gestion des projets', 'fa fa-briefcase')->setSubItems([
            MenuItem::linkToCrud('Ajouter un projet', 'fa fa-plus', Post::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des projets', 'fa fa-list', Post::class),
        ]);

        yield MenuItem::subMenu('Gestion des compétences', 'fa fa-puzzle-piece')->setSubItems([
            MenuItem::linkToCrud('Ajouter une compétence', 'fa fa-plus', Competence::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des compétences', 'fa fa-list', Competence::class),
        ]);
        // Liste des menus user
        yield MenuItem::section('Gestion Utilisateurs');

        yield MenuItem::subMenu('Gestion des Utilisateurs', 'fa fa-user-circle-o')->setSubItems([
            MenuItem::linkToCrud('Ajouter un utilisateur', 'fa fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des utilisateurs', 'fa fa-list', User::class),
        ]);
    }
}
