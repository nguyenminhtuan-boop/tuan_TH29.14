<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [
        [ 
            'id' => 1, 
            'name' => 'Áo Sơ Mi Nam Oxford Cao Cấp', 
            'price' => 450000, 
            'category' => 'Nam', 
            'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Chất liệu vải Oxford 100% cotton tự nhiên, thoáng mát, chống nhăn tự nhiên, thiết kế lịch lãm chuẩn form công sở THE TUAN\'S.' 
        ],
        [ 
            'id' => 2, 
            'name' => 'Áo Blazer Nam Hàn Quốc', 
            'price' => 1250000, 
            'category' => 'Nam', 
            'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Blazer dáng suông thời thượng, đường may tỉ mỉ, đệm vai nhẹ tạo phong cách quý ông hiện đại.' 
        ],
        [ 
            'id' => 3, 
            'name' => 'Quần Tây Nam Slimfit 9 Tấc', 
            'price' => 550000, 
            'category' => 'Nam', 
            'image' => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Quần tây form ôm vừa vặn, co giãn nhẹ thoải mái vận động cả ngày dài.' 
        ],
        [ 
            'id' => 4, 
            'name' => 'Áo Khoác Dạ Nam Hàn Quốc', 
            'price' => 1350000, 
            'category' => 'Nam', 
            'image' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Áo khoác dạ nam cao cấp thiết kế dáng dài phong cách Hàn Quốc, giữ ấm cực tốt, lớp lót bên trong mềm mại và lịch lãm.' 
        ],
        [ 
            'id' => 5, 
            'name' => 'Áo Hoodie Nỉ Bông Form Rộng', 
            'price' => 490000, 
            'category' => 'Nam', 
            'image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Áo hoodie chất liệu nỉ bông dày dặn, thiết kế form rộng trẻ trung năng động, giữ ấm cực tốt trong mùa lạnh.' 
        ],
        [ 
            'id' => 6, 
            'name' => 'Đầm Maxi Dạo Phố Thiết Kế', 
            'price' => 890000, 
            'category' => 'Nữ', 
            'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Đầm maxi cao cấp tôn dáng, chất liệu lụa cát mềm mại, họa tiết thanh lịch phù hợp đi tiệc hoặc dạo phố.' 
        ],
        [ 
            'id' => 7, 
            'name' => 'Chân Váy Midi Xếp Ly Sang Trọng', 
            'price' => 480000, 
            'category' => 'Nữ', 
            'image' => 'https://images.unsplash.com/photo-1583496661160-fb5886a0aaaa?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Chân váy xếp ly tinh tế, lưng chun co giãn thoải mái, dễ dàng phối hợp cùng áo sơ mi hoặc áo thun.' 
        ],
        [ 
            'id' => 8, 
            'name' => 'Quần Jean Nữ Skinny Cạp Cao', 
            'price' => 520000, 
            'category' => 'Nữ', 
            'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Quần jean nữ cạp cao tôn dáng tuyệt đối, chất liệu denim co giãn 4 chiều mang lại sự thoải mái tối đa, bền màu sau nhiều lần giặt.' 
        ],
        [ 
            'id' => 9, 
            'name' => 'Túi Xách Da Tổng Hợp Cao Cấp', 
            'price' => 1450000, 
            'category' => 'Phụ kiện', 
            'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Túi xách nữ da PU cao cấp nhập khẩu, khóa mạ vàng chống gỉ, thiết kế sang trọng đẳng cấp.' 
        ],
        [ 
            'id' => 10, 
            'name' => 'Kính Mát Thời Trang Unisex', 
            'price' => 350000, 
            'category' => 'Phụ kiện', 
            'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Kính mát thời trang chống tia UV bảo vệ mắt hiệu quả, thiết kế gọng cứng cáp, sang trọng phù hợp cho cả nam và nữ.' 
        ],
        [ 
            'id' => 11, 
            'name' => 'Giày Sneaker Nam Thể Thao', 
            'price' => 850000, 
            'category' => 'Phụ kiện', 
            'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Giày thể thao sneaker thiết kế năng động, đế êm ái chống trơn trượt, dễ dàng phối hợp với nhiều phong cách thời trang trẻ trung.' 
        ],
        [ 
            'id' => 12, 
            'name' => 'Đồng Hồ Đeo Tay Nam Dây Da', 
            'price' => 1890000, 
            'category' => 'Phụ kiện', 
            'image' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?auto=format&fit=crop&q=80&w=600', 
            'desc' => 'Đồng hồ nam thiết kế sang trọng với dây da tổng hợp cao cấp, mặt kính chống xước, phụ kiện không thể thiếu cho quý ông lịch lãm.' 
        ]
    ];
}

if (!isset($_SESSION['warrantyCards'])) {
    $_SESSION['warrantyCards'] = [
        [ 'warrantyCode' => 'WAR-TT-8888', 'phone' => '0901234567', 'customerName' => 'Nguyễn Văn Test', 'orderId' => '#TT-8888', 'purchaseDate' => '26/10/2026', 'items' => [['name' => 'Áo Sơ Mi Nam Oxford Cao Cấp', 'quantity' => 1]] ]
    ];
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['isAdminLoggedIn'])) {
    $_SESSION['isAdminLoggedIn'] = false;
}
?>