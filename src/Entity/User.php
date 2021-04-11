<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="cet email est déjà utilisé")
 */
class User implements UserInterface, CustomerInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message = "Entrez votre adresse email")
     *  @Assert\Email(
     *     message = "Entrez un email valide"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Entrez un mot de passe")
     * @Assert\Length(
     *      min = 8,
     *      max = 255,
     *      minMessage = "Le mot de passe doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le mot de passe ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message = "Entrez votre nom")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le nom doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le nom ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $lName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message = "Entrez votre prénom")
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le prénom doit contenir au moins {{ limit }} caractères",
     *      maxMessage = "Le prénom ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $fName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\NotBlank(message = "Confirmer votre mot de passe")
     * @Assert\IdenticalTo(
     *      propertyPath="password",
     *      message="Le mot de passe ne correspond pas"
     * )
     */
    public $passwordConfirmation;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message = "Entrez votre numéro de téléphone")
     */
    private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="registeredCustomer")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * Permet d'initialiser la date d'inscription
     *
     * @ORM\PrePersist
     * 
     * @return void
     */
    public function initializeCreatedAt()
    {
        if(empty($this->getCreatedAt()))
        {
            $this->setCreatedAt(new DateTime());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setRegisteredCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getRegisteredCustomer() === $this) {
                $order->setRegisteredCustomer(null);
            }
        }

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fName.' '.$this->lName;
    }
}
