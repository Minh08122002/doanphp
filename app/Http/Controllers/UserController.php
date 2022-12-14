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
                    'password.max'=>'M???t kh???u t??? 6 ?????n 20 k?? t???',
                    'password.min'=>'M???t kh???u t??? 6 ?????n 20 k?? t???',
                    'password.required'=> 'M???t kh???u kh??ng ???????c b??? tr???ng',
                    'passwordnew.max'=>'M???t kh???u t??? 6 ?????n 20 k?? t???',
                    'passwordnew.min'=>'M???t kh???u t??? 6 ?????n 20 k?? t???',
                    'passwordnew.required'=> 'M???t kh???u kh??ng ???????c b??? tr???ng',
                    'passwordnew.required'=> ' M???t kh???u m???i ph???i ch???a 6 ?????n 20 k?? t???',
                    'passwordcheck.same' =>' X??c nh???n m???t kh???u ph???i tr??ng v???i m???t kh???u m???i',
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
            Alert::success('','?????i m???t kh???u th??nh c??ng!');
            return  redirect()->route('info');
            }
            elseif ($request->password==$request->passwordnew)
            {
             Alert::error('','M???t kh???u m???i kh??ng ???????c tr??ng v???i m???t kh???u c??');
             return redirect()->route('doimatkhaumoi',[$thongtinUserdoimatkhau->id])->with('message','');
            }
            else
            {
            Alert::error('','Sai m???t kh???u!');   
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
        Alert::success('','S???a th??nh c??ng!');
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
                    'username.max'=>'T??i kho???n t??? 6 ?????n 20 k?? t???',
                    'username.min'=>'T??i kho???n t??? 6 ?????n 20 k?? t???',
                    'username.required'=>'T??i kho???n kh??ng ???????c ????? tr???ng',
                    'email.required'=> 'B???n ph???i nh???p email',
                    'password.max'=>'M???t kh???u t??? 6 ?????n 20 k?? t???',
                    'password.min'=>'M???t kh???u t??? 6 ?????n 20 k?? t???',
                    'password.required'=> 'M???t kh???u kh??ng ???????c b??? tr???ng',
                    'avatar.image'=> 'File t???i l??n ph???i l?? h??nh ???nh',
                    'avatar.mimes'=> 'File t???i l??n ph???i c?? ??u??i l?? jpg, jpeg, png, gif',
                    'confirmpassword.same' =>'X??c nh???n m???t kh???u ch??a kh???p',
                    'name.required'=>'B???n ch??a nh???p t??n'
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
                Alert::success('','????ng k?? th??nh c??ng m???i b???n ????ng nh???p!');
                return redirect()->route('login');
            }
            else 
            {
                Alert::error('','T??i kho???n ???? t???n t???i!');
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
  

