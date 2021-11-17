<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    public function upload(Request $request){

        //Validacion de archivo
        $validator = Validator::make($request->all(), [
            'file' => 
            'required|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['Error'=>$validator->errors()], 401);
        }


        //Almacenar archivo.
        if ($file = $request->file('file')) {
            
            $path = $file->store('public/img');
            $name = $file->getClientOriginalName();

            //Almacenar tu archivo en el directorio y db
            $save = new File();
            $save->name = $name;
            $save->path = $path;
            $save->save();

            return response()->json([
                "success" => true,
                "message" => "Archivo subido satisfactoriamente",
                "file address" => $path
            ]);

        }



    }
}
