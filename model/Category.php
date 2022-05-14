<?php
if (is_file('configuration/Database.php'))
{
    require_once('configuration/Database.php');
} else {
    require_once('../configuration/Database.php');
}

Class Category extends Database 
{
    private $table = 'category';
    private $book_table = 'book';
    private $id;
    private $name;
    private $logo;

    function setFields($field_array, $files = null)
    {
        $this->id           = isset($field_array['id']) ? $field_array['id'] : null;
        $this->name         = isset($field_array['name']) ? $field_array['name'] : null;

        if (isset($files['logo']) && file_exists($files['logo']['tmp_name'])) {
            $this->logo = $files['logo'];
        }
    }

    function mightyGetRecords($params = null)
    {
        $order = (isset($params['order']) && $params['order'] != '' ) ? $params['order'] : 'ASC';
        $order_by = (isset($params['order_by']) && $params['order_by'] != '' ) ? $params['order_by'] : 'id';
        $limit = (isset($params['limit']) && $params['limit'] != '' ) ? $params['limit'] : 10;
        $page = (isset($params['page']) && $params['page'] != '' ) ? $params['page'] : 1;
        $offset = ( $page - 1 ) * $limit;

        $query = "SELECT * FROM $this->table";
        
        $query = $query. " ORDER BY ".$order_by." ". $order." LIMIT $limit OFFSET $offset ";

        $result = $this->mightyQuery($query);
        
        $records = [];
        if($result) {
            while($row = $this->mightyFetchArray($result))
            {
                $row['logo'] = $this->mightyHost().'upload/category/'.$row['logo'];
                $records[] = $row;
            }
        }
        return $records;
    }

    function mightyGetRecord()
    {
        $result = $this->mightyQuery("SELECT * FROM $this->table ");
        
        $records = [];
        while($row = $this->mightyFetchArray($result))
        {
            $row['logo'] = $row['logo'];
            $records[] = $row;
        }
        return $records;
    }

    function mightySave()
    {
        $image = 'default.png';
        $is_upload = false;
        if (isset($this->logo) && file_exists($this->logo['tmp_name'])) {
            $path = '../upload/category';
            $image = time().'-'.$this->logo['name'];
            move_uploaded_file($this->logo['tmp_name'], $path."/".$image);
            $is_upload = true;
        }
        if( $this->id == null )
        {
            $record = "INSERT INTO $this->table VALUES(NULL,'".$this->name."','".$image."')";
            $message = "Category has been saved successfully";
        } else {
            
            $result = $this->mightyGetByID($this->id);

            if($is_upload == false)
            {
                $image = $result['logo'];
            }
            $record = "UPDATE $this->table SET `name` = '$this->name', `logo` = '$image' WHERE `id` = '".$this->id."' ";
            $message = "Category has been updated successfully";
        }
        try {
            $this->mightyQuery($record);
            $_SESSION['success'] = $message;
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed";
        }
        
        echo '<script> location.href = "index.php?page=category"; </script>';
        die;
    }

    function mightyGetByID($id)
    {
        $query = "SELECT * FROM $this->table WHERE `id` = '".$id."'";
        return $this->mightyFetchArray($this->mightyQuery($query));
    }

    function mightyDelete()
    {
        $result = $this->mightyGetByID($this->id);
        
        $logo = $result['logo'];
        
        $query = "DELETE FROM $this->table WHERE `id` = '".$this->id."' ";

        $path = '../upload/category/'.$logo;
        
        if( $logo != 'default.png' ) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $message = 'Category has been deleted.';
        try {
            $this->mightyQuery($query);
            $book_result = $this->mightyQuery("SELECT * FROM $this->book_table WHERE `category_id` = '".$this->id."' ");
        
            $records = [];
            while($row = $this->mightyFetchArray($book_result)) {
                $image = '../upload/book/'.$row['logo'];
                if( $row['logo'] != 'default.png' ) {
                    if (file_exists($image)) {
                        unlink($image);
                    }
                }
                
                $file = '../upload/book/'.$row['file'];
                if( $row['file'] != null ) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
            $this->mightyQuery("DELETE FROM $this->book_table WHERE `category_id` = '".$this->id."' ");
            $_SESSION['success'] = $message;
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed";
        }
        echo '<script> location.href = "index.php?page=category"; </script>';
        die;
    }

    function mightyHost()
    {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
            $http = "https://";
        } else {
            $http = "http://";   
        }
        
        $host = $http.$_SERVER['HTTP_HOST'];
        
        $host = str_replace('model','', $host.substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])));
        return $host;
    }
}