<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Service\Exception\BookServiceException;

/**
 * Class BookService
 * @package App\Service
 */
class BookService
{
    /**
     * @var BookRepository
     */
    private BookRepository $repository;

    /**
     * BookService constructor.
     * @param BookRepository $repository
     */
    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return Book|null
     * @throws BookServiceException
     */
    public function find(int $id) : ?Book
    {
        try {
            return $this->repository->find($id);
        } catch (\Throwable $e) {
            throw new BookServiceException(
                sprintf('Не удалось получить экземпляр книги: %s', $e->getMessage()),
                0,
                $e
            );
        }
    }

    /**
     * @param string $phrase
     * @return array|null
     * @throws BookServiceException
     */
    public function findByName(string $phrase) : ?array
    {
        try {
            return $this->repository->search($phrase);
        } catch (\Throwable $e) {
            throw new BookServiceException(
                sprintf('не удалось совершить поиск по имени: %s', $e->getMessage()),
                $e->getCode(),
                $e
            );
        }
    }
}