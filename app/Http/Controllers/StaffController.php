<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin')->orWhere('id', '!=', auth()->id());
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Sorting
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);
        
        $staff = $query->paginate(10);
        
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,staff',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Prevent creating admin if current user is not admin
        if ($request->role === 'admin' && auth()->user()->role !== 'admin') {
            return back()->withErrors(['role' => 'Anda tidak memiliki izin untuk membuat akun admin.'])->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Staff berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $staff)
    {
        // Prevent viewing admin details if not admin
        if ($staff->role === 'admin' && auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk melihat detail admin.');
        }
        
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $staff)
    {
        // Prevent editing admin if not admin
        if ($staff->role === 'admin' && auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk mengedit admin.');
        }
        
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $staff)
    {
        // Prevent editing admin if not admin
        if ($staff->role === 'admin' && auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk mengedit admin.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,staff',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Prevent changing to admin if not admin
        if ($request->role === 'admin' && auth()->user()->role !== 'admin') {
            return back()->withErrors(['role' => 'Anda tidak memiliki izin untuk mengubah role menjadi admin.'])->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->name = $data['name'];
        $staff->email = $data['email'];
        $staff->role = $data['role'];
        
        if (isset($data['password'])) {
            $staff->password = $data['password'];
        }
        
        $staff->save();

        return redirect()->route('staff.index')
            ->with('success', 'Data staff berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $staff)
    {
        // Prevent admin from deleting themselves
        if ($staff->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        // Prevent deleting admin if not admin
        if ($staff->role === 'admin' && auth()->user()->role !== 'admin') {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus admin!');
        }

        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff berhasil dihapus!');
    }
} 