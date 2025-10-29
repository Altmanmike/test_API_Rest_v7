<?php

namespace App\Controller\Api;

use App\Entity\Developer;
use App\Dto\DtoCreateDevRequest;
use App\Repository\DeveloperRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

final class CreateDeveloperController
{
    public function __construct(
        private readonly DeveloperRepository $devRepo,
        private readonly ObjectMapperInterface $objectMapper       
    ) {}
    
    #[Route('/api/developers', name: 'app_create_developer', methods: ['POST'])]
    public function create(#[MapRequestPayload] DtoCreateDevRequest $dtoCreateDevRequest): Response
    {         
        $developer = $this->objectMapper->map($dtoCreateDevRequest, Developer::class);
        
        $this->devRepo->add($developer, true);        
        
        return new Response('resource added', Response::HTTP_CREATED);
    }
}