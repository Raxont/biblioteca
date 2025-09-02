<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibroRepository::class)]
class Libro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $titulo = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $isbn = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaPublicacion = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $genero = null;

    #[ORM\Column]
    private ?bool $disponible = null;

    #[ORM\ManyToOne(inversedBy: 'libros')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Autor $autor = null;

    // ✅ CORRECCIÓN: Agregar inversedBy="libro"
    #[ORM\OneToMany(mappedBy: 'libro', targetEntity: Prestamo::class, orphanRemoval: true)]
    private Collection $prestamos;

    public function __construct()
    {
        $this->prestamos = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->titulo ?? '';
    }

    public function getEstadoTexto(): string
    {
        return $this->disponible ? 'Disponible' : 'No Disponible';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(?string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTime
    {
        return $this->fechaPublicacion;
    }

    public function setFechaPublicacion(?\DateTime $fechaPublicacion): static
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(?string $genero): static
    {
        $this->genero = $genero;

        return $this;
    }

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getAutor(): ?Autor
    {
        return $this->autor;
    }

    public function setAutor(?Autor $autor): static
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * @return Collection<int, Prestamo>
     */
    public function getPrestamos(): Collection
    {
        return $this->prestamos;
    }

    public function addPrestamo(Prestamo $prestamo): static
    {
        if (!$this->prestamos->contains($prestamo)) {
            $this->prestamos->add($prestamo);
            $prestamo->setLibro($this);
        }

        return $this;
    }

    public function removePrestamo(Prestamo $prestamo): static
    {
        if ($this->prestamos->removeElement($prestamo)) {
            // set the owning side to null (unless already changed)
            if ($prestamo->getLibro() === $this) {
                $prestamo->setLibro(null);
            }
        }

        return $this;
    }
}