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
        switch ($this->ext) {
            case 'pdf':
                return 'Default/pdf.png';
                break;
            case 'csv':
                return 'Default/csv.png';
                break;
            case 'Doc':
                return 'Default/Doc.png';
                break;
            case 'txt':
                return 'Default/txt.png';
                break;
            case 'xml':
                return 'Default/xml.png';
                break;
            default:
                return null;
                break;
        }
    }


	public function user() {
		return \DB::table('users')->where('id', $this->user_id)->first();
	}
}
