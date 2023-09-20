<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Auth;
use DB;
use Hash;
use File;
use Mail;
use App\Notifications\addNewBuyer; 
use Str;
use App;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Notifications\resetPasswordUser;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Session;
use Throwable;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = new \stdClass();
        $count->buyers = User::count(); 

        return view('admin.dashboard',compact('count'));
    }

    public function profile(){
         return view('admin.settings.profile');
    }

    public function updateAdminProfile(Request $request){

        $formData = request()->except(['_token']);

        if ($request->hasFile('profile_pic')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg'];
            $file = $request->file('profile_pic');

            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, $allowedfileExtension)) {

                $formData['profile_pic'] = $file->store('profile_pics');
            }
        }
        
        $user = User::find(['id' => Auth::id()])->first();

        if ($user->update($formData)) {
            return back()->with('success','You have successfully updated the profile.!');

        } else {
            return back()->with('error','Sorry there is an error while updating your profile.!')->withInput();

        }

    }

    public function changePassword(){
        return view('admin.settings.change-password');
    }

    public function  updateAdminPassword(Request $request)
    {
        $user = DB::table('users')
            ->select('*')
            ->where('id', Auth::guard('admin')->id())
            ->first();

        if (!Hash::check($request->oldpassword, $user->password)) {
            return back()->with('error', 'Sorry your current password does not match.!')->withInput();
        }

        $this->validate($request, ['password' => 'required|confirmed|min:8']);

        if ($request->password == $request->password_confirmation) {
            if ($user) {
                $password_updated = DB::table('users')
                    ->where('id',  Auth::guard('admin')->id())
                    ->update(['password' => Hash::make($request->password)]);

                if ($password_updated) {
                    return back()->with(['success' => 'Password is changed successfully.!']);
                } else {
                    return back()->with(['error' => 'There is an error while changing the password please try again later.!']);
                }
            }
        } else {
            return back()->with('error', 'New password do not matched with confirm password.!')->withInput();
        }
    }


    //Buyer
    public function manageBuyers()
    {
        $result = User::get();

        return view('admin.buyers.manage', compact('result'));
    }

    public function notifications()
    {
        DB::table('notifications')->where('read_at', NULL)->where('notifiable_id', Auth::id())->update(['read_at' => Date('Y-m-d H:i:s')]);

        $all_notifications = Auth::user()->notifications()->get();
        $notifications = [];
        foreach ($all_notifications as $notification) {
            $notifications[] = $notification;
        }

        return view('admin.settings.notifications', compact('notifications'));
    }




  
    //Manage products
    public function manageProducts()
    { 
        $products = Product::get();

        return view('admin.product-management.manage', compact('products')); 

    } 
    public function addProducts()
    { 
        return view('admin.product-management.add');
    }
    public function saveProducts(Request $request)
    {   
        $formData = request()->except(['_token', 'meta_title', 'meta_description', 'meta_keywords']);  
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],  
            'images' => ['mimes:jpeg,jpg,png,svg,mov,mp4,webm,mkv'],   
        ], [
            "name.required" => "Please enter :attribute", 
            "images.mimes" => "Please enter valid product image", 
        ]); 

        $formData['user_id'] = Auth::id();
       
        if ($request->hasFile('images')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
            $file = $request->file('images'); 
            $extension = $file->getClientOriginalExtension(); 
            if (in_array($extension, $allowedfileExtension)) { 
                $formData['images'] = $file->store('product-images');
            }
        }

        $Product = Product::create($formData); 

        if ($Product->save()) {
            return redirect('/admin/manage-product-management')->with('success', 'Product   added successfully.');
        } else {
            return redirect('/admin/manage-product-management')->with('error', 'Sorry there is an error while adding Product. please try again.')->withInput();
        }   
    }


    public function editProduct($id)
    {
        $row = Product::where('products.id', $id)->first();

        return view('admin.product-management.edit', compact('row'));
    }

    public function updateProduct($id, Request $request)
    {
        $formData = request()->except(['_token', 'images', 'meta_title', 'meta_description', 'meta_keywords']);  
      
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'images' => ['file', 'mimes:jpeg,jpg,png,svg,mov,mp4,webm,mkv'],   
        ], [
            "name.required" => "Please enter :attribute", 
            "images.mimes" => "Please enter valid product image", 
        ]); 
        if ($request->hasFile('images')) {
            $allowedfileExtension = ['jpeg', 'jpg', 'png', 'svg', 'JPG', 'PNG', 'JPEG', 'SVG'];
            $file = $request->file('images'); 
            $extension = $file->getClientOriginalExtension(); 
            if (in_array($extension, $allowedfileExtension)) { 
                $formData['images'] = $file->store('product-images');
            }
        }
        
        // save the row to the database
        // $duplicateEntry = Product::whereName($formData['name'])->first();
        $Product = Product::find($id);
        
            $Product->update($formData);
        return redirect('/admin/manage-product-management')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(Request $request)
    {
        $id = $request->input('id'); 
        if (Product::find($id)->delete()) {
            return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted Product']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Sorry there is an error in deleting Product. Please try again later!']);
        }
    }

    public function manageRoles(Request $request)
    {
    
        $result = Role::where('name','!=', 'admin')->get();

        return view('admin.roles.manage',['result' => $result]);
    }

    public function create()
    {
        $permissions = Permission::all()
            ->groupBy(function (Permission $permission) {
                return preg_replace("/-(view|create|edit|delete)/", '', $permission->name);
            });

        return view('admin.roles.add', [
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|alpha|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name'
        ]);

        /** @var Role $role */
        try {
            return DB::transaction(function () use ($request) {
                $role = Role::create([
                    'name' => $request->get('name')
                ]);

                $role->givePermissionTo($request->get('permissions'));

                return redirect()->route('roles.index')->with('success','Role created successfully.');
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    public function edit($id)
    {
        $permissions = Permission::all()
            ->groupBy(function (Permission $permission) {
                return preg_replace("/-(view|create|edit|delete)/", '', $permission->name);
            });
        $role = Role::find($id);

        return view('admin.roles.edit', [
            'row' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Role $role
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            // 'name' => [
            //     'required','alpha',
            // Rule::unique('roles', 'name')->ignore($id)
            // ],
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name'
        ]);
        try {
            return DB::transaction(function () use ($request, $id) {
                $role = Role::find($id);
               
                $role->syncPermissions($request->get('permissions'));

        return redirect()->route('roles.index')->with(['success' => 'Role updated successfully.']);
            });
        } catch (Throwable $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.'])->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $role = Role::find($request->id);
        $roleCount = $role->users()->whereRoleId($role->id)->count();
      
        try {
            if($roleCount > 0){
                return response()->json(['status' => 'error', 'msg' => 'You can not delete Role as there are some active users in it.']);
            }else{
                $role->delete();

                return response()->json(['status' => 'success', 'msg' => 'You have successfully deleted role']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.']);
        }
    }

  }
