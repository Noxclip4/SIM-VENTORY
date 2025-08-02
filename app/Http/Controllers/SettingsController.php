<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Clean up invalid profile photos
        if ($user->profile_photo) {
            // Check if file exists and is valid
            if (!Storage::disk('public')->exists($user->profile_photo)) {
                $user->profile_photo = null;
                $user->save();
            } else {
                // Check if file is actually an image and not problematic
                $filePath = storage_path('app/public/' . $user->profile_photo);
                if (!file_exists($filePath) || !getimagesize($filePath)) {
                    Storage::disk('public')->delete($user->profile_photo);
                    $user->profile_photo = null;
                    $user->save();
                } else {
                    // Check file size - if too small, likely corrupted
                    $fileSize = filesize($filePath);
                    if ($fileSize < 1024) { // Less than 1KB
                        Storage::disk('public')->delete($user->profile_photo);
                        $user->profile_photo = null;
                        $user->save();
                    }
                }
            }
        }
        
        // Handle form submissions
        if ($request->isMethod('post')) {
            if ($request->input('action') === 'update_password') {
                return $this->updatePassword($request);
            } elseif ($request->input('action') === 'update_photo') {
                return $this->updatePhoto($request);
            } else {
                return $this->updateProfile($request);
            }
        }
        
        return view('settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePhoto(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'profile_photo' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'profile_photo.required' => 'Pilih foto terlebih dahulu.',
            'profile_photo.file' => 'File tidak valid.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.',
            'profile_photo.max' => 'Ukuran file terlalu besar. Maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $file = $request->file('profile_photo');
            
            // Additional validation
            if (!$file->isValid()) {
                return back()->withErrors(['profile_photo' => 'File tidak valid atau rusak.'])->withInput();
            }
            
            // Check file size again
            if ($file->getSize() > 2 * 1024 * 1024) {
                return back()->withErrors(['profile_photo' => 'Ukuran file terlalu besar. Maksimal 2MB.'])->withInput();
            }
            
            // Check if file is too small (likely corrupted)
            if ($file->getSize() < 1024) {
                return back()->withErrors(['profile_photo' => 'File terlalu kecil atau rusak.'])->withInput();
            }
            
            // Get image info to verify it's actually an image
            $imageInfo = getimagesize($file->getPathname());
            if ($imageInfo === false) {
                return back()->withErrors(['profile_photo' => 'File bukan gambar yang valid.'])->withInput();
            }
            
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo with unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $photoPath = $file->storeAs('profile-photos', $filename, 'public');
            
            $user->profile_photo = $photoPath;
            $user->save();

            return back()->with('success', 'Foto profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Profile photo upload error: ' . $e->getMessage());
            return back()->withErrors(['profile_photo' => 'Gagal mengupload foto. Silakan coba lagi.'])->withInput();
        }
    }

    public function deletePhoto(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Delete photo from storage if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }
        
        // Update user record to remove photo reference
        $user->profile_photo = null;
        $user->save();

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
} 