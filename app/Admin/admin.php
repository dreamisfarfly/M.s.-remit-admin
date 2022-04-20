<?php
/**
 * 后台
 */
use Illuminate\Support\Facades\Route;

/**
 * 登录
 */
Route::post('login','AdminUserController@login');

/**
 * 需要登录的接口
 */
Route::middleware('adminVerifyToken')->group(function(){

    /**
     * 用户信息列表
     */
    Route::get('userinfo','UserController@listview');

    /**
     * 上传
     */
    Route::post('uploadImg','CommonsController@uploadImg');

    /**
     * 上传
     */
    Route::post('uploadsImg','CommonsController@uploadsImg');

    /**
     * 分类管理
     */
    Route::prefix('classify')->group(function(){

        /**
         * 列表
         */
        Route::get('/','ClassifyController@listview');

        /**
         * 详情
         */
        Route::get('/{id}','ClassifyController@show')->where(['id'=>'[0-9]+']);

        /**
         * 删除
         */
        Route::delete('/{id}','ClassifyController@delete')->where(['id'=>'[0-9]+']);

        /**
         * 更新状态
         */
        Route::put('/status/{id}','ClassifyController@changeState')->where(['id'=>'[0-9]+']);

        /**
         * 更新
         */
        Route::put('/{id}','ClassifyController@update')->where(['id'=>'[0-9]+']);

        /**
         * 新增
         */
        Route::post('/','ClassifyController@add');

        /**
         * 分类
         */
        Route::get('/list','ClassifyController@classifyList');

    });

    /**
     * 反馈管理
     */
    Route::prefix('feedback')->group(function(){

        /**
         * 列表
         */
        Route::get('/','FeedbackController@listview');

        /**
         * 处理
         */
        Route::put('/dispose/{id}','FeedbackController@dispose')->where(['id'=>'[0-9]+']);

    });

    /**
     * 设计师
     */
    Route::prefix('designer')->group(function(){

        /**
         * 列表
         */
        Route::get('/','DesignerController@listview');

        /**
         * 详情
         */
        Route::get('/{id}','DesignerController@show')->where(['id'=>'[0-9]+']);

        /**
         * 删除
         */
        Route::delete('/{id}','DesignerController@del')->where(['id'=>'[0-9]+']);

        /**
         * 推荐
         */
        Route::put('/recommend/{id}','DesignerController@recommend')->where(['id'=>'[0-9]+']);

        /**
         * 更改状态
         */
        Route::put('/status/{id}','DesignerController@changeState')->where(['id'=>'[0-9]+']);

        /**
         * 更新
         */
        Route::put('/{id}','DesignerController@update')->where(['id'=>'[0-9]+']);

        /**
         * 添加
         */
        Route::post('/','DesignerController@add')->where(['id'=>'[0-9]+']);

        /**
         * 列表
         */
        Route::get('/listview','DesignerController@designerListview');


    });

    /**
     * 反馈问题管理
     */
    Route::prefix('problemFeedback')->group(function(){

        /**
         * 列表
         */
        Route::get('/','ProblemFeedbackController@listview');

        /**
         * 详情
         */
        Route::get('/{id}','ProblemFeedbackController@show')->where(['id'=>'[0-9]+']);

        /**
         * 删除
         */
        Route::delete('/{id}','ProblemFeedbackController@del')->where(['id'=>'[0-9]+']);

        /**
         * 状态
         */
        Route::put('/status/{id}','ProblemFeedbackController@updateStatus')->where(['id'=>'[0-9]+']);

        /**
         * 更新
         */
        Route::put('/{id}','ProblemFeedbackController@updated')->where(['id'=>'[0-9]+']);

        /**
         * 新增
         */
        Route::post('/','ProblemFeedbackController@add');

    });

    /**
     * 工长管理
     */
    Route::prefix('foreman')->group(function(){

        /**
         * 列表
         */
        Route::get('/','ForemanController@listview');

        /**
         * 删除
         */
        Route::delete('/{id}','ForemanController@del')->where(['id'=>'[0-9]+']);

        /**
         * 添加
         */
        Route::post('/','ForemanController@add');

        /**
         * 详情
         */
        Route::get('/{id}','ForemanController@show')->where(['id'=>'[0-9]+']);

        /**
         * 分类
         */
        Route::get('/classify','ForemanController@classify');

        /**
         * 更新
         */
        Route::put('/{id}','ForemanController@update')->where(['id'=>'[0-9]+']);


    });

    /**
     * 作品管理
     */
    Route::prefix('production')->group(function(){

        /**
         * 列表
         */
        Route::get('/','ProductionController@listview');

        /**
         * 删除
         */
        Route::delete('/{id}','ProductionController@del');

        /**
         * 添加
         */
        Route::post('/','ProductionController@add');

        /**
         * 详情
         */
        Route::get('/{id}','ProductionController@show')->where(['id'=>'[0-9]+']);

        /**
         * 更新
         */
        Route::put('/{id}','ProductionController@edit')->where(['id'=>'[0-9]+']);

    });

    /**
     * 案例
     */
    Route::prefix('case')->group(function(){

        /**
         * 列表
         */
        Route::get('/','CaseController@listview');

        /**
         * 删除
         */
        Route::delete('/{id}','CaseController@del')->where(['id'=>'[0-9]+']);

        /**
         * 详情
         */
        Route::get('/{id}','CaseController@show')->where(['id'=>'[0-9]+']);

        /**
         * 更新
         */
        Route::put('/{id}','CaseController@edit')->where(['id'=>'[0-9]+']);

        /**
         * 添加
         */
        Route::post('/','CaseController@add');

    });

    /**
     * 商品
     */
    Route::prefix('goods')->group(function(){

        /**
         * 列表
         */
        Route::get('/','GoodsController@listview');

        /**
         * 删除
         */
        Route::delete('/{id}','GoodsController@del')->where(['id'=>'[0-9]+']);

        /**
         * 详情
         */
        Route::get('/{id}','GoodsController@show')->where(['id'=>'[0-9]+']);

        /**
         * 更新
         */
        Route::put('/{id}','GoodsController@edit')->where(['id'=>'[0-9]+']);

        /**
         * 添加
         */
        Route::post('/','GoodsController@add');

        /**
         * 分类
         */
        Route::get('/classify/','GoodsController@classifyListview');

    });

    /**
     * 团购商品
     */
    Route::prefix('groupActivity')->group(function(){

        /**
         * 列表
         */
        Route::get('/','GroupActivityController@listview');

        /**
         * 添加
         */
        Route::post('/','GroupActivityController@add');

        /**
         * 详情
         */
        Route::get('/{id}','GroupActivityController@show')->where(['id'=>'[0-9]+']);

        /**
         * 更新
         */
        Route::put('/{id}','GroupActivityController@update')->where(['id'=>'[0-9]+']);

        /**
         * 删除
         */
        Route::delete('/{id}','GroupActivityController@del')->where(['id'=>'[0-9]+']);

    });

    /**
     * 订单
     */
    Route::prefix('order')->group(function(){

        /**
         * 列表
         */
        Route::get('/','OrderController@listview');

        /**
         * 列表
         */
        Route::get('/goodsList','OrderInfoController@listview');

    });

    /**
     * 横幅管理
     */
    Route::prefix('banner')->group(function(){

        /**
         * 列表
         */
        Route::get('/','BannerController@listview');

        /**
         * 更改状态
         */
        Route::put('/status/{id}','BannerController@changeState')->where(['id'=>'[0-9]+']);

        /**
         * 删除
         */
        Route::delete('/{id}','BannerController@del')->where(['id'=>'[0-9]+']);

        /**
         * 新增
         */
        Route::post('/','BannerController@append');

        /**
         * 详情
         */
        Route::get('/{id}','BannerController@details')->where(['id'=>'[0-9]+']);

        /**
         * 更新轮播图
         */
        Route::put('/{id}','BannerController@update')->where(['id'=>'[0-9]+']);

    });

    /**
     * 用户
     */
    Route::prefix('user')->group(function(){

        /**
         * 用户信息
         */
        Route::get('info','AdminUserController@info');

       /**
        * 退出登录
        */
        Route::post('logout','AdminUserController@logout');

    });

    /**
     * 热门推荐
     */
    Route::prefix('hot')->group(function(){

        /**
         * 列表
         */
        Route::get('/','HotController@listview');

        /**
         * 添加
         */
        Route::post('/','HotController@add');

        /**
         * 详情
         */
        Route::get('/{id}','HotController@show');

        /**
         * 更新
         */
        Route::put('/{id}','HotController@update');

        /**
         * 删除
         */
        Route::delete('/{id}','HotController@del');

    });

    Route::get('getRouters','SysMenuController@getRouters');


});
