<?php


namespace App\Controller;

use App\Entity\Publication;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/add", name="publication_add",methods={"POST"})
     */
    public function add(Request $request)
    {
        /**@var Serializer $serializer*/
        $serializer=$this->get('serializer');
        $pubAdd=$serializer->deserialize($request->getContent(),Publication::class,'json');

        $em=$this->getDoctrine()->getManager();
        $em->persist($pubAdd);
        $em->flush();
        return $this->json($pubAdd);
    }
}