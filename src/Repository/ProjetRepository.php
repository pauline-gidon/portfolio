<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Projet::class);
        $this->em = $em;
    }


    /**
      * @return Projet[] Returns an array of Projet objects
      */
    
    public function allProjetAndTechno()

    {

        $conn = $this->em->getConnection();
        $sql = "SELECT techno.nom, projet.description, projet.media, projet.url, GROUP_CONCAT(techno.nom SEPARATOR \'/\') AS liste_techno
        FROM projet
        INNER JOIN projet_techno
        on projet.id = projet_techno.projet_id
        INNER JOIN techno
        ON projet_techno.techno_id = techno.id
        GROUP BY projet.id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        var_dump($stmt->fetchAll());die;
        
    
    }


    // /**
    //  * @return Projet[] Returns an array of Projet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
