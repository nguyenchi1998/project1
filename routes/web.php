<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>'login'], function () {
   		Route::get('','LogIn@loginview')->name('login');
   		Route::post('loginprocess','LogIn@login')->name('loginprocess');
   		Route::get('doiMatKhau', 'LogIn@doiMatKhau')->name('doiMatKhau');
});
Route::get('logout','LogIn@logout')->name('logout');

Route::group(['prefix'=>'admin'],function(){

		//trang chủ
		Route::get('/','AdminController@index')->name('admin.index');
		Route::get('thongbaohoanthanhdiem','AdminController@danhsachthongbao')->name('admin.thongbao');
		Route::post('doimatkhau','AdminController@doimatkhau')->name('admin.doimatkhau');

		//Sinh viên
		Route::get('danhsachsinhvien','SinhVienController@danhsachsinhvien')->name('danhsachsinhvien');
		Route::get('danhsachsinhvientheolop','SinhVienController@danhsachsinhvientheolop')->name('danhsachsinhvientheolop');
		Route::get('themsinhvien','SinhVienController@viewthem')->name('viewthemsinhvien');
		Route::get('suasinhvien','SinhVienController@viewsua')->name('viewsuasinhvien');
		Route::post('themsinhvienprocess','SinhVienController@them')->name('themsinhvienprocess');
		Route::post('suasinhvienprocess','SinhVienController@sua')->name('suasinhvienprocess');
		Route::get('xoasinhvien','SinhVienController@xoa')->name('xoasinhvien');

		//Giáo viên
		Route::get('danhsachgiaovien','GiaoVienController@danhsachgiaovien')->name('danhsachgiaovien')->middleware('loginadmin');
		Route::get('danhsachgiaovien/timkiem','GiaoVienController@danhsachgiaovientheotukhoa')->name('timkiemgiaovien')->middleware('loginadmin');
		Route::get('themgiaovien','GiaoVienController@viewthem')->name('viewthemgiaovien')->middleware('loginadmin');
		Route::get('suagiaovien','GiaoVienController@viewsua')->name('viewsuagiaovien')->middleware('loginadmin');
		Route::post('themgiaovienprocess','GiaoVienController@them')->name('themgiaovienprocess')->middleware('loginadmin');
		Route::post('suagiaovienprocess','GiaoVienController@sua')->name('suagiaovienprocess')->middleware('loginadmin');
		Route::post('xoagiaovien','GiaoVienController@xoa')->name('xoagiaovien')->middleware('loginadmin');

		//Admin
		Route::get('danhsachadmin','AdminController@danhsachadmin')->name('danhsachadmin');
		Route::get('danhsachadmin/timkiem','AdminController@danhsachadmintheotukhoa')->name('timkiemadmin');
		Route::get('themadmin','AdminController@viewthem')->name('viewthemadmin');
		Route::post('themadminprocess','AdminController@them')->name('themadminprocess');
		Route::get('suaadmin','AdminController@viewsua')->name('viewsuaadmin');
		Route::post('suaadminprocess','AdminController@sua')->name('suaadminprocess');
		Route::post('xoaadmin','AdminController@xoa')->name('xoaadmin');

		//Môn học
		Route::get('danhsachmonhoc','MonHocController@danhsachmonhoc')->name('danhsachmonhoc');
		Route::get('themmonhoc','MonHocController@viewthem')->name('viewthemmonhoc');
		Route::get('danhsachmonhoctheochuyennganh','MonHocController@danhsachmonhoctheochuyennganh')->name('monhoc.loctheochuyennganh');
		Route::get('suamonhoc','MonHocController@viewsua')->name('viewsuamonhoc');
		Route::post('themmonhocprocess','MonHocController@them')->name('themmonhocprocess');
		Route::post('suamonhocprocess','MonHocController@sua');
		Route::get('xoamonhoc','MonHocController@xoa')->name('xoamonhoc');

		//Chuyên ngành
		Route::get('danhsachchuyennganh','ChuyenNganhController@danhsachchuyennganh')->name('danhsachchuyennganh');
		Route::get('danhsachchuyennganh/timkiem','ChuyenNganhController@danhsachchuyennganhtheotukhoa')->name('timkiemchuyennganh');
		Route::get('themchuyennganh','ChuyenNganhController@viewthem')->name('viewthemchuyennganh');
		Route::post('themchuyennganhprocess','ChuyenNganhController@them')->name('themchuyennganhprocess');
		Route::get('suachuyennganh','ChuyenNganhController@viewsua')->name('viewsuachuyennganh');
		Route::post('suachuyennganhprocess','ChuyenNganhController@sua')->name('suachuyennganhprocess');
		Route::post('xoachuyennganh','ChuyenNganhController@xoa')->name('xoachuyennganh');
		//Lớp
		Route::get('danhsachlop','LopController@danhsachlop')->name('danhsachlop');
		Route::get('danhsachloptheochuyennganh','LopController@danhsachloptheochuyennganh')->name('lop.loctheochuyennganh');
		Route::get('themlop','LopController@viewthem')->name('viewthemlop');
		Route::post('themlopprocess','LopController@them')->name('themlopprocess');
		Route::get('sualop','LopController@viewsua')->name('viewsualop');
		Route::post('sualopprocess','LopController@sua')->name('sualopprocess');
		Route::get('xoalop','LopController@xoa')->name('xoalop');
		//Lịch học
		Route::get('danhsachlich', 'LichHocController@danhsachlich')->name('admin.danhsachlich');
		Route::get('danhsachlich/lop', 'LichHocController@chonlop')->name('admin.danhsachlop');
		Route::get('themlich', 'LichHocController@viewthem')->name('viewthemlich');
		Route::post('themlichprocess', 'LichHocController@themprocess')->name('themlichprocess');
		Route::get('sualich', 'LichHocController@viewsua')->name('viewsualich');
		Route::post('sualichprocess', 'LichHocController@suaprocess')->name('sualichprocess');
		Route::get('xoalich', 'LichHocController@xoalich')->name('xoalich');
		//Điểm
		Route::get('diem','DiemController@chonchuyennganh')->name('admin.viewchonchyennganh');
		Route::get('diem/xem','DiemController@danhsachdiem')->name('admin.danhsachdiem');
		Route::get('diem/chon/lop','DiemController@danhsachlop')->name('admin.danhsachdiem.danhsachlop');
		Route::get('diem/chon/monhoc','DiemController@danhsachmonhoc')->name('admin.danhsachdiem.danhsachmonhoc');
		//Thống kê
		Route::get('thongketheochuyennganh','ThongKeController@chonchuyennganhvamonhoc')->name('thongketheochuyennganh');
		Route::get('thongketheochuyennganh/danhsachmonhoc','ThongKeController@danhsachmonhoctheochuyennganh')->name('thongketheochuyennganh.danhsachmonhoc');
		Route::get('thongketheochuyennganh/xem','ThongKeController@thongketheochuyennganh')->name('danhsachthongketheochuyennganh');
		Route::get('thongketheochuyennganh/xuatexcel','ThongKeController@thongketheochuyennganh_xuatExcel')->name('danhsachthongketheochuyennganh.xuatexcel');

		Route::get('thongketheolop','ThongKeController@chonlop')->name('thongketheolop');
		Route::get('thongketheolop/chonlop','ThongKeController@danhsachmonhoccualop')->name('danhsachmonhoccualop');
		Route::get('thongketheolop/xem','ThongKeController@thongketheolop')->name('danhsachthongketheolop');
		Route::get('thongketheolop/xuatexcel','ThongKeController@danhsachthongketheolop_xuatExcel')->name('danhsachthongketheolop.xuatexcel');
		
		Route::get('thongketheosinhvien','ThongKeController@viewthongketheosinhvien')->name('viewthongketheosinhvien');
		Route::get('danhsachthongketheosinhvien','ThongKeController@danhsachthongketheosinhvien')->name('danhsachsinhvienthongke');
		Route::get('thongketheosinhvien/xem','ThongKeController@thongketheosinhvien')->name('danhsachthongketheosinhvien');
		Route::get('thongketheosinhvien/xem/monhoc','ThongKeController@thongketheosinhvien_json')->name('danhsachthongketheosinhvien_json');
		Route::get('thongketheosinhvien/xuatexcel','ThongKeController@danhsachthongketheosinhvien_xuatExcel')->name('danhsachthongketheosinhvien_xuatexcel');
});
Route::group(['prefix'=>'giaovien'],function(){
	Route::get('/','GiaoVienController@index')->name('giaovien.index')->middleware('logingiaovien');
	Route::get('diem','DiemController@chonlopvamonhoc_giaovien')->name('giaovien.viewchonlopvamonhoc');
	Route::get('diem/danhsachmon','DiemController@danhsachmonhoccualop')->name('giaovien.danhsachmonhoc');
	Route::get('diem/xem','DiemController@danhsachdiem_giaovien')->name('giaovien.danhsachdiem');
	Route::get('themdiem','DiemController@viewthemdiem')->name('giaovien.themdiem');
	Route::post('themdiemprocess','DiemController@themdiemprocess')->name('themdiemprocess');
	Route::get('suadiem','DiemController@viewsuadiem')->name('giaovien.suadiem');
	Route::post('suadiemprocess','DiemController@suadiemprocess')->name('suadiemprocess');
	Route::get('xoadiem','DiemController@xoadiemprocess')->name('giaovien.xoadiem');
});

Route::group(['prefix'=>'sinhvien'],function(){
	//trang chủ
	Route::get('/','SinhVienController@index')->name('sinhvien.index');
	//diemthi
	Route::get('diemthi','DiemController@danhsachdiemtheosinhvien')->name('sinhvien.diemthi');
});
Route::get('demo',function(){
	return view('demo1');
});

Route::get('','LogIn@loginview')->name('login');

