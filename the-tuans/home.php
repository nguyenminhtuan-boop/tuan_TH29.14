<?php
$searchQuery = $_GET['search'] ?? '';
$selectedCategory = $_GET['cat'] ?? 'all';
$filteredProducts = array_filter($_SESSION['products'], function($p) use ($searchQuery, $selectedCategory) {
    $matchCat = ($selectedCategory === 'all' || $p['category'] === $selectedCategory);
    $matchSearch = (empty($searchQuery) || stripos($p['name'], $searchQuery) !== false || stripos($p['desc'], $searchQuery) !== false);
    return $matchCat && $matchSearch;
});
?>
<div class="absolute inset-0 overflow-y-auto p-4 md:p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Form Tìm kiếm & Lọc danh mục -->
        <form method="GET" action="index.php" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between">
            <input type="hidden" name="tab" value="home">
            <input type="hidden" name="cat" value="<?= htmlspecialchars($selectedCategory) ?>">
            <div class="relative w-full md:w-80">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Tìm kiếm trang phục, phụ kiện..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>
            <div class="flex items-center space-x-2 w-full md:w-auto overflow-x-auto pb-1">
                <a href="index.php?tab=home&cat=all&search=<?= urlencode($searchQuery) ?>" class="px-4 py-2 <?= $selectedCategory === 'all' ? 'bg-amber-500 text-slate-900' : 'bg-gray-100 text-gray-700' ?> text-xs font-bold rounded-xl whitespace-nowrap transition">Tất Cả</a>
                <a href="index.php?tab=home&cat=Nam&search=<?= urlencode($searchQuery) ?>" class="px-4 py-2 <?= $selectedCategory === 'Nam' ? 'bg-amber-500 text-slate-900' : 'bg-gray-100 text-gray-700' ?> text-xs font-bold rounded-xl whitespace-nowrap transition">Thời Trang Nam</a>
                <a href="index.php?tab=home&cat=Nữ&search=<?= urlencode($searchQuery) ?>" class="px-4 py-2 <?= $selectedCategory === 'Nữ' ? 'bg-amber-500 text-slate-900' : 'bg-gray-100 text-gray-700' ?> text-xs font-bold rounded-xl whitespace-nowrap transition">Thời Trang Nữ</a>
                <a href="index.php?tab=home&cat=Phụ kiện&search=<?= urlencode($searchQuery) ?>" class="px-4 py-2 <?= $selectedCategory === 'Phụ kiện' ? 'bg-amber-500 text-slate-900' : 'bg-gray-100 text-gray-700' ?> text-xs font-bold rounded-xl whitespace-nowrap transition">Phụ Kiện</a>
            </div>
        </form>

        <!-- Lưới hiển thị sản phẩm -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 pb-20">
            <?php if (empty($filteredProducts)): ?>
                <div class="col-span-full text-center py-12 text-gray-400 text-sm">Không tìm thấy sản phẩm phù hợp.</div>
            <?php else: foreach ($filteredProducts as $p): ?>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 flex flex-col transition group">
                    <!-- Bấm vào ảnh để xem chi tiết -->
                    <div class="relative aspect-[4/5] bg-gray-100 overflow-hidden cursor-pointer" onclick='openProductDetail(<?= json_encode($p) ?>)'>
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-slate-900/80 text-amber-400 text-[10px] font-bold rounded-lg uppercase"><?= htmlspecialchars($p['category']) ?></span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                        <div class="space-y-1">
                            <!-- Bấm vào tên để xem chi tiết -->
                            <h3 onclick='openProductDetail(<?= json_encode($p) ?>)' class="font-bold text-sm text-slate-900 line-clamp-1 hover:text-amber-600 cursor-pointer transition"><?= htmlspecialchars($p['name']) ?></h3>
                            <p class="text-xs font-black text-red-600"><?= number_format($p['price'], 0, ',', '.') ?>đ</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <button onclick='openProductDetail(<?= json_encode($p) ?>)' class="py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold rounded-xl transition">Chi tiết</button>
                            <form method="POST" action="index.php" class="w-full">
                                <input type="hidden" name="action" value="add_to_cart">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-amber-500 hover:text-slate-900 text-white text-xs font-bold rounded-xl transition flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-cart-plus text-[10px]"></i> Mua
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>