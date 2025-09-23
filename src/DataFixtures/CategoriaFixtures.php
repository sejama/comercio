<?php

namespace App\DataFixtures;

use App\Entity\CategoriaProducto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoria = new CategoriaProducto();
        $categoria->setNombre('Agregar Categoría');
        $manager->persist($categoria);

        $manager->flush();
    }
}
