<?php

namespace App\Entity;

use App\Repository\AuctioneerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuctioneerRepository::class)
 */
class Auctioneer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="auction")
     */
    private $product;

    /**
     * @ORM\OneToMany(targetEntity=Bids::class, mappedBy="auctioneer")
     */
    private $auction;

    public function __construct()
    {
        $this->auction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection|Bids[]
     */
    public function getAuction(): Collection
    {
        return $this->auction;
    }

    public function addAuction(Bids $auction): self
    {
        if (!$this->auction->contains($auction)) {
            $this->auction[] = $auction;
            $auction->setAuctioneer($this);
        }

        return $this;
    }

    public function removeAuction(Bids $auction): self
    {
        if ($this->auction->removeElement($auction)) {
            // set the owning side to null (unless already changed)
            if ($auction->getAuctioneer() === $this) {
                $auction->setAuctioneer(null);
            }
        }

        return $this;
    }
}
