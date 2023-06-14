<?php

namespace App\DTO;

use App\Entity\User;

class RecipeDTO
{
    public string $name;

    public string $description;

    public User  $owner;

    public function __construct(string $name, string $description, User $owner){
        $this->name = $name;
        $this->description = $description;
        $this->owner = $owner;
    }

    /**
     * @return int
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param int $owner
     */
    public function setOwner(int $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}