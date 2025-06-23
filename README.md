# Domain Checker

**Laravel 10 + Vue 3** приложение для асинхронной проверки доступности доменных имён.

![screenshot](public/screenshot.png)

---

## Возможности

| Функция            | Описание                                                                                  |
| ------------------ | ----------------------------------------------------------------------------------------- |
| Авторизация        | Email / Password через Laravel Sanctum (токен хранится в `localStorage`).                 |
| Массовая проверка  | Вводите домены строкой или через запятую — сервис отправит отдельный запрос для каждого.  |
| Асинхронный вывод  | Пока идёт запрос, у домена крутится «⏳», после ответа — «✔️ Доступен» или «❌ Занят до …». |
| Фейковый WHOIS     | Результаты детерминированы на основе CRC‑хэша домена — без внешних сервисов.              |
| UI на Tailwind CDN | Карточки, градиенты, плавные hover‑эффекты.                                               |

---

## Быстрый старт (локально)

```bash
# 1. Клонируем и устанавливаем PHP‑зависимости
 git clone https://github.com/YOUR_USER/domain-checker.git
 cd domain-checker
 composer install

# 2. Настраиваем .env и генерируем APP_KEY
 cp .env.example .env
 php artisan key:generate

# 3. Запускаем миграции + сидер тест‑пользователя
 php artisan migrate --seed   # создаст пользователя test@example.com / secret123

# 4. Устанавливаем JS-зависимости и сборку фронта
 npm install
 npm run dev       # вкладка 1 – Vite
 php artisan serve # вкладка 2 – Laravel
```

Откройте [http://127.0.0.1:8000](http://127.0.0.1:8000) — появится форма входа.

### Тестовые учётные данные

| Email              | Пароль   |
|--------------------|----------|
| `user@example.com` | `qwerty` |

---

## API

| Метод  | URL                 | Access         | Payload               | Ответ                               |
| ------ | ------------------- | -------------- | --------------------- | ----------------------------------- |
| `POST` | `/api/login`        | Публичный      | `{ email, password }` | `{ token }`                         |
| `POST` | `/api/check-domain` | `auth:sanctum` | `{ domain }`          | `{ domain, available, expires_at }` |

Пример `curl`:

```bash
curl -X POST http://127.0.0.1:8000/api/check-domain \
     -H "Authorization: Bearer <TOKEN>" \
     -H "Accept: application/json" \
     -d "domain=example.com"
```

---

## Структура проекта

```
├─ app/Http/Controllers/
│  ├─ AuthController.php        # login/logout
│  └─ DomainCheckController.php # проверка домена
├─ database/seeders/
│  └─ TestUserSeeder.php        # создаёт тест‑юзера
├─ resources/js/components/
│  ├─ App.vue                   # роутер + переключение
│  ├─ Login.vue                 # форма входа
│  └─ DomainChecker.vue         # ввод + списки
├─ routes/api.php
└─ …
```

---

## Развёртывание production

1. `npm run build` — минифицированные ассеты в `public/build`.
2. `php artisan migrate --seed --force`.
3. `php artisan config:cache && php artisan route:cache`.

---

## Лицензия

apache
