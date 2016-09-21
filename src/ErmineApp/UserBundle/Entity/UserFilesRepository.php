<?php

namespace ErmineApp\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserFilesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserFilesRepository extends EntityRepository
{
    public function save(UserFiles $userfiles)
    {
        $this->getEntityManager()->persist($userfiles);
        $this->getEntityManager()->flush();
    }

    /**
     * @param UserFiles $entity
     */
    public function remove(UserFiles $entity){
        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();
    }
}