$(document).ready(function () {
    // CSRF token'ını ayarla
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Sepete ürün ekleme
    $(document).on('click', '.add-to-cart', function () {
        var productId = $(this).data('id');
        $.post('/cart/add/' + productId, function (response) {
            alert(response.message);
            loadCartItems(); // Sepet ürünlerini güncelle
        }).fail(function (response) {
            alert(response.responseJSON.message);
        });
    });

    // Sepetten ürün silme
    $(document).on('click', '.remove-from-cart', function () {
        var productId = $(this).data('id');
        $.post('/cart/remove/' + productId, function (response) {
            alert(response.message);
            loadCartItems(); // Sepet ürünlerini güncelle
        }).fail(function (response) {
            alert(response.responseJSON.message);
        });
    });

    // Sepet içeriğini yükle
    function loadCartItems() {
        $.get('/cart/items', function (data) {
            var cartItems = '';
            $.each(data, function (index, product) {
                cartItems += `
                    <tr>
                        <td>${product.name}</td>
                        <td>${product.price} TL</td>
                        <td><img src="${product.image_url}" width="50" alt="${product.name}"></td>
                        <td>
                            <button class="btn btn-danger remove-from-cart" data-id="${product.id}">Sil</button>
                        </td>
                    </tr>
                `;
            });
            $('#cart-items tbody').html(cartItems);
        });
    }

    // Sepeti onaylama
    $('#confirm-cart').click(function () {
        $.post('/cart/confirm', function (response) {
            alert(response.message);
            loadCartItems(); // Sepeti boşaltmak için yenile
        }).fail(function (response) {
            alert(response.responseJSON.message);
        });
    });

    // Sayfa yüklendiğinde sepet içeriğini getir
    loadCartItems();
});


// Header'a kaydırma ile renk değiştirme işlevi
window.addEventListener("scroll", function () {
    const header = document.getElementById("header");
    if (window.scrollY > 50) {  // Belirli bir kaydırma mesafesi
        header.classList.add("kaydirildi");
    } else {
        header.classList.remove("kaydirildi");
    }
});


function initializeSlider(sliderClass) {
    let currentIndex = 0; // Başlangıçta gösterilecek ürünün indeksi
    const slides = document.querySelectorAll(`.${sliderClass} .product-slide`); // Tüm ürünleri seç
    const totalSlides = slides.length;

    // Ürünleri karıştırma fonksiyonu
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]]; // Değiştir
        }
        return array;
    }

    // Ürünleri karıştır
    const shuffledSlides = shuffleArray(Array.from(slides));

    // İlk ürünü göster
    shuffledSlides[currentIndex].style.display = 'block';

    function showNextSlide() {
        // Mevcut ürünü gizle
        shuffledSlides[currentIndex].style.display = 'none';

        // Sonraki ürünün indeksini hesapla
        currentIndex = (currentIndex + 1) % totalSlides; // Dolaşan döngü

        // Yeni ürünü göster
        shuffledSlides[currentIndex].style.display = 'block';
    }

    // Her 3 saniyede bir slide değiştir
    setInterval(showNextSlide, 3000);
}

// Slider'ı başlat
initializeSlider('slider-1');
initializeSlider('slider-2');


//     document.addEventListener('DOMContentLoaded', function() {
//     // "Sil" butonuna tıklama olayını yakala
//     document.querySelectorAll('.remove-from-cart').forEach(button => {
//         button.addEventListener('click', function () {
//             const productId = this.getAttribute('data-id');
//
//             // DELETE isteği gönder
//             fetch(`/cart/remove/${productId}`, {
//                 method: 'DELETE',
//                 headers: {
//                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
//                     'Content-Type': 'application/json'
//                 }
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.message === 'Ürün sepetten silindi.') {
//                         alert('Ürün başarıyla silindi.');
//                         location.reload(); // Sayfayı yeniden yükleyerek güncelle
//                     } else {
//                         alert('Ürün silinirken bir hata oluştu.');
//                     }
//                 })
//                 .catch(error => console.error('Hata:', error));
//         });
//     });
// });
