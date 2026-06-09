=== Cara Mengisi Object Repository ===

Katalon Studio butuh Object Repository untuk mengenali elemen website (tombol, input, dll).

Gunakan Katalon Studio -> Spy Web untuk menangkap elemen-elemen berikut:

== BERANDA ==
Page_Beranda/header_logo            -> CSS: .logo atau img[alt*="logo"]
Page_Beranda/section_produk         -> CSS: .product-section, #product
Page_Beranda/link_kategori_pertama  -> CSS: .kategori-list a:first-child

== PRODUK ==
Page_Produk/heading_produk          -> CSS: h1, .page-title
Page_Produk/card_produk             -> CSS: .card-produk, .product-card
Page_Produk/card_produk_pertama     -> CSS: .card-produk:first-child a

== PRODUK DETAIL ==
Page_ProdukDetail/heading_nama_produk  -> CSS: h1.nama-produk, .product-name
Page_ProdukDetail/label_harga          -> CSS: .harga, .price
Page_ProdukDetail/btn_tambah_keranjang -> CSS: .btn-beli, button[onclick*="cart"]

== CART ==
Page_Cart/heading_cart              -> CSS: h1, .cart-title

== SHIPPING ==
Page_Shipping/select_province       -> CSS: select[name="province"]
Page_Shipping/select_city           -> CSS: select[name="city"]
Page_Shipping/select_district       -> CSS: select[name="district"]

== BACKEND LOGIN ==
Page_BackendLogin/input_email       -> CSS: input[name="email"]
Page_BackendLogin/input_password    -> CSS: input[name="password"]
Page_BackendLogin/btn_submit        -> CSS: button[type="submit"]

== BACKEND DASHBOARD ==
Page_BackendDashboard/sidebar_menu  -> CSS: .sidebar, nav.sidebar
Page_BackendDashboard/card_statistik -> CSS: .card-statistik, .stat-card

== KATEGORI ==
Page_Kategori/heading_kategori      -> CSS: .content-header h1
Page_Kategori/btn_tambah_kategori   -> CSS: a[href*="kategori/create"], .btn-add
Page_Kategori/form_nama_kategori    -> CSS: input[name="nama_kategori"]
Page_Kategori/btn_simpan            -> CSS: button[type="submit"]

== PRODUK BACKEND ==
Page_ProdukBackend/heading_produk   -> CSS: .content-header h1
Page_ProdukBackend/btn_tambah_produk -> CSS: a[href*="produk/create"]
Page_ProdukBackend/form_nama_produk -> CSS: input[name="nama_produk"]
Page_ProdukBackend/form_harga_produk -> CSS: input[name="harga"]
Page_ProdukBackend/form_stok_produk  -> CSS: input[name="stok"]
Page_ProdukBackend/select_kategori  -> CSS: select[name="kategori_id"]
Page_ProdukBackend/btn_simpan       -> CSS: button[type="submit"]

== PESANAN ==
Page_Pesanan/heading_pesanan        -> CSS: .content-header h1

== CUSTOMER ==
Page_Customer/heading_customer      -> CSS: .content-header h1
Page_Customer/row_customer          -> CSS: table tbody tr
