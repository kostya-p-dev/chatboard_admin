<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 5/14/15
 * Time: 5:01 PM
 */

namespace ErmineApp\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use ErmineApp\UserBundle\Entity\SessionStatus;
use ErmineApp\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        /*create Admin User*/
        $testData[] = (new User())
            /*id*/
                
            /*settingsId*/
            
            /*username*/
            ->setUsername('admin')
            /*password*/
            ->setPassword('$2y$13$I1jE5hg9FbOgs9582DMwIOkNgtht4DmJS1dzQFk3oyHGkyqJKj4a2')
            /*fbid*/

            /*email*/
            ->setEmail('admin@gmail.ru')
            /*role*/
            ->setRole('ROLE_SUPER_ADMIN')
            /*name*/
            ->setName('admin')
            /*age*/

            /*img*/

            /*primary_interests_img*/

            /*interests_str*/

            /*about*/

            /*created*/
            ->setCreated(new \DateTime('now'))
            /*access*/

            /*login*/

            /*status*/

            /*gender*/

            /*lan_status*/

            /*isRegister*/

            /*timezone*/

            /*isOnline*/

            /*phone*/

            /*verification*/

        ;

        /* create test User */
        $testData[] = (new User())
            /*id*/

            /*settingsId*/

            /*username*/
            ->setUsername('user')
            /*password*/
            ->setPassword('$2y$13$I1jE5hg9FbOgs9582DMwIOkNgtht4DmJS1dzQFk3oyHGkyqJKj4a2')
            /*fbid*/

            /*email*/
            ->setEmail('user@gmail.ru')
            /*role*/
            ->setRole('ROLE_USER')
            /*name*/
            ->setName('user')
            /*age*/

            /*img*/

            /*primary_interests_img*/

            /*interests_str*/

            /*about*/

            /*created*/
            ->setCreated(new \DateTime('now'))
            /*access*/

            /*login*/

            /*status*/

            /*gender*/

            /*lan_status*/

            /*isRegister*/

            /*timezone*/

            /*isOnline*/

            /*phone*/

            /*verification*/

        ;

        foreach ($testData as $entry) {
            $manager->persist($entry);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

} 