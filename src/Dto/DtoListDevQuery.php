<?php

namespace App\Dto;

use App\Entity\Developer;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(target: Developer::class)]
final readonly class DtoListDevQuery {
    
    public function __construct(
        
        public ?string $title = null,
    
        public ?string $description = null,

        public ?array $companies = null,

        public ?int $experience = null,

        public ?bool $isParticipant = null,

        public ?\DateTimeImmutable $createdAt = null,

        public ?\DateTimeImmutable $updatedAt = null,
        
        public int $page = 1,
        
        public int $itemsPerPage = 4,
    ) {
        
    }    
}