<?php

namespace App\Models;

use App\Db\Db;

class Model extends Db
{
    //table de la base de donnée
    protected $table;

    // Instance de Db
    private $db;


    //creation methode create
    public function create(Model $model)
    {
        $champs = [];
        $inter = [];
        $valeurs = [];

        //On boucle pour eclater le tableau
        foreach ($model as $champ => $valeur) {
            //INSERT INTO annonces (titre, description, actif) VALUES (?, ?, ?)
            if ($valeur != null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        //On transforme le tableau "champs" en une chaine de caractère
        $list_champs = implode(', ', $champs);
        $list_inter = implode(', ', $inter);

        //On execute la requete (forme de la requete : requete(string $sql, array $attributs))
        return $this->requete('INSERT INTO ' . $this->table . '(' . $list_champs . ') VALUES (' . $list_inter . ')', $valeurs);
    }

    //creation methode update
    public function update(int $id, Model $model)
    {
        $champs = [];
        $valeurs = [];

        //On boucle pour eclater le tableau
        foreach ($model as $champ => $valeur) {
            //UPDATE annonces SET titre =? , description =? , actif =? WHERE id =?
            //$valeur !== null car actif est de base à 0 qui est associé à nul en cas de simple "="
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ =?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $id;

        //On transforme le tableau "champs" en une chaine de caractère
        $list_champs = implode(', ', $champs);

        //On execute la requete (forme de la requete : requete(string $sql, array $attributs))
        return $this->requete('UPDATE ' . $this->table . 'SET' . $list_champs . 'WHERE id=?', $valeurs);
    }

    //creation methode delete
    public function delete(int $id)
    {
        return $this->requete('DELETE FROM' . $this->table . 'WHERE id=?', [$id]);
    }

    //creation methode findAll
    public function findAll()
    {
        $requete = $this->requete('SELECT * FROM ' . $this->table);
        //utilisation de fetchAll pour couvrir tous les résultats
        return $requete->fetchAll();
    }

    //creation methode find
    //permet de faire des recherches dans la base de données avec une instruction du type :
    //$annonces = $model->find(2) correspondant à l'id "2" de la table annonces;
    //pas d'obligation de protection car $id typé en int donc, pas d'injection possible;
    public function find(int $id)
    {
        //return d'une simple requete sql
        return $this->requete('SELECT * FROM ' . $this->table . 'WHERE id =' . $id)->fetch();
    }

    //creation methode findBy
    //permet de faire des recherches dans la base de données avec une instruction du type :
    //$annonces = $model->findBy(['actif' => 1, 'signale' => 0]);
    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs = [];

        //On boucle pour eclater le tableau
        foreach ($criteres as $champ => $valeur) {
            //SELECT * FROM annonces WHERE actif = ? AND signale = 0
            //bindValue(1, valeur)
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        //On transforme le tableau "champs" en une chaine de caractère
        $list_champs = implode(' AND ', $champs);

        //On execute la requete
        return $this->requete("SELECT * FROM " . $this->table . " WHERE " . $list_champs, $valeurs)->fetchAll();
    }

    //fonction de preparation des requètes dans le cas ou elles utilisent des paralètres extérieurs et potentiellement dangereux.
    public function requete(string $sql, array $attributs = null)
    {
        //On recupere l'instance de Db
        $this->db = Db::getInstance();

        if ($attributs !== null) {
            //requete preparée. La préparation de la requete avec "bindValues" ou les "bindParams" est faite automatiquement par 'prepare()'.
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            //requete "simple" sans besoin de préparation.
            $query = $this->db->query($sql);
        }
    }

    //creation methode hydrate
    //permet d'hydrater les propriétés d'un objet avec des données issues d'un tableau ou d'un formulaire etc par le biais des setters.
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            //On récupère le nom du setter correspondant à la clé $key
            //titre -> setTitre avec un "T" maj, d'ou le ucfirst (uppercase First letter)
            $setter = 'set' . ucfirst($key);

            //On vérifie si le setter existe
            if (method_exists($this, $setter)) {
                //On appelle le setter
                $this->$setter($value);
            }
        }
        return $this;
    }
}
