<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Directory as ModelsDirectory;
use App\Models\User;
use Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Finder\Finder;
use Storage;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $directories = ModelsDirectory::with('files','allChildren.files')
        ->whereNull('parent_id')
        ->where(['user_id' => auth()->user()->id])
        ->get();

        return $this->returnData($directories);
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
            'type' => 'string|required|In:video,image,file',
            'name' => 'required|string',
            'directory_id' => 'nullable|exists:directories,id',
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(401,$validator->errors()->all());
        }

        $user = User::find(auth()->user()->id);

        $directories = ['video' => 1, 'image' => 2, 'file' => 3];

        $basePath = "Customer/{$user->id}/Space/";
        $type = $request->type;
        $name = $request->name;

        $path = "{$basePath}/{$type}/{$name}";

        if (! \Storage::exists('public'.$path)) {
            \Storage::disk('public')->makeDirectory($path);
        }

        $parentDirectory = null;
        if ($request->has('parent_id')) {
            // Get the parent directory
            $parentDirectory = ModelsDirectory::find($request->parent_id);

            // Get the last right value of the parent directory
            $lastRightValue = ModelsDirectory::where('parent_id', $parentDirectory->id)
                ->max('right');

                // Calculate the new left and right values
            $newLeftValue = $lastRightValue + 1;
            $newRightValue = $newLeftValue + 1;
        }

        $directory = ModelsDirectory::create([
            'directory_type_id' => $directories[$request['type']],
            'name' => $request->name,
            'user_id' => $user->id,
            'parent_id' => $parentDirectory ? $parentDirectory->id : null,
            'left' => $newLeftValue ?? 0,
            'right' =>  $newRightValue ?? 0,
        ]);

        return $this->returnSuccessMessage( trans("api.folderCreatedsuccessfully") );

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
        $validator = Validator::make($request->all(), [
            'type' => 'string|required|In:videos,images,files',
            'name' => 'required|string',

        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(401,$validator->errors()->all());
        }

        $user = User::find(auth()->user()->id);
        $directory = ModelsDirectory::find($id);

        $basePath = "Storage/Customer/{$user->id}/Space/";
        $type = $request->type;
        $newName = $request->name;

        $path = "{$basePath}/{$type}/{$directory->name}";

        if (file_exists($path)) {
            rmdir($path);
            $newPath = "{$basePath}/{$type}/{$newName}";
            mkdir($newPath, 0777, true);
        }

        $directory->update(['name' => $request->name]);

        return $this->returnSuccessMessage( trans("api.folderRenamedsuccessfully") );

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
        $directory = ModelsDirectory::find($id);
        $basePath = "storage/Customer/{$user->id}/Space";

        $path = "{$basePath}/{$directory->directoryType->name}/{$directory->name}";


        if (file_exists(public_path($path))) {

            $directory_size_bytes = $this->getDirectorySize($path);

            $total_un_used_space = $user->un_used_storage +  $directory_size_bytes;

            $user->update(['un_used_storage' => $total_un_used_space]);

            File::deleteDirectory(public_path($path));
            $directory->update(['size_bytes' => 0]);
            $directory->files()->delete();
            $directory->delete();
        }



        return $this->returnSuccessMessage( trans("api.folderDeletedsuccessfully") );
    }


    function getDirectorySize($directoryPath)
    {
        $totalSize = 0;

        // Get all files and directories within the given directory
        $contents = File::allFiles(public_path($directoryPath));
        // dd( $contents );
        foreach ($contents as $file) {
            $totalSize += $file->getSize();
        }

        return $totalSize;

        return $totalSize;
    }
}
