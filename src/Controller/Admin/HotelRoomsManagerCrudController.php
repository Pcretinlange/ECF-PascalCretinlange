<?php

namespace App\Controller\Admin;

use App\Entity\HotelRooms;
use App\Entity\Users;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class HotelRoomsManagerCrudController extends AbstractCrudController
{


    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, \EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection $filters): QueryBuilder
    {
        /**
         * @var Users $user
         */
        $user = $this->getUser();
        $hotels= $user->getHotels();
        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere('entity.hotels = :name')
                 ->setParameter('name', $hotels);
        return $response;
    }




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
            ->showEntityActionsInlined()
            ->showEntityActionsInlined()
            ->setSearchFields(['title', 'description', 'adress'])
            ->setPageTitle('detail', fn (HotelRooms $hotel_rooms) => (string) $hotel_rooms->getTitle())
            ->setEntityLabelInSingular('Suite')
            ->setEntityLabelInPlural('Suites');
    }
    public function configureFields(string $pageName): iterable
    {
        /**
         * @var Users $user
         */
        $user = $this->getUser();
        $hotels = $user->getHotelName();
        return [
            AssociationField::new('hotels','Hôtel')
                ->setQueryBuilder(function ($query) use ($hotels) {
                    return $query
                            ->andWhere('entity.name = :hotel')
                            ->setParameter('hotel', $hotels);
                }),
            TextField::new('title','Nom'),
            NumberField::new('price', 'Prix/Nuit'),
            TextareaField::new('description', 'Description'),
            AssociationField::new('Images','Image')
                ->setRequired(true),
            TextField::new('booking_link','Lien Booking.com')->hideOnIndex()
        ];
    }}