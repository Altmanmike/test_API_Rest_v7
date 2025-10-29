<?php

namespace App\Controller\Api;

use App\Entity\Developer;
use App\Dto\DtoUpdateDevRequest;
use App\Repository\DeveloperRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\SerializerInterface;

final class UpdateDeveloperController
{
    public function __construct(
        private readonly DeveloperRepository $devRepo,
        private readonly ObjectMapperInterface $objectMapper,
        private readonly SerializerInterface $serializer      
    ) {}
    
    #[Route('/api/developers/{id}', name: 'app_update_developer', methods: ['PUT', 'PATCH'])]
    public function update(
        #[MapEntity(expr: 'repository.find(id)', message: 'resource not found')] Developer $developer, 
        #[MapRequestPayload] DtoUpdateDevRequest $dtoUpdateDevRequest): JsonResponse
    {
                
        $updatedDeveloper = $this->objectMapper->map($dtoUpdateDevRequest, $developer);
        
        $this->devRepo->add($updatedDeveloper, true);
                
        $data = $this->serializer->serialize($updatedDeveloper, 'json', [
            'groups' => ['developer:read'] 
        ]);        
        
        return JsonResponse::fromJsonString($data);
    }
}