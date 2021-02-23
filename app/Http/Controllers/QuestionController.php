<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOutgoing;
use App\Models\Question;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Question::latest()->with('user')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customername', function($row){
                    $customer = $row->user->name;
                    return $customer;
                })
                ->addColumn('productname', function($row){
                    $outproduct = ProductOutgoing::where('id', $row->outproduct_id)->first();
                    $product = Product::where('id', $outproduct->product_id)->first();
                    $productname = $product->name;
                    return $productname;
                })
                ->addColumn('storage', function($row){
                    $outproduct = ProductOutgoing::where('id', $row->outproduct_id)->first();
                    $storage = $outproduct->ram. '/' .$outproduct->rom ;
                    return $storage;
                })
                ->addColumn('date', function($row){
                    $date = date('Y/m/d h:i:s a', strtotime($row->created_at));
                    return $date;
                })
                ->addColumn('image', function($row){
                    $outproduct = ProductOutgoing::where('id', $row->outproduct_id)->first();
                    $product = Product::where('id', $outproduct->product_id)->first();

                    $src = Storage::disk('uploads')->url($product->modelimage);

                    $image = "<img src='$src' style='max-height: 100px;'>";
                    return $image;
                })
                ->addColumn('action', function($row){
                    $editurl = route('admin.questions.edit', $row->id);
                    $deleteurl = route('admin.questions.destroy', $row->id);
                    $csrf_token = csrf_token();
                    $btn = "<a href='$editurl' class='edit btn btn-primary btn-sm'>Give Answer</a>
                           <form action='$deleteurl' method='POST' style='display:inline-block;'>
                            <input type='hidden' name='_token' value='$csrf_token'>
                            <input type='hidden' name='_method' value='DELETE' />
                               <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                           </form>
                           ";

                            return $btn;
                })
                ->rawColumns([ 'customername','productname','storage','date','image', 'action'])
                ->make(true);
        }

        return view('backend.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findorFail($id);
        return view('backend.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::findorFail($id);
        $data = $this->validate($request, [
            'answer' => 'required'
        ]);

        $question->update([
            'answer' => $data['answer'],
        ]);
        return redirect()->route('admin.questions.index')->with('success', 'Answer is updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findorFail($id);
        $question->delete();
        return redirect()->back()->with('success', 'Question Successfully Deleted');
    }
}
