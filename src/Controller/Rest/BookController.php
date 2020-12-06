<?php declare(strict_types=1);

namespace App\Controller\Rest;

use App\Entity\Book;
use App\Service\BookService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Route("/api/book/")
 *
 * Class BookController
 * @package App\Controller\Rest
 */
class BookController
{
    /**
     * @var EventDispatcherInterface
     */
    protected EventDispatcherInterface $dispatcher;

    /**
     * @var BookService
     */
    protected BookService $service;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param BookService $service
     */
    public function __construct(EventDispatcherInterface $dispatcher, BookService $service)
    {
        $this->dispatcher = $dispatcher;
        $this->service = $service;
    }

    /**
     * @Route(path="{id}", name="rest_get-book", methods={"GET"}, requirements={"id"="\d+"})
     * @param $id
     * @return JsonResponse
     * @throws \App\Service\Exception\BookServiceException
     */
    public function get($id)
    {
        $book = $this->service->find((int) $id);
        if (! $book instanceof Book) {
            return new JsonResponse(
                ['error' => sprintf('не удалось найти книгу с идентификатором \'%s\'', $id)],
                404
            );
        }
        return new JsonResponse([
            'id' => $book->getId(),
            'name' => $book->getName(),
            'description' => $book->getDescription(),
            'created' => $book->getCreated(),
            'updated' => $book->getUpdated(),
            'authors' => $book->getAuthors()
                ->map(function ($v) {
                    return [
                        'id' => $v->getId(),
                        'name' => $v->getName(),
                        'second_name' => $v->getSecondName(),
                        'middle_name' => $v->getMiddleName(),
                    ];
                })->toArray()
        ], 200);
    }

    /**
     * @Route(path="/search", name="rest_book-search", methods={"POST", "GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \App\Service\Exception\BookServiceException
     */
    public function search(Request $request)
    {
        $phrase = $request->query->get('search', null) ?? $request->request->get('search', null);
        if (null === $phrase) {
            return new JsonResponse(['error' => 'Отсутствует обязательный аргумент \'search\''], 400);
        }
        if (null === $books = $this->service->findByName($phrase)) {
            return new JsonResponse([]);
        }
        return new JsonResponse(
            array_map(
                function ($b) {
                    return [
                        'id' => $b->getId(),
                        'name' => $b->getName(),
                        'description' => $b->getDescription(),
                        'created' => $b->getCreated(),
                        'updated' => $b->getUpdated(),
                        'authors' => $b->getAuthors()
                            ->map(function ($v) {
                                return [
                                    'id' => $v->getId(),
                                    'name' => $v->getName(),
                                    'second_name' => $v->getSecondName(),
                                    'middle_name' => $v->getMiddleName(),
                                ];
                            })->toArray()
                    ];
                },
                $books
            ),
            200
        );
    }

    /**
     * @Route(path="/create", name="rest_create-book", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validation::createValidator();
        $input = $request->request->all();
        $groups = new Assert\GroupSequence(['Default', 'custom']);
        $constraint = new Assert\Collection([

        ]);
        $violations = $validator->validate($input, $groups, $constraint);

        return new JsonResponse([]);
    }

    public function delete()
    {
    }

    public function update()
    {
    }

    public function join()
    {
    }
}
