<?php

namespace App\Controller\Api;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class ShowDeveloperController
{
    public function __construct(
        private readonly DeveloperRepository $devRepo,
        private readonly SerializerInterface $serializer,
    ) {}
    
    #[Route('/api/developers/{id}', name: 'app_show_developer', methods: ['GET'])]
    public function show(#[MapEntity(id: 'id', message: 'Not found')] Developer $developer): Response
    {
        $dev = $this->serializer->serialize($developer, 'json', [
            'groups' => ['developer:read'] 
        ]);        
        
        return JsonResponse::fromJsonString($dev);
    }
}