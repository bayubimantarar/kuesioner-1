@extends('app')

@section('content')
	<h1 class="h3 mb-2 text-gray-800">Tambah Data Mata Kuliah</h1>
  <hr>
	
	<a href="{{ route('matkul.index') }}" class="btn btn-secondary btn-sm btn-icon-split mb-3">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Daftar Mata Kuliah</span>
  </a>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data</h6>
    </div>
    <form action="{{ route('matkul.create') }}" method="post">

		@csrf

	    @include('matkul.form')

	    <div class="card-footer">
	    	<div class="d-flex justify-content-end">
	    		<button class="btn btn-primary btn-icon-split" type="submit">
	    			<span class="icon text-white-50">
	    				<i class="fas fa-save"></i>
	    			</span>
	    			<span class="text">Simpan</span>
	    		</button>
	    	</div>
	    </div>

    </form>
  </div>
@endsection