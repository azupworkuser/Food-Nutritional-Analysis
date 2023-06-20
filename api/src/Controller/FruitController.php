<?php

namespace App\Controller;

use App\Repository\FruitFamilyRepository;
use App\Repository\FruitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/fruits')]
class FruitController extends BaseController
{
    private FruitRepository $repository;
    public function __construct(FruitRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/', name: 'app_fruits', methods: ['GET', 'HEAD'])]
    public function index(Request $request, FruitFamilyRepository $familyRepository): JsonResponse
    {
        // Preparing the query params
        $limit = (int)$request->get('limit', 10);
        $page = (int)$request->get('page', 1);
        $query = (string)$request->get('query', '');
        $family = (string)$request->get('family', '');

        $familyEntity = $familyRepository->find($family);
        $fruits = $this->repository->getFruitListByFilter($query, $familyEntity, $page, $limit);
        return $this->json([
            'data' => $this->serializeCollection($fruits),
            'meta' => [
                'limit' => $limit,
                'page' => $page,
                'total' => $fruits->count()
            ]
        ]);
    }

    #[Route('/favorites', name: 'app_fruits_favorite', methods: ['GET', 'HEAD'])]
    public function favoriteFruits(): JsonResponse
    {
        $fruits = $this->repository->findBy(['isFavorite' => true], ['name' => 'DESC']);
        return $this->json($this->serializeCollection($fruits), Response::HTTP_OK);
    }

    #[Route('/{uuid}/toggle-favorite', name: 'app_fruits_toggle_favorite', methods: ['PUT'])]
    public function toggleFavorite(string $uuid): JsonResponse
    {
        $fruit = $this->repository->find($uuid);
        if (empty($fruit)) {
            throw new NotFoundHttpException("Record not found!");
        }

        $isMaximumFavoriteReached = $this->repository->isMaxFavoriteReached();
        if ($isMaximumFavoriteReached && !$fruit->getIsFavorite()) {
            throw new UnprocessableEntityHttpException("Maximum Limit reached!");
        }

        $fruit->setIsFavorite(!$fruit->getIsFavorite());
        $this->repository->save($fruit, true);
        return $this->json($this->serialize($fruit), Response::HTTP_OK);
    }
}
