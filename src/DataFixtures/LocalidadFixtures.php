<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Localidad;
use App\Entity\Provincia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;

class LocalidadFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public const L_SANTA_FE = 'lsanta-fe';
    public const L_ENTRE_RIOS = 'lentre-rios';

    public function load(ObjectManager $manager): void
    {

        foreach ($this->getData() as $data) {
            $localidad = $this->getLocalidad($data);

            $manager->persist($localidad);

            // Forzar para especificar un ID
            $metadata = $manager->getClassMetaData($localidad::class);
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        }

        $manager->flush();
    }

    /**
     * @return array<mixed>
     */
    public function getDependencies(): array
    {
        return [
            ProvinciaFixtures::class,
        ];
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
    private function getLocalidad(array $data): Localidad
    {
        $localidad = new Localidad();
        $localidad->setId($data['id']);
        $localidad->setNombre($data['nombre']);
        $localidad->setCodigoPostal($data['codigoPostal']);

        $this->addReference($data['referencia'], $localidad);

        $localidad->setProvincia($this->getReference($data['provincia'], Provincia::class));

        return $localidad;
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
                    'nombre' => "Santa Fe",
                    'codigoPostal' => "3000",
                    'referencia' => self::L_SANTA_FE,
                    'provincia' => ProvinciaFixtures::SANTA_FE,
                ],
                [
                    'id' => 2,
                    'nombre' => "Paraná",
                    'codigoPostal' => "3100",
                    'referencia' => self::L_ENTRE_RIOS,
                    'provincia' => ProvinciaFixtures::ENTRE_RIOS,
                ],
            ];
    }
}
