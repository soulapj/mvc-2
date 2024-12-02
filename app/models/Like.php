<?php

class Like
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getLikes()
    {
        $this->db->query('SELECT * FROM posts_likes');
        return $this->db->findAll();
    }

    public function getLikesByPost($postId)
    {
        $this->db->query('SELECT * FROM posts_likes WHERE id_post = :postId');
        $this->db->bind(':postId', $postId);
        return $this->db->findAll();
    }

    public function verifyLikes($postId)
    {
        $this->db->query('SELECT * FROM posts_likes WHERE id_post = :post_id AND id_user = :user_id');
        $this->db->bind(':post_id', $postId);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        if ($this->db->findOne()) {
            return false;
        } else {
            return true;
        }
    }

    public function addLikes($postId)
    {
        $this->db->query('INSERT INTO posts_likes (id_post, id_user) VALUES (:post_id, :user_id)');
        $this->db->bind(':post_id', $postId);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deLikes($postId)
    {
        $this->db->query('DELETE FROM posts_likes WHERE id_post = :post_id AND id_user = :user_id');
        $this->db->bind(':post_id', $postId);
        $this->db->bind(':user_id', $_SESSION['user_id']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}