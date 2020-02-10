<?php


namespace App\Controller;


use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{

    /**
     * @Route("/fetch/{id}", name="fetch_comment",methods={"GET"})
     */
    public function fetch(Comment $comment)
    {
        return $this->json($comment);
    }
    /**
     * @Route("/fetch_from_post/{id}", name="fetch_comment_from_pos",methods={"GET"})
     */
    public function fetchFromPost($id)
    {
        // return $this->json($comment);
        $em=$this->getDoctrine()->getManager();
        $listComments=$em->getRepository(Comment::class)->findBy(array('publication'=>$id));
        return $this->json($listComments);
    }
    /**
     * @Route("/fetch_by_user/{id}", name="fetch_comment_by_user",methods={"GET"})
     */
    public function fetchByUser($id)
    {
        $em=$this->getDoctrine()->getManager();
        $listComments=$em->getRepository(Comment::class)->findBy(array('user'=>$id));
        return $this->json($listComments);
    }
}