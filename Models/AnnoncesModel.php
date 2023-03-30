<?php

namespace App\Models;

class AnnoncesModel extends Model
{
    //definition des propriétés protected $id, $titre, $descritption, $created_at et $actif
    protected $id;
    protected $titre;
    protected $description;
    protected $created_at;
    protected $actif;

    public function __construct()
    {


        //correspond à la table "annonces" dans la base de donées de nouvelle techno
        $this->table = 'annonces';
    }

    /**
     * Obtenir la valeur de id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Définir la valeur de id
     *
     * @return  self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Obtenir la valeur de titre
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * Définir la valeur de titre
     *
     * @return  self
     */
    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Obtenir la valeur de description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Définir la valeur de description
     *
     * @return  self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Obtenir la valeur de created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Définir la valeur de created_at
     *
     * @return  self
     */
    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Obtenir la valeur de actif
     */
    public function getActif(): int
    {
        return $this->actif;
    }

    /**
     * Définir la valeur de actif
     *
     * @return  self
     */
    public function setActif(int $actif): self
    {
        $this->actif = $actif;

        return $this;
    }
}
