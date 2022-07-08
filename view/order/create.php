<?php
    // get database connection
    include_once '../configuration/DatabaseApi.php';
    // instantiate order object
    include_once '../model/Order.php';

    $database = new DatabaseApi();
    $db = $database->getConnection();

    // initialize object
    $order = new Order($db);

    $id = isset($_GET) && isset($_GET['id']) ? $_GET['id'] : null;
    $order->id = $id;
    $row = $order->readOneDetail();
    
    //var_dump($row);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $order->status = $_POST['status'];
        $order->payment_status = 'paid';
        $order->updateStatus();
    }

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title"><?= isset($id) ? 'Edit' : 'Add' ?> Order</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form method="post"  action="" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $id ?>" />
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Book title <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="book_name" id="book_name" value ="<?= isset($row) && isset($row['book_name'])  ? $row['book_name'] : '' ?>" placeholder="Book title" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Price <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="price" id="price" value ="<?= isset($row) && isset($row['price'])  ? $row['price'] : '' ?>" placeholder="Price" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Amount <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="amount" id="amount" value ="<?= isset($row) && isset($row['amount'])  ? $row['amount'] : '' ?>" placeholder="Amount" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Customer <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="customer" id="customer" value ="<?= isset($row) && isset($row['first_name'])  ? $row['first_name'].' '. $row['last_name'] : '' ?>" placeholder="Book title" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name" class="form-label">Booking Date <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="booking_date" id="booking_date" value ="<?= isset($row) && isset($row['create_dt'])  ? $row['create_dt'] : '' ?>" placeholder="Book title" disabled>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status" required>
                                        <option value="">Status</option>
                                        <option value="pending" <?php if(isset($row) && isset($row['status']) && ($row['status'] == 'pending')) echo "selected" ?> > Pending</option>
                                        <option value="confirm" <?php if(isset($row) && isset($row['status']) && ($row['status'] == 'confirm')) echo "selected" ?> > Confirm</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <?php
                                    $logo = isset($row) && isset($row['paid_document']) ? $row['paid_document'] : 'default.png';
                                    $path = '../upload/';
                                ?>
                                <div class="form-group col-md-4 mt-3">
                                    <div class="">
                                        <img class="rounded logo_preview" src="<?= $logo ?>" alt="#" data-original-title="" title="" width="150" height="200">
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