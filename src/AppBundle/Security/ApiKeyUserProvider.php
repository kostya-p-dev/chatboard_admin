<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 5/14/15
 * Time: 10:51 AM
 */

namespace AppBundle\Security;

use ErmineApp\UserBundle\Entity\SessionRepository;
use ErmineApp\UserBundle\Entity\UserRepository;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class ApiKeyUserProvider implements UserProviderInterface
{
    protected $userRepo;
    protected $sessionRepo;

    public function __construct(UserRepository $userRepo, SessionRepository $sessionRepo )
    {
        $this->userRepo = $userRepo;
        $this->sessionRepo = $sessionRepo;
    }


    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different

        if(!$session = $this->sessionRepo->findOneByRestToken($apiKey)){
            $username = null;
        } else{
            $username = $session->getUser();
        }
        return $username;
    }

    public function loadUserByUsername($username)
    {
        return $username;
//        return new User(
//            $username,
//            null,
//            // the roles for the user - you may choose to determine
//            // these dynamically somehow based on the user
//            array('ROLE_USER')
//        );
    }

    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\User\User' === $class;
    }
}