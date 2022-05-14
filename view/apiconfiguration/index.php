<?php
require_once('../configuration/Connection.php');
require_once('../model/AppSetting.php');

$app_setting = new AppSetting();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_POST['type'] = 'apiconfiguration';
        $app_setting->setFields($_POST);
        $app_setting->mightySave();
    }
    $result = $app_setting->mightyGetByKey('apiconfiguration');
    if( $result != null ) {
        $value = json_decode($result['value']);
        $category_order = isset($value->category_order) && $value->category_order != '' ? $value->category_order : 'ASC';
        $category_orderby = isset($value->category_orderby) && $value->category_orderby != '' ? $value->category_orderby : 'id';
        $author_order = isset($value->author_order) && $value->author_order != '' ? $value->author_order : 'ASC';
        $author_orderby = isset($value->author_orderby) && $value->author_orderby != '' ? $value->author_orderby : 'id';
        $book_order = isset($value->book_order) && $value->book_order != '' ? $value->book_order : 'ASC';
        $book_orderby = isset($value->book_orderby) && $value->book_orderby != '' ? $value->book_orderby : 'id';
    } else {
        $value = null;
        $category_order = $author_order = $book_order = 'ASC';
        $category_orderby = $author_orderby = $book_orderby = 'id';
    }

    $order = [
        [ 
            'value' => 'ASC',
            'label' => 'ASC'
        ],
        [ 
            'value' => 'DESC',
            'label' => 'DESC'
        ]
    ];

    $orderby = [
        [ 
            'value' => 'id',
            'label' => 'ID'
        ],
        [ 
            'value' => 'name',
            'label' => 'Name'
        ]
    ];
   
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">API Configuration</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="new-user-info">
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="limit" class="form-label">Pagination Limit</label>
                                        <input name="value[limit]" id="limit" type="number" class="form-control" value="<?= isset($value) && isset($value->limit)  ? $value->limit : '10' ?>" placeholder="Enter Pagination Limit">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="category_order" class="form-label">Category Order </label>
                                    <div class="form-group">
                                        <?php 
                                        foreach ($order as $a => $opt) {
                                            $selected = ($category_order == $opt['value']) ? "checked" : "";
                                        ?>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="category_order_radio_<?= $a ?>" name="value[category_order]"  value="<?= $opt['value'] ?>" <?= $selected ?>  class="custom-control-input">
                                            <label class="custom-control-label" for="category_order_radio_<?= $a ?>" > <?= $opt['label'] ?> </label>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="category_orderby" class="form-label">Category Order By </label>
                                    <div class="form-group">
                                        <?php 
                                        foreach ($orderby as $a => $opt) {
                                            $selected = ($category_orderby == $opt['value']) ? "checked" : "";
                                        ?>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="category_orderby_radio_<?= $a ?>" name="value[category_orderby]"  value="<?= $opt['value'] ?>" <?= $selected ?>  class="custom-control-input">
                                            <label class="custom-control-label" for="category_orderby_radio_<?= $a ?>" > <?= $opt['label'] ?> </label>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="book_order" class="form-label">Book Order </label>
                                    <div class="form-group">
                                        <?php 
                                        foreach ($order as $a => $opt) {
                                            $selected = ($book_order == $opt['value']) ? "checked" : "";
                                        ?>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="book_order_radio_<?= $a ?>" name="value[book_order]"  value="<?= $opt['value'] ?>" <?= $selected ?>  class="custom-control-input">
                                            <label class="custom-control-label" for="book_order_radio_<?= $a ?>" > <?= $opt['label'] ?> </label>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="book_orderby" class="form-label">Book Order By </label>
                                    <div class="form-group">
                                        <?php 
                                        foreach ($orderby as $a => $opt) {
                                            $selected = ($book_orderby == $opt['value']) ? "checked" : "";
                                        ?>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="book_orderby_radio_<?= $a ?>" name="value[book_orderby]"  value="<?= $opt['value'] ?>" <?= $selected ?>  class="custom-control-input">
                                            <label class="custom-control-label" for="book_orderby_radio_<?= $a ?>" > <?= $opt['label'] ?> </label>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="author_order" class="form-label">Author Order </label>
                                    <div class="form-group">
                                        <?php 
                                        foreach ($order as $a => $opt) {
                                            $selected = ($author_order == $opt['value']) ? "checked" : "";
                                        ?>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="author_order_radio_<?= $a ?>" name="value[author_order]"  value="<?= $opt['value'] ?>" <?= $selected ?>  class="custom-control-input">
                                            <label class="custom-control-label" for="author_order_radio_<?= $a ?>" > <?= $opt['label'] ?> </label>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="author_orderby" class="form-label">Author Order By </label>
                                    <div class="form-group">
                                        <?php 
                                        foreach ($orderby as $a => $opt) {
                                            $selected = ($author_orderby == $opt['value']) ? "checked" : "";
                                        ?>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="author_orderby_radio_<?= $a ?>" name="value[author_orderby]"  value="<?= $opt['value'] ?>" <?= $selected ?>  class="custom-control-input">
                                            <label class="custom-control-label" for="author_orderby_radio_<?= $a ?>" > <?= $opt['label'] ?> </label>
                                        </div>
                                        <?php
                                            }
                                        ?>
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