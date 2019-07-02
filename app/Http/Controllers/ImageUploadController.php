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
        $image->move(public_path('fotos'),$imageName);
        
        $imageUpload = new Foto();
        $imageUpload->path = $imageName;
        $imageUpload->save();
        return response()->json(['success'=>$imageName]);
    }
    public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        Foto::where('path',$filename)->delete();
        $path=public_path().'/fotos/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;  
    }


}
