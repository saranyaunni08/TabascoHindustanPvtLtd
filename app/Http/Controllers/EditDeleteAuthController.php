<?php

// app/Http/Controllers/EditDeleteAuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EditDeleteAuth;
use App\Models\room;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Session;



class EditDeleteAuthController extends Controller
{  public function showLogin()
    {
        $title = 'Edit/Delete Authentication'; // Define your title here
        return view('auth.edit_delete_login', compact('title'));
    }
    

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $user = EditDeleteAuth::where('username', $credentials['username'])->first();
    
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Authentication successful
            Session::put('edit_delete_auth', true);
    
            // Check the action to perform
            $action = $request->input('action');
            $roomId = $request->input('room_id');
            $buildingId = $request->input('building_id');
    
            if ($action === 'delete') {
                // Perform soft delete
                $room = Room::findOrFail($roomId);
                $room->delete(); // Soft delete
    
                // Redirect with success message
                return redirect()->route('admin.rooms.index', ['buildingId' => $buildingId])->with('success', 'Room deleted successfully.');
            }
    
            // Handle other actions if needed
            // For now, just redirect to the URL with a success message
            $redirectUrl = $request->input('redirect_url');
            return redirect()->to($redirectUrl)->with('success', 'Authenticated successfully');
        }
    
        // Authentication failed
        return redirect()->back()->withErrors(['Invalid credentials']);
    }
    
    
    public function logout(Request $request)
    {
        // Store the current building_id in the session or another method to capture it
        $buildingId = $request->session()->get('building_id', null);
    
        // Perform the logout logic
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect to the login route
        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
    
    

    public function showEditPage(Request $request, $roomId , $building_id)
    {
        session(['building_id' => $building_id]);

        if (!$request->session()->has('edit_delete_auth')) {
            return redirect()->route('admin.edit_delete_auth.show_login');
        }
    
        $room = Room::find($roomId);
        
        if (!$room) {
            return redirect()->back()->withErrors(['Room not found']);
        }
    
        // Return the view without setting headers here
        return view('rooms.edit', compact('room'));
    }
    
    public function deleteRoom(Request $request, $roomId, $buildingId)
    {
        // Check if the user has the authentication session
        if (!$request->session()->has('edit_delete_auth')) {
            return redirect()->route('admin.edit_delete_auth.show_login');
        }
    
        // Find the room with the given IDs
        $room = Room::where('id', $roomId)
                    ->where('building_id', $buildingId)
                    ->first();
    
        // Handle the case where the room is not found
        if (!$room) {
            return redirect()->back()->withErrors(['Room not found']);
        }
    
        // Soft delete the room
        $room->delete();
        $redirectUrl = $request->input('redirect_url', route('admin.shops.index')); // Default to a route if no redirect URL is provided

        return redirect($redirectUrl)->with('success', 'Room deleted successfully.');

    }
    
    
    
}
