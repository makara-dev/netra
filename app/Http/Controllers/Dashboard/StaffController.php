<?php

namespace App\Http\Controllers\Dashboard;


use Exception;
use Throwable;

use App\Staff;
use App\User;

use Dotenv\Regex\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;

class StaffController extends Controller
{
    /**
     * Display a listing of Staffs.
     * @param  \Illuminate\Http\Request  $orderByRequest
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $this->getSortType($request);

        //sort staff
        if ($sort['sortBy'] === 'name') {
            $staffs = Staff::leftJoin('users', 'users.user_id', '=', 'staffs.user_id')
                ->orderBy($sort['sortBy'], $sort['sortOrder'])
                ->paginate(10);
        } else {
            $staffs = Staff::orderBy($sort['sortBy'], $sort['sortOrder'])->paginate(10);
        }
        return view('dashboard.staff.list')->with('staffs', $staffs);
    }

    /**
     * Show the form for creating adding a new staff.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.staff.add');
    }

    /**
     * Store a newly created Staff in Database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Start transaction!
        DB::beginTransaction();

        //create user
        $user = new User([
            'name' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'contact' => $request->input('contact'),
        ]);
        //save user
        try {
            $user->markEmailAsVerified();
            $userResult = $user->save();
            if (!$userResult) {
                throw new \ErrorException('Unable To Save Staff');
            }
        } catch (\Exception | Throwable $e) {
            DB::rollback();
            $errorCode = $e->errorInfo[1];
            if ($errorCode  === 1062) {
                return back()->with('error', 'UserName Or Contact Already Exist');
            } else {
                return back()->with('error', $errorCode . ' : ' . $e->getMessage());
            }
        }

        $imgStored = $this->storeImage($request, $user); //store staff image

        //create staff
        $staff = new Staff(['avatar' => $imgStored,]);
        $staff->is_admin = ($request->has('admin'));

        //save staff
        try {
            $staffResult = $user->staff()->save($staff);

            if ($imgStored === null) {
                throw new \ErrorException('Unable to Save Image');
            } else if (!$staffResult) {
                $this->deleteImage($imgStored);     //delete img if staff storing fails
                throw new \ErrorException('Unable to Save Staff');
            }
        } catch (Exception | Throwable $exception) {
            DB::rollBack();
            return back()->with('error', 'Staff Failed to Create.' . $exception->getMessage());
        }

        //save transaction
        DB::commit();
        return redirect('dashboard/staffs')->with('success', 'Staff Created Successfully');
    }

    /**
     * Show the form for editing the staff.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        try {
            $staff = Staff::findOrFail($id);
        } catch (Throwable | Exception $e) {
            return redirect('dashboard/staffs')->with('error', 'Unable To Find Staff');
        }
        return view('dashboard.staff.edit')->with('staff', $staff);
    }

    /**
     * Update the staff.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //get staff
        try {
            $staff = Staff::findOrFail($id);
        } catch (Throwable | Exception $e) {
            return back()->with('error', 'Unable To Find Staff');
        }

        //begin transaction
        DB::beginTransaction();

        //get user linked to staff
        $userStaff = $staff->user;

        //update user info
        $username = $request->input('username');
        $password = $request->input('password');
        $contact = $request->input('contact');
        $setAdmin = $request->has('admin');

        if (!empty($username) && $username !== $userStaff->name) {
            $userStaff->name = $username;
        }
        if (!empty($password) && Hash::check($password, $userStaff->password)) {
            $userStaff->password = Hash::make($password);
        }
        if (!empty($contact) && $contact !== $userStaff->contact) {
            $userStaff->contact = $contact;
        }

        $staff->is_admin = $setAdmin;

        try {
            //save user
            $userResult = $userStaff->update();
            if (!$userResult) {
                throw new ErrorException('something went wrong while trying to update user');
            }

            //update image
            $image = $this->storeImage($request, $userStaff);
            if (!empty($image)) {
                $result = $this->deleteImage($staff->avatar);
                if (!$result) {
                    throw new ErrorException('Failed to update image');
                }
                $staff->avatar = $image;
            }

            //save staff
            $staffResult = $staff->update();
            if (!$staffResult) {
                throw new ErrorException('something went wrong while trying to update staff');
            }
        } catch (Throwable $e) {
            DB::rollback();
            return back()->with('error', "Unable To Update Staff" . $e);
        }

        DB::commit();
        return redirect('dashboard/staffs')->with('success', 'Staff Was Updated Successfully');
    }

    /**
     * Remove the Staff from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get staff
        try {
            $staff = Staff::findOrFail($id);
        } catch (Throwable | Exception $e) {
            return back()->with('error', 'Unable To Find Staff');
        }

        //start transaction
        DB::beginTransaction();

        try {
            $tempPath = $staff->avatar;

            //avoid deleting self
            if (auth()->user()->user_id == $id) {
                throw new ErrorException('Invalid action : Deleting current user');
            }

            //delete user
            $deleteUser = $staff->user->delete();
            if (!$deleteUser) {
                throw new ErrorException('Unable to Delete Staff');
            }

            //delete image
            $this->deleteImage($tempPath); //might need to change this logic later
        } catch (ErrorException $e) {
            DB::rollBack();
            return redirect('dashboard/staffs')->with('error', $e->getMessage());
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            return redirect('dashboard/staffs')->with('error', 'Unable To Delete Staff');
        }
        //Deleted
        DB::commit();
        return back()->with('success', 'Staff Was Deleted Successfully');
    }

    /**
     * store user image in storage
     * @param  \Illuminate\Http\Request  $request
     * @return string $imagePath
     * @return null error storing image
     */
    private function storeImage($request, User $user)
    {
        if ($request->hasFile('user-image')) {
            $image = $request->file('user-image');
            $fileName = $user->name . $user->user_id . '.' . $image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->resize(
                240,
                240,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->stream();
            $imagePath = 'images/staff/' . $fileName;
            Storage::disk('public')->put($imagePath, $img);
            return $imagePath;
        }
        return null;
    }

    /**
     * Delete staff image from storage
     * @param string imagePath
     * @return bool
     */
    private function deleteImage($imagePath)
    {
        $img = storage_path() . '/app/public/' . $imagePath;
        if (file_exists($img)) {
            $result = Storage::delete("public/{$imagePath}");
            return ($result) ? true : false;
        } else {
            return false;
        }
    }

    /**
     * return sortBy and sortorder based on request
     */
    private function getSortType($request)
    {
        $sort = [
            'sortBy' => 'staff_id',
            'sortOrder' => 'asc'
        ];
        foreach ($request->all() as $key => $value) {
            if ($value != null && $key !== 'page') {
                //remove "-sort" from sortBy Request
                $sort['sortBy'] = str_replace('-sort', '', $key);;
                $sort['sortOrder'] = $value;
            }
        }
        return $sort;
    }
}
