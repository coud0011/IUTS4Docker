<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @return array Contact[]
     */
    public function search(string $researching = ''): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where($qb->expr()->orX(
            $qb->expr()->like('p.firstname', ':researching'),
            $qb->expr()->like('p.lastname', ':researching')))
        ->setParameter('researching', '%'.$researching.'%')
        ->orderBy('p.lastname, p.firstname')
        ->leftJoin('p.category', 'ca')
        ->addSelect('ca');

        return $qb->getQuery()->execute();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findWithCategory(int $id): ?Contact
    {
        $qb = $this->createQueryBuilder('c');
        $qb->leftJoin('c.category', 'ca')
            ->addSelect('ca')
            ->where('c.id = :id')
            ->setParameter('id', $id);

        return $result = $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws Exception
     */
    public function deleteContact($id): void
    {
        $this->getEntityManager()->getConnection()->delete('contact', ['id' => $id]);
    }
    //    /**
    //     * @return Contact[] Returns an array of Contact objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Contact
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
