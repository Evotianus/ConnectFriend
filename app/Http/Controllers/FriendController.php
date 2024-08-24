<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{
    public function index()
    {
        $title = "Home Page";
        $auth = Auth::user();
        $filterGender = request()->query('filter');
        // return $filterGender;

        if (!$auth) {
            $users = User::with(['works' => function ($query) {
                $query->select('work_id', 'name', 'user_id')->distinct('work_id');
            }])
                ->when($filterGender, function ($query, $filterGender) {
                    return $query->where('gender', $filterGender);
                })
                ->get();
        } else {
            $users = User::where('username', '!=', $auth->username)
                ->with(['works' => function ($query) {
                    $query->select('work_id', 'name', 'user_id')->distinct('work_id');
                }])
                ->when($filterGender, function ($query, $filterGender) {
                    return $query->where('gender', $filterGender);
                })
                ->get();
        }

        return view('home', compact('title', 'auth', 'users'));
    }

    public function store($id)
    {
        $friend = User::find($id);

        if (!$friend) {
            return redirect()->back()->with('error', 'Friend not found');
        }

        $authId = Auth::id();

        $existingFriend = Friend::where(function ($query) use ($authId, $id) {
            $query->where('user1_id', $authId)
                ->where('user2_id', $id)
                ->where('status', 'pending');
        })->orWhere(function ($query) use ($authId, $id) {
            $query->where('user1_id', $id)
                ->where('user2_id', $authId)
                ->where('status', 'pending');
        })->get();

        if ($existingFriend->count() > 0) {
            foreach ($existingFriend as $friend) {
                $friend->update(['status' => 'accepted']);
            }

            return redirect()->back()->with('success', 'Friend request accepted');
        } else {
            Friend::create([
                'user1_id' => Auth::id(),
                'user2_id' => $id,
            ]);

            Notification::create([
                'user_id' => $id,
                'notification_id' => 1,
                'message' => 'Friend request incoming from ' . Auth::user()->username,
            ]);

            return redirect()->back()->with('success', 'Friend request sent');
        }
    }

    public function destroy($id)
    {
        $friend = User::find($id);

        if (!$friend) {
            return redirect()->back()->with('error', 'Friend not found');
        }

        $authId = Auth::id();

        $existingFriend = Friend::where(function ($query) use ($authId, $id) {
            $query->where('user1_id', $authId)
                ->where('user2_id', $id)
                ->where('status', 'accepted');
        })->orWhere(function ($query) use ($authId, $id) {
            $query->where('user1_id', $id)
                ->where('user2_id', $authId)
                ->where('status', 'accepted');
        })->get();

        if ($existingFriend->count() > 0) {
            foreach ($existingFriend as $friend) {
                $friend->delete();
            }

            return redirect()->back()->with('success', 'Friend deleted');
        }
    }

    public function chat($id)
    {
        $title = "Chat Page";
        $friend = User::find($id);
        $auth = Auth::user();
        $authId = Auth::id();

        $chats = Chat::where(function ($query) use ($authId, $id) {
            $query->where('user_id', $authId)
                ->where('friend_id', $id);
        })->orWhere(function ($query) use ($authId, $id) {
            $query->where('user_id', $id)
                ->where('friend_id', $authId);
        })->orderBy('created_at', 'DESC')->get();

        return view('chat.chat', compact('title', 'auth', 'friend', 'chats'));
    }

    public function send(Request $request, $id)
    {
        $authUserId = Auth::id();

        Chat::create([
            'user_id' => $authUserId,
            'friend_id' => $id,
            'message' => $request->message,
        ]);

        Notification::create([
            'user_id' => $id,
            'notification_id' => 2,
            'message' => 'New message from ' . Auth::user()->username,
        ]);

        return redirect()->back()->with('success', 'Message sent');
    }
}
