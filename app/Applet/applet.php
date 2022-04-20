<?php
/**
 * 小程序
 * 接口
 */
use Illuminate\Support\Facades\Route;

Route::get('test',function(){
   \App\Jobs\SpellGroupOrderQueue::dispatch('20211215013531703638');
});

/**
 * 热门推荐
 */
Route::get('hot','HotController@listview');

/**
 * 上传
 */
Route::post('uploadsImg','CommonsController@uploadsImg');

/**
 * 分类
 */
Route::get('classify','ClassifyController@classify');

/**
 * 意见反馈
 */
Route::get('problemFeedback','ProblemFeedbackController@listview');

/**
 * 横幅列表
 */
Route::get('banner','BannersController@listview');

/**
 * 登录
 */
Route::post('login','UsersController@login');

/**
 * 工长
 */
Route::get('foreman','ForemanController@listview');

/**
 * 案例
 */
Route::prefix('case')->group(function(){

    /**
     * 列表
     */
    Route::get('/','CaseController@listview');

    /**
     * 详情
     */
    Route::get('/{id}','CaseController@show')->where(['id'=>'[0-9]+']);

});

/**
 * 设计师
 */
Route::prefix('designer')->group(function(){

    /**
     * 优秀设计师
     */
    Route::get('excellent','DesignerController@excellentDesigner');

    /**
     * 列表
     */
    Route::get('/','DesignerController@listview');

    /**
     * 详情
     */
    Route::get('/{id}','DesignerController@show')->where(['id'=>'[0-9]+']);

    /**
     * 作品
     */
    Route::get('/production/{id}','ProductionController@designerListView')->where(['id'=>'[0-9]+']);

    /**
     * 作品详情
     */
    Route::get('/production/show/{id}','ProductionController@show')->where(['id'=>'[0-9]+']);

});

/**
 * 作品
 */
Route::prefix('production')->group(function(){

    /**
     * 列表
     */
    Route::get('/','ProductionController@listview');

});

/**
 * 团购商品
 */
Route::prefix('groupActivity')->group(function (){

    /**
     * 列表
     */
    Route::get('/','GroupActivityController@listview');

    /**
     * 推荐
     */
    Route::get('/recommend','GroupActivityController@recommendListview');

    /**
     * 详情
     */
    Route::get('/{id}','GroupActivityController@show')->where(['id'=>'[0-9]+']);

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
     * 详情
     */
    Route::get('/{id}','GoodsController@show')->where(['id'=>'[0-9]+']);

});

/**
 * 拼团
 */
Route::prefix('groupBooking')->group(function(){

    /**
     * 列表
     */
    Route::get('/list/{goodsId}','GroupBookingController@listview')->where(['goodsId'=>'[0-9]+']);

    /**
     * 列表
     */
    Route::get('/{id}','GroupBookingController@show')->where(['id'=>'[0-9]+']);

});

/**
 * 需要登录的接口
 */
Route::middleware('authenticationToken')->group(function(){

    /**
     * 意见反馈
     */
    Route::post('feedback','FeedbackController@feedback');

    /**
     * 用户信息
     */
    Route::get('userInfo','UsersController@userinfo');

    /**
     * 地址信息
     */
    Route::prefix('address')->group(function(){

        /**
         * 删除
         */
        Route::delete('/{id}','AddressController@del');

        /**
         * 列表
         */
        Route::get('/','AddressController@listview');

        /**
         * 添加
         */
        Route::post('/','AddressController@add');

        /**
         * 详情
         */
        Route::get('/{id}','AddressController@show')->where(['id'=>'[0-9]+']);

        /**
         * 更新
         */
        Route::put('/{id}','AddressController@edit')->where(['id'=>'[0-9]+']);

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
         * 删除订单
         */
        Route::delete('/{id}','OrderController@delOrder')->where(['id'=>'[0-9]+']);

        /**
         * 确认收货
         */
        Route::put('confirmReceipt/{id}','OrderController@confirmReceipt')->where(['id'=>'[0-9]+']);

        /**
         * 确认完成
         */
        Route::put('confirmCompleted/{id}','OrderController@confirmCompleted')->where(['id'=>'[0-9]+']);

        /**
         * 详情
         */
        Route::get('/{id}','OrderController@show')->where(['id'=>'[0-9]+']);

        /**
         * 订单信息
         */
        Route::get('/info/','OrderController@orderInformation');

        /**
         * 创建订单
         */
        Route::post('/','OrderController@createOrder');

        /**
         * 支付
         */
        Route::get('/pay/{id}','OrderController@pay')->where(['id'=>'[0-9]+']);

        /**
         * 取消支付
         */
        Route::delete('/cancelPayment/{id}','OrderController@cancelPayment')->where(['id'=>'[0-9]+']);


    });

});

