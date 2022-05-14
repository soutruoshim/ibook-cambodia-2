<?php
    require('../model/Author.php');
    require('../model/AppSetting.php');
    
    $author = new Author();

    $appsetting = new AppSetting();
    $apiconfiguration = $appsetting->mightyGetByKey('apiconfiguration');
    $value = isset($apiconfiguration) ? json_decode($apiconfiguration['value']) : null;

    $author_order = isset($value) ? $value->author_order : 'ASC';
    $author_orderby = isset($value) ? $value->author_orderby : 'id';
    $limit = isset($value) ? $value->limit : 10;

    $params = [
        'page' => isset($_GET) && isset($_GET['page']) ? $_GET['page'] : '1',
        'order' => isset($_GET) && isset($_GET['order']) ? $_GET['order'] : $author_order,
        'order_by' => isset($_GET) && isset($_GET['order_by']) ? $_GET['order_by'] : $author_orderby,
        'limit' => isset($_GET) && isset($_GET['limit']) ? $_GET['limit'] : $limit
    ];
    
    $author_records = $author->mightyGetRecords($params);
    
    $master_array = $author_records;

    $newJsonString = json_encode($master_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
    http_response_code(200);
    echo $newJsonString;
    die;
    header("Location: ../index.php");