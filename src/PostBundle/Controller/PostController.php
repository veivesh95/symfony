<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Category;
use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    private function respose($param)
    {
        return new Response($param);
    }

    private function getEntiyManger()
    {
        return $this->getDoctrine()->getManager();
    }

    public function indexAction(Request $request)
    {
        return $this->respose('er');
    }

    public function createCatAction(Request $request)
    {
        $parametersAsArray = json_decode($request->getContent(), true);
        $category = new Category();
        $category->setName($parametersAsArray['name']);
        $this->getEntiyManger()->persist($category);
        $this->getEntiyManger()->flush();
        return $this->respose('added category with cat id ' . $category->getId());
    }

    public function createAction(Request $request)
    {
        $parametersAsArray = json_decode($request->getContent(), true);
        $category = new Category();
        $category->setCname($parametersAsArray['cname']);
        $post = new Post();
        $post->setName($parametersAsArray['name']);
        $post->setDes($parametersAsArray['des']);
        $post->setCategory($category);
        $this->getEntiyManger()->persist($category);
        $this->getEntiyManger()->persist($post);
        $this->getEntiyManger()->flush();
        return $this->respose('saved post with id ' . $post->getId() . ' saved category with id ' . $category->getId());
    }

    public function showAction($postId)
    {
        $post = $this->getEntiyManger()->getRepository(Post::class)->find($postId);
        if (!$post) {
            return $this->respose('not found');
        } else {
            return $this->respose('found');
        }
    }

    public function updateAction($postId)
    {
        $post = $this->getEntiyManger()->getRepository(Post::class)->find($postId);
        if (!$post) {
            return $this->respose('not found');
        } else {
            $post->setName('post New 1');
            $this->getEntiyManger()->flush();
            return $this->respose('updated!');
        }
    }

    public function deleteAction($postId)
    {
        $post = $this->getEntiyManger()->getRepository(Post::class)->find($postId);
        if (!$post) {
            return $this->respose('not found');
        } else {
            $this->getEntiyManger()->remove($post);
            $this->getEntiyManger()->flush();
            return $this->respose('deleted!');
        }
    }

}
