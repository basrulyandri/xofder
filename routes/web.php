<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::post('addtocart', [
	'uses' => 'CartController@addtocart',
	'as'	 => 'ajax.post.addtocart'
]);

Route::post('substractqty', [
	'uses' => 'CartController@substractqty',
	'as'	 => 'ajax.post.substractqty'
]);

Route::post('removefromcart', [
		'uses' => 'CartController@removefromcart',
		'as' => 'ajax.post.removefromcart',
	]);

Route::get('/', [	
	'uses' => 'PageController@home',
	'as' => 'home',	
]);

Route::get('page/login', [
		'uses' => 'PageController@login',
		'as' => 'page.login',
	]);
Route::post('page/login', [
		'uses' => 'PageController@postlogin',
		'as' => 'page.post.login',
	]);
Route::get('page/register', [
		'uses' => 'PageController@register',
		'as' => 'page.register',
	]);
Route::post('page/register', [
		'uses' => 'PageController@postregister',
		'as' => 'page.post.register',
	]);
Route::get('kategori/{slug}', [
		'uses' => 'PageController@category',
		'as' => 'page.category',
	]);
Route::get('search', [
		'uses' => 'PageController@search',
		'as' => 'page.search',
	]);

Route::group(['middleware' => 'rbac'],function(){
	Route::get('roles',[
		'uses' => 'RoleController@index',
		'as' => 'roles.index',
	]);
	Route::get('dashboard', [
		'uses' => 'DashboardController@index',
		'as' => 'dashboard.index',
	]);	

	Route::get('users',[
		'uses' =>  'UserController@index',
		'as' => 'users.index'
	]);

	Route::get('user/add',[
		'uses' => 'UserController@add',
		'as' => 'user.add',
	]);

	Route::post('user/create',[
		'uses' => 'UserController@create',
		'as' => 'user.create'
	]);

	Route::get('user/{user}/edit', [
			'uses' => 'UserController@edit',
			'as' => 'user.edit',
		]);
	Route::post('user/{user}/update', [
			'uses' => 'UserController@update',
			'as' => 'user.update',
		]);
	

	Route::post('user/updatephoto',[
		'uses' => 'UserController@updatePhoto',
		'as' => 'user.updatephoto'
	]);
	Route::get('user/{username}',[
		'uses' => 'UserController@profile',
		'as' => 'user.profile'
	]);

	Route::get('role/add',[
		'uses' => 'RoleController@add',
		'as' => 'role.add',
	]);

	Route::post('role/create',[
		'uses' => 'RoleController@create',
		'as' => 'role.create',
	]);
	Route::get('role/{id}/edit',[
		'uses' => 'RoleController@edit',
		'as' => 'role.edit'
	]);

	Route::post('role/{id}/update',[
		'uses' => 'RoleController@update',
		'as' => 'role.update'
	]);

	Route::get('role/{id}/delete',[
		'uses' => 'RoleController@delete',
		'as' => 'role.delete'
	]);	

	Route::get('permissions',[
		'uses' => 'PermissionController@index',
		'as' => 'permissions.index'
	]);

	Route::get('permission/add',[
		'uses' => 'PermissionController@add',
		'as' => 'permission.add'
	]);

	Route::post('permission/create',[
		'uses' => 'PermissionController@create',
		'as' => 'permission.create',
	]);

	Route::get('/permission/{id}/edit',[
		'uses' => 'PermissionController@edit',
		'as' => 'permission.edit',
	]);

	Route::post('permission/{id}/update',[
		'uses' => 'PermissionController@update',
		'as' => 'permission.update',
	]);

	Route::get('permission/{id}/delete',[
		'uses' => 'PermissionController@delete',
		'as' => 'permission.delete',
	]);

	Route::get('anggota', [
			'uses' => 'AnggotaController@index',
			'as' => 'anggota.index',
		]);

	Route::get('products', [
			'uses' => 'ProductController@index',
			'as' => 'products.index',
		]);

	Route::get('product/{product}/view', [
			'uses' => 'ProductController@view',
			'as' => 'product.view',
		]);

	Route::get('product/add', [
			'uses' => 'ProductController@add',
			'as' => 'product.add',
		]);

	Route::post('product/add', [
			'uses' => 'ProductController@postadd',
			'as' => 'post.product.add',
		]);

	Route::get('product/{product}/edit', [
			'uses' => 'ProductController@edit',
			'as' => 'product.edit',
		]);

	Route::post('product/{product}/update', [
			'uses' => 'ProductController@update',
			'as' => 'post.product.update',
		]);

	Route::get('product/{product}/addstocks', [
			'uses' => 'ProductController@addstocks',
			'as' => 'product.addstocks',
		]);

	Route::post('product/addstocks', [
			'uses' => 'ProductController@postaddstock',
			'as' => 'post.product.addstock',
		]);

	Route::get('product/editstock/{stock}', [
			'uses' => 'ProductController@editstock',
			'as' => 'product.edit.stock',
		]);

	Route::post('product/updatestock/{stock}', [
			'uses' => 'ProductController@updatestock',
			'as' => 'product.update.stock',
		]);

	Route::get('stock/{stock}/delete', [
			'uses' => 'StockController@delete',
			'as' => 'stock.delete',
		]);

	Route::get('orders', [
			'uses' => 'OrderController@index',
			'as' => 'orders.index',
		]);

	Route::get('order/{order}/view', [
			'uses' => 'OrderController@view',
			'as' => 'order.view',
		]);

	Route::group(['prefix' => config('rollo-inventor.KASIR_PREFIX_URL')], function () {
	    Route::get('/', [
	    		'uses' => 'KasirController@index',
	    		'as' => 'kasir.index',
	    	]);
	    Route::get('/quick', [
	    	'uses' => 'KasirController@quick',
	    	'as' => 'kasir.quick',
	    ]);	   

	    Route::get('/tocustomer', [
	     		'uses' => 'KasirController@tocustomer',
	     		'as' => 'kasir.to.customer',
	     	]); 

	    Route::get('/tostore', [
	    		'uses' => 'KasirController@tostore',
	    		'as' => 'kasir.tostore',
	    	]);

	    
	    Route::get('/save', [
	    		'uses' => 'KasirController@save',
	    		'as' => 'kasir.save',
	    	]);	    
	    Route::post('/save/tocustomer', [
	    		'uses' => 'KasirController@savetocustomer',
	    		'as' => 'kasir.save.to.customer',
	    	]);	    

	    Route::get('/finish', [
	    		'uses' => 'KasirController@finish',
	    		'as' => 'kasir.finish',
	    	]);
	    Route::get('/finishtocustomer', [
	    		'uses' => 'KasirController@finishtocustomer',
	    		'as' => 'kasir.finish.to.customer',
	    	]);

	    Route::post('/finishfinaltocustomer', [
	    		'uses' => 'KasirController@finishfinaltocustomer',
	    		'as' => 'kasir.finish.final.tocustomer',
	    	]);

	    Route::post('/finishtostore', [
	    		'uses' => 'KasirController@finishtostore',
	    		'as' => 'kasir.finish.to.store',
	    	]);

	    Route::get('/penjualan/hari-ini', [
	    		'uses' => 'KasirController@penjualanhariini',
	    		'as' => 'penjualan.hari.ini',
	    	]);

	    Route::get('/penjualan/semua', [
	    		'uses' => 'KasirController@penjualansemua',
	    		'as' => 'penjualan.semua',
	    	]);

	    Route::get('penjualan/edit/{order}', [
	    		'uses' => 'KasirController@editpenjualan',
	    		'as' => 'penjualan.edit',
	    	]);

	    Route::post('penjualan/update/', [
	    		'uses' => 'KasirController@updatepenjualan',
	    		'as' => 'post.penjualan.update',
	    	]);

	    Route::get('penjualan/detail/{order}', [
	    		'uses' => 'KasirController@penjualandetail',
	    		'as' => 'penjualan.detail',
	    	]);

	    Route::get('penjualan/{order}/bayar', [
	    		'uses' => 'KasirController@bayarhutangpenjualan',
	    		'as' => 'kasir.bayar.hutang.penjualan',
	    	]);

	    Route::post('penjualan/post/bayar', [
	    		'uses' => 'KasirController@postbayarhutangpenjualan',
	    		'as' => 'kasir.post.bayar.hutang.penjualan',
	    	]);

	    Route::get('penjualan/{order}/delete', [
	    		'uses' => 'KasirController@deleteorder',
	    		'as' => 'kasir.penjualan.delete',
	    	]);

	    Route::get('stocks/', [
	    		'uses' => 'KasirController@stocks',
	    		'as' => 'kasir.stocks.index',
	    	]);
	    Route::get('stock/product/{product}/view', [
	    		'uses' => 'KasirController@stockproductview',
	    		'as' => 'kasir.stock.product.view',
	    	]);

	    Route::get('product/{product}/addstock', [
	    		'uses' => 'KasirController@addproductstock',
	    		'as' => 'kasir.product.addstock',
	    	]);
	});
});

