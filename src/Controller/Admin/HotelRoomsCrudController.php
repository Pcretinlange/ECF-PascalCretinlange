<?php

namespace App\Controller\Admin;

use App\Entity\HotelRooms;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use phpDocumentor\Reflection\PseudoTypes\NumericString;

class HotelRoomsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HotelRooms::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['title', 'description', 'adress'])
            ->setPageTitle('detail', fn (HotelRooms $hotel_rooms) => (string) $hotel_rooms->getTitle())
            ->setEntityLabelInSingular('Suite')
            ->setEntityLabelInPlural('Suites');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title','Nom'),
            NumberField::new('price', 'Prix/Nuit'),
            TextareaField::new('description', 'Description'),
            AssociationField::new('hotels','Hôtel')
                ->setRequired(true),
            TextField::new('booking_link','Lien Booking.com')->hideOnIndex()


        ];
    }}


