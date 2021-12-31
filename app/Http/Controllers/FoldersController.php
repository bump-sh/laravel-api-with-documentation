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
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return FolderResource::collection($request->user()->folders);
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
