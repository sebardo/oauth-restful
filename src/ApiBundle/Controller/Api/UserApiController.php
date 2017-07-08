<?php
namespace ApiBundle\Controller\Api;

use AppBundle\Entity\OAuthAccessToken;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ApiBundle\Entity\AccessToken;
use ApiBundle\Entity\Actor;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserApiController extends FOSRestController
{
  /**
   * @Rest\Get("/user/{user}", name="api.user")
   */
  public function getUserAction(Actor $user)
  {
      
    $token = $this->get('fos_oauth_server.access_token_manager')->findTokenByToken($this->get('security.token_storage')->getToken()->getToken());

    if(!$token instanceof AccessToken){
      throw new AccessDeniedException();
    }

     if ($user instanceof Actor) {
        $userInfo['username'] = $user->getUsername();
        $userInfo['email'] = $user->getEmail();
        $userInfo['id'] = $user->getId();
    }

    return new JsonResponse($userInfo);

  }
  
}
