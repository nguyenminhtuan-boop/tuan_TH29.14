<?php
$cartTotalQty = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartTotalQty += isset($item['quantity']) ? intval($item['quantity']) : 0;
    }
}
$activeTab = isset($activeTab) ? $activeTab : 'home';
$isAdminLoggedIn = isset($_SESSION['isAdminLoggedIn']) ? $_SESSION['isAdminLoggedIn'] : false;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE TUAN'S - Thời Trang Cao Cấp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        @media print {
            body * { visibility: hidden; }
            #printableBillArea, #printableBillArea * { visibility: visible; }
            #printableBillArea { position: absolute; left: 0; top: 0; width: 100%; background: white; color: black; padding: 20px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 h-screen overflow-hidden flex flex-col">

    <header class="bg-slate-900 text-white shadow-md z-30 flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3 cursor-pointer" onclick="window.location.href='index.php?tab=home'">
                    <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center font-extrabold text-slate-900 text-xl tracking-wider shadow-lg shadow-amber-500/20">T</div>
                    <span class="font-extrabold text-xl tracking-tight text-white uppercase">THE TUAN'S</span>
                </div>

                <nav class="hidden md:flex items-center space-x-1">
                    <a href="index.php?tab=home" class="px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2 <?= $activeTab === 'home' ? 'bg-amber-500 text-slate-900' : 'text-gray-300 hover:text-white hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-house text-xs"></i> Trang Chủ
                    </a>
                    <a href="index.php?tab=warranty" class="px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2 <?= $activeTab === 'warranty' ? 'bg-amber-500 text-slate-900' : 'text-gray-300 hover:text-white hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-shield-halved text-xs"></i> Tra Cứu Bảo Hành
                    </a>
                    <a href="index.php?tab=branches" class="px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2 <?= $activeTab === 'branches' ? 'bg-amber-500 text-slate-900' : 'text-gray-300 hover:text-white hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-store text-xs"></i> Chi Nhánh
                    </a>
                    <a href="index.php?tab=admin" class="px-4 py-2 rounded-lg text-sm font-semibold transition flex items-center gap-2 <?= $activeTab === 'admin' ? 'bg-amber-500 text-slate-900' : 'text-gray-300 hover:text-white hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-bars-progress text-xs"></i> Quản Lý
                    </a>
                </nav>

                <div class="flex items-center space-x-3">
                    <button onclick="toggleCartModal(true)" class="relative p-2.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl transition flex items-center justify-center">
                        <i class="fa-solid fa-bag-shopping text-base"></i>
                        <?php if ($cartTotalQty > 0): ?>
                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-extrabold px-1.5 py-0.5 rounded-full ring-2 ring-slate-900"><?= $cartTotalQty ?></span>
                        <?php endif; ?>
                    </button>
                    <?php if ($isAdminLoggedIn): ?>
                        <div class="flex items-center space-x-2">
                            <span class="hidden sm:inline text-xs font-bold text-amber-400">Admin</span>
                            <a href="index.php?action=logout" class="px-3 py-1.5 bg-red-600 hover:bg-red-500 text-white text-xs font-bold rounded-xl transition">Đăng Xuất</a>
                        </div>
                    <?php else: ?>
                        <button onclick="toggleLoginModal(true)" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-amber-400 text-xs font-bold rounded-xl transition flex items-center gap-1.5">
                            <i class="fa-solid fa-lock text-xs"></i> Admin
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <main class="flex-1 relative overflow-hidden bg-gray-50">