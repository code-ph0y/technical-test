<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgencyRepository")
 */
class Agency
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $agency_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $contact_email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    private $web_address;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\Length(
      *      max = 255,
      *      maxMessage = "Your short description cannot be longer than {{ limit }} characters"
      * )
     */
    private $short_description;

    /**
     * @ORM\Column(type="string", length=4)
     * @Assert\Length(
     *      min = 4,
     *      max = 4,
     *      exactMessage = "This value should have exactly {{ limit }} characters"
     * )
     */
    private $established;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Service", inversedBy="agencies")
     */
    private $services;


    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgencyName(): ?string
    {
        return $this->agency_name;
    }

    public function setAgencyName(string $agency_name): self
    {
        $this->agency_name = $agency_name;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contact_email;
    }

    public function setContactEmail(string $contact_email): self
    {
        $this->contact_email = $contact_email;

        return $this;
    }

    public function getWebAddress(): ?string
    {
        return $this->web_address;
    }

    public function setWebAddress(string $web_address): self
    {
        $this->web_address = $web_address;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getEstablished(): ?string
    {
        return $this->established;
    }

    public function setEstablished(string $established): self
    {
        $this->established = $established;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->contains($service)) {
            $this->services->removeElement($service);
        }

        return $this;
    }

}
