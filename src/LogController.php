<?php

namespace LaveroAdmin\Admin\LogViewer;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaveroAdmin\Admin\Facades\Admin;
use LaveroAdmin\Admin\Layout\Content;

class LogController extends Controller
{
    public function index(Request $request, $file = null)
    {
        if ($file === null) {
            $file = (new LogViewer())->getLastModifiedLog();
        }

        return Admin::content(function (Content $content) use ($file, $request) {
            $offset = $request->get('offset');

            $viewer = new LogViewer($file);

            $content->body(view('lavero-admin-logs::logs', [
                'logs'                           => $viewer->fetch($offset),
                'logFiles'                       => $viewer->getLogFiles(),
                'fileName'                       => $viewer->file,
                'end'                            => $viewer->getFilesize(),
                'tailPath'                       => route('log-viewer-tail', ['file' => $viewer->file]),
                'prevUrl'                        => $viewer->getPrevPageUrl(),
                'nextUrl'                        => $viewer->getNextPageUrl(),
                'filePath'                       => $viewer->getFilePath(),
                'size'                           => static::bytesToHuman($viewer->getFilesize()),
                'bypass_protected_urls_find'     => $viewer->bypass_protected_urls_find,
                'bypass_protected_urls_replace'  => $viewer->bypass_protected_urls_replace,
            ]));

            $content->header($viewer->getFilePath());
        });
    }

    public function tail(Request $request, $file)
    {
        $offset = $request->get('offset');

        $viewer = new LogViewer($file);

        list($pos, $logs) = $viewer->tail($offset);

        return compact('pos', 'logs');
    }

    public function download($file)
    {
        $viewer = new LogViewer($file);
        $path = $viewer->getFilePath();

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path, basename($path));
    }

    public function clear($file)
    {
        $viewer = new LogViewer($file);
        $path = $viewer->getFilePath();

        if (file_exists($path) && is_writable($path)) {
            file_put_contents($path, '');
        }

        admin_toastr('Log file cleared.', 'success');

        return redirect()->route('log-viewer-file', ['file' => $file]);
    }

    protected static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}
