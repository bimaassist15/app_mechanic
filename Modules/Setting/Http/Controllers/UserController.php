<?php

namespace Modules\Setting\Http\Controllers;

use App\Models\Cabang;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Modules\Setting\Http\Requests\CreateUserRequest;
use Modules\Setting\Http\Requests\CreateUserUpdateRequest;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
     
        if($request->ajax()){
            $cabang_id = $request->query('cabang_id');
            $data = User::query()
            ->join('roles','roles.id','=','users.roles_id')
            ->with('profile');
            if($cabang_id != '' && $cabang_id != null){
                $data->where('users.cabang_id', $cabang_id);
            }
            $data = $data
            ->select('users.*','roles.id as roles_id', 'roles.name as roles_name', 'roles.guard_name as roles_guard');

            return DataTables::eloquent($data)
            ->addColumn('status_users', function ($row) {
                $output = $row->status_users ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';
                return '<div class="text-center">
                '.$output.'
                </div>';
            })
                ->addColumn('action', function ($row) {
                    $buttonUpdate = '
                    <a class="btn btn-warning btn-edit btn-sm" 
                    data-typemodal="extraLargeModal"
                    data-urlcreate="' . url('setting/user/'.$row->id.'/edit') . '"
                    data-modalId="extraLargeModal"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </a>
                    ';
                    $buttonDelete = '
                    <button type="button" class="btn-delete btn btn-danger btn-sm" data-url="'.url('setting/user/'.$row->id).'?_method=delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    ';

                    $button = '
                <div class="text-center">
                    ' . $buttonUpdate . '
                    ' . $buttonDelete . '
                </div>
                ';
                    return $button;
                })
                ->rawColumns(['action', 'status_users'])
                ->toJson();
        }
        $cabang = Cabang::all();
        $array_cabang = [];
        foreach ($cabang as $key => $item) {
            $array_cabang[] = [
                'id' => $item->id,
                'label' => $item->bengkel_cabang.' '.$item->nama_cabang,
            ];
        }
        return view('setting::user.index', compact('array_cabang'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $cabang = Cabang::all();
        $array_cabang = [];
        foreach ($cabang as $key => $item) {
            $array_cabang[] = [
                'id' => $item->id,
                'label' => $item->bengkel_cabang.' '.$item->nama_cabang,
            ];
        }
        $role = Role::all();
        $array_role = [];
        foreach ($role as $key => $item) {
            $array_role[] = [
                'id' => $item->id,
                'label' => $item->name,
            ];
        }
        $action = url('setting/user');
        return view('setting::user.form', compact('array_cabang', 'array_role', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateUserRequest $request)
    {
        // users
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'cabang_id' => $request->input('cabang_id'),
            'roles_id' => $request->input('roles_id'),
            'status_users' => $request->input('status_users') !== null ? true : false,
        ];
        $users = User::create($data);

        // profile
        $dataProfile = [
            'nama_profile' => $request->input('name'),
            'nohp_profile' => $request->input('nohp_profile'),
            'alamat_profile' => $request->input('alamat_profile'),
            'jeniskelamin_profile' => $request->input('jeniskelamin_profile'),
            'users_id' => $users->id,
            'cabang_id' => $request->input('cabang_id'),
        ];
        Profile::create($dataProfile);

        // roles
        $roles = Role::find($request->input('roles_id'));
        $users->assignRole($roles->name);
        return response()->json('Berhasil tambah data', 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $cabang = Cabang::all();
        $array_cabang = [];
        foreach ($cabang as $key => $item) {
            $array_cabang[] = [
                'id' => $item->id,
                'label' => $item->bengkel_cabang.' '.$item->nama_cabang,
            ];
        }
        $role = Role::all();
        $array_role = [];
        foreach ($role as $key => $item) {
            $array_role[] = [
                'id' => $item->id,
                'label' => $item->name,
            ];
        }
        $action = url('setting/user/'.$id.'?_method=put');
        $row = User::with('roles', 'profile')->find($id);
        return view('setting::user.form', compact('array_cabang', 'array_role', 'action', 'row'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CreateUserUpdateRequest $request, $id)
    {
         // users
         $password_old = $request->input('password_old');
         $password = $request->input('password');
         $password_db = $password_old;
         if($password != null && $password != ''){
            $password_db = Hash::make($password);
         }
         $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => $password_db,
            'cabang_id' => $request->input('cabang_id'),
            'roles_id' => $request->input('roles_id'),
            'status_users' => $request->input('status_users') !== null ? true : false,
        ];
        $users = User::find($id)->update($data);

        // profile
        $dataProfile = [
            'nama_profile' => $request->input('name'),
            'nohp_profile' => $request->input('nohp_profile'),
            'alamat_profile' => $request->input('alamat_profile'),
            'jeniskelamin_profile' => $request->input('jeniskelamin_profile'),
            'users_id' => $id,
            'cabang_id' => $request->input('cabang_id'),
        ];
        Profile::dataTable()->where('users_id', $id)->update($dataProfile);

        // roles
        $roles = Role::find($request->input('roles_id'));
        $userData = User::find($id);
        $userData->syncRoles([$roles->name]);
        return response()->json('Berhasil update data', 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
        User::destroy($id);
        return response()->json('Berhasil hapus data', 200);
    }
}
