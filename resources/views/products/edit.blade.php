@extends('layout')

@section('content')
    <div class="container-fluid">
        <h6> create product</h6>
        <form class="mx-5"
              enctype="multipart/form-data"
              method="post" action="{{route('products.store')}}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" value="{{old('name')}}" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Enter name" id="name">
            </div>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror


            <div class="form-group">
                <label for="brand_id">Select Brand</label>
                <select class="form-control select2" @error('name') is-invalid @enderror name="brand_id"
                        id="brand_id">
                    <option value="">Select brand</option>
                    @foreach($brands as $brand)
                        <option value="{{$brand->id}}"
                            {{--                        @if(old('brand_id')==$brand->id) selected @endif--}}
                            @selected(old('brand_id') == $brand->id)
                        >{{$brand->name}}</option>

                    @endforeach
                </select>
                @error('brand_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
                <label for="brand_id">Select Categories</label>
                <select class="form-control select2" multiple name="categories[]"
                        id="categories">

                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('brand_id')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" value="{{old('price')}}" name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       placeholder="Enter price" id="price">
            </div>
            @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror


            <div class="form-group">
                <label for="Description">Description:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                          id="Description">{{old('description')}}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" value="{{old('image')}}"
                       name="image" class="form-control @error('image') is-invalid @enderror"
                       id="image">
                @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-check">
                <label class="form-check-label">
                    <input name="status"
                           @checked(old('status') )
                           class="form-check-input" type="checkbox"> Status
                    {{old('name')}}
                </label>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
