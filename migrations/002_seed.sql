INSERT INTO brands (name, is_active)
VALUES ('Acme', 1), ('Nova', 1), ('Zeta', 1)
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO categories (name, is_active)
VALUES ('Elektronik', 1), ('Ofis', 1), ('Aksesuar', 1)
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO products (name, sku, brand_id, category_id, unit, critical_stock_level, is_active)
SELECT 'Kablosuz Mouse', 'SKU-MOUSE-001', b.id, c.id, 'adet', 10, 1
FROM brands b, categories c WHERE b.name='Acme' AND c.name='Elektronik'
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO products (name, sku, brand_id, category_id, unit, critical_stock_level, is_active)
SELECT 'Mekanik Klavye', 'SKU-KEYB-001', b.id, c.id, 'adet', 8, 1
FROM brands b, categories c WHERE b.name='Nova' AND c.name='Elektronik'
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO products (name, sku, brand_id, category_id, unit, critical_stock_level, is_active)
SELECT 'A4 Kagit Paketi', 'SKU-PAPR-001', b.id, c.id, 'adet', 20, 1
FROM brands b, categories c WHERE b.name='Zeta' AND c.name='Ofis'
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO stock_movements (product_id, movement_type, qty, user_id, note)
SELECT p.id, 'IN', 50, u.id, 'Baslangic stok'
FROM products p
JOIN users u ON u.email = 'admin@example.com'
WHERE p.sku IN ('SKU-MOUSE-001', 'SKU-KEYB-001', 'SKU-PAPR-001')
  AND NOT EXISTS (
    SELECT 1
    FROM stock_movements sm
    WHERE sm.product_id = p.id
      AND sm.movement_type = 'IN'
      AND sm.note = 'Baslangic stok'
  );
