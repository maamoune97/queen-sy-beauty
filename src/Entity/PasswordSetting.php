<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class PasswordSetting
{

    /**
     * @SecurityAssert\UserPassword(
     *     message = "Mot de passe actuel incorrect"
     * )
     */
    private $actual;

    /**
     * @Assert\NotBlank(message = "Entrez un mot de passe")
     * @Assert\Length(
     *      min = 8,
     *      max = 255,
     *      minMessage = "Le mot de passe doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le mot de passe ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $new;

    /**
     * @Assert\NotBlank(message = "Confirmer votre mot de passe")
     * @Assert\IdenticalTo(
     *      propertyPath="new",
     *      message="Le mot de passe ne correspond pas"
     * )
     */
    private $confirm;

    public function getActual(): ?string
    {
        return $this->actual;
    }

    public function setActual(string $actual): self
    {
        $this->actual = $actual;

        return $this;
    }

    public function getNew(): ?string
    {
        return $this->new;
    }

    public function setNew(string $new): self
    {
        $this->new = $new;

        return $this;
    }

    public function getConfirm(): ?string
    {
        return $this->confirm;
    }

    public function setConfirm(string $confirm): self
    {
        $this->confirm = $confirm;

        return $this;
    }
}
