<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Service\Exception\AuthorException;

/**
 * Class AuthorService
 * @package App\Service
 */
class AuthorService
{
    /**
     * @var AuthorRepository
     */
    private AuthorRepository $repository;

    /**
     * AuthorService constructor.
     * @param AuthorRepository $repository
     */
    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Author|null
     * @throws AuthorException
     */
    public function get(int $id) : ?Author
    {
        try {
            return $this->repository->find($id);
        } catch (\Throwable $e) {
            throw new AuthorException(
                sprintf('Не удалось найти автора %s: %s', $id, $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }
}
