<?php
require_once 'config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'login') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    if ($u === 'admin' && $p === '123456') {
        $_SESSION['isAdminLoggedIn'] = true;
    }
    header("Location: index.php?tab=admin");
    exit;
}

if ($action === 'logout') {
    $_SESSION['isAdminLoggedIn'] = false;
    header("Location: index.php?tab=home");
    exit;
}

if ($action === 'add_to_cart') {
    $id = intval($_POST['product_id']);
    foreach ($_SESSION['products'] as $p) {
        if ($p['id'] === $id) {
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] === $id) {
                    $item['quantity'] += 1;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $p['quantity'] = 1;
                $_SESSION['cart'][] = $p;
            }
            break;
        }
    }
    header("Location: index.php?tab=home");
    exit;
}

if ($action === 'update_qty') {
    $id = intval($_POST['product_id']);
    $delta = intval($_POST['delta']);
    foreach ($_SESSION['cart'] as $key => &$item) {
        if ($item['id'] === $id) {
            $item['quantity'] += $delta;
            if ($item['quantity'] <= 0) {
                unset($_SESSION['cart'][$key]);
            }
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: index.php?tab=home");
    exit;
}

if ($action === 'checkout') {
    $name = trim($_POST['custName'] ?? '');
    $phone = trim($_POST['custPhone'] ?? '');
    $address = trim($_POST['custAddress'] ?? '');

    if (!empty($name) && !empty($phone) && !empty($address) && count($_SESSION['cart']) > 0) {
        $orderId = '#TT-' . rand(1000, 9999);
        $warrantyCode = 'WAR-TT-' . rand(1000, 9999);
        $today = date('d/m/Y');

        $_SESSION['warrantyCards'][] = [
            'warrantyCode' => $warrantyCode,
            'phone' => $phone,
            'customerName' => $name,
            'orderId' => $orderId,
            'purchaseDate' => $today,
            'items' => $_SESSION['cart']
        ];

        $_SESSION['last_bill'] = [
            'orderId' => $orderId,
            'date' => $today,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'items' => $_SESSION['cart'],
            'warrantyCode' => $warrantyCode
        ];

        $_SESSION['cart'] = [];
        $_SESSION['show_bill'] = true;
    }
    header("Location: index.php?tab=home");
    exit;
}

if ($action === 'save_product' && $_SESSION['isAdminLoggedIn']) {
    $editId = intval($_POST['editProductId'] ?? 0);
    $name = trim($_POST['crudName'] ?? '');
    $price = intval($_POST['crudPrice'] ?? 0);
    $category = $_POST['crudCategory'] ?? 'Nam';
    $image = trim($_POST['crudImage'] ?? '');
    $desc = trim($_POST['crudDesc'] ?? '');

    if ($editId > 0) {
        foreach ($_SESSION['products'] as &$p) {
            if ($p['id'] === $editId) {
                $p['name'] = $name;
                $p['price'] = $price;
                $p['category'] = $category;
                $p['image'] = $image;
                $p['desc'] = $desc;
                break;
            }
        }
    } else {
        $newId = count($_SESSION['products']) > 0 ? max(array_column($_SESSION['products'], 'id')) + 1 : 1;
        $_SESSION['products'][] = [
            'id' => $newId,
            'name' => $name,
            'price' => $price,
            'category' => $category,
            'image' => $image,
            'desc' => $desc
        ];
    }
    header("Location: index.php?tab=admin");
    exit;
}

if ($action === 'delete_product' && $_SESSION['isAdminLoggedIn']) {
    $id = intval($_GET['id'] ?? 0);
    $_SESSION['products'] = array_values(array_filter($_SESSION['products'], function($p) use ($id) {
        return $p['id'] !== $id;
    }));
    header("Location: index.php?tab=admin");
    exit;
}

$activeTab = $_GET['tab'] ?? 'home';

// Include Header
include 'header.php';

// Include Tab Content tương ứng
switch ($activeTab) {
    case 'warranty':
        include 'warranty.php';
        break;
    case 'branches':
        include 'branches.php';
        break;
    case 'admin':
        include 'admin.php';
        break;
    case 'home':
    default:
        include 'home.php';
        break;
}

// Include Footer
include 'footer.php';
?>