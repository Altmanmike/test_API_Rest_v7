<?php

namespace App\Dto;

use App\Entity\Developer;
use DateTimeImmutable;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Developer::class)]
final readonly class DtoCreateDevRequest {
    
    public function __construct(

        #[Assert\NotBlank()]
        #[Assert\Length(min: 10, max: 255)]        
        public ?string $title = null,
    
        #[Assert\Length(min: 10)]
        public ?string $description = null,
                
        #[Assert\Count(min: 1)]
        public ?array $companies = null,

        #[Assert\NotBlank()]
        #[Assert\Range(min: 0, max: 30)]
        public ?int $experience = null,
        
        public ?bool $isParticipant = null,
        
        public ?DateTimeImmutable $createdAt = new \DateTimeImmutable(),
        
        public ?DateTimeImmutable $updatedAt = new \DateTimeImmutable(),

    ) {
        
    }    
}