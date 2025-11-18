<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get API key from Authorization header
        $apiKey = $request->header('Authorization');
        
        // Check if Authorization header exists
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Key is required. Please provide Authorization header.',
            ], 401);
        }
        
        // Remove "Bearer " prefix if exists
        $apiKey = str_replace('Bearer ', '', $apiKey);
        
        // Validate API key in database
        $validKey = ApiKey::where('key', $apiKey)->first();
        
        if (!$validKey) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API Key.',
            ], 401);
        }
        
        // Increment total call
        $validKey->incrementCall();
        
        // Attach API key to request for use in controller
        $request->merge(['api_key_record' => $validKey]);
        
        return $next($request);
    }
}
