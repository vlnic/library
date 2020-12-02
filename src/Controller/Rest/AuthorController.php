<?php declare(strict_types=1);

namespace App\Controller\Rest;

use App\Service\AuthorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/author/")
 *
 * Class AuthorController
 * @package App\Controller\Rest
 */
class AuthorController
{
    /**
     * @var AuthorService
     */
    private AuthorService $service;

    /**
     * AuthorController constructor.
     * @param AuthorService $service
     */
    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(path="/{id}", name="rest_author-get")
     * @param int $id
     * @return JsonResponse
     * @throws \App\Service\Exception\AuthorException
     */
    public function get(int $id)
    {
        if (null === $author = $this->service->get($id)) {
            return new JsonResponse(
                ['error' => sprintf('не удалось найти автора \'%s\'', $id)],
                404
            );
        }
        return new JsonResponse([
            'id' => $author->getId(),
            'name' => $author->getName(),
            'second_name' => $author->getSecondName(),
            'middle_name' => $author->getMiddleName(),
        ], 200);
    }

    /**
     * @Route(path="/create", name="rest_author-create", methods={"POST"})
     */
    public function create()
    {
        return new JsonResponse([]);
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function join()
    {

    }
}
