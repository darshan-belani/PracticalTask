<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Datatables;

class BlogController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add()
    {
        return view('addBlog');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ], [
            'title.required' => 'Please enter title',
            'image.required' => 'Please choose image',
            'description.required' => 'Please enter description',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('success', $validator);
        } else {
            if ($request->image) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
            }
            $addBlog = blog::create([
                "title" => $request['title'],
                "description" => $request['description'],
                "image" => $imageName,
                "user_id" => auth()->user()->id,
            ]);

        }
        if ($addBlog) {
            return redirect()->route('list')->with('success', 'Blog added successfully');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Yajra\DataTables\Exceptions\Exception
     */
    public function blogList() {
        if(request()->ajax()) {
            $blogData = blog::query();
            if (auth()->user()->role == "blogger") {
                $blogData = $blogData->where('user_id', auth()->user()->id);
            }
            $blogData->with('user')->get();
            return datatables()->of($blogData)
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('view', $row->id) . '" class="edit btn btn-success btn-sm">View</a>';
                    return $actionBtn;
                })
                ->addColumn('user', function($row){
                    return $row->user->name;
                })
                ->editColumn('image', function($row){
                    $url= asset('images/'.$row->image);
                    return $url;
                })
                ->editColumn('created_at', function($row){
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->rawColumns(['action', 'user'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('blogList');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view($id)
    {
        $blogData = blog::find($id);
        return view('detailsBlog', compact('blogData'));
    }

}
