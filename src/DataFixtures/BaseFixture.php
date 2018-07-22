<?php
/**
 * Created by PhpStorm.
 * User: romariololz
 * Date: 21/07/18
 * Time: 12:55
 */

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var Generator
     */
    protected $faker;

    protected $referencesIndex = [];

    abstract protected function loadData(ObjectManager $em);

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        $this->loadData($manager);
    }

    public function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++)
        {
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);
            // store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className . '_' . $i, $entity);
        }
    }

    /**
     * @param string $className
     * @return object
     * @throws \Exception
     */
    protected function getRandomReference(string $className)
    {
        if (!isset($this->referencesIndex[$className]))
        {
            $this->referencesIndex[$className] = [];
            foreach ($this->referenceRepository->getReferences() as $key => $ref)
            {
                if (strpos($key, $className.'_') === 0)
                {
                    $this->referencesIndex[$className][] = $key;
                }
            }
        }
        if (empty($this->referencesIndex[$className]))
        {
            throw new \Exception(sprintf('Cannot find any references for class "%s"', $className));
        }

        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);
        return $this->getReference($randomReferenceKey);
    }

    /**
     * @param string $className
     * @param int $count
     * @return array
     * @throws \Exception
     */
    protected function getRandomReferences(string $className, int $count)
    {
        $references = [];
        while (count($references) < $count) {
            $references[] = $this->getRandomReference($className);
        }
        return $references;
    }
}
