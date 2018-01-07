<?php
/**
 * Created by PhpStorm.
 * User: rachid
 * Date: 1/6/18
 * Time: 12:44 PM
 */

namespace AppBundle\Controller\Api;


use AppBundle\AppBundle;
use AppBundle\Entity\Shop;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    /**
     * @Route("/",name="homepage")
     */

    public function indexAction(){



      //   return new JsonResponse($formatted_shops);
      return $this->render(':default:index.html.twig');

    }

    /**
     * @Route("api/shops",name="shops")
     */

    public  function showAction(){

        $user = $this->container->get('security.token_storage')->getToken()->isAuthenticated();
        $repository = $this->get('doctrine_mongodb')->getRepository('AppBundle:Shop');

        $shops = $repository->findAll();

        $formatted_shops = [];

        foreach ($shops as $shop){
            $formatted_shops[] = ['id'=> $shop->getId(),
                'picture'=>$shop->getPicture(),
                'name' => $shop->getName(),
                'email'=> $shop->getEmail(),
                'city'=> $shop->getCity(),
                'location'=> $shop->getLocation(),
                'users'=> $shop->getUsers()];

        }

         return $this->render('default/show.html.twig',['user'=>$user,'shops'=> $shops]);
    }
}