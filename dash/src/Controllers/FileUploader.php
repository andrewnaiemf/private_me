<?php
namespace Dash\Controllers;

use App\Models\User;
use Dash\Models\FileManagerModel;
use Storage;
trait FileUploader {

    public static function upload($files, $path, $typeid = 'image', $id = null , $directory_id  = null) {

        if (substr($path, -1) == '/') {
			$path = substr($path, 0, -1);
		}
        $upload = null; // Initialize the $upload variable
        $total_size_bytes = 0;

        foreach ($files as $file) {
            $ext        = $file->getClientOriginalExtension();
            $name       = $file->getClientOriginalName();
            $size       = self::GetSize($file->getSize());
            $size_bytes = $file->getSize();

            $availability = self::CheckAvailableSpace( $size_bytes);

            if (!$availability) {
                continue;
            }

            $mimtype    = $file->getMimeType();
            $hashname   = $file->hashName();

            if (env('FILESYSTEM_DRIVER') == 's3') {
                $file = request()->file($request);

                $filePath = $path.'/'.$name;
                Storage::disk(env('FILESYSTEM_DRIVER', 's3'))->put($filePath, file_get_contents($file));
                $full_path = Storage::disk(env('FILESYSTEM_DRIVER', 's3'))->url($filePath);
            } else {
                $full_path = $path.'/'.$hashname;
                $file->store('public/'.$path);
            }

            $upload = FileManagerModel::create([
				'user_id'    => auth()->user()->id,
				'file'       => $hashname,
				'full_path'  => $full_path,
				'file_type'  => $typeid,
				'file_id'    => $id,
				'path'       => $path,
				'ext'        => $ext,
				'name'       => $name,
				'size'       => $size,
				'size_bytes' => $size_bytes,
				'mimtype'    => $mimtype,
                'directory_id' =>  $directory_id
			]);
            $total_size_bytes += $size_bytes;

        }
        if ($upload) { // Check if $upload variable is set

            if (filter_var($upload->full_path, FILTER_VALIDATE_URL)) {
                return response([
                        'url' => $upload->full_path,
                        'id'  => $upload->id,
                        'size_bytes' => $total_size_bytes,
                    ], 200);
            } else {
                // $url = Storage::disk(env('FILESYSTEM_DRIVER', 'public'))->url($upload->full_path);
                return response([

                        'size_bytes' => $total_size_bytes,
                    ], 200);
            }
        }
	}

	public static function GetSize($bytes) {
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes/1073741824, 2).' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes/1048576, 2).' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes/1024, 2).' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes.' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes.' byte';
		} else {
			$bytes = '0 bytes';
		}
		return $bytes;
	}


    public static function CheckAvailableSpace($size_bytes) {

        $un_used_space = User::find(auth()->user()->id)->un_used_storage;
        // dd($un_used_space , $size_bytes);
        if($un_used_space < $size_bytes){

            return false;
        }
        return true;
	}



}
