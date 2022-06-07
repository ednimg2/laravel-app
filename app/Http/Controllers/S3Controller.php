<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{
    public function createFileWithPut()
    {
        $array = [
            'name' => 'Desk',
            'price' => 100,
        ];

        Storage::disk('digitalocean')->put('files/example.json', json_encode($array));

        echo Storage::disk('digitalocean')->url('files/example.json');
    }

    public function getFileContent()
    {
        dump(Storage::disk('digitalocean')->get('files/example.json'));

        dump(Storage::disk('digitalocean')->exists('files/example.json'));
        dd(Storage::disk('digitalocean')->missing('files/example.json'));
    }

    public function downloadFile()
    {
        //dd(Storage::download('example.txt'));
        return Storage::disk('digitalocean')->download('files/example.json');
    }

    public function temporaryUrl()
    {
        $url = Storage::disk('digitalocean')->temporaryUrl('files/example.json', now()->addSecond(30));

        dump($url);
    }

    public function visibilityFile()
    {
        Storage::disk('digitalocean')->put('files/hello.txt', 'Hello World', 'private');

        echo Storage::disk('digitalocean')->url('files/hello.txt');

        dump(Storage::disk('digitalocean')->get('files/hello.txt'));

        dump(Storage::disk('digitalocean')->getVisibility('files/hello.txt'));

        Storage::disk('digitalocean')->setVisibility('files/hello.txt', 'public');

        dump(Storage::disk('digitalocean')->getVisibility('files/hello.txt'));
    }
}
