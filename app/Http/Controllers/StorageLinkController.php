<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StorageLinkController extends Controller
{
    /**
     * Create storage symlink via web browser.
     * Useful for shared hosting without terminal access.
     */
    public function createLink()
    {
        try {
            // Check if link already exists
            $linkPath = public_path('storage');
            
            if (File::exists($linkPath)) {
                // Check if it's a valid symlink
                if (is_link($linkPath)) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Storage link already exists!',
                        'type' => 'info'
                    ]);
                }
                
                // If it's a directory, remove it first
                if (is_dir($linkPath)) {
                    File::deleteDirectory($linkPath);
                }
            }
            
            // Create the symlink
            $targetPath = storage_path('app/public');
            
            // Ensure target directory exists
            if (!File::exists($targetPath)) {
                File::makeDirectory($targetPath, 0755, true);
            }
            
            // Create symlink
            if (symlink($targetPath, $linkPath)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Storage link created successfully!',
                    'type' => 'success',
                    'details' => [
                        'from' => $targetPath,
                        'to' => $linkPath
                    ]
                ]);
            }
            
            throw new \Exception('Failed to create symlink');
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create storage link: ' . $e->getMessage(),
                'type' => 'error',
                'solution' => 'Try manual method: Create a folder named "storage" in public directory, then copy contents from storage/app/public to public/storage'
            ], 500);
        }
    }
    
    /**
     * Check storage link status.
     */
    public function checkLink()
    {
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');
        
        $status = [
            'link_exists' => File::exists($linkPath),
            'is_symlink' => is_link($linkPath),
            'target_exists' => File::exists($targetPath),
            'link_path' => $linkPath,
            'target_path' => $targetPath,
        ];
        
        if ($status['is_symlink']) {
            $status['link_target'] = readlink($linkPath);
            $status['is_valid'] = $status['link_target'] === $targetPath;
        }
        
        return response()->json([
            'success' => true,
            'status' => $status
        ]);
    }
}
