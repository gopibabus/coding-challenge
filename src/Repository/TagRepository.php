<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * @return array
     */
    public function getTagNames(): array
    {
        $tags = $this->createQueryBuilder('tag')
            ->select('tag.name')
            ->getQuery()
            ->getResult();

        $tagNames = [];
        foreach ($tags as $tag) {
            if(!in_array(trim($tag['name']), $tagNames)) {
                $tagNames[] = trim($tag['name']);
            }
        }

        return $tagNames;
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    public function deleteTagsByName(string $name)
    {
        return $this->createQueryBuilder('tag')
            ->delete()
            ->andWhere('tag.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
}
