<?php
//// src/Entity/Member.php
//namespace App\Entity;
//
//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Security\Core\User\UserInterface;
//
///**
// * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
// * @ORM\Table(name="member")
// */
//class Member implements UserInterface, \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
//{
//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string", length=50)
//     */
//    private $name;
//
//    /**
//     * @ORM\Column(type="string", length=50)
//     */
//    private $surname;
//
//    /**
//     * @ORM\Column(type="string", length=100, unique=true)
//     */
//    private $email;
//
//    /**
//     * @ORM\Column(type="string", length=255)
//     */
//    private $password;
//
//    /**
//     * @ORM\Column(type="json")
//     */
//    private $roles = [];
//
//    public function __construct()
//    {
//        $this->roles = ['ROLE_USER'];
//    }
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getName(): ?string
//    {
//        return $this->name;
//    }
//
//    public function setName(string $name): self
//    {
//        $this->name = $name;
//        return $this;
//    }
//
//    public function getSurname(): ?string
//    {
//        return $this->surname;
//    }
//
//    public function setSurname(string $surname): self
//    {
//        $this->surname = $surname;
//        return $this;
//    }
//
//    public function getEmail(): ?string
//    {
//        return $this->email;
//    }
//
//    public function setEmail(string $email): self
//    {
//        $this->email = $email;
//        return $this;
//    }
//
//    public function getPassword(): ?string
//    {
//        return $this->password;
//    }
//
//    public function setPassword(string $password): self
//    {
//        $this->password = $password;
//        return $this;
//    }
//
//    public function getRoles(): array
//    {
//        $roles = $this->roles;
//        // guarantee every user at least has ROLE_USER
//        $roles[] = 'ROLE_USER';
//        return array_unique($roles);
//    }
//
//    public function setRoles(array $roles): self
//    {
//        $this->roles = $roles;
//        return $this;
//    }
//
//    public function getSalt(): ?string
//    {
//        // Not needed for bcrypt or argon2i
//        return null;
//    }
//
//    public function getUsername(): string
//    {
//        return $this->email;
//    }
//
//    public function eraseCredentials(): void
//    {
//        // If you store any temporary, sensitive data on the user, clear it here
//        // $this->plainPassword = null;
//    }
//
//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\AdminComment", mappedBy="member")
//     */
//    private $comments;
//
//    /**
//     * @return Collection|AdminComment[]
//     */
//    public function getComments(): Collection
//    {
//        return $this->comments;
//    }
//
//    public function addComment(AdminComment $comment): self
//    {
//        if (!$this->comments->contains($comment)) {
//            $this->comments[] = $comment;
//            $comment->setMember($this);
//        }
//
//        return $this;
//    }
//
//    public function removeComment(AdminComment $comment): self
//    {
//        if ($this->comments->removeElement($comment)) {
//            // set the owning side to null (unless already changed)
//            if ($comment->getMember() === $this) {
//                $comment->setMember(null);
//            }
//        }
//
//        return $this;
//    }
//
//
//}
//
//
//

// src/Entity/Member.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 * @ORM\Table(name="member")
 */
class Member implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdminComment", mappedBy="member")
     */
    private $comments;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

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

    public function getSalt(): ?string
    {
        // Not needed for bcrypt or argon2i
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|AdminComment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(AdminComment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setMember($this);
        }

        return $this;
    }

    public function removeComment(AdminComment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMember() === $this) {
                $comment->setMember(null);
            }
        }

        return $this;
    }

    /**
     * Member nesnesini stringe dönüştürmek için kullanılır.
     *
     * @return string
     */
    public function __toString(): string
    {
        // Örneğin, kullanıcı adını döndürebilirsiniz:
        return $this->name; // veya $this->email, $this->surname vb.
    }
}
