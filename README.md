# Stok Takip Mini ERP

PHP 8.2 ve MySQL 8 ile geliştirilmiş, portfolyo odaklı bir mini ERP uygulaması.
Odak noktası: kimlik doğrulama, RBAC, CRUD, stok hareketleri, satış yönetimi, raporlama ve denetim kaydı.

## Özellikler

### 1) Kimlik Doğrulama ve Yetkilendirme (RBAC)
- Giriş / çıkış
- Roller: `Admin`, `Personel`
- `Admin`: kullanıcı ekleme, aktif/pasif yapma, şifre sıfırlama
- `Personel`: kullanıcı yönetimine erişemez

### 2) Katalog Yönetimi
- Marka CRUD
- Kategori CRUD
- Ürün CRUD
- Ürün alanları:
  - Ürün adı
  - SKU/seri numarası (benzersiz)
  - Marka, kategori
  - Birim (`adet`)
  - Kritik stok seviyesi
  - Aktif/Pasif durumu
- Ürün detay ekranı:
  - Güncel stok
  - Son stok hareketleri
  - Son satış satırları

### 3) Stok Hareketleri
- Hareket defteri: `IN` / `OUT`
- Alanlar: miktar, tarih-saat, kullanıcı, not, satış referansı
- Stok değeri hareketlerden hesaplanır
- Negatif stok engeli uygulanır

### 4) Satış Yönetimi
- Basit müşteri adı (MVP)
- Çok satırlı satış oluşturma (ürün, miktar, birim fiyat)
- Satış kaydında otomatik `OUT` stok hareketi oluşturma
- İşlem (transaction) içinde kayıt + stok kontrolü
- Satış listesi ve satış detay ekranı

### 5) Gösterge Paneli
- Toplam ürün sayısı
- Kritik stoktaki ürün sayısı
- Bugünkü satış adedi
- Bugünkü ciro
- Kritik stok listesi

### 6) Raporlama
- Tarih aralığı filtresi
- Günlük ciro tablosu
- En çok satılan 10 ürün (adet)

### 7) Denetim Kaydı
- Önemli aksiyonlar kayıt altına alınır:
  - Başarılı/başarısız giriş
  - Ürün oluşturma/güncelleme
  - Satış oluşturma

## Teknoloji Yığını
- PHP 8.2 (Apache)
- MySQL 8
- PDO + prepared statements
- Bootstrap 5
- Docker Compose

## Proje Yapısı

```text
.
├── public/                 # Uygulama giriş noktası (index.php)
├── src/
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   ├── Services/
│   └── Support/
├── views/
├── migrations/
├── docker/
│   ├── apache/
│   └── app.Dockerfile
├── storage/
├── tests/
├── docker-compose.yml
├── .env.example
└── README.md
```

## Kurulum

### Gereksinimler
- Docker
- Docker Compose

### Hızlı Başlangıç
1. Proje dizinine geçin.
2. Ortam dosyasını oluşturun:
   ```bash
   cp .env.example .env
   ```
3. Servisleri ayağa kaldırın:
   ```bash
   docker compose up -d --build
   ```
4. Şema geçişini çalıştırın:
   ```bash
   docker compose exec app php migrations/run.php
   ```
5. Başlangıç verisini yükleyin:
   ```bash
   docker compose exec app php migrations/seed.php
   ```
6. Uygulamayı açın:
   - `http://localhost:8080`

## Varsayılan Kullanıcılar

| Rol | E-posta | Şifre |
|---|---|---|
| Admin | `admin@example.com` | `123456` |
| Personel | `personel@example.com` | `123456` |

> Not: Admin panelindeki şifre sıfırlama işlemi `.env` içindeki `DEFAULT_RESET_PASSWORD` değerini kullanır.

## Veritabanı Komutları
- Şema geçişi:
  ```bash
  docker compose exec app php migrations/run.php
  ```
- Demo başlangıç verisi:
  ```bash
  docker compose exec app php migrations/seed.php
  ```

## Mimari Notlar

### RBAC
- Route korumaları `require_auth()` ve `require_admin()` ile yapılır.
- Kullanıcı yönetimi yalnızca `Admin` rolüne açıktır.

### İşlem Yönetimi
- Satış oluşturma `SaleService::createSale()` içinde transaction ile yönetilir.
- Aynı transaction içinde:
  - satış kaydı
  - satış satırları
  - stok hareketleri (`OUT`)
- Yetersiz stok durumunda işlem rollback edilir.

## MVP Varsayımları
- Müşteri ayrı tablo yerine `customer_name` alanında tutulur.
- Stok cache kolonu yerine stok, hareketlerden hesaplanır.

## Yol Haritası
- Birim ve entegrasyon testleri
- İade / satış iptal akışı
- CSV/Excel dışa aktarma
- Gelişmiş raporlama filtreleri
