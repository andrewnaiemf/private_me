<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Directory as ModelsDirectory;
use App\Models\User;
use Dash\Controllers\FileUploader;
use Dash\Models\FileManagerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class UploadUserDataController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:video,image,file',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video.*' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime|max:50000',
            'file.*' => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'directory_id' => 'nullable|exists:directories,id'
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(401,$validator->errors()->all());
        }


        $user = User::find(auth()->user()->id);
        $types = ['video' => 1, 'image' => 2, 'file' => 3];

        $type = $request->type;
        $name = $request->name;

        $basePath = "Customer/{$user->id}/Space/{$type}";

        $directory_id = $request->directory_id;
        $directory = ModelsDirectory::find( $directory_id );

        if ( $directory_id ) {


            if( $directory ){
                $directory_name = $directory->name;
            }

            $basePath .= '/'.$directory_name;
        }

        $path = "{$basePath}/{$name}";


        $files = $request->file($type);

        $result = $this->upload($files, $path, $request->type, $types[$request->type], $directory_id );

        if(!$result){
            return $this->returnError(trans("api.YouHaveNotEnoughSpace"));
        }

        $size_bytes = $result->original['size_bytes'];

        if ( $directory ) {
            $total_size_bytes = $directory->size_bytes + $size_bytes;
            $directory->update([ 'size_bytes' => $total_size_bytes]);

            $user->un_used_storage -=  $size_bytes;
            $user->update(['un_used_storage' => $user->un_used_storage]);
        }

        return $this->returnSuccessMessage( trans("api.user'sdataUploadedSuccessfully") );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find(auth()->user()->id);

        $file = FileManagerModel::find($id);

        $full_path = 'public/' .$file->full_path;

        if( \Storage::exists($full_path)){
            $user->un_used_storage += $file->size_bytes;
            $user->update(['un_used_storage' => $user->un_used_storage]);
            \Storage::delete($full_path);
            $file->delete();
        }

        return $this->returnSuccessMessage( trans("api.user'sFileDeletedSuccessfully") );
    }
}
