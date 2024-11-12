@extends('layouts.admin')

@section('content')
    <div class="konteyner mt-4">
        <h1 class="mb-4">Məhsulları İdarə Et</h1>

        <!-- Məhsul Əlavə Et Formu -->
        <div class="kart mb-4 kölgə-sını olmayan yuvarlaq">
            <div class="kart-başlıq bg-primary text-white">
                <h4 class="mb-0">Yeni Məhsul Əlavə Et</h4>
            </div>
            <div class="kart-bədən">
                <form action="{{ route('admin.addProduct') }}" method="POST" class="form2">
                    @csrf
                    <div class="form-qrup mb-3">
                        <label for="name" class="form-yarlıq">Məhsulun Adı</label>
                        <input type="text" name="name" class="form-nəzarət form-nəzarət-lg" required placeholder="Məhsul adını daxil edin">
                    </div>

                    <div class="form-qrup mb-3">
                        <label for="description" class="form-yarlıq">Məhsulun Təsviri</label>
                        <textarea name="description" class="form-nəzarət form-nəzarət-lg" placeholder="Məhsul təsvirini daxil edin"></textarea>
                    </div>

                    <div class="form-qrup mb-3">
                        <label for="price" class="form-yarlıq">Qiymət</label>
                        <input type="number" name="price" class="form-nəzarət form-nəzarət-lg" step="0.01" required placeholder="Qiyməti daxil edin">
                    </div>

                    <div class="form-qrup mb-3">
                        <label for="stock" class="form-yarlıq">Stok</label>
                        <input type="number" name="stock" class="form-nəzarət form-nəzarət-lg" required placeholder="Stok miqdarını daxil edin">
                    </div>

                    <div class="form-qrup mb-3">
                        <label for="image_url" class="form-yarlıq">Məhsul Şəkil URL-i</label>
                        <input type="text" name="image_url" class="form-nəzarət form-nəzarət-lg" required placeholder="Məhsul şəkil URL-i daxil edin">
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-blok elave" >Məhsul Əlavə Et</button>
                </form>
            </div>
        </div>

        <!-- Mövcud Məhsullar Cədvəli -->
        <h2 class="mb-4">Mövcud Məhsullar</h2>
        <div class="cedvel-cavabdeh">
            <table class="cedvel cedvel-sını sərhədli cedvel-kölgə yuvarlaq">
                <thead class="başlıq-tünd">
                <tr>
                    <th>Adı</th>
                    <th>Təsviri</th>
                    <th>Qiymət</th>
                    <th>Stok</th>
                    <th>Əməliyyatlar</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="pro-color">{{ $product->name }}</td>
                        <td class="pro-color">{{ Str::limit($product->description, 50) }}</td>
                        <td class="pro-color">${{ number_format($product->price, 2) }}</td>
                        <td class="pro-color">{{ $product->stock }}</td>
                        <td class="redd">
                            <a href="{{ route('admin.editProduct', $product->id) }}" class="btn btn-warning btn-sm px-3 redakte py-2">Redaktə Et</a>

                            <form action="{{ route('admin.deleteProduct', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm px-3 py-2">Sil</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
