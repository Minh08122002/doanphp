<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateFormRequest;
use Illuminate\Http\Request;
use App\Http\Services\MenuService;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use RealRashid\SweetAlert\Facades\Alert;
class MenuController extends Controller
{
    protected $menuService;
    public function __construct(MenuService $menuService)
    {
        $this->menuService =$menuService;
    }
   public function create()
   {
    return view('add',[
        'title'=>'Thêm Danh Mục Mới',
        'menus'=>$this->menuService->getParent()
    ]);

   }
   public function store(CreateFormRequest $request)
   {
    $this ->menuService->create($request);
    Alert::success('','Thêm thành công!');
   return redirect()->back();
   }
   public function index()
   {
    return view('list',[
        'title'=>'Danh Sách Danh Mục',
        'menus'=>$this->menuService->getAll()
    ]);
   }
   public function show(Menu $menu)
   {
    
    return view('edit',[
        'title'=>'Chỉnh sửa danh mục' . $menu->name,
        'menu'=> $menu,
        'menus'=>$this->menuService->getParent()
    ]);
   }
   public function update(Menu $menu, CreateFormRequest $request)
   {
        $this->menuService->update($request, $menu);
        Alert::success('','Chỉnh sửa thành công!');
        return redirect('list');
   }
   public function destroy($id): JsonResponse
   {
    $xoa = Menu::where('id', $id)->delete();
       if ($id) {
        Alert::success('','Xóa thành công!');
           return response()->json([
            
               'error' => false,
               'message' => ''
           ]);
       }

       return response()->json([
           'error' => true
       ]);
       
   }

}
