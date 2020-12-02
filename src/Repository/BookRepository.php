<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class BookRepository
 * @package App\Repository
 */
class BookRepository extends ServiceEntityRepository
{
    /**
     * BookRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @param string $phrase
     * @return array|null
     */
    public function search(string $phrase) : ?array
    {
        return $this
            ->getEntityManager()
            ->createQuery(
                'select b, a from App\Entity\Book b join b.authors a where b.name like ?'
            )->setParameter(0, $phrase)
            ->getResult(AbstractQuery::HYDRATE_OBJECT);
    }
}
