<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Images::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setSearchFields(['title', 'description', 'adress'])
            ->setPageTitle('detail', fn (Images $images) => (string) $images->getName())
            ->setEntityLabelInSingular('Image')
            ->setEntityLabelInPlural('Images');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Nom'),
            ImageField::new('bin', 'Image')
                ->setBasePath('img/')
                ->setUploadDir('public/img')
                ->setSortable(false),


        ];
    }}


