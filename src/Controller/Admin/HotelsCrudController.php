<?php

namespace App\Controller\Admin;

use App\Entity\Hotels;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class HotelsCrudController extends AbstractCrudController
{ protected EntityRepository $entityRepository;

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['name', 'city', 'adress'])
            ->setEntityLabelInSingular('Hotel')
            ->setEntityLabelInPlural('Hotels');
    }

    public static function getEntityFqcn(): string
    {
        return Hotels::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Nom'),
            TextField::new('city','Ville'),
            TextField::new('adress', 'Adresse'),
            TextareaField::new('description','Description')
        ];
    }
}
