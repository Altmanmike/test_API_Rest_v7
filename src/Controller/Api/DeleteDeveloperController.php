<?php

namespace App\Controller\Api;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class DeleteDeveloperController
{
    public function __construct(
        private readonly DeveloperRepository $devRepo        
    ) {}
    
    #[Route('/api/developers/{id}', name: 'app_delete_developer', methods: ['DELETE'])]
    public function delete(#[MapEntity(expr: 'repository.find(id)', message: 'Not found')] Developer $developer): Response
    {
        $this->devRepo->remove($developer, true);
        
        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}