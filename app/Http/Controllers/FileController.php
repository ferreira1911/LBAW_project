<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Needed for User::find()

class FileController extends Controller
{   

    static $default = 'default.jpg';
    static $diskName = 'Tutorial02';

    static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg', 'gif'],
        'post' => ['mp3', 'mp4', 'gif', 'png', 'jpg', 'jpeg'],
    ];

    // --- Private Helpers ---

    private static function isValidType(String $type) {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function defaultAsset(String $type) {
        return asset($type . '/' . self::$default);
    }

    private static function getFileName (String $type, int $id) {
        
        $fileName = null;
        switch($type) {
            case 'profile':
                $fileName = User::find($id)->profile_image;
                break;
            case 'post':
                // other models
                break;
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
            return asset($type . '/' . $fileName); // Return specific file
        }

        // Not found: returns default asset
        return self::defaultAsset($type);
    }


    function upload(Request $request) {

        // Parameters
        $file = $request->file('file');
        $type = $request->type;
        $id = $request->id;
        $extension = $file->getClientOriginalExtension();

        // Hashing
        $fileName = $file->hashName(); // generate a random unique id

        // Save in correct folder and disk
        $request->file->storeAs($type, $fileName, self::$diskName);
        
        return redirect()->back();
    }
}