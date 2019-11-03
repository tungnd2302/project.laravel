<?php

namespace App\Http\Controllers\Backend;
use App\Models\UserInfo;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::get();
        $users = User::paginate(15);
         // $users = User::simplePaginate(15); //dùng cho nhiều bản ghi
        return view('backend.user.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // dd($request);
        $user = new User();
        $user->name = $request->get('username');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->password = bcrypt($request->get('password'));
        $user->role = $request->get('role');
        $save = $user->save();
        if ($save) {
            $request->session()->flash('success','Tạo danh mục thành công');
        }else{
            $request->session()->flash('error','Tạo danh mục không thành công');
        }
        return redirect()->route('backend.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $user = User::find($id);
        // $userInfo = $user->userInfo;
        // dd($userInfo);
        $userInfo = Userinfo::find(1);
        // dd($userInfo);
        $user = $userInfo->User;
        dd($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::get();
        $item = User::find($id);
        return view('backend.user.edit')->with([
            'users' => $users,
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->get('username');
        $user->phone = $request->get('phone');
        $save = $user->save();
        if ($save) {
            $request->session()->flash('success1','Cập nhật thông tin thành công');
        }else{
            $request->session()->flash('error1','Cập nhật thông tin không thành công');
        }
        return redirect()->route('backend.user.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
