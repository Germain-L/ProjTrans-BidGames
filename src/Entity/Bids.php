<?php

namespace App\Entity;

use App\Repository\BidsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BidsRepository::class)
 */
class Bids
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     */
    private $dateTime;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="bids")
     */
    private $auction;

    /**
     * @ORM\ManyToOne(targetEntity=Auctioneer::class, inversedBy="auction")
     */
    private $auctioneer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getAuction(): ?Product
    {
        return $this->auction;
    }

    public function setAuction(?Product $auction): self
    {
        $this->auction = $auction;

        return $this;
    }

    public function getAuctioneer(): ?Auctioneer
    {
        return $this->auctioneer;
    }

    public function setAuctioneer(?Auctioneer $auctioneer): self
    {
        $this->auctioneer = $auctioneer;

        return $this;
    }
}