Route::get('login',[
	'uses' => 'AuthController@login',
	'as' => 'auth.login',
	'middleware' => 'guest',
]);

Route::post('dologin',[
	'uses' => 'AuthController@dologin',
	'as' => 'auth.dologin',
]);
Route::get('logout',[
	'uses' => 'AuthController@logout',
	'as' => 'auth.logout',
]);

Route::get('request/resetpassword', [
		'uses' => 'UserController@requestresetpassword',
		'as' => 'request.reset.password',
	]);

Route::post('request/resetpassword', [
		'uses' => 'UserController@postrequestresetpassword',
		'as' => 'post.request.reset.password',
	]);
Route::get('resetpassword/{reset_password_code}',[
	'uses' => 'UserController@resetpassword',
	'as' => 'reset.password',
]);

Route::post('resetpassword/{reset_password_code}',[
	'uses' => 'UserController@postresetpassword',
	'as' => 'post.reset.password',
]);

Route::get('order/{order}/print', [
		'uses' => 'OrderController@cetak',
		'as' => 'order.print',
	]);

// Ajax

Route::post('ajax/category/select', [
		'uses' => 'CategoryController@ajaxSelect',
		'as' => 'ajax.category.select',
	]);

Route::post('ajax/addtocart', [
		'uses' => 'CartController@addtocart',
		'as' => 'ajax.post.addtocart',
	]);

//retrieve all cart session
Route::get('ajax/getcartsession', [
		'uses' => 'CartController@getcartsession',
		'as' => 'ajax.get.cart.session',
	]);

Route::post('ajax/qty/edit', [
		'uses' => 'CartController@ajaxqtyedit',
		'as' => 'ajax.qty.edit',
	]);

Route::post('ajax/harga/edit', [
		'uses' => 'CartController@ajaxhargaedit',
		'as' => 'ajax.harga.edit',
	]);

Route::post('ajax/removeitem', [
		'uses' => 'CartController@ajaxremoveitem',
		'as' => 'ajax.post.removeitem',
	]);

Route::get('getcustomername', [
		'uses' => 'KasirController@getCustomerNameAutocomplete',
		'as' => 'ajax.autocomplete.get.customer.name',
	]);

Route::post('ajaxaddcustomertocart', [
		'uses' => 'CartController@ajaxaddcustomertocart',
		'as' => 'ajax.add.customer.to.cart',
	]);
