<?php
//  Dans cette class on va faire les requetes SQL pour les posts
// On commence par instacier la class Database pour pouvoir faire des requetes SQL
class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPosts()
    {
        $this->db->query('SELECT *, posts.id as postId 
        FROM posts 
        JOIN users 
        ON posts.id_user = users.id 
        ORDER BY posts.dateCreated DESC');
        return $this->db->findAll();
    }

    public function getPostById($id)
    {
        $this->db->query("SELECT * FROM posts WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->findOne();
    }

    public function addPost($data)
    {
        $this->db->query("INSERT INTO posts (title, content, id_user, dateCreated, author) VALUES (:title, :content, :id_user, :dateCreated, :author)");
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['body']);
        $this->db->bind(':id_user', $data['id_user']);
        $this->db->bind(':author', $_SESSION['username']);
        $this->db->bind(':dateCreated', date('Y-m-d'));
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($dataToUpdate)
    {
        if (count($dataToUpdate) <= 1) {
            return true;
        }
        $clauseSet = [];
        $parameters = [];
        foreach ($dataToUpdate as $key => $value) {
            if ($key !== "id") {
                $clauseSet[] = "$key = :$key";
                $parameters[":$key"] = $value;
            } else {
                $parameters[":id"] = $value;
            }
        }
        $sql = "UPDATE posts SET " . implode(",", $clauseSet) . " WHERE id = :id";
        $this->db->query($sql);
        foreach ($parameters as $key => $value) {
            $this->db->bind($key, $value);
        }
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function deletePost($id)
    {
        $this->db->query('DELETE FROM posts WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getLastPosts($limit = 5)
    {
        $query = 'SELECT *, posts.id as postId 
        FROM posts 
        JOIN users 
        ON posts.id_user = users.id 
        ORDER BY posts.dateCreated DESC LIMIT ' . $limit;
        $this->db->query($query);
        return $this->db->findAll();

    }
    public function getBestPosts($limit = 5)
    {
        $query = 'SELECT *, COUNT(pl.id_post) as likes
        FROM posts p
        JOIN posts_likes pl
        ON p.id = pl.id_post
        JOIN users u
        ON p.id_user = u.id
        GROUP BY p.id
        ORDER BY likes DESC LIMIT ' . $limit;
        $this->db->query($query);
        return $this->db->findAll();
    }


}