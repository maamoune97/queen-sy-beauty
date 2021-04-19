<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PlaceOrder
{
    const PAYEMENT_MODE = ['1', '2'];
    /**
     * @Assert\NotBlank(message = "Entrez votre nom")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le nom doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le nom ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     */
    private $lName;

    /**
     * @Assert\NotBlank(message = "Entrez votre prénom")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le prénom doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le prénom ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     */
    private $fName;

    /**
     * @Assert\NotBlank(message = "Entrez votre adresse email")
     * @Assert\Email(message = "Entrez un email valide")
     *
     */
    private $email;

    /**
     * @Assert\NotBlank(message = "Entrez votre numéro de téléphone")
     */
    private $phone;

    /**
     * @Assert\NotBlank(message = "Entrez votre adresse de résidence")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "L'adresse doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "L'adresse ne doit pas dépasser {{ limit }} caractères"
     * )
     *
     */
    private $deliveryAddress;

    private $createAccount;

    private $password;

    /**
     * @Assert\IdenticalTo(
     *      propertyPath="password",
     *      message="Le mot de passe ne correspond pas"
     * )
     */
    private $passwordConfirm;

    /**
     * @Assert\NotNull(message = "Sélectionner un mode de paiement")
     * @Assert\Choice(choices=PlaceOrder::PAYEMENT_MODE, message="sélectionner un mode de paiement valide")
     */
    private $paymentMode;

    public function getLName(): ?string
    {
        return $this->lName;
    }

    public function setLName(string $lName): self
    {
        $this->lName = $lName;

        return $this;
    }

    public function getFName(): ?string
    {
        return $this->fName;
    }

    public function setFName(string $fName): self
    {
        $this->fName = $fName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(string $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getCreateAccount(): ?bool
    {
        return $this->createAccount;
    }

    public function setCreateAccount(bool $createAccount): self
    {
        $this->createAccount = $createAccount;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm(string $passwordConfirm): self
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }

    public function getPaymentMode(): ?string
    {
        return $this->paymentMode;
    }

    public function setPaymentMode(string $paymentMode): self
    {
        $this->paymentMode = $paymentMode;

        return $this;
    }
}
