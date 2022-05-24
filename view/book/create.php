<?php
    require_once('../configuration/Connection.php');
    require_once('../model/Book.php');
    require_once('../model/Category.php');
    require_once('../model/Author.php');

    $book = new Book();
    
    $id = isset($_GET) && isset($_GET['id']) ? $_GET['id'] : null;
    $row = $book->mightyGetByID($id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $book->setFields($_POST, $_FILES);
        $book->mightySave();
    }
    $category = new Category();
    $category_list = $category->mightyGetRecord();
    $type_list = [
        'pdf' => 'PDF (URL)',
        'file' => 'Upload PDF File'
    ];
    $author = new Author();
    $author_list = $author->mightyGetRecord();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title"><?= isset($id) ? 'Edit' : 'Add' ?> Book</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form method="post"  action="" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $id ?>" />
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" value ="<?= isset($row) && isset($row['name'])  ? $row['name'] : '' ?>" placeholder="Enter Name" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control" name="category_id" required>
                                        <option value=""> Select Category</option>
                                        <?php
                                            foreach ($category_list as $k => $val) {
                                        ?>
                                            <option value="<?= $val['id'] ?>" <?php if(isset($row) && isset($row['category_id']) && ($val['id'] == $row['category_id'])) echo "selected" ?> > <?= $val['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="author_id">Author <span class="text-danger">*</span></label>
                                    <select class="form-control" name="author_id" required>
                                        <option value=""> Select Author</option>
                                        <?php
                                            foreach ($author_list as $k => $val) {
                                        ?>
                                            <option value="<?= $val['id'] ?>" <?php if(isset($row) && isset($row['author_id']) && ($val['id'] == $row['author_id'])) echo "selected" ?> > <?= $val['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="price" id="price" value ="<?= isset($row) && isset($row['price'])  ? $row['price'] : '' ?>" placeholder="Enter Price" required>
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label for="type">Type </label>
                                    <select class="form-control upload_type" name="type">
                                        <?php
                                            foreach ($type_list as $k => $val) {
                                        ?>
                                            <option value="<?= $k ?>" <?php if(isset($row) && isset($row['type']) && ($k == $row['type'])) echo "selected" ?> > <?= $val ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4 file_upload">
                                    <label for="file" class="form-label">Upload PDF</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="customFile" accept="application/pdf" name="file">
                                        <label class="custom-file-label" for="customFile"><?= isset($row) && isset($row['file']) ? $row['file'] : 'Choose pdf file' ?></label>
                                    </div>
                                </div>

                                <div class="form-group col-md-4 file_url">
                                    <label for="url" class="form-label">URL </label>
                                    <input type="url" class="form-control" name="url" id="url" value ="<?= isset($row) && isset($row['url']) ? $row['url'] : '' ?>" placeholder="Enter URL">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="image" class="form-label">Image</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="customFile" accept="image/*" name="logo">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                
                                <?php
                                    $logo = isset($row) && isset($row['logo']) ? $row['logo'] : 'default.png';
                                    $path = '../upload/book/';
                                ?>
                                <div class="form-group col-md-4 mt-3">
                                    <div class="mm-avatar">
                                        <img class="avatar-60 rounded logo_preview" src="<?= $path.$logo ?>" alt="#" data-original-title="" title="">
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description" rows="3" ><?= isset($row) && isset($row['description'])  ? $row['description'] : '' ?></textarea>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Is Popular? </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="is_popular" id="is_popular" <?= (isset($row) && isset($row['is_popular']) && $row['is_popular'] == 1 ) || ( $id == null ) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="is_popular"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Is Featured? </label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="is_featured" id="is_featured" <?= (isset($row) && isset($row['is_featured']) && $row['is_featured'] == 1 ) || ( $id == null ) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="is_featured"></label>
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