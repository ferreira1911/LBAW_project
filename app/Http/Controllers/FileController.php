<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Needed for User::find()
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{   

    static $default = 'default.png';
    static $diskName = 'Tutorial02';

    static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg', 'gif'],
        'post' => ['mp3', 'mp4', 'gif', 'png', 'jpg', 'jpeg'],
        'auction' => ['png', 'jpg', 'jpeg']

    ];

    // --- Private Helpers ---

    private static function isValidType(String $type) {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function defaultAsset(String $type) {
        return asset('images/' . $type . '/' . self::$default);
    }

    private static function getFileName(String $type, int $id) {

        $fileName = null;
        switch($type) {
            case 'profile':
                $fileName = User::find($id)->url;
                break;
            case 'post':
                // other models
                break;
            case 'auction':
                $fileName = \App\Models\Auction::find($id)->picture ?? null;
                break;
            default:
                return null;
        }

        return $fileName;
    }

    // --- Public Method ---

    static function get(String $type, int $userId) {

        // Validation: upload type
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }

        // Validation: file exists
        $fileName = self::getFileName($type, $userId);
        if ($fileName) {
            $filePath = 'images/' . $type . '/' . $fileName;
            return Storage::disk(self::$diskName)->url($filePath); // Return specific file
        }

        // Not found: returns default asset
        return self::defaultAsset($type);
    }


    function upload(Request $request) {

        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'Error: File not found');
        }
        if (!self::isValidType($request->type)) {
            return redirect()->back()->with('error', 'Error: Unsupported upload type');
        }

        $file = $request->file('file');
        $type = $request->type;
        $id = $request->id;

        self::delete($type, $id);

        $fileName = $file->hashName();

        $error = null;
        switch($request->type) {
            case 'profile':
                $user = User::findOrFail($id);
                if ($user) {
                    $user->url = $fileName;
                    $user->save();
                } else {
                    $error = "unknown user";
                }
                break;
            case 'post':
                break;
            case 'auction':
                $auction = \App\Models\Auction::findOrFail($id);
                if ($auction) {
                    $auction->picture = $fileName;
                    $auction->save();
                } else {
                    $error = "unknown auction";
                }
                break;
            default:
                return redirect()->back()->with('error', 'Error: Unsupported upload object');
        }

        if ($error) {
            return redirect()->back()->with('error', "Error: {$error}");
        }

        $folderPath = 'images/' . $type;
        $file->storeAs($folderPath, $fileName, self::$diskName);
        
        return redirect()->back()->with('success', 'Success: upload completed!');
    }

    public static function delete(String $type, int $id) {
        $existingFileName = self::getFileName($type, $id);
        if ($existingFileName) {
            
            $folderPath = 'images/' . $type;
            Storage::disk(self::$diskName)->delete($folderPath . '/' . $existingFileName);

            switch($type) {
                case 'profile':
                    $user = User::find($id);
                    if ($user) {
                        $user->url = null;
                        $user->save();
                    }
                    break;
                case 'post':
                    // Lógica para apagar ficheiros de posts
                    break;
                case 'auction':
                    $auction = \App\Models\Auction::find($id);
                    if ($auction) {
                        $auction->picture = null;
                        $auction->save();
                    }
                    break;
            }
        }
    }
    
}