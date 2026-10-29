<div class="absolute inset-0 overflow-y-auto p-4 md:p-6">
    <div class="max-w-6xl mx-auto space-y-6">
        <?php if (!$_SESSION['isAdminLoggedIn']): ?>
            <div class="bg-white rounded-3xl p-8 text-center max-w-md mx-auto shadow-sm border border-gray-200 space-y-4">
                <h3 class="text-xl font-extrabold">Đăng Nhập Admin</h3>
                <form method="POST" action="index.php" class="space-y-3">
                    <input type="hidden" name="action" value="login">
                    <input type="text" name="username" value="admin" required class="w-full px-3 py-2 bg-gray-50 border rounded-xl text-xs">
                    <input type="password" name="password" value="123456" required class="w-full px-3 py-2 bg-gray-50 border rounded-xl text-xs">
                    <button type="submit" class="w-full py-2 bg-amber-500 font-extrabold text-xs rounded-xl">Đăng Nhập</button>
                </form>
            </div>
        <?php else: ?>
            <div class="flex justify-between items-center bg-white p-6 rounded-3xl shadow-sm border">
                <h2 class="text-xl font-extrabold">Quản Lý Sản Phẩm</h2>
                <button onclick="openCrudModalForAdd()" class="px-4 py-2 bg-amber-500 font-extrabold text-xs rounded-xl">Thêm Sản Phẩm</button>
            </div>
            <div class="bg-white rounded-3xl shadow-sm border overflow-hidden mt-4">
                <table class="w-full text-left text-xs">
                    <tr class="bg-gray-50 border-b font-bold uppercase text-gray-500"><th class="p-4">Ảnh</th><th class="p-4">Tên</th><th class="p-4">Danh mục</th><th class="p-4">Giá</th><th class="p-4 text-right">Thao tác</th></tr>
                    <?php foreach ($_SESSION['products'] as $p): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4"><img src="<?= $p['image'] ?>" class="w-10 h-10 object-cover rounded-lg"></td>
                            <td class="p-4 font-bold"><?= $p['name'] ?></td>
                            <td class="p-4"><?= $p['category'] ?></td>
                            <td class="p-4 text-red-600 font-black"><?= number_format($p['price'], 0, ',', '.') ?>đ</td>
                            <td class="p-4 text-right">
                                <button onclick='openCrudModalForEdit(<?= json_encode($p) ?>)' class="px-2 py-1 bg-blue-50 text-blue-600 rounded">Sửa</button>
                                <a href="index.php?action=delete_product&id=<?= $p['id'] ?>" onclick="return confirm('Xóa sản phẩm này?')" class="px-2 py-1 bg-red-50 text-red-600 rounded">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>