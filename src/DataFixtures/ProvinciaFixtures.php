<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Provincia;
use App\Entity\Pais;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;

class ProvinciaFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public const SANTA_FE = 'santa-fe';
    public const NEUQUEN = 'neuquen';
    public const SAN_LUIS = 'san-luis';
    public const CABA = 'c-a-buenos-aires';
    public const LA_RIOJA = 'la-rioja';
    public const CATAMARCA = 'catamarca';
    public const TUCUMAN = 'tucuman';
    public const CHACO = 'chaco';
    public const FORMOSA = 'formosa';
    public const SANTA_CRUZ = 'santa-cruz';
    public const CHUBUT = 'chubut';
    public const MENDOZA = 'mendoza';
    public const ENTRE_RIOS = 'entre-rios';
    public const SAN_JUAN = 'san-juan';
    public const JUJUY = 'jujuy';
    public const SANTIAGO_DEL_ESTERO = 'santiago-del-estero';
    public const RIO_NEGRO = 'rio-negro';
    public const CORRIENTES = 'corrientes';
    public const MISIONES = 'misiones';
    public const SALTA = 'salta';
    public const CORDOBA = 'cordoba';
    public const BUENOS_AIRES = 'buenos-aires';
    public const LA_PAMPA = 'la-pampa';
    public const TIERRA_DEL_FUEGO = 'tierra-del-fuego';

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $provincia = $this->getProvincia($data);

            $manager->persist($provincia);

            // Forzar para especificar un ID
            $metadata = $manager->getClassMetaData($provincia::class);
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
    private function getProvincia(array $data): Provincia
    {
        $provincia = new Provincia();
        $provincia->setId($data['id']);
        $provincia->setNombre($data['nombre']);

        $provincia->setPais($this->getReference(PaisFixtures::ARGENTINA, Pais::class));

        $this->addReference($data['referencia'], $provincia);

        return $provincia;
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
                    'referencia' => self::SANTA_FE,
                ],
                [
                    'id' => 2,
                    'nombre' => "Neuquén",
                    'referencia' => self::NEUQUEN,
                ],
                [
                    'id' => 3,
                    'nombre' => "San Luis",
                    'referencia' => self::SAN_LUIS,
                ],
                [
                    'id' => 4,
                    'nombre' => "Ciudad Autónoma de Buenos Aires",
                    'referencia' => self::CABA,
                ],
                [
                    'id' => 5,
                    'nombre' => "La Rioja",
                    'referencia' => self::LA_RIOJA,
                ],
                [
                    'id' => 6,
                    'nombre' => "Catamarca",
                    'referencia' => self::CATAMARCA,
                ],
                [
                    'id' => 7,
                    'nombre' => "Tucumán",
                    'referencia' => self::TUCUMAN,
                ],
                [
                    'id' => 8,
                    'nombre' => "Chaco",
                    'referencia' => self::CHACO,
                ],
                [
                    'id' => 9,
                    'nombre' => "Formosa",
                    'referencia' => self::FORMOSA,
                ],
                [
                    'id' => 10,
                    'nombre' => "Santa Cruz",
                    'referencia' => self::SANTA_CRUZ,
                ],
                [
                    'id' => 11,
                    'nombre' => "Chubut",
                    'referencia' => self::CHUBUT,
                ],
                [
                    'id' => 12,
                    'nombre' => "Mendoza",
                    'referencia' => self::MENDOZA,
                ],
                [
                    'id' => 13,
                    'nombre' => "Entre Ríos",
                    'referencia' => self::ENTRE_RIOS,
                ],
                [
                    'id' => 14,
                    'nombre' => "San Juan",
                    'referencia' => self::SAN_JUAN,
                ],
                [
                    'id' => 15,
                    'nombre' => "Jujuy",
                    'referencia' => self::JUJUY,
                ],
                [
                    'id' => 16,
                    'nombre' => "Santiago del Estero",
                    'referencia' => self::SANTIAGO_DEL_ESTERO,
                ],
                [
                    'id' => 17,
                    'nombre' => "Río Negro",
                    'referencia' => self::RIO_NEGRO,
                ],
                [
                    'id' => 18,
                    'nombre' => "Corrientes",
                    'referencia' => self::CORRIENTES,
                ],
                [
                    'id' => 19,
                    'nombre' => "Misiones",
                    'referencia' => self::MISIONES,
                ],
                [
                    'id' => 20,
                    'nombre' => "Salta",
                    'referencia' => self::SALTA,
                ],
                [
                    'id' => 21,
                    'nombre' => "Córdoba",
                    'referencia' => self::CORDOBA,
                ],
                [
                    'id' => 22,
                    'nombre' => "Buenos Aires",
                    'referencia' => self::BUENOS_AIRES,
                ],
                [
                    'id' => 23,
                    'nombre' => "La Pampa",
                    'referencia' => self::LA_PAMPA,
                ],
                [
                    'id' => 24,
                    'nombre' => "Tierra del Fuego",
                    'referencia' => self::TIERRA_DEL_FUEGO,
                ],
            ];
    }

    /**
     * @return array<class-string>
     */
    public function getDependencies(): array
    {
        return [
            PaisFixtures::class,
        ];
    }
}

