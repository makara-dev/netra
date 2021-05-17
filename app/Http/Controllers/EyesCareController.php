<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EyesCareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('eyecare/index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // blog
    public function blog(){
        return view('eyecare/blog');
    }
    public function blogdetail($id){
        // process query when user decide to have db
        return view('eyecare/blog-detail')->with('id', $id);
    }

    // diy
    public function diy(){
        return view('eyecare/diy');
    }
    public function diydetail($id){
        // process query when user decide to have db
        return view('eyecare/diy-detail')->with('id', $id);
    }

    // youtube
    public function youtube(){
        // return view('eyecare/youtube');
        return view('eyecare/index');
    }
}
