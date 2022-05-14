<?php
if (is_file('configuration/Database.php'))
{
    require_once('configuration/Database.php');
} else {
    require_once('../configuration/Database.php');
}

Class Author extends Database
{
    private $table = 'author';
    
    private $id;
    private $name;
    private $description;
    private $designation;
    private $image;
    private $youtube_url;
    private $facebook_url;
    private $instagram_url;
    private $twitter_url;
    private $website_url;
    private $status;
    private $created_at;

    function setFields($field_array, $files = null)
    {
        $this->id           = isset($field_array['id']) ? $field_array['id'] : null;
        $this->name         = isset($field_array['name']) ? $field_array['name'] : null;
        $this->description  = isset($field_array['description']) && $field_array['description'] != null ? $field_array['description'] : NULL;
        $this->designation  = isset($field_array['designation']) && $field_array['designation'] != null ? $field_array['designation'] : NULL;
        $this->youtube_url  = isset($field_array['youtube_url']) && $field_array['youtube_url'] != null ? $field_array['youtube_url'] : NULL;
        $this->facebook_url = isset($field_array['facebook_url']) && $field_array['facebook_url'] != null ? $field_array['facebook_url'] : NULL;
        $this->instagram_url= isset($field_array['instagram_url']) && $field_array['instagram_url'] != null ? $field_array['instagram_url'] : NULL;
        $this->twitter_url  = isset($field_array['twitter_url']) && $field_array['twitter_url'] != null ? $field_array['twitter_url'] : NULL;
        $this->website_url  = isset($field_array['website_url']) && $field_array['website_url'] != null ? $field_array['website_url'] : NULL;
        $this->status       = (isset($field_array['status']) && $field_array['status'] == 'on') ? 1 : 0;
        $this->created_at   = date('Y-m-d H:i:s');

        if (isset($files['image']) && file_exists($files['image']['tmp_name'])) {
            $this->image = $files['image'];
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
            while($row = $this->mightyFetchArray($result)) {
                $row['image'] = $row['image'];
                $row['image_url'] = $this->mightyHost().'upload/author/'.$row['image'];
                $records[] = $row;
            }
        }
        
        return $records;
    }

    function mightyGetRecord()
    {
        $query = "SELECT * FROM $this->table ORDER BY id DESC";
        
        $result = $this->mightyQuery($query);
        
        $records = [];
        
        if($result) {
            while($row = $this->mightyFetchArray($result)) {
                $row['image'] = $row['image'];
                $row['image_url'] = $this->mightyHost().'upload/author/'.$row['image'];
                $records[] = $row;
            }
        }
        
        return $records;
    }
    function mightySave()
    {
        $image = 'default.png';
        $is_image_upload = false;
        $description = $this->connection->escape_string($this->description);

        if (isset($this->image) && file_exists($this->image['tmp_name'])) {
            $path = '../upload/author';
            $image = time().'-'.$this->image['name'];
            move_uploaded_file($this->image['tmp_name'], $path."/".$image);
            $is_image_upload = true;
        }

        if( $this->id == null )
        {
            $record = "INSERT INTO $this->table VALUES(NULL, '".$this->name."', '".$description."', '".$this->designation."', '".$image."', '".$this->youtube_url."', '".$this->facebook_url."', '".$this->instagram_url."', '".$this->twitter_url."', '".$this->website_url."', '".$this->status."' , '".$this->created_at."'  )";
            $message = "Author has been saved successfully";
        } else {
            $result = $this->mightyGetByID($this->id);
            if($is_image_upload == false)
            {
                $image = $result['image'];
            }

            $record = "UPDATE $this->table SET `name` = '$this->name', `description` = '$description', `designation` = '$this->designation', `status` = '$this->status', `image` = '$image', `website_url` = '$this->website_url' , `twitter_url` = '$this->twitter_url', `youtube_url` = '$this->youtube_url' , `facebook_url` = '$this->facebook_url' , `instagram_url` = '$this->instagram_url' WHERE `id` = '".$this->id."' ";
            $message = "Author has been updated successfully";
        }
        
        try {
            $this->mightyQuery($record);
            $_SESSION['success'] = $message;
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed";
        }
        
        echo '<script> location.href = "index.php?page=author"; </script>';
        die;
    }

    function mightyGetByID($id)
    {
        $query = "SELECT * FROM $this->table WHERE `id` = '".$id."'";
        $result = $this->mightyFetchArray($this->mightyQuery($query));
        if($result != null) {
            $result['image_url'] = $this->mightyHost().'upload/author/'.$result['image'];
        } else {
            $result['image_url'] = null;
        }
        return $result;
    }

    function mightyDelete()
    {
        $result = $this->mightyGetByID($this->id);
        
        $image = $result['image'];

        $query = "DELETE FROM $this->table WHERE `id` = '".$this->id."' ";

        $path = '../upload/author/'.$image;
        
        if( $image != 'default.png' ) {
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $message = 'Author has been deleted.';
        try {
            $this->mightyQuery($query);
            $_SESSION['success'] = $message;
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed";
        }
        echo '<script> location.href = "index.php?page=author"; </script>';
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

