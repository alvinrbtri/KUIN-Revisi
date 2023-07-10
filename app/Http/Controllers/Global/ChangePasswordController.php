<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    // handle update change password view
    protected function showChangePassword()
    {
        $data = [
            'title'     => 'Change Password',
            'id_page'   => 9,
        ];

        return view('global.change_password', $data);
    }

    // handle update password
    protected function update_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $currentPassword = $user->password;
        $inputPassword = $request->input('current_password');

        if (Hash::check($inputPassword, $currentPassword)) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            return redirect()->back()->with('success', 'Password has been changed successfully.');
        } else {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
    }
}
