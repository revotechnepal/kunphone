@extends('backend.layouts.app')
@section('content')
<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Edit User <a href="{{route('admin.user.index')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View Users</a></h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel">
                        <div class="panel-body">
                            <form action="{{route('admin.user.update', $user->id)}}" method="POST" class="bg-light p-3">
                                @csrf
                                @method('PUT')
                                    <div class="form-group">
                                        <label for="name">Full Name: </label>
                                        <input type="text" name="name" class="form-control" value="{{$user->name}}" placeholder="Enter Full Name">
                                        @error('name')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email: </label>
                                        <input type="text" name="email" class="form-control" value="{{$user->email}}" placeholder="E-mail Address">
                                        @error('email')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role:</label>
                                        <select class="form-control" name="role_id" id="role">
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}" {{$role->id == $user->role_id ? 'selected' : ''}}>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" name="updatedetails" class="btn btn-success">Submit</button>
                                </form>
                        </div>
                    </div>
                    <h3 class="my-5">Change Password</h3>
                    <div class="panel">
                        <div class="panel-body">
                            <p>Note:If you dont want to change password then leave empty</p>
                            <form action="{{route('admin.user.update', $user->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="oldpassword">Old Password: </label>
                                    <input type="password" name="oldpassword" class="form-control" value="{{@old('oldpassword')}}" placeholder="Old Password">
                                    @error('oldpassword')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password: </label>
                                    <input type="password" name="new_password" class="form-control" value="{{@old('new_password')}}" placeholder="New Password">
                                    @error('new_password')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm New Password: </label>
                                    <input type="password" name="new_password_confirmation" class="form-control" value="{{@old('password_confirmation')}}" placeholder="Re-Enter New Password">
                                    @error('new_password_confirmation')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success" name="updatepassword">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
