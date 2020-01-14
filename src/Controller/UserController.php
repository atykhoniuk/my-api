<?php


namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/add", name="user_add",methods={"POST"})
     */
    public function add(Request $request)
    {
        /**@var Serializer $serializer*/
        $serializer=$this->get('serializer');
        $userAdd=$serializer->deserialize($request->getContent(),User::class,'json');

        $em=$this->getDoctrine()->getManager();
        $em->persist($userAdd);
        $em->flush();
        return $this->json($userAdd);
    }
    /**
     * @Route("/fetch_all", name="fetch_all",methods={"GET"})
     */
    public function fetchAll()
    {
        return $this->json($this->getDoctrine()->getRepository(User::class)->findAll());
    }
    /**
     * @Route("/fetch/{id}", name="fetch",methods={"GET"})
     */
    public function fetch(User $user)
    {
        return $this->json($user);
    }

    /**
     * @Route("/delete/{id}", name="delete_user",methods={"DELETE"})
     */
    public function deleteUser(User $user)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return new JsonResponse(null,Response::HTTP_NO_CONTENT);
    }

}