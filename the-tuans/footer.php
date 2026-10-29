</main>

    <!-- MODAL CHI TIẾT SẢN PHẨM -->
    <div id="productDetailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl relative p-6 md:p-8">
            <button onclick="closeProductDetailModal()" class="absolute top-4 right-4 w-9 h-9 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-full flex items-center justify-center transition z-10"><i class="fa-solid fa-xmark text-lg"></i></button>
            <div id="productDetailContent" class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <!-- Nội dung được đổ động bằng JavaScript -->
            </div>
        </div>
    </div>

    <!-- MODAL CART -->
    <div id="cartModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="cartContainer" class="absolute top-0 right-0 bottom-0 w-full max-w-md bg-white shadow-2xl flex flex-col translate-x-full transition-transform duration-300">
            <div class="p-4 bg-slate-900 text-white flex items-center justify-between">
                <h3 class="font-extrabold text-base">Giỏ Hàng Của Bạn</h3>
                <button onclick="toggleCartModal(false)" class="text-gray-400 hover:text-white"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                <?php 
                $cartSubtotal = array_reduce($_SESSION['cart'], function($sum, $item) { return $sum + ($item['price'] * $item['quantity']); }, 0);
                if (empty($_SESSION['cart'])): 
                ?>
                    <div class="text-center py-16 text-gray-400 text-xs">Giỏ hàng của bạn đang trống.</div>
                <?php else: foreach ($_SESSION['cart'] as $item): ?>
                    <div class="flex items-center gap-3 bg-gray-50 p-2.5 rounded-xl border">
                        <img src="<?= htmlspecialchars($item['image']) ?>" class="w-12 h-12 object-cover rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-bold text-xs"><?= htmlspecialchars($item['name']) ?></h4>
                            <p class="text-xs text-red-600 font-bold"><?= number_format($item['price'], 0, ',', '.') ?>đ</p>
                            <div class="flex items-center gap-2 mt-1">
                                <form method="POST" action="index.php"><input type="hidden" name="action" value="update_qty"><input type="hidden" name="product_id" value="<?= $item['id'] ?>"><input type="hidden" name="delta" value="-1"><button class="px-1.5 bg-white border rounded text-xs font-bold">-</button></form>
                                <span class="text-xs font-bold"><?= $item['quantity'] ?></span>
                                <form method="POST" action="index.php"><input type="hidden" name="action" value="update_qty"><input type="hidden" name="product_id" value="<?= $item['id'] ?>"><input type="hidden" name="delta" value="1"><button class="px-1.5 bg-white border rounded text-xs font-bold">+</button></form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
            <div class="p-4 bg-gray-50 border-t space-y-3">
                <div class="flex justify-between text-sm font-extrabold"><span>Tổng thanh toán:</span><span class="text-red-600"><?= number_format($cartSubtotal, 0, ',', '.') ?>đ</span></div>
                <form method="POST" action="index.php" class="space-y-2">
                    <input type="hidden" name="action" value="checkout">
                    <input type="text" name="custName" placeholder="Họ và tên người nhận *" required class="w-full px-3 py-2 bg-white border rounded-lg text-xs">
                    <input type="tel" name="custPhone" placeholder="Số điện thoại *" required class="w-full px-3 py-2 bg-white border rounded-lg text-xs">
                    <input type="text" name="custAddress" placeholder="Địa chỉ giao hàng *" required class="w-full px-3 py-2 bg-white border rounded-lg text-xs">
                    <button type="submit" class="w-full py-3 bg-amber-500 text-slate-900 font-extrabold text-xs rounded-xl shadow">Đặt Hàng & In Hóa Đơn</button>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL BILL (HÓA ĐƠN & BẢO HÀNH) -->
    <?php if (!empty($_SESSION['show_bill'])): $bill = $_SESSION['last_bill']; unset($_SESSION['show_bill']); ?>
    <div id="billModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-5 space-y-3 shadow-2xl flex flex-col">
            <div id="printableBillArea" class="space-y-3 text-gray-800 text-[11px] font-mono bg-white p-2">
                <div class="text-center space-y-0.5 border-b border-gray-300 pb-2">
                    <h2 class="text-sm font-bold tracking-wider uppercase text-black">THE TUAN'S FASHION</h2>
                    <p class="text-[10px] text-gray-600">128 Nguyễn Trãi, Q.1, TP.HCM</p>
                    <p class="text-[10px] text-gray-600">Tel: 0901.888.999</p>
                    <p class="text-[10px] font-bold uppercase pt-1 text-black">PHIẾU BÁN HÀNG & BẢO HÀNH</p>
                </div>
                <div class="space-y-0.5 text-[10px] text-gray-700 border-b border-gray-300 pb-2">
                    <div class="flex justify-between"><span>Mã đơn: <b><?= $bill['orderId'] ?></b></span><span>Ngày: <?= $bill['date'] ?></span></div>
                    <div>Khách hàng: <b><?= htmlspecialchars($bill['name']) ?></b></div>
                    <div>SĐT: <b><?= htmlspecialchars($bill['phone']) ?></b></div>
                    <div>Địa chỉ: <?= htmlspecialchars($bill['address']) ?></div>
                </div>
                <table class="w-full text-[10px]">
                    <thead>
                        <tr class="border-b border-gray-300 text-gray-600">
                            <th class="py-1 text-left">Sản phẩm</th>
                            <th class="py-1 text-center">SL</th>
                            <th class="py-1 text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $bTotal = 0; foreach ($bill['items'] as $bi): $lineSum = $bi['price'] * $bi['quantity']; $bTotal += $lineSum; ?>
                            <tr class="border-b border-gray-100">
                                <td class="py-1 pr-1"><?= htmlspecialchars($bi['name']) ?></td>
                                <td class="py-1 text-center"><?= $bi['quantity'] ?></td>
                                <td class="py-1 text-right font-bold"><?= number_format($lineSum, 0, ',', '.') ?>đ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pt-1 border-t border-gray-300 flex justify-between font-bold text-xs text-black">
                    <span>TỔNG THANH TOÁN:</span>
                    <span><?= number_format($bTotal, 0, ',', '.') ?> VNĐ</span>
                </div>
                <div class="pt-2 border-t border-dashed border-gray-300 text-[10px] space-y-1">
                    <div>Mã bảo hành điện tử: <b class="text-black"><?= $bill['warrantyCode'] ?></b></div>
                    <div class="text-[9px] text-gray-500">Thời hạn bảo hành: 06 - 12 tháng theo quy định cửa hàng.</div>
                </div>
                <div class="text-center pt-3 border-t border-gray-300 space-y-0.5">
                    <p class="text-[11px] font-bold text-black">Cảm ơn quý khách và hẹn gặp lại!</p>
                    <p class="text-[9px] text-gray-500">Website: thetuans.vn</p>
                </div>
            </div>
            <div class="flex gap-2 no-print pt-2 border-t border-gray-200">
                <button onclick="window.print()" class="flex-1 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-800 transition">In Hóa Đơn</button>
                <button onclick="document.getElementById('billModal').style.display='none'" class="px-4 py-2 bg-gray-200 text-gray-800 font-bold text-xs rounded-xl hover:bg-gray-300 transition">Đóng</button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- MODAL LOGIN -->
    <div id="loginModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl relative space-y-4">
            <button onclick="toggleLoginModal(false)" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            <h3 class="text-lg font-extrabold text-center text-slate-900">Đăng Nhập Admin</h3>
            <form method="POST" action="index.php" class="space-y-3">
                <input type="hidden" name="action" value="login">
                <div><label class="block text-xs font-bold text-gray-700 mb-1">Tài khoản</label><input type="text" name="username" value="admin" required class="w-full px-3 py-2 bg-gray-50 border rounded-xl text-xs"></div>
                <div><label class="block text-xs font-bold text-gray-700 mb-1">Mật khẩu</label><input type="password" name="password" value="123456" required class="w-full px-3 py-2 bg-gray-50 border rounded-xl text-xs"></div>
                <button type="submit" class="w-full py-2.5 bg-amber-500 hover:bg-amber-400 font-extrabold text-xs rounded-xl">Đăng Nhập</button>
            </form>
        </div>
    </div>

    <!-- MODAL ADMIN CRUD -->
    <div id="productCrudModal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 relative">
            <button onclick="toggleCrudModal(false)" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
            <h3 id="crudModalTitle" class="text-lg font-extrabold text-slate-900">Thêm Sản Phẩm</h3>
            <form method="POST" action="index.php" class="space-y-3">
                <input type="hidden" name="action" value="save_product">
                <input type="hidden" name="editProductId" id="editProductId">
                <div><label class="block text-xs font-bold text-gray-700 mb-1">Tên sản phẩm</label><input type="text" name="crudName" id="crudName" required class="w-full px-3 py-2 border rounded-xl text-xs"></div>
                <div class="grid grid-cols-2 gap-2">
                    <div><label class="block text-xs font-bold text-gray-700 mb-1">Giá bán</label><input type="number" name="crudPrice" id="crudPrice" required class="w-full px-3 py-2 border rounded-xl text-xs"></div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Danh mục</label>
                        <select name="crudCategory" id="crudCategory" class="w-full px-3 py-2 border rounded-xl text-xs"><option value="Nam">Nam</option><option value="Nữ">Nữ</option><option value="Phụ kiện">Phụ Kiện</option></select>
                    </div>
                </div>
                <div><label class="block text-xs font-bold text-gray-700 mb-1">Link Ảnh URL</label><input type="url" name="crudImage" id="crudImage" required class="w-full px-3 py-2 border rounded-xl text-xs"></div>
                <div><label class="block text-xs font-bold text-gray-700 mb-1">Mô tả</label><textarea name="crudDesc" id="crudDesc" rows="3" required class="w-full px-3 py-2 border rounded-xl text-xs"></textarea></div>
                <button type="submit" class="w-full py-2.5 bg-amber-500 hover:bg-amber-400 font-extrabold text-xs rounded-xl">Lưu Sản Phẩm</button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT XỬ LÝ MODAL -->
    <script>
        function toggleCartModal(show) {
            const modal = document.getElementById('cartModal');
            const container = document.getElementById('cartContainer');
            if (show) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                container.classList.remove('translate-x-full');
            } else {
                modal.classList.add('opacity-0', 'pointer-events-none');
                container.classList.add('translate-x-full');
            }
        }

        function openProductDetail(p) {
            const content = document.getElementById('productDetailContent');
            content.innerHTML = `
                <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden shadow-inner">
                    <img src="${p.image}" alt="${p.name}" class="w-full h-full object-cover">
                </div>
                <div class="space-y-4">
                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-lg uppercase">${p.category}</span>
                    <h2 class="text-xl font-extrabold text-slate-900">${p.name}</h2>
                    <p class="text-2xl font-black text-red-600">${parseInt(p.price).toLocaleString('vi-VN')}đ</p>
                    <p class="text-xs text-gray-600 leading-relaxed">${p.desc}</p>
                    <form method="POST" action="index.php">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="product_id" value="${p.id}">
                        <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-400 text-slate-900 font-extrabold text-sm rounded-xl shadow transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-bag-shopping"></i> Thêm Vào Giỏ Hàng & Mua Ngay
                        </button>
                    </form>
                </div>
            `;
            document.getElementById('productDetailModal').classList.remove('opacity-0', 'pointer-events-none');
        }

        function closeProductDetailModal() {
            document.getElementById('productDetailModal').classList.add('opacity-0', 'pointer-events-none');
        }

        function toggleLoginModal(show) {
            const m = document.getElementById('loginModal');
            if (show) m.classList.remove('hidden'); else m.classList.add('hidden');
        }
        function toggleCrudModal(show) {
            const m = document.getElementById('productCrudModal');
            if (show) m.classList.remove('hidden'); else m.classList.add('hidden');
        }
        function openCrudModalForAdd() {
            document.getElementById('crudModalTitle').innerText = 'Thêm Sản Phẩm Mới';
            document.getElementById('editProductId').value = '';
            document.getElementById('crudName').value = '';
            document.getElementById('crudPrice').value = '';
            document.getElementById('crudImage').value = '';
            document.getElementById('crudDesc').value = '';
            toggleCrudModal(true);
        }
        function openCrudModalForEdit(p) {
            document.getElementById('crudModalTitle').innerText = 'Sửa Sản Phẩm';
            document.getElementById('editProductId').value = p.id;
            document.getElementById('crudName').value = p.name;
            document.getElementById('crudPrice').value = p.price;
            document.getElementById('crudCategory').value = p.category;
            document.getElementById('crudImage').value = p.image;
            document.getElementById('crudDesc').value = p.desc;
            toggleCrudModal(true);
        }
    </script>
</body>
</html>