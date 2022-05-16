<?php
    require('../model/Book.php');
    require('../model/AppSetting.php');
    
    $appsetting = new AppSetting();
    $apiconfiguration = $appsetting->mightyGetByKey('apiconfiguration');
    $value = isset($apiconfiguration) ? json_decode($apiconfiguration['value']) : null;

    $order = isset($value) ? $value->order : 'ASC';
    $orderby = isset($value) ? $value->orderby : 'id';
    $limit = isset($value) ? $value->limit : 10;

    $params = [
        'is_popular'    => isset($_POST) && isset($_POST['is_popular']) ? $_POST['is_popular'] : null,
        'is_featured'   => isset($_POST) && isset($_POST['is_featured']) ? $_POST['is_featured'] : null,
        'category_id'   => isset($_POST) && isset($_POST['category_id']) ? $_POST['category_id'] : null,
        'order_by'      => isset($_POST) && isset($_POST['order_by']) ? $_POST['order_by'] : $orderby,
        'order'         => isset($_POST) && isset($_POST['order']) ? $_POST['order'] : $order,
        'category_ids'  => isset($_POST) && isset($_POST['category_ids']) ? json_decode($_POST['category_ids']) : [],
        'page'          => isset($_POST) && isset($_POST['page']) ? $_POST['page'] : 1,
        'limit'         => isset($_POST) && isset($_POST['limit']) ? $_POST['limit'] : $limit
    ];

    $book = new Book();
    $book_records = $book->mightyGetRecords($params);
    
    $master_array = $book_records;

    $newJsonString = json_encode($master_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
    http_response_code(200);
    echo $newJsonString;
    die;
    header("Location: ../index.php");