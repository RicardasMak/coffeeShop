<?php
namespace Tudublin;


use http\Message;
use mysql_xdevapi\Exception;

class Db
{
    private $connection;

    public function __construct()
    {
        //establish connection to db
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;
        try {
            $this->connection = new \PDO(
                $dsn,
                DB_USER,
                DB_PASS
            );
        } catch (\Exception $e){
            var_dump($e);
            die();
        }
    }
    //displays all from comment tables and returns all
    public function getAllShops()
    {
            $sql = 'SELECT * FROM shop ORDER BY date DESC';

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Tudublin\\Shop');

            return $stmt->fetchAll();
    }
    //gets all review
    public function getAllReview()
    {
        $sql = 'SELECT * FROM review ORDER BY date DESC';

        $stmt = $this->connection->prepare($sql);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Tudublin\\Review');

        return $stmt->fetchAll();
    }

    //show all comments
    public function getAllComment()
    {
        $sql = 'SELECT * FROM comment ORDER BY date DESC';

        $stmt = $this->connection->prepare($sql);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Tudublin\\Comment');

        return $stmt->fetchAll();
    }

    //inserts comment, user name who commented in table
    public function insertShop($shopName, $userName, $ifPayed, $shopOwner)
    {
        $sql = 'INSERT INTO shop (shopName, userName, profilePayed, shopOwner) 
							VALUES (:shopName, :userName, :profilePayed, :shopOwner)';

        $stmt = $this->connection->prepare($sql);
        // initializing variables in sql query
        $stmt->bindParam(':shopName', $shopName);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':profilePayed', $ifPayed);
        $stmt->bindParam(':shopOwner', $shopOwner);

        $stmt->execute();
    }

    public function insertComment($id, $comment, $userName, $permit, $profilePayed)
    {
        $sql = 'INSERT INTO comment (id, comment, userName, permit, profilePayed) 
							VALUES (:id, :comment, :userName, :permit, :profilePayed)';

        $stmt = $this->connection->prepare($sql);
        // initializing variables in sql query
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':permit', $permit);
        $stmt->bindParam(':profilePayed', $profilePayed);

        $stmt->execute();
    }
    //insert review
    public function insertReview($id, $review, $userName)
    {
        $sql = "INSERT INTO review (id, review, userName) 
                                   VALUES (:id, :review, :userName)";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':review', $review);
        $stmt->bindParam(':userName', $userName );

        return $stmt->execute();
    }

    //searches for user by user name and returns boolean
    public function findUser($userName)
    {
        $sql = 'SELECT * FROM users WHERE userName = :userName';

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':userName', $userName, \PDO::PARAM_STR);

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Tudublin\\Users');
        $stmt->execute();

        return $stmt->fetch();
    }
    //deletes user by user name and returns boolean
    public function deleteUser($userName)
    {
        $sql = "DELETE FROM users WHERE userName = :userName";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':userName', $userName);

        return $stmt->execute();
    }
    //create user and return boolean
    public function createUser($userName, $password, $role, $payed)
    {
        $sql = "INSERT INTO users (userName, password, role, payed) 
                                   VALUES (:userName, :password, :role, :payed)";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':userName', $userName, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, \PDO::PARAM_STR);
        $stmt->bindParam(':payed', $payed, \PDO::PARAM_INT);

        return $stmt->execute();
    }
    //delete shop with all comment and review from that shop
    public function deteleShop($table, $id)
    {
        if($table == 'shop')
        {   //from shop table
            $sql = "DELETE FROM shop WHERE id = :id";
        }
        elseif($table == 'review')
        {   //from review table
            $sql = "DELETE FROM review WHERE id = :id";
        }else
        {   //from comment table
            $sql = "DELETE FROM comment WHERE id = :id";
        }
        //prepare statement
        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        $stmt->execute();
    }
    //moderate permit to 1 = comment will go online
    public function allowComment($id, $permit)
    {
        // Prepare UPDATE statement
            $sql = "UPDATE comment SET permit = :permit WHERE idUnque = :id";

            //create prepare statment
            $stmt = $this->connection->prepare($sql);

            // Bind parameters to statement variables
            $stmt->bindParam(':id',$id);
        $stmt->bindParam(':permit',$permit);

            $stmt->execute();
    }
    //create profile (update excising )
    public function updateProfile($user, $email, $occupation, $phone)
    {
          // Prepare UPDATE statement
        $sql = "UPDATE users SET email = ?, occupation = ?, phone = ? WHERE userName = ?";

        //create prepare statment
        $stmt = $this->connection->prepare($sql);

        // Bind parameters to statement variables
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $occupation);
        $stmt->bindParam(3, $phone);
        $stmt->bindParam(4, $user);

        return $stmt->execute();
    }
    //find shop by name
    public function findShop($shopName)
    {
        $sql = 'SELECT * FROM shop WHERE shopName = :shopName';

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':shopName', $shopName, \PDO::PARAM_STR);

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'Tudublin\\Shop');
        $stmt->execute();

        return $stmt->fetch();
    }

    //delete from comment or review tables
    public function deteleShopContent($table, $id)
    {
        if($table == 'comment')
        {
            $sql = "DELETE FROM comment WHERE idUnque = :id";
        }else
        {
            $sql = "DELETE FROM review WHERE idUnque = :id";
        }

        $stmt = $this->connection->prepare($sql);

        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

        $stmt->execute();
    }
}