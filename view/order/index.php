<?php
    // get database connection
    include_once '../configuration/DatabaseApi.php';
    // instantiate order object
    include_once '../model/Order.php';

    $database = new DatabaseApi();
    $db = $database->getConnection();
    
    // initialize object
    $order = new Order($db);
    
    // read Orders will be here
    // query Orders
    $stmt = $order->readDetail('pending');
   
    $num = $stmt->rowCount();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
           <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title mb-0">Pending Order List</h4>
                    </div>
                    <!-- <a href="?page=book_create" class="btn btn-primary">Add New</a> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="" class="table data-table table-bordered">
                            <thead>
                                <tr>
                                    <th data-orderable="false">Book</th>
                                    <th>Book Conver</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th data-orderable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if($num > 0){
                                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                            <tr>
                                                <td><?= $data['book_name'] ?></td>
                                                <td>
                                                    <div class="mm-avatar col-md-2">
                                                        <img class="avatar-40 rounded" src="../upload/book/<?= $data['book_logo'] ?>" alt="#img" data-original-title="" title="">
                                                    </div>    
                                                </td>
                                                <td><?= $data['price'] ?></td>
                                                <td><?= $data['amount'] ?></td>
                                                <td><?= $data['first_name'].' '.$data['last_name'] ?></td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                                <td><?= $data['create_dt'] ?></td>
                                                <td>
                                                <div class="d-flex align-items-center list-action">
                                                        <!-- <a class="badge bg-secondary-light mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Send Notification" href="?page=onesignal_send&book_id=<?= $data['id'] ?>" ><i class="las la-bell"></i></a> -->
                                                        <a class="badge bg-primary-light mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="?page=order_create&id=<?= $data['id'] ?>" ><i class="las la-edit"></i></a>
                                                        <!-- <a class="badge bg-danger-light mr-2" data-toggle="modal" data-target="#exampleModal<?= $data['id'] ?>" data-placement="top" title="" data-original-title="Delete" href="#"><i class="las la-trash-alt"></i></a> -->
                                                    </div>
                                                </td>
                                                <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal<?= $data['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Book</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form id="exapleFormModal<?= $data['id'] ?>" method="post" action="">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id" value="<?= $data['id'] ?>" />
                                                                        <h4>Are you sure want to delete ?</h4> 
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php 
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>