<?php
    require('../model/AppSetting.php');
    require('../model/Category.php');
    require('../model/Author.php');
    require('../model/Book.php');
    require('../model/Slider.php');
    
    $master_array = [];

    $appsetting = new AppSetting();
    $appsetting_records = $appsetting->mightyQuery("SELECT * FROM `app_settings`");
    
    if($appsetting_records->num_rows > 0){
        foreach( $appsetting_records as $k => $val ){
            $value = json_decode($val['value']);
            $master_array[$val['key']] = $value;
        }
    }

    $apiconfiguration = $appsetting->mightyGetByKey('apiconfiguration');
    $value = isset($apiconfiguration) ? json_decode($apiconfiguration['value']) : null;
    $limit = isset($value) ? $value->limit : 10;

    $category_order = isset($value) ? $value->category_order : 'ASC';
    $category_orderby = isset($value) ? $value->category_orderby : 'id';

    $slider = new Slider();
    $slider_records = $slider->mightyGetRecords([ 'status' => 1 ]);
    $master_array['slider'] = $slider_records;
    
    $book_order = isset($value) && isset($value->book_order) ? $value->book_order : 'ASC';
    $book_orderby = isset($value) && isset($value->book_orderby) ? $value->book_orderby : 'id';

    $book = new Book();
    $book_records = $book->mightyGetRecords([ 'is_popular' => 1, 'order' => $book_order, 'order_by' => $book_orderby ]);

    $master_array['popular_book'] = $book_records;

    $featured_book = $book->mightyGetRecords([ 'is_featured' => 1, 'order' => $book_order, 'order_by' => $book_orderby ]);
    $master_array['featured_book'] = $featured_book;
    
    $latest_book = $book->mightyGetRecords([ 'order' => 'DESC', 'order_by' => 'id' ]);
    $master_array['latest_book'] = $latest_book;
    
    $category = new Category();
    $category_record = $category->mightyGetRecords( ['order' => $category_order, 'order_by' => $category_orderby ] );
    $category_list = [];
    foreach ($category_record as $key => $value) {
        $value['book'] = [];
        $value['book'] = $book->mightyGetRecords([ 'category_id' => $value['id'], 'order' => $book_order, 'order_by' => $book_orderby ]);
        $category_list[] = $value;
    }

    $master_array['category'] = $category_list;

    $author_order = isset($value) && isset($value->author_order) ? $value->author_order : 'ASC';
    $author_orderby = isset($value) && isset($value->author_orderby) ? $value->author_orderby : 'id';
    
    $author = new Author();
    $author_record = $author->mightyGetRecords();
    $master_array['author'] = $author_record;

    $newJsonString = json_encode($master_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
    http_response_code(200);
    echo $newJsonString;
    
    die;