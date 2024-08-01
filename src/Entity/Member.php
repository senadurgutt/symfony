<?php
//
//namespace App\Entity;
//
//use Doctrine\ORM\Mapping as ORM;
//
///**
// * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
// * @ORM\Table(name="member")
// */
//class Member
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
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    public function setId($id): void
//    {
//        $this->id = $id;
//    }
//
//    public function getName()
//    {
//        return $this->name;
//    }
//
//    public function setName($name): void
//    {
//        $this->name = $name;
//    }
//
//    public function getSurname()
//    {
//        return $this->surname;
//    }
//
//    public function setSurname($surname): void
//    {
//        $this->surname = $surname;
//    }
//
//    public function getEmail()
//    {
//        return $this->email;
//    }
//
//    public function setEmail($email): void
//    {
//        $this->email = $email;
//    }
//
//    public function getPassword()
//    {
//        return $this->password;
//    }
//
//    public function setPassword($password): void
//    {
//        $this->password = $password;
//    }
//}

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 * @ORM\Table(name="member")
 */
class Member implements UserInterface
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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    // Implementing UserInterface methods

    public function getRoles()
    {
        // You can return the roles that are assigned to the member.
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        // Not needed for bcrypt and argon2i algorithms.
        return null;
    }

    public function getUsername()
    {
        return $this->email; // or any other field you use as username.
    }

    public function eraseCredentials()
    {
        // Implement this method if you need to erase sensitive data.
    }
}
