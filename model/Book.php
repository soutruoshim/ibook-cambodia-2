<?php
if (is_file('configuration/Database.php'))
{
    require_once('configuration/Database.php');
} else {
    require_once('../configuration/Database.php');
}

Class Book extends Database
{
    private $table = 'book';
    
    private $id;
    private $name;
    private $author_id;
    private $type;
    private $file;
    private $category_id;
    private $logo;
    private $url;
    private $is_popular;
    private $is_featured;
    private $created_at;

    function setFields($field_array, $files = null)
    {
        $this->id           = isset($field_array['id']) ? $field_array['id'] : null;
        $this->name         = isset($field_array['name']) ? $field_array['name'] : null;
        $this->author_id    = isset($field_array['author_id']) ? $field_array['author_id'] : null;
        $this->type         = isset($field_array['type']) ? $field_array['type'] : null;
        $this->category_id  = isset($field_array['category_id']) ? $field_array['category_id'] : null;
        $this->url          = isset($field_array['url']) && $field_array['url'] != null ? $field_array['url'] : NULL;
        $this->description  = isset($field_array['description']) && $field_array['description'] != null ? trim(strip_tags($field_array['description'])) : NULL;
        $this->is_popular   = (isset($field_array['is_popular']) && $field_array['is_popular'] == 'on') ? 1 : 0;
        $this->is_featured  = (isset($field_array['is_featured']) && $field_array['is_featured'] == 'on') ? 1 : 0;
        $this->created_at   = date('Y-m-d H:i:s');

        if (isset($files['logo']) && file_exists($files['logo']['tmp_name'])) {
            $this->logo = $files['logo'];
        }

        if (isset($files['file']) && file_exists($files['file']['tmp_name'])) {
            $this->file = $files['file'];
        }
    }
        
    function mightyGetRecords($params)
    {
        $category_id = isset($params) & isset($params['category_id']) ? $params['category_id'] : null;
        $author_id = isset($params) & isset($params['author_id']) ? $params['author_id'] : null;
        $category_ids = isset($params) & isset($params['category_ids']) ? $params['category_ids'] : [];
        $featured = isset($params) & isset($params['is_featured']) ? $params['is_featured'] : null;
        $popular = isset($params) & isset($params['is_popular']) ? $params['is_popular'] : null;
        $order = isset($params) & isset($params['order']) ? $params['order'] : 'ASC';
        $order_by = isset($params) & isset($params['order_by']) ? $params['order_by'] : 'id';
        $count = isset($params) & isset($params['count']) ? $params['count'] : null;

        $page = (isset($params['page']) && $params['page'] != '' ) ? $params['page'] : 1;
        $limit = (isset($params['limit']) && $params['limit'] != '' ) ? $params['limit'] : 10;
        $offset = ( $page - 1 ) * $limit;

        $condition = '';
        $query = "SELECT * FROM $this->table";
        if($category_id != null) {
            $condition = " WHERE category_id = {$category_id} ";
        }
        if($category_ids != null && is_array($category_ids)) {
            $category_ids = "'" . implode( "','", $category_ids ) . "'";
            $condition = " WHERE category_id IN ($category_ids) ";
        }
        if($featured != null) {
            $condition = " WHERE is_featured = {$featured} ";
        }

        if($popular != null) {
            $condition = " WHERE is_popular = {$popular} ";
        }

        if($author_id != null) {
            $condition = " WHERE author_id = {$author_id} ";
        }

        if($count){
            $query = $query." ".$condition;
        } else {
            $query = $query." ".$condition." ORDER BY ". $order_by ." ". $order ." LIMIT $limit OFFSET $offset ";
        }
        $result = $this->mightyQuery($query);
        
        $records = [];
        if($result)
        {
            while($row = $this->mightyFetchArray($result)) {
                
                $category_result = $this->mightyQuery("SELECT `name` FROM `category` WHERE `id` = '".$row['category_id']."' ");
                
                $category_name = '';
                if($category_result->num_rows > 0)
                {
                    $category_data = $this->mightyFetchArray($category_result);
                    $category_name = $category_data['name'];
                }
                $author_result = $this->mightyQuery("SELECT `name`, `image` FROM `author` WHERE `id` = '".$row['author_id']."' ");
                $author_name = $author_image = '';
                if($author_result->num_rows > 0)
                {
                    $author_data = $this->mightyFetchArray($author_result);
                    $author_name = $author_data['name'];
                    $author_image = $this->mightyHost().'upload/author/'.$author_data['image'];
                }
    
    
                $row['logo'] = $this->mightyHost().'upload/book/'.$row['logo'];
                $row['file'] = $this->mightyHost().'upload/book/'.$row['file'];
                $row['category_name'] = $category_name;
                $row['author_name'] = $author_name;
                $row['author_image'] = $author_image;
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
            $category_result = $this->mightyQuery("SELECT `name` FROM `category` WHERE `id` = '".$row['category_id']."' ");

            $category_name = '';
            if($category_result->num_rows > 0)
            {
                $category_data = $this->mightyFetchArray($category_result);
                $category_name = $category_data['name'];
            }
            $author_result = $this->mightyQuery("SELECT `name`, `image` FROM `author` WHERE `id` = '".$row['author_id']."' ");
            $author_name = $author_image = '';
            if($author_result->num_rows > 0)
            {
                $author_data = $this->mightyFetchArray($author_result);
                $author_name = $author_data['name'];
                $author_image = $this->mightyHost().'upload/author/'.$author_data['image'];
            }

            $row['logo'] = $row['logo'];
            $row['file'] = $this->mightyHost().'upload/book/'.$row['file'];
            $row['category_name'] = $category_name;

            $row['author_name'] = $author_name;
            $row['author_image'] = $author_image;
            $records[] = $row;
        }
        return $records;
    }

    function mightySave()
    {
        $image = 'default.png';
        $pdf_file = NULL;
        $is_logo_upload = false;
        $is_file_upload = false;
        $description = $this->connection->escape_string($this->description);
        if (isset($this->logo) && file_exists($this->logo['tmp_name'])) {
            $path = '../upload/book';
            $image = time().'-'.$this->logo['name'];
            move_uploaded_file($this->logo['tmp_name'], $path."/".$image);
            $is_logo_upload = true;
        }
        if (isset($this->file) && file_exists($this->file['tmp_name'])) {
            $path = '../upload/book';
            $pdf_file = time().'-'.$this->file['name'];
            move_uploaded_file($this->file['tmp_name'], $path."/".$pdf_file);
            $is_file_upload = true;
        }
        if( $this->id == null )
        {
            $record = "INSERT INTO $this->table VALUES(NULL,'".$this->name."','".$this->category_id."','".$this->author_id."', '".$this->type."', '".$pdf_file."' ,'".$image."','". $description."', '".$this->url."','".$this->is_popular."', '".$this->is_featured."', '".$this->created_at."' )";
            $message = "Book has been saved successfully";
        } else {
            
            $result = $this->mightyGetByID($this->id);
            if($is_logo_upload == false)
            {
                $image = $result['logo'];
            }
            if($is_file_upload == false)
            {
                $pdf_file = $result['file'];
            }
            $record = "UPDATE $this->table SET `name` = '$this->name', `author_id` = '$this->author_id', `type` = '$this->type',  `file` = '$pdf_file', `category_id` = '$this->category_id', `url` = '$this->url', `logo` = '$image' , `description` = '$description', `is_popular` = '$this->is_popular',  `is_featured` = '$this->is_featured' WHERE `id` = '".$this->id."' ";
            $message = "Book has been updated successfully";
        }
        try {
            $this->mightyQuery($record);
            $_SESSION['success'] = $message;
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed";
        }
        echo '<script> location.href = "index.php?page=book"; </script>';
        die;
    }

    function mightyGetByID($id)
    {
        $query = "SELECT * FROM $this->table WHERE `id` = '".$id."'";
        $result = $this->mightyFetchArray($this->mightyQuery($query));
        if($result != null) {
            $result['logo_url'] = $this->mightyHost().'upload/book/'.$result['logo'];
            if($result['type'] == 'file')
            {
                $result['pdf_url'] = $this->mightyHost().'upload/book/'.$result['file'];
            } else {
                $result['pdf_url'] = $result['url'];
            }
            $result['logo_url'] = $this->mightyHost().'upload/book/'.$result['logo'];
        } else {
            $result['logo_url'] = null;
        }
        return $result;
    }

    function mightyDelete()
    {
        $result = $this->mightyGetByID($this->id);
        
        $logo = $result['logo'];
        $file = $result['file'];
        
        $query = "DELETE FROM $this->table WHERE `id` = '".$this->id."' ";

        $path = '../upload/book/'.$logo;
        $file_path = '../upload/book/'.$file;
        
        if( $logo != 'default.png' ) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
        if( $file != null ) {
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $message = 'Book has been deleted.';
        try {
            $this->mightyQuery($query);
            $_SESSION['success'] = $message;
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed";
        }
        echo '<script> location.href = "index.php?page=book"; </script>';
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

