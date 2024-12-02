<?php

class Pages extends AbstractController
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = $this->model('Post');

    }

    public function index()
    {
        $lastPosts = $this->postModel->getLastPosts();
        $bestPosts = $this->postModel->getBestPosts();

        $data = [
            'title' => 'Landing Page',
            'last' => $lastPosts,
            'best' => $bestPosts,
        ];
        // dd($data);

        $this->render('index', $data);
    }

    public function about()
    {

        $data = [
            'title' => 'About page',
        ];
        $this->render('about', $data);
    }
}