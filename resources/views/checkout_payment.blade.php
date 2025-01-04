@extends('layouts.user')

@section('content')  
<div class="d-flex flex-column min-vh-100">
    <div class="flex-grow-1">
        <br>
        <div class="container">  
            <h1>Konfirmasi Pembayaran</h1>  
            <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>  

            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>  
            <script>  
                document.addEventListener('DOMContentLoaded', function() {  
                    const payButton = document.getElementById('pay-button');  
                    if (payButton) {  
                        console.log('Tombol bayar ditemukan');  
                        payButton.onclick = function () {  
                            console.log('Tombol bayar diklik'); // Log untuk debugging  
                            snap.pay('{{ $snapToken }}', {  
                                onSuccess: function(result) {  
                                    alert('Pembayaran berhasil!');
                                    window.location.href = '/list';
                                },  
                                onPending: function(result) {  
                                    alert('Menunggu pembayaran!');  
                                },  
                                onError: function(result) {  
                                    alert('Pembayaran gagal!');  
                                },
                                onClose: function () {
                                    alert('Anda menutup pop-up tanpa menyelesaikan pembayaran');
                                }  
                            });  
                        };  
                    } else {  
                        console.log('Tombol bayar tidak ditemukan');  
                    }  
                });
            </script>  
        </div>  
        <br>
        <br>
    </div>
    <footer class="bg-light text-center py-3">
        © KIND
    </footer>
</div>
@endsection
