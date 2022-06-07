<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function createFileWithPut()
    {
        $array = [
            'name' => 'Desk',
            'price' => 100,
        ];

        if (Storage::put('example.txt', json_encode($array)))
        {
            echo 'ok';
        }

        $filePath2 = Storage::disk('public')->put('example2.txt', json_encode($array));
        $filePath3 = Storage::disk('public_files')->put('example3.txt', json_encode($array));
        $filePath3 = Storage::disk('public')->put('files/example4.txt', json_encode($array));

        echo asset(Storage::url('example.txt'));
        echo '<br>';
        echo '<a href="' . asset(Storage::url('example2.txt')) .'" >download example</a>';
        echo '<br>';
        echo asset(Storage::url('example2.txt'));
        echo '<br>';
        echo asset(Storage::disk('public_files')->url('example3.txt'));
        echo '<br>';
        echo asset(Storage::url('files/example4.txt'));
        echo '<br>';
        echo '<a href="'. url('file/download') .'">download</a>';

        echo '<br>';
        echo Storage::url('example2.txt');
    }

    public function getFileContent()
    {
        if (Storage::exists('example.txt')) {
            $content = Storage::get('example.txt');

            dump($content);
        }

        dump(Storage::exists('example5.txt'));
        dd(Storage::missing('example5.txt'));
    }

    public function downloadFile()
    {
        //dd(Storage::download('example.txt'));
        return Storage::download('example.txt', 'failas.json');
    }

    public function getMeta()
    {
        dump(Storage::size('file1.jpg'));
        dump(Storage::lastModified('file1.jpg'));
        dump(Storage::mimeType('file1.jpg'));
        dump(Storage::path('file1.jpg'));
    }

    public function prependAppendFile()
    {
        Storage::prepend('example6.txt', '3');
        Storage::append('example7.txt', '2');
    }

    public function copyMoveFile()
    {
        Storage::move('example6.txt', 'example/example6.txt');
        Storage::copy('example7.txt', 'example/example7_1.txt');
    }

    public function saveWithUniqId()
    {
        $filePath = Storage::disk('public')->putFile('example', new File('storage/file1.jpg'));

        //$filePath = Storage::disk('public')->putFileAs('example', new File('storage/file1.jpg'), 'kazkoks.jpg');

        echo asset(Storage::url($filePath));
        dd($filePath);
    }

    public function deleteFile()
    {
        Storage::delete('$$example.txt');
        Storage::disk('public')->delete('example/kazkoks.jpg');
        Storage::delete(['example.txt', 'example2.txt', 'example7.txt']);
    }

    public function getFilesAndDirectories()
    {
        dump(Storage::files('example'));
        dump(Storage::allFiles());
        dump(Storage::directories());
        dump(Storage::allDirectories());

        Storage::deleteDirectory('example');
        Storage::makeDirectory('example1');
    }
}
