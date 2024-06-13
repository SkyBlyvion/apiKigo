<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
   {
    //permet de renommer les différentes page
    return $crud
        ->setPageTitle(Crud::PAGE_INDEX, 'Post')
        ->setPageTitle(Crud::PAGE_EDIT, 'Modifier les posts')
        ->setPageTitle(Crud::PAGE_NEW, 'Ajouter un nouveau post');
   }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('text'),
            DateTimeField::new('created_date'),
            DateTimeField::new('updated_date'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
     //permet de configurer les différentes actions
     return $actions
         //permet de customiser les champs de la page index
         ->update(Crud::PAGE_INDEX, Action::NEW,
             fn(Action $action) => $action->setIcon('fa fa-add')->setLabel('Ajouter')->setCssClass('btn btn-success'))
         ->update(Crud::PAGE_INDEX, Action::EDIT,
             fn(Action $action) => $action->setIcon('fa fa-pen')->setLabel('Modifier'))
         ->update(Crud::PAGE_INDEX, Action::DELETE,
             fn(Action $action) => $action->setIcon('fa fa-trash')->setLabel('Supprimer'))
         
         //page edition
         ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
             fn(Action $action) => $action->setLabel('Enregistrer et quitter'))
         ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE,
             fn(Action $action) => $action->setLabel('Enregistrer et continer'))
         
         //page création 
         ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN,
             fn(Action $action) => $action->setLabel('Enregistrer'))
         ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER,
             fn(Action $action) => $action->setLabel('Enregistrer et ajouter un nouveau'));
    }
 }
    

