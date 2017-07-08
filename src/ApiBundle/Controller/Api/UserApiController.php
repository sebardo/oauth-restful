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
   * @Rest\Get("/users", name="get_users")
   */
  public function getUsersAction()
  {
      
//    $token = $this->get('fos_oauth_server.access_token_manager')->findTokenByToken($this->get('security.token_storage')->getToken()->getToken());
//
//    if(!$token instanceof AccessToken){
//      throw new AccessDeniedException();
//    }

    $data = array(
        array('id' => 1, 'email' => 'email1@email.com', 'name' => 'user1'),
        array('id' => 2, 'email' => 'email2@email.com', 'name' => 'user2'),
    );
    $view = $this->view($data, 200)
//        ->setTemplate("ApiBundle:Users:getUsers.html.twig")
//        ->setTemplateVar('users')
    ;

    return $this->handleView($view);

  }
  
}
