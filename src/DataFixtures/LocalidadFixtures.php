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
    public const L_BUENOS_AIRES = 'l-buenos-aires';
    public const L_CABA = 'l-caba';
    public const L_CATAMARCA = 'l-catamarca';
    public const L_CHACO = 'l-chaco';
    public const L_CHUBUT = 'l-chubut';
    public const L_CORDOBA = 'l-cordoba';
    public const L_CORRIENTES = 'l-corrientes';
    public const L_ENTRE_RIOS = 'l-entre-rios';
    public const L_FORMOSA = 'l-formosa';
    public const L_JUJUY = 'l-jujuy';
    public const L_LA_PAMPA = 'l-la-pampa';
    public const L_LA_RIOJA = 'l-la-rioja';
    public const L_MENDOZA = 'l-mendoza';
    public const L_MISIONES = 'l-misiones';
    public const L_NEUQUEN = 'l-neuquen';
    public const L_RIO_NEGRO = 'l-rio-negro';
    public const L_SALTA = 'l-salta';
    public const L_SAN_JUAN = 'l-san-juan';
    public const L_SAN_LUIS = 'l-san-luis';
    public const L_SANTA_CRUZ = 'l-santa-cruz';
    public const L_SANTA_FE = 'l-santa-fe';
    public const L_SANTIAGO_DEL_ESTERO = 'l-santiago-del-estero';
    public const L_TIERRA_DEL_FUEGO = 'l-tierra-del-fuego';
    public const L_TUCUMAN = 'l-tucuman';

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

        $localidadesData = [];
        $dir = './Localidades/';

        $provincias = [
            [
                ProvinciaFixtures::BUENOS_AIRES,
                self::L_BUENOS_AIRES
            ],
            [
                ProvinciaFixtures::CABA,
                self::L_CABA
            ],
            [
                ProvinciaFixtures::CATAMARCA,
                self::L_CATAMARCA
            ],
            [
                ProvinciaFixtures::CHACO,
                self::L_CHACO
            ],
            [
                ProvinciaFixtures::CHUBUT,
                self::L_CHUBUT
            ], 
            [
                ProvinciaFixtures::CORDOBA,
                self::L_CORDOBA
            ],
            [
                ProvinciaFixtures::CORRIENTES,
                self::L_CORRIENTES
            ],
            [
                ProvinciaFixtures::ENTRE_RIOS,
                self::L_ENTRE_RIOS
            ],
            [
                ProvinciaFixtures::FORMOSA,
                self::L_FORMOSA
            ],
            [
                ProvinciaFixtures::JUJUY,
                self::L_JUJUY
            ],
            [
                ProvinciaFixtures::LA_PAMPA,
                self::L_LA_PAMPA
            ],
            [
                ProvinciaFixtures::LA_RIOJA,
                self::L_LA_RIOJA
            ],
            [
                ProvinciaFixtures::MENDOZA,
                self::L_MENDOZA
            ],
            [
                ProvinciaFixtures::MISIONES,
                self::L_MISIONES
            ],
            [
                ProvinciaFixtures::NEUQUEN,
                self::L_NEUQUEN
            ],
            [
                ProvinciaFixtures::RIO_NEGRO,
                self::L_RIO_NEGRO
            ],
            [
                ProvinciaFixtures::SALTA,
                self::L_SALTA
            ],
            [
                ProvinciaFixtures::SAN_JUAN,
                self::L_SAN_JUAN
            ],
            [
                ProvinciaFixtures::SAN_LUIS,
                self::L_SAN_LUIS
            ],
            [
                ProvinciaFixtures::SANTA_CRUZ,
                self::L_SANTA_CRUZ
            ],
            [
                ProvinciaFixtures::SANTA_FE,
                self::L_SANTA_FE
            ],
            [
                ProvinciaFixtures::SANTIAGO_DEL_ESTERO,
                self::L_SANTIAGO_DEL_ESTERO
            ],
            [
                ProvinciaFixtures::TIERRA_DEL_FUEGO,
                self::L_TIERRA_DEL_FUEGO
            ],
            [
                ProvinciaFixtures::TUCUMAN,
                self::L_TUCUMAN
            ]
        ];

        foreach ($provincias as $provincia) {
            $file = $dir . $provincia[0] . '.txt';

            if (file_exists($file)) {
                $localidades = file($file);
                foreach ($localidades as $localidad) {
                    $localidadesData[] = [
                        'nombre' => $localidad[0],
                        'codigoPostal' => "0000",
                        'referencia' => $provincia[1],
                        'provincia' => $provincia[0],
                    ];
                }
            }
        }

        return $localidadesData;
    }
}
