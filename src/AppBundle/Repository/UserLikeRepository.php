<?php

namespace AppBundle\Repository;

use AppBundle\Entity\UserLike;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * UserLikeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserLikeRepository extends \Doctrine\ORM\EntityRepository
{

    public function queryLatestLikes($user)
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT c
                FROM AppBundle:UserLike ul
                LEFT JOIN  AppBundle:Catalogue c
				WHERE ul.catelogue = c.id
				WHERE ul.user = :user
                ORDER BY c.createdAt DESC
            ')
            ->setParameter('user', $user)
        ;
    }
    
	public function findLatest($page = 1, $user)
    {
		$paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatestLikes($user), false));
        $paginator->setMaxPerPage(10);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

}
