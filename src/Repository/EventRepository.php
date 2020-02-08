<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Event::class);
        $this->manager = $manager;
    }

    /**
     * @param $name
     * @param $location
     * @param $attendance
     * @param $period
     * @param $date
     * @param $type
     */
    public function saveEvent($name, $location, $attendance, $period, $date, $type)
    {
        $event = new Event();

        $event
            ->setName($name)
            ->setLocation($location)
            ->setAttendance($attendance)
            ->setPeriod($period)
            ->setDate($date)
            ->setType($type);

        $this->manager->persist($event);
        $this->manager->flush();
    }


    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $id
     * @return Event|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByOne($id): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();

    }

    /**
     * @param $id
     * @return Event|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
//    public function find($id): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.id = :val')
//            ->setParameter('val', $id)
//            ->getQuery()
//            ->getOneOrNullResult();
//
//    }

    /**
     * @param Event $event
     */
    public function removeEvent(Event $event)
    {
        $this->manager->remove($event);
        $this->manager->flush();
    }

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function updateCustomer(Event $event): Event
    {
        $this->manager->persist($event);
        $this->manager->flush();

        return $event;
    }
}
