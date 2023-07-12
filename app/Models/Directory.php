<?php

namespace App\Models;

use Dash\Models\FileManagerModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Directory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'directory_type_id', 'user_id', 'size_bytes', 'left', 'right', 'parent_id'];
    protected $hidden = [
		'crraed_at',
        'updated_at',
        'deleted_at',
	];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function directoryType()
    {
        return $this->belongsTo(DirectoryType::class, 'directory_type_id');
    }

    public function parent()
    {
        return $this->belongsTo(Directory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Directory::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(FileManagerModel::class, 'directory_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren', 'files');
    }
}
