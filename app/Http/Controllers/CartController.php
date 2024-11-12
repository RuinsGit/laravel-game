<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class CartController extends Controller
{
    // Sepete ürün ekle
    public function add(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            // Mevcut sepeti oturumdan al
            $cart = session()->get('cart', []);

            // Sepete ürünü ekle veya miktarını artır
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'id' => $product->id,   // Ürün ID'sini ekliyoruz
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'image_url' => $product->image_url,
                ];
            }

            // Sepeti oturuma kaydet
            session()->put('cart', $cart);
            return response()->json(['message' => 'Ürün sepete eklendi.']);
        }

        return response()->json(['message' => 'Ürün bulunamadı.'], 404);
    }

    // Sepeti görüntüle
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart')); // 'cart.index' görünümüne yönlendir
    }

    // Sepeti onayla ve WhatsApp mesajı gönder
    public function confirmCart()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş.');
        }

        // Giriş yapmış kullanıcı bilgisi
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Lütfen önce giriş yapınız.');
        }

        // WhatsApp mesajı göndermek için Twilio yapılandırması
        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.token');
        $twilioClient = new Client($twilioSid, $twilioToken);

        $recipient = 'whatsapp:+994514940398'; // Alıcı numarası

        try {
            // Siparişi veritabanına kaydet
            foreach ($cart as $product) {
                if (!isset($product['id'])) {
                    // id eksikse, hata mesajı döndür
                    return redirect()->route('cart.index')->with('error', 'Sepette ürün ID eksik.');
                }

                // Sipariş kaydını veritabanına ekle
                $order = new Order();
                $order->user_id = $user->id;
                $order->product_id = $product['id'];  // Ürün ID'sini kullanıyoruz
                $order->quantity = $product['quantity'];
                $order->total_price = $product['price'] * $product['quantity'];
                $order->status = 'pending'; // Varsayılan olarak "pending" durumu
                $order->save();

                // WhatsApp mesajı içeriğini oluştur
                $messageBody = "🛒 *Ürün Adı:* {$product['name']}\n";
                $messageBody .= "💲 *Fiyat:* {$product['price']} TL\n";
                $messageBody .= "📦 *Miktar:* {$product['quantity']}\n";
                $messageBody .= "-----------------------------------\n"; // Ürünler arasında ayrım için
                $messageBody .= "👤 *Kullanıcı:* {$user->name}\n"; // Kullanıcı adı ekliyoruz

                // Önce resmi gönder
                if (!empty($product['image_url'])) {
                    $twilioClient->messages->create(
                        $recipient,
                        [
                            'from' => 'whatsapp:+14155238886', // Twilio WhatsApp numarası
                            'mediaUrl' => [$product['image_url']], // Ürün fotoğrafını gönder
                            'body' => $messageBody // Mesajı aynı anda ekliyoruz
                        ]
                    );
                } else {
                    // Eğer ürün resmi yoksa, yalnızca metin mesajını gönder
                    $twilioClient->messages->create(
                        $recipient,
                        [
                            'from' => 'whatsapp:+14155238886', // Twilio WhatsApp numarası
                            'body' => $messageBody
                        ]
                    );
                }
            }

            // Sepeti boşalt
            session()->forget('cart');
            return redirect()->route('products')->with('success', 'Sepet onaylandı ve mesaj gönderildi.');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', 'Mesaj gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    // Sepetten ürün silme
    // Sepetten ürün silme
    public function remove($id)
    {
        // Sepet verisini alın
        $cart = session('cart', []);

        // Ürünü sepetten sil
        if (isset($cart[$id])) {
            // Ürünü sepetten sil
            unset($cart[$id]);

            // Sepeti oturuma kaydet
            session(['cart' => $cart]);

            // Sepet boşsa, kullanıcıyı bilgilendir
            if (empty($cart)) {
                return redirect()->route('cart.index')->with('info', 'Sepetiniz boş.');
            }

            return redirect()->route('cart.index')->with('success', 'Ürün sepetten silindi.');
        }

        return redirect()->route('cart.index')->with('error', 'Ürün bulunamadı.');
    }





}

