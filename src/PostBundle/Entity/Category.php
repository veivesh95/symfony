<?php

namespace PostBundle\Entity;

/**
 * Category
 */
class Category
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $cname;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setCname($cname)
    {
        $this->cname = $cname;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getCname()
    {
        return $this->cname;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $posts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add post
     *
     * @param \PostBundle\Entity\Post $post
     *
     * @return Category
     */
    public function addPost(\PostBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \PostBundle\Entity\Post $post
     */
    public function removePost(\PostBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

}
