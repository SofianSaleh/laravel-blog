<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

	public function index(Request $request)
	{
		// Check if the user is admin
		// return Auth::check()  && $request->path != 'login';
		if (!Auth::check() && $request->path() != 'login') {
			return redirect('/login');
		}
		if (!Auth::check() && $request->path() == 'login') {

			return view('welcome');
		}
		$user = Auth::user();
		if ($user->userType == 'User') {
			return redirect('/login');
		}
		if ($request->path() == 'login') {
			return redirect('/');
		}
		return view('welcome');
	}
	public function logout(Request $request)
	{
		Auth::logout();
		return redirect('login');
	}


	public function createUser(Request $request)
	{
		// bail checks the first requirement if it fails it doesn't comntinue
		$this->validate($request, [
			'fullName' => 'required',
			'email' => 'bail|required|email|unique:users',
			'password' => 'bail|required|min:6',
			'userType' => 'required',
		]);

		$password = bcrypt($request->password);
		$user = User::create([
			'fullName' => $request->fullName,
			'email' => $request->email,
			'password' => $password,
			'userType' => $request->userType,
		]);

		return $user;
	}

	public function editUser(Request $request)
	{
		// bail checks the first requirement if it fails it doesn't comntinue
		// bail|required|email|unique:users,id,$request->id if the user has the same id don't trigger the check
		$this->validate($request, [
			'id' => 'required',
			'fullName' => 'required',
			'email' => "bail|required|email|unique:users,email,$request->id",
			'password' => 'min:6',
			'userType' => 'required',
		]);
		$data = [
			'id' => $request->id,
			'fullName' => $request->fullName,
			'email' => $request->email,
			'userType' => $request->userType,
		];
		if ($request->password) {
			$password = bcrypt($request->password);
			$data['password'] = $password;
		};

		$user = User::where('id', $request->id)->update($data);
		return $data;
	}

	public function adminLogin(Request $request)
	{
		// bail checks the first requirement if it fails it doesn't comntinue
		// bail|required|email|unique:users,id,$request->id if the user has the same id don't trigger the check
		$this->validate($request, [
			'email' => "bail|required|email|",
			'password' => 'bail|required|min:6',
		]);
		if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
			$user = Auth::user();
			Log::info($user->role());
			if ($user->userType == 'User') {
				Auth::logout();
				return response()->json([
					'msg' => 'you are not log in'
				], 401);
			};
			return response()->json([
				'msg' => 'you are log in',
				'user' => $user
			]);
		} else {
			return response()->json([
				'msg' => 'you are not log in'
			], 401);
		}
	}

	public function getUsers()
	{
		return User::orderBy('id', 'desc')->get();
	}

	public function createRole(Request $request)
	{
		$this->validate($request, [
			'roleName' => "required",
		]);

		$role = Roles::create([
			'roleName' => $request->roleName
		]);
		return $role;
	}

	public function getRoles()
	{
		return Roles::orderBy('id', 'desc')->get();
	}

	public function editRole(Request $request)
	{
		$this->validate($request, [
			'id' => 'required',
			'roleName' => 'required'
		]);
		$updated = Roles::where('id', $request->id)->update([
			'roleName' => $request->roleName
		]);
		if ($updated) {
			return response()->json([
				'roleName' => $request->roleName,
				'id' => $request->id
			]);
		} else {
			return response()->json([
				'error' => "Failed to update try again"
			]);
		}
	}

	public function deleteRole(Request $request)
	{
		$this->validate($request, [
			'id' => 'required',
		]);

		return Roles::where('id', $request->id)->delete();
	}
}
