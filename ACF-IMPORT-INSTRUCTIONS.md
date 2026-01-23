# ACF Import Instructions

## 📦 Що в цьому файлі:

Файл `acf-export-page-content-blocks.json` містить повну структуру ACF Flexible Content з 7 блоками:

1. ✅ **Hero Section** - головний банер
2. ✅ **Best Offers** - популярні товари
3. ✅ **Categories** - категорії WooCommerce
4. ✅ **Accent Block** - акцентний блок з текстом
5. ✅ **Testimonials** - відгуки клієнтів
6. ✅ **SEO Text** - SEO текст з розгортанням
7. ✅ **Contact Form** - контактна форма (CF7)

---

## 🚀 Як імпортувати:

### Метод 1: Через ACF UI (рекомендовано)

1. **Встанови ACF Pro** на WordPress
2. Перейди до **Custom Fields → Tools**
3. Клікни на вкладку **Import Field Groups**
4. Натисни **Choose File** і вибери `acf-export-page-content-blocks.json`
5. Натисни **Import JSON**
6. Готово! Field Group "Page Content Blocks" буде створено

### Метод 2: JSON Sync (автоматичний)

1. Створи папку `/wp-content/themes/allmighty/acf-json/` (якщо не існує)
2. Скопіюй файл `acf-export-page-content-blocks.json` в цю папку
3. Перейменуй файл на `group_page_content_blocks.json`
4. Перейди до **Custom Fields** в WordPress
5. Побачиш повідомлення про "Sync available"
6. Натисни **Sync** біля Field Group

---

## ⚙️ Після імпорту:

### 1. Перевір налаштування Field Group

Перейди до **Custom Fields → Field Groups → Page Content Blocks**

Переконайся що:
- ✅ Location: Post Type = Page
- ✅ Position: Normal (After Content)
- ✅ Style: Default
- ✅ Active: Yes

### 2. Створи тестову сторінку

1. **Pages → Add New**
2. Назви сторінку "Home Test"
3. Скролл вниз - побачиш "Content Blocks"
4. Натисни **Add Block** і вибери блок
5. Заповни поля і Save

### 3. Налаштуй додатково

**Для блоку Best Offers:**
- Переконайся що є товари в WooCommerce
- Якщо source = "Manual", додай товари через Relationship field

**Для блоку Categories:**
- Створи категорії товарів в WooCommerce
- Додай thumbnail зображення до категорій (Products → Categories → Edit → Thumbnail)

**Для блоку Contact Form:**
- Встанови **Contact Form 7** плагін
- Створи форму за шаблоном з `/theme/template-parts/blocks/partials/CF7-EXAMPLE-MARKUP.txt`
- Скопіюй shortcode в поле "Form Shortcode"

**Для блоку Testimonials:**
- Додай мінімум 3 відгуки для кращого вигляду
- Rating: 1-5 зірок

---

## 🔧 Troubleshooting

### Проблема: "Import failed"
**Рішення:** Переконайся що ACF Pro версії 6.0+ встановлено

### Проблема: "No fields visible on page"
**Рішення:**
1. Перевір Location Rules (має бути Post Type = Page)
2. Очисти кеш WordPress
3. Перевір чи Template файл = Default

### Проблема: "Products not showing in Best Offers"
**Рішення:**
1. Створи тестові товари в WooCommerce
2. Переконайся що Products Source = "popular" або "featured"
3. Якщо manual - додай товари через Relationship field

### Проблема: "Contact Form not displaying"
**Рішення:**
1. Встанови Contact Form 7 плагін
2. Створи форму в Contact → Add New
3. Скопіюй правильний shortcode (має бути ID форми)

---

## 📋 Структура Field Group

```
Page Content Blocks
└── Content Blocks (Flexible Content)
    ├── Hero Section
    │   ├── Background Image
    │   ├── Secondary Image
    │   ├── Title
    │   ├── Subtitle
    │   ├── Button Text
    │   └── Button Link
    │
    ├── Best Offers
    │   ├── Section Title
    │   ├── Products Source
    │   ├── Products Count
    │   └── Products (Relationship - conditional)
    │
    ├── Categories
    │   ├── Section Title
    │   ├── Categories Order
    │   └── Exclude Categories
    │
    ├── Accent Block
    │   ├── Background Color
    │   ├── Title
    │   ├── Content (WYSIWYG)
    │   ├── Button Text
    │   ├── Button Link
    │   ├── Image
    │   └── Image Position
    │
    ├── Testimonials
    │   ├── Section Title
    │   └── Testimonials (Repeater)
    │       ├── Rating
    │       ├── Quote
    │       └── Author Name
    │
    ├── SEO Text
    │   ├── Title
    │   ├── Content (WYSIWYG)
    │   ├── Show More Text
    │   ├── Show Less Text
    │   └── Preview Lines
    │
    └── Contact Form
        ├── Image
        ├── Form Shortcode
        ├── Title
        └── Subtitle
```

---

## ✅ Перевірка після імпорту

- [ ] Field Group з'явився в Custom Fields
- [ ] Можеш додати нову сторінку
- [ ] Бачиш "Content Blocks" на сторінці
- [ ] Можеш додавати блоки через "Add Block"
- [ ] Всі 7 блоків доступні в списку
- [ ] Поля відображаються правильно
- [ ] Conditional logic працює (Products field в Best Offers)

---

## 🎉 Готово!

Тепер можеш створювати сторінки з гнучким контентом!

**Приклад використання:**
1. Створи сторінку "Home"
2. Встанови як головну (Settings → Reading → Front page displays → A static page → Home)
3. Додай блоки в потрібному порядку
4. Заповни контент
5. Опублікуй!

---

## 💡 Корисні поради

- **Порядок блоків:** Drag & drop для зміни порядку
- **Дублювання:** Натисни "Duplicate" біля блоку
- **Видалення:** Натисни "Remove" біля блоку
- **Згортання:** Клікни на заголовок блоку для згортання/розгортання

---

**Якщо щось не працює - пиши в GitHub Issues:** https://github.com/yutsick/Woocommerce/issues
