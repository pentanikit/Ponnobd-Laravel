<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Uploads;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UploaderController extends Controller
{
    public function index(Request $request)
    {
        // $all_uploads = (auth()->user()->user_type == 'admin') ? Uploads::where('user_id', auth()->user()->id) : Uploads::query();
        $all_uploads = Uploads::query();
        $search = null;
        $sort_by = null;

        if ($request->search != null) {
            $search = $request->search;
            $all_uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }

        $sort_by = $request->sort;
        switch ($request->sort) {
            case 'newest':
                $all_uploads->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $all_uploads->orderBy('created_at', 'asc');
                break;
            case 'smallest':
                $all_uploads->orderBy('file_size', 'asc');
                break;
            case 'largest':
                $all_uploads->orderBy('file_size', 'desc');
                break;
            default:
                $all_uploads->orderBy('created_at', 'desc');
                break;
        }

        $all_uploads = $all_uploads->paginate(60)->appends(request()->query());

        return (auth()->user()->user_type == 'seller')
            ? view('frontend.user.seller.uploads.index', compact('all_uploads', 'search', 'sort_by'))
            : view('backend.uploaded_files.index', compact('all_uploads', 'search', 'sort_by'));
    }

    public function create()
    {
        return (auth()->user()->user_type == 'seller')
            ? view('frontend.user.seller.uploads.create')
            : view('backend.uploaded_files.create');
    }

    public function show_uploader(Request $request)
    {
        return view('uploader.index');
    }

    public function upload(Request $request)
    {
        // dd($request->file('file')->move(public_path('uploads/all'),$request->file('file')->getClientOriginalName()));
        $type = [
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image',
            'svg' => 'image',
            'webp' => 'image',
            'gif' => 'image',
            'mp4' => 'video',
            'mpg' => 'video',
            'mpeg' => 'video',
            'webm' => 'video',
            'ogg' => 'video',
            'avi' => 'video',
            'mov' => 'video',
            'flv' => 'video',
            'swf' => 'video',
            'mkv' => 'video',
            'wmv' => 'video',
            'wma' => 'audio',
            'aac' => 'audio',
            'wav' => 'audio',
            'mp3' => 'audio',
            'zip' => 'archive',
            'rar' => 'archive',
            '7z' => 'archive',
            'doc' => 'document',
            'txt' => 'document',
            'docx' => 'document',
            'pdf' => 'document',
            'csv' => 'document',
            'xml' => 'document',
            'ods' => 'document',
            'xlr' => 'document',
            'xls' => 'document',
            'xlsx' => 'document',
        ];

        if ($request->hasFile('file')) {
            $extension = strtolower($request->file('file')->getClientOriginalExtension());

            if (isset($type[$extension])) {
                $upload = new Uploads();
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('file')->getClientOriginalName());

                for ($i = 0; $i < count($arr) - 1; $i++) {
                    if ($i == 0) {
                        $upload->file_original_name .= $arr[$i];
                    } else {
                        $upload->file_original_name .= '.'.$arr[$i];
                    }
                }

                $path = 'uploads/all/'.$request->file('file')->getClientOriginalName();
                $size = $request->file->getSize();

                $request->file('file')->move(public_path('uploads/all'), $request->file('file')->getClientOriginalName());

                if($type[$extension] == 'image') {
                    $this->convertToWebP(public_path($path));
                    $path = str_replace($extension, 'webp', $path);
                }

                $upload->extension = $extension;
                $upload->file_name = $path;
                $upload->user_id = auth()->id() ?? User::where('user_type', 'admin')->first()->id;
                $upload->type = $type[$upload->extension];
                $upload->file_size = $size;
                $upload->save();

                return response()->json([
                    'success' => true,
                ]);
            }

            return response()->json([
                'error' => 'file type not supported',
            ], 500);
        }
    }

    private function convertToWebP($inputImagePath)
    {
        $extension = pathinfo($inputImagePath, PATHINFO_EXTENSION);
        $latestPath = str_replace($extension, 'webp', $inputImagePath);

        $image = Image::make($inputImagePath);
        $image->encode('webp', 95);
        $image->save($latestPath);

        unlink($inputImagePath);
    }

    public function get_uploaded_files(Request $request)
    {
        // $uploads = Uploads::where('user_id', auth()->id());
        $uploads = Uploads::query();

        if ($request->search != null) {
            $uploads->where('file_original_name', 'like', '%'.$request->search.'%');
        }

        if ($request->sort != null) {

            match ($request->sort) {
                'newest' => $uploads->orderBy('created_at', 'desc'),
                'oldest' => $uploads->orderBy('created_at', 'asc'),
                'smallest' => $uploads->orderBy('file_size', 'asc'),
                'largest' => $uploads->orderBy('file_size', 'desc')
            };

        }

        return $uploads->paginate(60)->appends(request()->query());
    }

    public function destroy(Request $request, $id)
    {
        $upload = Uploads::findOrFail($id);

        if (auth()->user()->user_type == 'seller' && $upload->user_id != auth()->id()) {
            return back()->with('error', "You don't have permission for deleting this!");
        }

        try {

            unlink(public_path().'/'.$upload->file_name);

            $upload->delete();

            session()->flash('success', 'File deleted successfully!');
        } catch (\Exception $e) {
            $upload->delete();

            session()->flash('success', 'File deleted successfully!');
        }

        return back();
    }

    public function get_preview_files(Request $request)
    {
        $ids = explode(',', $request->ids);
        $files = Uploads::whereIn('id', $ids)->get();

        return $files;
    }

    public function attachment_download($id)
    {
        $project_attachment = Uploads::find($id);
        try {

            $file_path = public_path($project_attachment->file_name);

            return response()->download($file_path);
        } catch (\Exception $e) {

            session()->flash('error', 'File does not exist!');

            return back();
        }

    }

    public function file_info(Request $request)
    {
        $file = Uploads::findOrFail($request['id']);

        return (auth()->user()->user_type == 'seller')
            ? view('frontend.user.seller.uploads.info', compact('file'))
            : view('backend.uploaded_files.info', compact('file'));
    }
}
