<?php


class Likes extends AbstractController
{

    private $likeModel;
    public function __construct()
    {
        $this->likeModel = $this->model('Like');
    }

    public function addLike($postId)
    {
        // dd($this->likeModel->verifyLikes($postId));
        if ($this->likeModel->verifyLikes($postId)) {
            $this->likeModel->addLikes($postId);
            redirect('posts/details/' . $postId);
        } else {
            $this->likeModel->deLikes($postId);
            redirect('posts/details/' . $postId);
        }
    }




}