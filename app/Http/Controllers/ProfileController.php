<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use DataTables;
use Redirect, Response;

class ProfileController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $data = Profile::get();
      return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {

          $action = '<a class="fa fa-eye" id="show-profile" data-toggle="modal" data-id=' . $row->id . '></a>
<a class="fa fa-edit" id="edit-profile" data-toggle="modal" data-id=' . $row->id . '></a>
<meta name="csrf-token" content="{{ csrf_token() }}">
<a id="delete-profile" data-id=' . $row->id . ' class="fa fa-trash delete-profile"></a>';

          return $action;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    return view('usuarios');
  }

  public function store(Request $request)
  {

    $r = $request->validate([
      'name' => 'required',
      'email' => 'required',

    ]);

    $uId = $request->user_id;
    Profile::updateOrCreate(['id' => $uId], ['name' => $request->name, 'email' => $request->email]);
    if (empty($request->user_id))
      $msg = 'User created successfully.';
    else
      $msg = 'User data is updated successfully';
    return redirect()->route('users.index')->with('success', $msg);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */

  public function show($id)
  {
    $where = array('id' => $id);
    $user = Profile::where($where)->first();
    return Response::json($user);
    //return view('users.show',compact('user'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */

  public function edit($id)
  {
    $where = array('id' => $id);
    $user = Profile::where($where)->first();
    return Response::json($user);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */

  public function destroy($id)
  {
    $user = Profile::where('id', $id)->delete();
    return Response::json($user);
    //return redirect()->route('users.index');
  }
}
