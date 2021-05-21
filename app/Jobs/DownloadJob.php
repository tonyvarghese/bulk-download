<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Storage;
use ZipArchive;

class DownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $download;
    private $fileList;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($download, $fileList)
    {
        $this->download = $download;
        $this->fileList = $fileList;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zip = new ZipArchive;

        $zip->open(public_path('downloads' . $this->download->id), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            foreach ($this->fileList as $file) {

                $fileInfo = pathinfo($file);

                $fileName = $fileInfo['basename'];

                //Copying from S3 to local for creating zip
                Storage::disk('local')->put('local/' . $fileName, Storage::disk('s3')->get($file));

                // Using local instead of S3 for testing
                //Storage::disk('local')->put('local/' . $fileName, Storage::disk('local')->get('s3/' . $fileName));
                //sleep(2);

                if (file_exists(storage_path("app\local", $fileName))) {
                    $zip->addFile(storage_path("app\local", $fileName));
                }
            }

        $zip->close();

        //Changing status to 1 when zip is ready to download
        $this->download->status = 1; 
        $this->download->save();          
    }
}
