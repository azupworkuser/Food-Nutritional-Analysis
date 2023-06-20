<?php

namespace App\Controller;

use App\Repository\FruitFamilyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/fruit/families')]
class FruitFamilyController extends BaseController
{
    #[Route('/', name: 'app_fruit_families', methods: ['GET', 'HEAD'])]
    public function index(FruitFamilyRepository $repository): JsonResponse
    {
        $families = $repository->findBy([], ['name' => 'ASC']);
        return $this->json($this->serializeCollection($families), Response::HTTP_OK);
    }
}
