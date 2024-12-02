<?php

class AbstractController
{

    public function model($model)
    {
        // appel du model
        require_once '../app/models/' . $model . '.php';
        // instanciation du model
        return new $model();
    }


    public function render($view, $data = [])
    {
        $controllerName = strtolower(get_called_class());
        // appel de la vue
        if (file_exists('../app/views/' . $controllerName . '/' . $view . '.php')) {
            require_once '../app/views/' . $controllerName . '/' . $view . '.php';
        } else {
            die('La vue n\'existe pas');
        }
    }

    public function validateForm($data)
    {
        $errors = [];
        $password = '';
        foreach ($data as $key => $value) {
            $cleanField = htmlspecialchars(trim($value));
            switch ($key) {
                case 'email':
                    if (empty(filter_var($cleanField, FILTER_VALIDATE_EMAIL))) {
                        $errors[$key] = ['Veuillez entrer votre email.'];
                    } elseif (!filter_var($cleanField, FILTER_VALIDATE_EMAIL)) {
                        $errors[$key] = ['Cet email n\'est pas valide.'];
                    }
                    break;
                case 'title':
                    if (empty($cleanField)) {
                        $errors[$key] = ['Veuillez saisir un titre.'];
                    }
                    break;
                case 'body':
                    if (empty($cleanField)) {
                        $errors[$key] = ['Veuillez saisir un contenu à poster.'];
                    }
                    break;
                case 'username':
                    if (empty($cleanField)) {
                        $errors[$key] = ['Veuillez choisir un nom d\'utilisateur.'];
                    }
                    break;
                case 'password':
                    if (empty($cleanField)) {
                        $errors[$key] = ['Veuillez choisir un mot de passe.'];
                    } else {
                        $password = $cleanField;
                    }
                    break;
                case 'confirm_password':
                    if (empty($cleanField)) {
                        $errors[$key] = ['Veuillez retaper votre mot de passe.'];
                    } elseif ($password !== $cleanField) {
                        $errors[$key] = ['Les mots de passe ne sont pas identiques.'];
                    }
                    break;
                case 'comment':
                    if (empty($cleanField)) {
                        $errors[$key] = ['Veuillez saisir un commentaire.'];
                    }
                    break;
            }
            dd($errors);
            foreach ($errors as $key => $error) {
                $flashName = 'flash' . ucfirst($key);
                flash($flashName, $value, 'alert alert-danger');
            }
            return $errors;
        }
    }
}