<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get search query
        $search = $request->input('search');
        
        // Query API keys with search
        $apiKeys = ApiKey::where('user_id', $user->user_id)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('apiKeys.index', compact('apiKeys', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        
        // Generate random API key (32 characters for better security)
        $plainKey = 'sk_live_' . Str::random(32);
        
        // Hash the API key using SHA-256
        $hashedKey = hash('sha256', $plainKey);

        // Create API key with hashed value
        ApiKey::create([
            'user_id' => $user->user_id,
            'name' => $request->name,
            'key' => $hashedKey, // Store hashed key
            'total_call' => 0,
        ]);

        return redirect()->route('api-keys.index')
            ->with('success', 'API Key berhasil dibuat!')
            ->with('new_key', $plainKey); // Show plain key once for user to copy
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        $apiKey = ApiKey::where('apikey_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        $apiKey->delete();

        return redirect()->route('api-keys.index')
            ->with('success', 'API Key berhasil dihapus!');
    }
}
