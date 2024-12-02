<?php

class Posts extends AbstractController
{
    //  chaque page est représentée par une méthode spécifique qui appelle une vue spécifique le model si besoin.
    private $postModel;
    private $commentModel;
    private $likeModel;

    public function __construct()
    {
        // if (!isLoggedIn()){
        //     redirect('users/login');
        // }


        //  Instanciation du model post pour récupérer les données de la BDD concernant les posts 
        $this->postModel = $this->model('Post');
        $this->commentModel = $this->model('Comment');
        $this->likeModel = $this->model('Like');

    }
    public function index()
    {
        // On appel la méthode getPosts du model Post pour récupérer les posts
        $posts = $this->postModel->getPosts();
        $likes = $this->likeModel->getLikes();
        // Le tableau data contient les données à envoyer à la vue
        $data = [
            'title' => 'Posts page',
            'posts' => $posts,
            'likes' => $likes

        ];
        //  On appel la méthode render de la class AbstractController pour afficher la vue index
        $this->render('index', $data);
    }

    public function details($id)
    {
        // On appel la méthode getPostById du model Post pour récupérer un post en fonction de son id
        $post = $this->postModel->getPostById($id);
        $likes = $this->likeModel->getLikesByPost($id);

        $data = [
            'title' => 'Posts page',
            'post' => $post,
            'comments' => $this->commentModel->getCommentsByPost($id),
            'likes' => $likes
        ];
        $this->render('details', $data);
    }

    public function addPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = [
                'title' => htmlspecialchars(trim($_POST['title'])),
                'body' => htmlspecialchars(trim($_POST['body'])),
                'id_user' => $_SESSION['user_id'],
            ];
            if (empty($data['title'])) {
                flash('flashTitle', 'Le titre est vide', 'alert alert-danger');
            }
            if (empty($data['body'])) {
                flash('flashBody', 'Le contenu est vide', 'alert alert-danger');
            }
            if (empty($_SESSION['flashTitle']) && empty($_SESSION['flashBody'])) {
                if ($this->postModel->addPost($data)) {
                    flash('flashAdd', 'Le post à été bien ajouté', 'alert alert-success');
                    redirect('posts/index');
                } else {
                    flash('flashFailure', "Le post n'a pas été publié", 'alert alert-danger');
                    redirect('posts/addPost');
                }
            } else {
                redirect('posts/addPost');
            }
        } else {
            $data = [];
            $this->render('addPost', $data);
        }
    }

    public function update($id)
    {
        $post = $this->postModel->getPostById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'title' => htmlspecialchars(trim($_POST['title'])),
                'body' => htmlspecialchars(trim($_POST['body'])),
                'id' => $id,
            ];

            if (!$post) {
                redirect('posts/index');
            }

            // Vérif si les champs sont vides
            if (empty($data['title'])) {
                flash('flashTitle', 'Le titre est vide', 'alert alert-danger');
            }
            if (empty($data['body'])) {
                flash('flashBody', 'Le contenu est vide', 'alert alert-danger');
            }

            // Vérifier si il n'y à pas d'erreurs 
            if (!empty($_SESSION['flashTitle']) || !empty($_SESSION['flashBody'])) {
                $data['post'] = $post;
                $this->render('updatePost', $data);
                return;
            }

            // Vérifier si le user à modifié le post 
            $dataToUpdate = ['id' => $id];
            if ($data['title'] !== $post->title) {
                $dataToUpdate['title'] = $data['title'];
            }
            if ($data['body'] !== $post->content) {
                $dataToUpdate['content'] = $data['body'];
            }

            // Appeller la méthode updatePost du model pour mettre à jour le post
            if ($this->postModel->updatePost($dataToUpdate)) {
                flash('flashAdd', 'Le post a bien été modifié', 'alert alert-success');
                redirect('posts/index');
            } else {
                flash('flashFail', 'Problème survenu lors de la mise à jour', 'alert alert-danger');
                redirect('posts/update/' . $id);
            }
        }
        if ($post->id_user != $_SESSION['user_id']) {
            redirect('posts/index');
        }
        $data = [
            'post' => $post,
        ];
        $this->render('updatePost', $data);
    }

    public function delete($id)
    {
        // Get existing post from model
        $post = $this->postModel->getPostById($id);

        // Check for owner
        if ($post->id_user != $_SESSION['user_id']) {
            redirect('posts/index');
        }

        if ($this->postModel->deletePost($id)) {
            flash('flashAdd', 'Le post a bien été supprimé');
            redirect('posts/index');
        } else {
            flash('flashFailure', 'Le post a bien été supprimé');
            redirect('posts/index');
        }
    }

}