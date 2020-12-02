<?php declare(strict_types=1);

namespace App\Controller\Rest;

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
