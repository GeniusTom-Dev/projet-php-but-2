<?php

namespace controllers;

use GFramework\database\DbUsers;

class AuthController{

    /**
     * Checks if the user's registration information is valid and adds the user to the database if so.
     *
     * @param DbUsers $dbUsers The database object for user management.
     * @param string $email The email address of the user.
     * @param string $login The username of the user.
     * @param string $password The password of the user.
     * @param string $passwordConfirm The confirmation of the user's password.
     * @return array An array containing the result of the registration process and any errors encountered.
     */
    public function checkRegister(DbUsers $dbUsers, string $email, string $login , string $password, string $passwordConfirm): array{
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $errors["email"] = "L'adresse mail n'est pas au bon format.";
        }else{
            if($dbUsers->isEmailAlreadyUsed($email)){
                $errors["email"] = "Cette adresse mail est déjà utilisé.";
            }
        }

        if($dbUsers->isUsernameAlreadyUsed($login)){
            $errors["login"] = "Ce nom d'utilisateur est déjà utilisé.";
        }

        if($this->validatePassword($password) === false){
            $errors["password"] = "Le mot de passe doit contenir 1 lettre, 1 chiffre, 6 caractères.";
        }

        if($password !== $passwordConfirm){
            $errors["passwordConfirm"] = "Les mots de passe ne correspondent pas.";
        }

        if(empty($errors) === false && count($errors) > 0){
            return ["result" => false, "errors" => $errors];
        }
        $password = password_hash($password, PASSWORD_BCRYPT);
        $dbUsers->addUser($login, $email, $password);

        return ["result" => true];
    }

    /**
     * Checks if the login and password are valid.
     *
     * @param DbUsers $dbUsers The database object for handling user data.
     * @param string $login The login value to be checked.
     * @param string $password The password value to be checked.
     * @return array The result of the login check.
     */
    public function checkLogin(DbUsers $dbUsers, string $login, string $password): array{
        if(filter_var($login, FILTER_VALIDATE_EMAIL)){
            if($dbUsers->isEmailAlreadyUsed($login)){
                $typeConnection = "email";
                $savedPassword = $dbUsers->getPasswordFromLogin($login, $typeConnection);
            }
        }else{
            if($dbUsers->isUsernameAlreadyUsed($login)){
                $typeConnection = "login";
                $savedPassword = $dbUsers->getPasswordFromLogin($login, $typeConnection);
            }
        }



        if(empty($password) === false && empty($savedPassword) === false){
            if(password_verify($password, $savedPassword)){
                $userId = $dbUsers->getUserIDFromLogin($login, $typeConnection);
                $idAdmin = $dbUsers->isAdminFromId($userId);
                return ["result" => true, "USER_ID" => $userId, "IS_ADMIN" => $idAdmin];
            }
        }
        return ["result" => false];
        }

    /**
     * Validates a password.
     *
     * @param string $password The password to be validated.
     * @return bool Returns true if the password is valid, false otherwise.
     */
    private function validatePassword(string $password): bool
    {
        if (strlen($password) < 6) {
            return false;
        }

        if (preg_match('/[a-zA-Z]/', $password)=== false) {
            return false;
        }

        if (preg_match('/[0-9]/', $password) === false) {
            return false;
        }

        return true;
    }
}