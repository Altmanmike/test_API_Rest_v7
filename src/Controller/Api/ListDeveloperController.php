<?php

namespace App\Controller\Api;

use App\Dto\DtoListDevQuery;
use App\Repository\DeveloperRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;

final class ListDeveloperController
{
    public function __construct(
        private readonly DeveloperRepository $devRepo,
        private readonly SerializerInterface $serializer,
    ) {}
    
    #[Route('/api/developers', name: 'app_list_developer', methods: ['GET'])]
    public function list(#[MapQueryString] DtoListDevQuery $dtoListDevQuery): Response
    {        
        $listDev = $this->devRepo->findAllWithFilters($dtoListDevQuery);

        $listDev = $this->serializer->serialize($listDev, 'json', [
            'groups' => ['developer:read'] 
        ]);        
        
        return JsonResponse::fromJsonString($listDev);
    }
}