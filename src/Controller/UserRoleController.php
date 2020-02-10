<?php


namespace App\Controller;


use App\Entity\User;
use App\Entity\UserRoles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/user_role")
 */
class UserRoleController extends AbstractController
{

    /**
     * @Route("/add", name="userroles_add",methods={"POST"})
     */
    public function add(Request $request, ValidatorInterface $validator)
    {
        /**@var Serializer $serializer*/
        $serializer=$this->get('serializer');
        $rolAdd=$serializer->deserialize($request->getContent(),UserRoles::class,'json');
        $em=$this->getDoctrine()->getManager();
        $em->persist($rolAdd);
        $em->flush();
        return $this->json($rolAdd);
    }

    /**
     * @Route("/get/{id}", name="userroles_get",methods={"GET"})
     */
    public function getUserRole($id)
    {
        /**@var Serializer $serializer*/
        $serializer=$this->get('serializer');
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $userRole=$user->getUserRole();
        foreach ($userRole as $role) {
            $r = $role->getName();

        }
        return new Response($r);
        //return new Response($serializer->serialize($userRole,'json'));
    }



}