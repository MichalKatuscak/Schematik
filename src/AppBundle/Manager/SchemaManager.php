<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Image;
use Doctrine\ORM\EntityManager;

final class SchemaManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    private $imageRepository;

    /**
     * PlayerManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->imageRepository = $entityManager->getRepository(Image::class);
    }

    public function find($id)
    {
        return $this->imageRepository->find($id);
    }

    public function generateSchema($level)
    {
        $svg = (new \AppBundle\Util\Schema($level))->getSchema();

        $schema = new Image();
        $schema->setData($svg["data"]);
        $schema->setResult($svg["result"]);
        $schema->setUsedChars($svg["used_chars"]);
        $schema->setLevel($level);

        $this->entityManager->persist($schema);
        $this->entityManager->flush();

        return $schema;
    }
}