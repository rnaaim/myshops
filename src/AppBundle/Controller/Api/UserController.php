<?php
/**
 * Created by PhpStorm.
 * User: rachid
 * Date: 1/21/18
 * Time: 3:18 PM
 */

namespace AppBundle\Controller\Api;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
              /**
              *@Route("/user/create")
              */

              public function CreateAction(Request $request){

                 $username = $request->get('username');
                 $email = $request->get('email');
                 $password = $request->get('password');

                 $fosuserManager = $this->get('fos_user.user_manager');

                 $check_email = $fosuserManager->findUserByEmail($email);
                 $check_username = $fosuserManager->findUserByUsername($username);
                 if($check_email){

                     return new JsonResponse(array('code'=> 0,'message' => 'Email already exists'));
                 }


                  if($check_username){

                      return new JsonResponse(array('code' => 1,'message' => 'Username already exists'));
                  }

                 $user =  $fosuserManager->createUser();

                 $user = $fosuserManager->createUser();
                 $user->setUsername($username);
                 $user->setEmail($email);
                 $user->setEmailCanonical($email);
                 //$user->setLocked(false);
                 $user->setEnabled(true);
                 $user->setPlainPassword($password);
                  $fosuserManager->updateUser($user,true);

                 $result = array('code'=> 2,
                     'result' => $username. " was created");
                 return new JsonResponse($result);

             }
}