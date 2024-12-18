<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $numero = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    private Client $client;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $dateEnvoie;

    #[ORM\Column(type: 'string', length: 255)]
    private string $statut;

    #[ORM\Column(type: 'integer')]
    private int $montant;

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getDateEnvoie(): \DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): self
    {
        $this->dateEnvoie = $dateEnvoie;
        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getMontant(): int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;
        return $this;
    }
}
