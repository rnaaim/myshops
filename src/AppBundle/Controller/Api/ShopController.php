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
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

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
     *
     */

    public  function showAction(){

        $shops = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Shop')->findAll();

        if(!$shops){    //Verify if object not null
            $response = array('code' => -1,
                'message' => "No shops were found",
                'result' => null,
                'error' => null);

           return new JsonResponse($response,HTTP_NOT_FOUND); //return response with code to be consumed by client
        }

        $allShops = $this->get('jms_serializer')->serialize($shops,'json');

        $response = array('code' => 1,
            'message'=> "success",
            'error' => null,
            'result' => json_decode($allShops));

        return new JsonResponse($response);

    }

    /**
     *@Route("api/shop/like/{id}")
     * @Method("PUT")
     */
    public function likeShopAction(Request $request,$id){  // Action to like a shop

         $shop= $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Shop')->find($id);

         if(!isset($shop)){
             $response = array('code' => -1,
                 'message' => 'Shop not found',
                 'result' => 'null');

             return new JsonResponse($response,404);

         }

         $current_user_id = $this->getUser()->getId();

         if(!isset($current_user_id)){
             $response = array('code' => -1,
                 'message' => ' You need to log to like a shop');

             return new JsonResponse($response);
         }

         $shop->setUsers([$current_user_id]);

         $dm = $this->get('doctrine_mongodb')->getManager();

         $dm->persist($shop);

         $dm->flush();

         $response = array('code' => '1',
             'message' => "You have liked this shop, you can see all your shops in your favourite shops page");

         return new JsonResponse($response);

    }

    /**
     * @param Request $request
     * @Route("api/user/shops")
     */
       public function getUserShops( Request $request){

           $current_user_id = $this->getUser()->getId();

           if(!isset($current_user_id)){
               $response = array('code' => -1,
                   'message' => ' You need to log to see your liked shops !');

               return new JsonResponse($response);
           }

           $shops = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Shop')->findBy(array('users' =>
           [$current_user_id]));


           if(!isset($shops) || count($shops) == 0){
               $response = array('code' => -1,
                   'message' => 'This user does not like any shop');

               return new JsonResponse($response);
           }

           $allShops = $this->get('jms_serializer')->serialize($shops,'json');

           $response = array('code' => 1,
               'message'=> "success",
               'error' => null,
               'result' => json_decode($allShops));

           return new JsonResponse($response);
       }

    /**
     * @param Request $request
     * @Route("api/shop/dislike/{id}")
     * @Method("PUT")
     */
       public function dislikePostAction(Request $request,$id){

           $current_user_id = $this->getUser()->getId();

           if(!isset($current_user_id)){
               $response = array('code' => -1,
                   'message' => ' You need to log to see your liked shops !');

               return new JsonResponse($response);
           }
           $shop = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Shop')->find($id);

           if(!isset($shop)){
               $response = array('code' => -1,
                   'message' => 'Shop not found',
                   'result' => 'null');

               return new JsonResponse($response,404);

           }

           //delete id of current user of the shop's user collection
            $remove_current_user = array_diff($shop->getUsers(),[$current_user_id]);
           $shop->setUsers($remove_current_user);

           $dm = $this->get('doctrine_mongodb')->getManager();

           $dm->persist($shop);

           $dm->flush();

           $response = array('code' => '1',
               'message' => "You have disliked this shop, you can see all your shops in your favourite shops page");

           return new JsonResponse($response);


       }
}