<?php

Route::group(['prefix'=>'example'],function(){


    Route::match(['get','post'],'exampleAdd',[
        'as'=>'exampleAdd',
        'uses'=>'ExampleController@exampleAdd'
    ]);

    Route::match(['get','post'],'exampleDelete',[
        'as'=>'exampleDelete',
        'uses'=>'ExampleController@exampleDelete'
    ]);

    Route::match(['get','post'],'exampleUpdate',[
        'as'=>'exampleUpdate',
        'uses'=>'ExampleController@exampleUpdate'
    ]);

    Route::get('exampleList',[
        'as'=>'exampleList',
        'uses'=>'ExampleController@exampleList'
    ]);

});

