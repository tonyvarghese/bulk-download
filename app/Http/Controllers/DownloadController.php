<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\DownloadJob;
use App\Models\Download;

class DownloadController extends Controller
{
    /**
     * Download files from S3
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        // Storing to downloads table to track the status
        $download = Download::create([
            'user_id' => auth()->user()->id,
            'file_name' => uniqid() . '.zip'
        ]);

        $fileList = auth()->user()->getFileList();

        DownloadJob::dispatch($download, $fileList);
        
        return redirect()->route('download.zip', [$download->id]);
    }

        /**
     * Download generated zip file
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadZip($id)
    {
        $download = Download::find($id);

        return view('download_zip', ['download' => $download]);
    }
}
