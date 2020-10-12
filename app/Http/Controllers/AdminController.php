<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

	public function index(Request $request)
	{
		// Check if the user is admin
		if (!Auth::check()) {
			return redirect('/login');
		};
		return $request->path();
		// return view('welcome');
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
}
