<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;

class ImageUploadController extends Controller
{
    public function fileCreate()
    {
        return view('imageupload');
    }
    public function fileStore(Request $request)
    {
        $image = $request->file('file');

        $imageName = $image->getClientOriginalName();
        $image->storeAs('file', $imageName);
       
        
        $imageUpload = new Foto();
        $imageUpload->path = 'file/' . $imageName;
        $imageUpload->entrada_id = 8;
        $imageUpload->save();
        return response()->json(['success'=>$imageName]);
    }
    public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        $compare = 'file/' . $filename;
        Foto::where('path', $compare)->delete();
        $path=storage_path('app/public').'/'.$compare;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }


}
