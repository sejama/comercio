<?php

namespace App\DataFixtures;

use App\Entity\Pais;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;

class PaisFixtures extends Fixture implements FixtureGroupInterface
{
    public const ARGENTINA = 'argentina';
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $pais = $this->getPais($data);

            $this->addReference($data['referencia'], $pais);

            $manager->persist($pais);

            // Forzar para especificar un ID
            $metadata = $manager->getClassMetaData($pais::class);
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $manager->flush();
    }

    /**
     * @return array<string>
     */
    public static function getGroups(): array
    {
        return ['test', 'desarrollo', 'produccion'];
    }

    /**
     * @param array<mixed> $data
     */
    private function getPais(array $data): Pais
    {
        return
            (new Pais())
                ->setId($data['id'])
                ->setNombre($data['nombre']);
    }

    /**
     * @return array<mixed>
     */
    private function getData(): array
    {
        return
            [
                [
                    'id' => 1,
                    'nombre' => 'Argentina',
                    'referencia' => self::ARGENTINA
                ],
            ];
    }

}
