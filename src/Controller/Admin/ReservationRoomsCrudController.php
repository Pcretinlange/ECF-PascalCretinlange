<?php

namespace App\Controller\Admin;

use App\Entity\ReservationRooms;
use App\Entity\Users;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class ReservationRoomsCrudController extends AbstractCrudController
{
    protected EntityRepository $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }
    public static function getEntityFqcn(): string
    {
        return ReservationRooms::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::EDIT, Action::NEW);
    }
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        /** @var Users $users */
        $users = $this->getUser();
        $response = $this->entityRepository
            ->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if ($users->getRole() == 'ROLE_GERANT'){
            $response
                ->andWhere('entity.hotels = :hotel')
                ->setParameter('hotel', $users->getHotels());
            return $response;
        }

       return $response;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setSearchFields(['hotels.name', 'hotelRooms.title', 'users.lastname'])
            ->setEntityLabelInSingular('Réservation')
            ->setEntityLabelInPlural('Réservations');
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('hotels', 'Hôtel'),
            TextField::new('hotelRooms', 'Suite'),
            TextField::new('users', 'Client'),
            NumberField::new('totalPrice', 'Prix Total (€)'),
            DateField::new('startDate', 'Début'),
            DateField::new('endDate', 'Fin'),
        ];
    }
}

