<?php
    require_once('../configuration/Connection.php');
    require_once('../model/Author.php');

    $author = new Author();
    
    $id = isset($_GET) && isset($_GET['id']) ? $_GET['id'] : null;
    $row = $author->mightyGetByID($id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST['id'] = $id;
        $author->setFields($_POST, $_FILES);
        $author->mightySave();
    }

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title"><?= isset($id) ? 'Edit' : 'Add' ?> Author</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form method="post"  action="" enctype="multipart/form-data">
                            
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" value ="<?= isset($row) && isset($row['name']) ? $row['name'] : '' ?>" placeholder="Enter Name" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="designation" class="form-label">Designation </label>
                                    <input type="text" class="form-control" name="designation" id="designation" value ="<?= isset($row) && isset($row['designation']) ? $row['designation'] : '' ?>" placeholder="Enter Designation">
                                </div>
                                
                                <div class="form-group col-md-4">
                                <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description" rows="2" ><?= isset($row) && isset($row['description']) ? $row['description'] : '' ?></textarea>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="facebook_url" class="form-label">Facebook URL </label>
                                    <input name="facebook_url" id="facebook_url" type="text" class="form-control" value="<?= isset($value) && isset($value->facebook_url) ? $value->facebook_url : '' ?>" placeholder="Enter Your Facebook URL">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="instagram_url" class="form-label">Instagram URL </label>
                                    <input name="instagram_url" id="instagram_url" type="text" class="form-control" value="<?= isset($value) && isset($value->instagram_url) ? $value->instagram_url : '' ?>" placeholder="Enter Your Instagram URL">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="twitter_url" class="form-label">Twitter URL </label>
                                    <input name="twitter_url" id="twitter_url" type="text" class="form-control" value="<?= isset($value) && isset($value->twitter_url) ? $value->twitter_url : '' ?>" placeholder="Enter Your Twitter URL">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="website_url" class="form-label">Website URL </label>
                                    <input name="website_url" id="website_url" type="text" class="form-control" value="<?= isset($value) && isset($value->website_url) ? $value->website_url : '' ?>" placeholder="Enter Your Website URL">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="image" class="form-label">Image</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="customFile" accept="image/*" name="image">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                
                                <?php
                                    $image = isset($row) && isset($row['image']) ? $row['image'] : 'default.png';
                                    $path = '../upload/author/';
                                ?>
                                <div class="form-group col-md-4 mt-3">
                                    <div class="mm-avatar">
                                        <img class="avatar-60 rounded image_preview" src="<?= $path.$image ?>" alt="#" data-original-title="" title="">
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Status </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="status" id="status" <?= (isset($row) && isset($row['status']) && $row['status'] == 1 ) || ( $id == null ) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="status"></label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-primary" value="Save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>