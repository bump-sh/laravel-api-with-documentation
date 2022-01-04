<?php

namespace App\Http\Controllers;

use App\Http\Resources\Folder as FolderResource;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @group Folders
 */
class FoldersController extends Controller
{
    /**
     * List all folders.
     *
     * @apiResourceCollection App\Http\Resources\Folder
     * @apiResourceModel App\Models\Folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return FolderResource::collection($request->user()->folders);
    }

    /**
     * Create a new folder.
     *
     * @apiResource App\Http\Resources\Folder
     * @apiResourceModel App\Models\Folder
     * @bodyParam name string required The name of the folder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('folders')->where('user_id', $request->user()->id),
            ],
        ]);

        $folder = $request->user()->folders()->create([
            'name' => $request->name,
        ]);

        return FolderResource::make($folder);
    }

    /**
     * Show a folder.
     *
     * @apiResource App\Http\Resources\Folder
     * @apiResourceModel App\Models\Folder
     * @urlParam id int required The id of the folder to show.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Folder $folder)
    {
        return FolderResource::make($folder);
    }

    /**
     * Update a folder.
     *
     * @apiResource App\Http\Resources\Folder
     * @apiResourceModel App\Models\Folder
     * @urlParam id int required The id of the folder to update.
     * @bodyParam name string The new name of the folder.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => [
                'max:255',
                Rule::unique('folders')->where('user_id', $request->user()->id)->ignore($folder->id),
            ],
        ]);

        $folder->update([
            'name' => $request->input('name', $folder->name),
        ]);

        return FolderResource::make($folder);
    }

    /**
     * Delete a folder.
     *
     * @urlParam id int required The id of the folder to delete.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();

        return response()->noContent();
    }
}
