<?php


namespace App\Controller;


use App\Entity\RolesPermissions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/role_permission")
 */
class RolesPermissionController extends AbstractController
{
    /**
     * @Route("/add", name="roles_permission_add",methods={"POST"})
     */
    public function add(Request $request, ValidatorInterface $validator)
    {
        /**@var Serializer $serializer*/
        $serializer=$this->get('serializer');
        $rolAdd=$serializer->deserialize($request->getContent(),RolesPermissions::class,'json');

        $em=$this->getDoctrine()->getManager();
        $em->persist($rolAdd);
        $em->flush();
        return $this->json($rolAdd);
    }
}