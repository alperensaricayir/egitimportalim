# Eğitim Portalı

Laravel 10 tabanlı, çok dilli (TR/EN) eğitim portalı. Yönetim paneli üzerinden ürünler, duyurular, iş ilanları ve destek talepleri yönetilir. Genel sitede kurslar, ürünler ve iş ilanları yayınlanır. Karanlık mod ve dil seçici (🇹🇷/🇬🇧) site genelinde çalışır.

## Özellikler
- Çok dil: Türkçe (varsayılan) ve İngilizce. Seçim oturum + çerez ile kalıcıdır.
- Yönetim Paneli: Ürünler, Duyurular, İş İlanları, Destek Talepleri için CRUD.
- Karanlık Mod: Layout üzerinden class tabanlı `dark` modu.
- Logo: Tüm sayfalarda `public/images/3s-logo.png` (yoksa `3s-grup-logo.png`) kullanılır.
- Basit ve erişilebilir UI (Blade + Tailwind).

## Teknoloji Yığını
- PHP 8.x, Laravel 10
- Blade, TailwindCSS (dark mode: class)

## Kurulum
1. Depoyu klonlayın:
   ```bash
   git clone <REPO_URL> egitim-portali
   cd egitim-portali
   ```
2. Bağımlılıkları yükleyin:
   ```bash
   .\php\php.exe -c .\php\php.ini composer.phar install
   ```
3. Ortam dosyasını hazırlayın:
   ```bash
   copy .env.example .env
   ```
   Ardından veritabanı ayarlarını `.env` içinde düzenleyin.
4. Uygulama anahtarını oluşturun:
   ```bash
   .\php\php.exe -c .\php\php.ini artisan key:generate
   ```
5. Veritabanı tablolarını oluşturun:
   ```bash
   .\php\php.exe -c .\php\php.ini artisan migrate
   ```

## Çalıştırma
```bash
.\php\php.exe -c .\php\php.ini artisan serve --host=127.0.0.1 --port=2323
```
Tarayıcı: http://127.0.0.1:2323

## Dil Değiştirme
- Navbar sağ üstte 🇹🇷 ve 🇬🇧 butonları var.
- Seçim anında aktif olur ve sayfalar arası korunur.
- Varsayılan ve yedek dil: `tr`.

## Admin Paneli
- Yönetim için giriş yaptıktan sonra Admin Paneli üzerinden:
  - Ürünler: oluşturma, düzenleme, silme
  - Duyurular: oluşturma, düzenleme, silme
  - İş İlanları: oluşturma, düzenleme, silme
  - Destek Talepleri: durum güncelleme ve silme
- Başarı mesajları i18n kullanır (`lang/tr/messages.php`, `lang/en/messages.php`).

## Logolar
- `public/images/3s-logo.png` mevcutsa bu kullanılır; yoksa `public/images/3s-grup-logo.png` devreye girer.
- Farklı bir logo için `resources/views/layouts/app.blade.php` içindeki yol güncellenebilir.

## Katkı
1. Yeni bir dal açın: `git checkout -b ozellik/xyz`
2. Değişiklikleri yapın ve test edin
3. PR açın

## Lisans
Bu proje kurum içi kullanım içindir.

