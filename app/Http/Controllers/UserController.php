<?php

namespace App\Http\Controllers;

use App\Models\Tin;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $listTaiKhoan=User::all();
        return view('nguoi-dung.them-moi',['listNguoiDung'=>$listTaiKhoan]);
        //dd($listQuanTriVien);

    }

    public function infomation()
    {
        $dstinchuaduyet =Tin::where('user_id',Auth::user()->id)->where('trang_thai','=','0')->get();
        $dstindaduyet =Tin::where('user_id',Auth::user()->id)->where('trang_thai','=','1')->get();
        return view('info',['title'=>Auth::user()->name],['dstinchuaduyet'=>$dstinchuaduyet,'dstindaduyet'=>$dstindaduyet]);
    }
    public function suainfo()
    {
        return view('sua-info',['title'=>'hehe']);
    }
    // public function edit($id)
    // {
    //     $sinhvien = User::find($id);
    //     if(empty($sinhvien)){
    //         return "#: {$id}";
    //     }
    //     return view('sinh_vien.cap_nhat', compact('sinhvien'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('them-moi',['title'=>'dang-ky']);
    }
    public function ShowSuaThongTin($id)
    {
        $thongtinUser = User::find($id);
        
        return view('sua-info',['title'=>'sua-thong-tin'],['thongtinUser'=>$thongtinUser]);
    }

    public function ShowSuaMatKhau($id)
    {
        $thongtinUserdoimatkhau = User::find($id);
        $Userid = $thongtinUserdoimatkhau->id;
        return view('doimatkhau',['title'=>'doimatkhau'],['thongtinUserdoimatkhau'=>$thongtinUserdoimatkhau,'Userid'=>$Userid]);
    }

    public function CapNhatMatKhau(Request $request, $id)
    {
        
        if ($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(),
            [
                'password'=>'required|min:6|max:20',
                'passwordnew'=>'required|min:6|max:20|',
                'passwordcheck'=>'required_with:password|same:passwordnew|min:6|max:20',
            ],
                [
                    'password.max'=>'Mật khẩu từ 6 đến 20 kí tự',
                    'password.min'=>'Mật khẩu từ 6 đến 20 kí tự',
                    'password.required'=> 'Mật khẩu không được bỏ trống',
                    'passwordnew.max'=>'Mật khẩu từ 6 đến 20 kí tự',
                    'passwordnew.min'=>'Mật khẩu từ 6 đến 20 kí tự',
                    'passwordnew.required'=> 'Mật khẩu không được bỏ trống',
                    'passwordnew.required'=> ' Mật khẩu mới phải chứa 6 đến 20 kí tự',
                    'passwordcheck.same' =>' Xác nhận mật khẩu phải trùng với mật khẩu mới',
                ]
                );
            if ($validator->fails())
            {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }

            $thongtinUserdoimatkhau = User::find($id);
            //dd($id);
            //  dd(Hash::make($request->password));
            if (Hash::check($request->password,$thongtinUserdoimatkhau->password) && $request->password != $request->passwordnew)
            {
            $thongtinUserdoimatkhau->password=Hash::make($request->passwordnew);
            $thongtinUserdoimatkhau->save();
            Alert::success('','Đổi mật khẩu thành công!');
            return  redirect()->route('info');
            }
            elseif ($request->password==$request->passwordnew)
            {
             Alert::error('','Mật khẩu mới không được trùng với mật khẩu cũ');
             return redirect()->route('doimatkhaumoi',[$thongtinUserdoimatkhau->id])->with('message','');
            }
            else
            {
            Alert::error('','Sai mật khẩu!');   
            return redirect()->route('doimatkhaumoi',[$thongtinUserdoimatkhau->id])->with('message','');
            }
        
        }

    }


    public function CapNhatThongTinUS(Request $request, $id)
    {
        $thongtinUser = User::find($id);
        $thongtinUser->name=$request->name;
        $thongtinUser->email=$request->email;
        $check= $request->hasFile('avatar') ? true: false;
        if ($check == true)
        {
            $file = $request->file('avatar');
            $destination_Path = public_path('image');
            $file_Name=$file->getClientOriginalName();
            $file->move($destination_Path,$file_Name);  
        }
       else
       {
          $file_Name= Auth::user()->avatar;
       }
        $thongtinUser->avatar=$file_Name;
        $thongtinUser->dia_chi=$request->dia_chi;
        $thongtinUser->save();
        Alert::success('','Sửa thành công!');
        return  redirect()->route('info');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(),
            [
                'username'=> 'required|min:6|max:20',
                'email'=>'required|email',
                'password'=>'required|min:6|max:20',
                'avatar'=> 'image|mimes:jpg,jpeg,png,gif',
                'confirmpassword'=>'required_with:password|same:password',
                'name'=>'required'
            ],
                [
                    'username.max'=>'Tài khoản từ 6 đến 20 kí tự',
                    'username.min'=>'Tài khoản từ 6 đến 20 kí tự',
                    'username.required'=>'Tài khoản không được để trống',
                    'email.required'=> 'Bạn phải nhập email',
                    'password.max'=>'Mật khẩu từ 6 đến 20 kí tự',
                    'password.min'=>'Mật khẩu từ 6 đến 20 kí tự',
                    'password.required'=> 'Mật khẩu không được bỏ trống',
                    'avatar.image'=> 'File tải lên phải là hình ảnh',
                    'avatar.mimes'=> 'File tải lên phải có đuôi là jpg, jpeg, png, gif',
                    'confirmpassword.same' =>'Xác nhận mật khẩu chưa khớp',
                    'name.required'=>'Bạn chưa nhập tên'
                ]
         );
        
            if ($validator->fails())
            {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
                
            }
          $check= $request->hasFile('avatar') ? true: false;
            if ($check == true)
            {
                $file = $request->file('avatar');
                $destination_Path = public_path('image');
                $file_Name=$file->getClientOriginalName();
                $file->move($destination_Path,$file_Name);
            }
            else
            {
                $file_Name='noname.jpg';
            }

            $user = DB::table('users')->where('username',$request->username)->first();
            if (!$user)
            {
                
                $newUser= new User();
                $newUser->username=$request->username;
                $newUser->password=Hash::make($request->password);
                $newUser->email=$request->email;
                $newUser->avatar=$file_Name;
                $newUser->name=$request->name; 
                $newUser->save();
                Alert::success('','Đăng kí thành công mời bạn đăng nhập!');
                return redirect()->route('login');
            }
            else 
            {
                Alert::error('','Tài khoản đã tồn tại!');
                return redirect()->route('form-them-moi-tai-khoan')->with('message','');
            }
        } 
        
        
    }
}
//return redirect()->route('admin');

        //dd($request);
       // $quanTriVien = new QuanTriVien;
       // $quanTriVien->ten_dang_nhap ='Admin';
       // $quanTriVien->mat_khau='123456';
       // $quanTriVien->ho_ten='Nguyen Van A';
        //$quanTriVien->save();
      //  $taiKhoan=TaiKhoan::create([
       //     'tai_khoan' => $request->tai_khoan,

       //     'mat_khau' => Hash::make($request->password),
       //     'email' =>$request->email,
      //      'user_name' =>$request->user_name,
      //  ]);
        
      //  return view('login',['title'=>'dang-nhap']);
        //
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

