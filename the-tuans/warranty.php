<div class="absolute inset-0 overflow-y-auto p-4 md:p-6">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-slate-900 text-white rounded-3xl p-6 md:p-8 text-center relative shadow-xl">
            <h2 class="text-2xl font-extrabold mb-2">Tra Cứu Thẻ Bảo Hành</h2>
            <form method="GET" action="index.php" class="pt-4 flex flex-col sm:flex-row gap-2 max-w-lg mx-auto">
                <input type="hidden" name="tab" value="warranty">
                <input type="text" name="warranty_query" value="<?= htmlspecialchars($_GET['warranty_query'] ?? '') ?>" placeholder="Nhập SĐT hoặc Mã BH..." class="flex-1 px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                <button type="submit" class="px-6 py-3 bg-amber-500 text-slate-900 font-extrabold text-sm rounded-xl">Tra Cứu</button>
            </form>
        </div>
        <?php if (isset($_GET['warranty_query']) && !empty(trim($_GET['warranty_query']))): 
            $wQuery = strtoupper(trim($_GET['warranty_query']));
            $foundW = array_filter($_SESSION['warrantyCards'], function($w) use ($wQuery) {
                return strtoupper($w['warrantyCode']) === $wQuery || $w['phone'] === $wQuery;
            });
        ?>
            <div class="space-y-4">
                <?php if (empty($foundW)): ?>
                    <div class="p-4 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl text-center">Không tìm thấy thông tin bảo hành cho: <b><?= htmlspecialchars($wQuery) ?></b></div>
                <?php else: foreach ($foundW as $w): ?>
                    <div class="bg-slate-900 text-white p-6 rounded-3xl shadow-xl space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                            <span class="font-extrabold text-sm text-amber-400 uppercase">Thẻ Bảo Hành: <?= $w['warrantyCode'] ?></span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <p><span class="text-gray-400">Khách hàng:</span> <strong><?= $w['customerName'] ?></strong></p>
                            <p><span class="text-gray-400">SĐT:</span> <strong><?= $w['phone'] ?></strong></p>
                        </div>
                        <div class="space-y-1 text-xs pt-2 border-t border-slate-700">
                            <?php foreach ($w['items'] as $wi): ?>
                                <div class="flex justify-between text-gray-200"><span>• <?= $wi['name'] ?></span><span>SL: <?= $wi['quantity'] ?></span></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>