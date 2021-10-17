<?php


class Database
{
    public function Authorization($login, $passw){
        $host = "localhost";
        $dbname = "chatik";
        $username = "root";
        $password = "root";
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;cahrset=utf8", $username, $password);

        $query = "SELECT * FROM USERS WHERE LOGIN = ". "'$login'". " AND PASSWORD ="."'$passw';";
        $user = $pdo->query($query);

        $i = 0;
        $id = null;
        while($row = $user->fetch(PDO::FETCH_ASSOC)){
            $id = $row['ID_USER'];
            $i++;
        }
        if ($i == 1)
            return $id;
        else
            return -1;
    }

    public function Registration($login, $passw) {
        $host = "localhost";
        $dbname = "chatik";
        $username = "root";
        $password = "root";
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;cahrset=utf8", $username, $password);
        $query = "SELECT * FROM USERS WHERE LOGIN = ". "'$login'";
        $user = $pdo->query($query);

        $log = $user->fetch(PDO::FETCH_ASSOC)['LOGIN'];

        if($log == $login)
            return false;
        else {
            $query = "INSERT INTO USERS (LOGIN, PASSWORD) VALUES ($login, " . "'$passw'". ");";
            $pdo->exec($query);
            return true;
        }
    }

    public function LoadChat(): array
    {
        $host = "localhost";
        $dbname = "chatik";
        $username = "root";
        $password = "root";
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;cahrset=utf8", $username, $password);
        $query = "SELECT U.LOGGIN, M.MESSAGE FROM USERS AS U INNER JOIN MESSAGES AS M ON U.ID_USER=M.ID_USER;";

        $messages = $pdo->query($query)->fetchAll();

        $pdo = null;
        return $messages;
    }

    public function SaveMassage($user_id, $massage){
        $host = "localhost";
        $dbname = "chatik";
        $username = "root";
        $password = "root";
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;cahrset=utf8", $username, $password);
        $query = "INSERT INTO MESSAGES (ID_USER, MESSAGE) VALUES ($user_id, " . "'$massage'". ");";
        $pdo->exec($query);
        $pdo = null;
    }
}