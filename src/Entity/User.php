<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email est déjà utiliser")
 */
class User implements UserInterface
{
    /**
     * @Assert\Length(min=4, max=12, minMessage="Plus de 4 caractères", maxMessage="Moins de 12 caractères")
     * @Assert\EqualTo(propertyPath="password", message="Vos mots de passe ne correspondent pas") // configurer le hashage des mdp dans confi->packages->security.yaml
     */
    private $confirmPassword;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=4, max=12, minMessage="Plus de 4 caractères", maxMessage="Moins de 12 caractères")
     */
    private $password;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function eraseCredentials() // Paramètre liés a "implements UserInterface"
    {
    }

    public function getSalt() // Paramètre liés a "implements UserInterface"
    {
    }

    public function getRoles() // Paramètre liés a "implements UserInterface"
    {
        return ['ROLE_USER'];
    }
}
