@extends('layouts.admin')

@section('content')
    <div class="konteyner-2">
        <h1 class="səhifə-başlıq">Məhsulu Redaktə Et</h1>

        <form action="{{ route('admin.updateProduct', $product->id) }}" method="POST" class="məhsul-redaktə-formu">
            @csrf
            @method('PUT')

            <div class="form-qrupu">
                <label for="name" class="form-etiket">Məhsulun Adı</label>
                <input type="text" id="name" name="name" class="form-giriş" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-qrupu">
                <label for="price" class="form-etiket">Qiymət</label>
                <input type="text" id="price" name="price" class="form-giriş" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-qrupu">
                <label for="description" class="form-etiket">Təsvir</label>
                <textarea id="description" name="description" class="form-mətnarea">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-qrupu">
                <label for="image_url" class="form-etiket">Şəkil URL</label>
                <input type="text" id="image_url" name="image_url" class="form-giriş" value="{{ old('image_url', $product->image_url) }}" placeholder="Şəkil URL burada yapışdırın">
            </div>

            <button type="submit" class="btn btn-əsas">Məhsulu Yenilə</button>
        </form>
    </div>
@endsection
