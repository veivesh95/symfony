<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Category;
use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PostController extends Controller
{

    private $parametersAsArray;

    private function setParameterArray($param)
    {
        $this->parametersAsArray = json_decode($param->getContent(), true);
        return $this->parametersAsArray;
    }

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
        $this->setParameterArray($request);
        $category = new Category();
        $category->setName($this->parametersAsArray['name']);
        $this->getEntiyManger()->persist($category);
        $this->getEntiyManger()->flush();
        return $this->respose('added category with cat id ' . $category->getId());
    }

    public function createAction(Request $request)
    {
        $this->setParameterArray($request);
        $category = new Category();
        $category->setCname($this->parametersAsArray['cname']);
        $post = new Post();
        $post->setName($this->parametersAsArray['name']);
        $post->setDes($this->parametersAsArray['des']);
        $post->setCategory($category);
        $this->getEntiyManger()->persist($category);
        $this->getEntiyManger()->persist($post);
        $this->getEntiyManger()->flush();
        return $this->respose('saved post with id ' . $post->getId() . ' saved category with id ' . $category->getId());
    }

    private function serializeToJson($param)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($param, 'json');
        return $jsonContent;
    }

    public function showAction($postId)
    {
        $post = $this->getEntiyManger()->getRepository(Post::class)->find($postId);
        if (!$post) {
            return $this->respose('not found');
        } else {
            //serializing
            $jsonContent = $this->serializeToJson($post);
            return $this->respose($jsonContent);
        }
    }

    public function showAllAction()
    {
        $posts = $this->getEntiyManger()->getRepository(Post::class)->findAll();
        if (!$posts) {
            return $this->respose('not found');
        } else {
            //serializing
            $jsonContent = $this->serializeToJson($posts);
            return $this->respose($jsonContent);
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
