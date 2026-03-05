@extends ('layouts.layout')
@section('title', 'สินค้า')
@section('content')
    <link rel="stylesheet" href="../css/products.css">
    <div class="container" id="products">
        <h2 class="section-title">สินค้าของเรา</h2>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-input" placeholder="🔎 ค้นหาสินค้า...">
        </div>

        <div class="category-tabs">
            <button class="tab-btn active" data-category="all">ทั้งหมด</button>
            <button class="tab-btn" data-category="dog">น้องสุนัข</button>
            <button class="tab-btn" data-category="cat">น้องแมว</button>
            <button class="tab-btn" data-category="dog-food">อาหารน้องสุนัข</button>
            <button class="tab-btn" data-category="cat-food">อาหารน้องแมว</button>
            <button class="tab-btn" data-category="dog-accessory">อื่นๆสำหรับน้องสุนัข</button>
            <button class="tab-btn" data-category="cat-accessory">อื่นๆสำหรับน้องแมว</button>
        </div>

        <div class="products-grid" id="productsGrid"></div>
    </div>

    <div class="cart" id="cartBtn" aria-label="ตะกร้าสินค้า">
        🛒
        <span class="cart-count" id="cartCount">0</span>
    </div>

    <!-- Cart Modal -->
    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <h2>ตะกร้าสินค้า</h2>
                <button class="cart-close-btn" id="cartCloseBtn">&times;</button>
            </div>
            <div class="cart-modal-body">
                <div class="cart-items" id="cartItems">
                    <!-- Cart items will be rendered here -->
                </div>
            </div>
            <div class="cart-modal-footer">
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>ราคารวม:</span>
                        <span id="cartTotal">฿0</span>
                    </div>
                </div>
                <div class="cart-actions">
                    <button class="btn btn-secondary" id="clearCartBtn">ล้างตะกร้า</button>
                    <button class="btn btn-primary" id="checkoutBtn">ไปชำระเงิน</button>
                </div>
            </div>
        </div>
    </div>
@endsection
