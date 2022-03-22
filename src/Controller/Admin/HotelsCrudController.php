<?php

namespace App\Controller\Admin;

use App\Entity\Hotels;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class HotelsCrudController extends AbstractCrudController
{
    protected EntityRepository $entityRepository;

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
            TextField::new('adress', 'Adresse'),
            TextField::new('city','Ville'),
            AssociationField::new('Users','Gérant')
            ->setRequired(true)
            ->setQueryBuilder(function ($queryBuilder) {
                return $queryBuilder
                    ->andWhere('entity.roles LIKE :role')
                    ->setParameter('role', '%ROLE_GERANT%');
            })
        ];
    }
}
