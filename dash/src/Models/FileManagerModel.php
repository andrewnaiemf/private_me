<?php
namespace Dash\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Imagick;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerModel extends Model {
	use SoftDeletes;
	protected $table    = 'filemanager';
	protected $dates    = ['deleted_at'];
	protected $fillable = [
		'user_id',
		'file',
		'full_path',
		'file_type',
		'file_id',
		'path',
		'ext',
		'name',
		'size',
		'size_bytes',
		'mimtype',
        'directory_id'
	];
    protected $appends = ['first_page_image'];

    public function getFirstPageImageAttribute()
    {
        if ($this->file_id == 3 && in_array($this->ext, ['pdf'])) {

            if (Storage::exists($this->full_path)) {
                $imagick = new Imagick();
                $imagick->readImage($this->full_path . '[0]'); // Read only the first page
                $imgSavePath = $this->path . Str::beforeLast($this->name, '.') . '.png';
                if (!Storage::exists($imgSavePath)) {
                    $imgSavePath = storage_path($imgSavePath);
                    $imagick->setImageFormat('png');
                    $imagick->writeImage($imgSavePath);
                    return Storage::url($imgSavePath);
                }else{
                    return $imgSavePath;
                }

            } else {
                // Handle case where the PDF file doesn't exist
                return null;
            }
        }
    }


	public function user() {
		return \DB::table('users')->where('id', $this->user_id)->first();
	}
}
