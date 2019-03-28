<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\File;
use Storage;
use Illuminate\Support\Facades\Response;

class FilesController extends Controller
{
    public function addFiles(Request $request, $slug)
    {
        $path = storage_path().'/tasks/';
        $files = $request->file('file');
        foreach($files as $file){
            $task = Task::findBySlugOrIdOrFail($slug);
            $filename = str_random(20);
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $file->move($path, $filename.'.'.$extension);
            $_file = new File();
            $_file->task_id = $task->id;
            $_file->mime = $file->getClientMimeType();
            $_file->filename = $filename.'.'.$extension;
            $_file->original_filename = $originalName;
            $_file->save();
        }
        return redirect('tasks');
    }
    public function downloadFile(Request $request, $file)
    {
        $file_path = storage_path().'/tasks/'.$file;
        if(file_exists($file_path))
        {
            return Response::download($file_path, $file,[
                'Content-Lenght:'. filesize($file_path)]);
        }
        else{
            abort(404);
        }   
    }        
        
}
