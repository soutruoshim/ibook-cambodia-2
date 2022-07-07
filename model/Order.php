<?php
class Order{
  
    // database connection and table name
    private $conn;
    private $table_name = "orders";
  
    // object properties
    public $id;
    public $user_id;
    public $book_id;
    public $price;
    public $amount;
    public $payment_status;
    public $paid_document;
    public $status;
    public $create_dt;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read orders
    function read(){
    
        // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                ORDER BY
                   create_dt DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // read detail 
    function readDetail($status){
    
        // select all query
        $query = "SELECT
                    o.id as id, 
                    o.price as price, 
                    o.amount as amount, 
                    o.payment_status as payment_status, 
                    o.status as status, 
                    o.paid_document as 	paid_document, 
                    o.create_dt as create_dt, 
                    b.name as book_name,
                    b.logo as book_logo,
                    u.first_name as first_name,
                    u.last_name as last_name
                FROM
                    " . $this->table_name . " o
                    LEFT JOIN
                         book b
                            ON b.id = o.book_id
                    LEFT JOIN
                         users u
                        ON u.id = o.user_id
                WHERE o.status = '$status'        
                ORDER BY
                    o.create_dt DESC";
        //echo $query;            
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // create order
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                user_id=:user_id, book_id=:book_id, price=:price, amount=:amount, payment_status=:payment_status, paid_document=:paid_document, create_dt=:create_dt";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    

        // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->book_id=htmlspecialchars(strip_tags($this->book_id));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->amount=htmlspecialchars(strip_tags($this->amount));
        $this->payment_status=htmlspecialchars(strip_tags($this->payment_status));
        $this->paid_document=htmlspecialchars(strip_tags($this->paid_document));
        $this->create_dt=htmlspecialchars(strip_tags($this->create_dt));
    
    
        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":book_id", $this->book_id);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":payment_status", $this->payment_status);
        $stmt->bindParam(":paid_document", $this->paid_document);
        $stmt->bindParam(":create_dt", $this->create_dt);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;    
    }
    // used when filling up the update order form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";

    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of order to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
       

        $this->user_id= $row['user_id'];
        $this->book_id= $row['book_id'];
        $this->price= $row['price'];
        $this->amount= $row['amount'];
        $this->payment_status= $row['payment_status'];
        $this->paid_document= $row['paid_document'];
        $this->create_dt= $row['create_dt'];
       
    }

    // used when filling up the update order form
    function readOneDetail(){

        // query to read single record
        $query = "SELECT
                    o.id as id, 
                    o.price as price, 
                    o.amount as amount, 
                    o.payment_status as payment_status, 
                    o.status as status, 
                    o.paid_document as 	paid_document, 
                    o.create_dt as create_dt, 
                    b.name as book_name,
                    b.logo as book_logo,
                    u.first_name as first_name,
                    u.last_name as last_name
                FROM
                    " . $this->table_name . " o
                    LEFT JOIN
                        book b
                            ON b.id = o.book_id
                    LEFT JOIN
                        users u
                        ON u.id = o.user_id
                    WHERE
                        o.id = ?
                    LIMIT
                        0,1";      
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of order to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
        
    }

    //==============check book status
    function checkOrder(){
    
        // query to read single record
       
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    user_id=:user_id AND book_id=:book_id
                LIMIT
                    0,1";

       
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of order to be updated
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":book_id", $this->book_id);
      
        // execute query
        $stmt->execute();
        //var_dump($stmt);
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        //var_dump($row);

        $this->user_id= $row['user_id'];
        $this->book_id= $row['book_id'];
        $this->price= $row['price'];
        $this->amount= $row['amount'];
        $this->payment_status= $row['payment_status'];
        $this->paid_document= $row['paid_document'];
        $this->create_dt= $row['create_dt'];
    }


    // update the order
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    user_id = :user_id,
                    book_id = :book_id,
                    price = :price,
                    amount = :amount,
                    payment_status = :payment_status,
                    paid_document = :paid_document
                WHERE
                    id = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->book_id=htmlspecialchars(strip_tags($this->book_id));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->amount=htmlspecialchars(strip_tags($this->amount));
        $this->payment_status=htmlspecialchars(strip_tags($this->payment_status));
        $this->paid_document=htmlspecialchars(strip_tags($this->paid_document));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind new values
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':payment_status', $this->payment_status);
        $stmt->bindParam(':paid_document', $this->paid_document);
        $stmt->bindParam(':id', $this->id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function updateStatus(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    status = :status
                WHERE
                    id = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind new values
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        // execute the query
        if($stmt->execute()){
            return true;
        }

        //echo $query;
    
        return false;
    }
    // delete the order
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
    // search orders
    function search($keywords){
    
        // select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                WHERE
                    p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
                ORDER BY
                    p.created DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }
    // read orders with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categories c
                            ON p.category_id = c.id
                ORDER BY p.created DESC
                LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
        // execute query
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }
    // used for paging orders
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
}

?>