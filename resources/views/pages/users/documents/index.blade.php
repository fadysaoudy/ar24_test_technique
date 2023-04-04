@extends('layouts.app')
@section('upload_document_form')

    <div class="container w-50">

        <form enctype="multipart/form-data" class="mx-auto my-5">
            <div class="form-group pb-4">
                <label class="form-label" for="customFile">Upload Document</label>
                <input type="file" class="form-control" id="customFile"/>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
@endsection
