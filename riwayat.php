<?php
require_once 'config.php';

$logs = $conn->query("SELECT l.*, i.name as item_name, i.unit 
                      FROM stock_logs l 
                      JOIN inventory i ON l.inventory_id = i.id 
                      ORDER BY l.created_at DESC LIMIT 50");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Log Penjualan & Restock - KKS FROZEN FOOD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F0F6FC; font-family: 'Plus Jakarta Sans', sans-serif; color: #0B2545; }
        .navbar-frozen { background: linear-gradient(135deg, #0B2545, #134074); }
        .table thead th { background-color: #E3EFFB; color: #0B2545; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-frozen mb-4 py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="index.php">
            <i class="bi bi-snow2 text-info me-2"></i>KKS FROZEN FOOD<span class="fs-6 fw-normal opacity-75">| Cold Storage Inventory</span>
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.php">Stok KKS FROZEN FOOD</a>
            <a class="nav-link active fw-semibold" href="riwayat.php">Log Penjualan & Restock</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="p-4 rounded-4 shadow-sm bg-white" style="border: 1px solid #D9E6F2;">
        <h4 class="fw-bold mb-3">📋 50 Aktivitas Keluar-Masuk Stok Freezer</h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Nama Produk</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($logs->num_rows > 0): ?>
                        <?php while ($log = $logs->fetch_assoc()): ?>
                        <tr>
                            <td><?= date('d M Y, H:i', strtotime($log['created_at'])) ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($log['item_name']) ?></td>
                            <td>
                                <?php if ($log['type'] == 'IN'): ?>
                                    <span class="badge bg-success">RESTOCK (+)</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">TERJUAL (-)</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold"><?= number_format($log['quantity'], 1) ?> <?= $log['unit'] ?></td>
                            <td><?= htmlspecialchars($log['notes'] ?: '-') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada catatan penjualan atau restock freezer.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>