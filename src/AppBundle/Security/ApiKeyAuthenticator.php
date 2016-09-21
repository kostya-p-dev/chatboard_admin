<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 5/13/15
 * Time: 6:47 PM
 */

namespace AppBundle\Security;

use ErmineApp\UserBundle\Entity\SessionRepository;
use ErmineApp\UserBundle\Service\RequestManager;
use Symfony\Component\Security\Core\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface
{
    protected $userProvider;
    protected $sessionRepo;
    /**
     * @var RequestManager
     */
    protected $requestManager;

    public function __construct(ApiKeyUserProvider $userProvider, SessionRepository $sessionRepo, RequestManager $requestManager )
    {
        $this->userProvider = $userProvider;
        $this->sessionRepo = $sessionRepo;
        $this->requestManager = $requestManager;
    }

    public function createToken(Request $request, $providerKey)
    {

        $this->requestManager->logRequest($request);
        if($request->getMethod() == 'OPTIONS'){
            throw new BadRequestHttpException('Options');
        }
        // Get api key from headers.
        $apiKey = $request->headers->get('restToken');
        if (!$apiKey || $apiKey == '') {
            $apiKey = $request->query->get('restToken');
        }
        if (!$apiKey || $apiKey == '') {
            $apiKey = $request->request->get('restToken');
        }

        if (!$apiKey || $apiKey == '') {
//            throw new BadCredentialsException('No API key found');
            echo json_encode(["errorCode" => "103", "success" => "0"]);die;

        }
        $sessionRepo = $this->sessionRepo;
        if(!$session = $sessionRepo->findOneByRestToken($apiKey))
        {
//            echo(['errorCode' => '103'];'RestToken not found');die;
            echo json_encode(["errorCode" => "103", "success" => "0"]);die;

        }
        return new PreAuthenticatedToken(
            'anon.',
            $apiKey,
            $providerKey
        );
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        $apiKey = $token->getCredentials();
        $username = $this->userProvider->getUsernameForApiKey($apiKey);

//        if (!$username) {
//            $token = md5(uniqid(mt_rand(), true));
//            echo $token;
//            echo $providerKey;
//            var_dump("API Key ". $apiKey ." does not exist.");die;
//            throw new AuthenticationException(
//                sprintf('API Key "%s" does not exist.', $apiKey)
//            );
//        }
//die($username->getId());
        $user = $this->userProvider->loadUserByUsername($username);
        if(!$user){
            /* 103 = BadRestToken*/
            echo json_encode(["errorCode" => "103", "success" => "0"]);die;
        }


        return new PreAuthenticatedToken(
            $user,
            $apiKey,
            $providerKey,
            $user->getRoles()
        );
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

//    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
//    {
//        return new Response("Authentication Failed.", 403);
//    }
}
