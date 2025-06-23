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
# 1. Клонируем и ставим PHP‑зависимости
git clone https://github.com/RikiTwiki/domain-checker.git
cd domain-checker
composer install

# 2. Настраиваем .env и генерируем APP_KEY
cp .env.example .env
php artisan key:generate

# 3. Создаём базу и сидим тест‑юзера
php artisan db:create            # создаст БД, если ещё нет
php artisan migrate --seed       # пользователь user@example.com / qwerty

# 4. Ставим JS‑зависимости и запускаем фронт
npm install
npm run dev       # вкладка 1 – Vite HMR
php artisan serve # вкладка 2 – Laravel backend
```

Откройте [http://127.0.0.1:8000](http://127.0.0.1:8000) — появится форма входа.

### Тестовые учётные данные

| Email              | Пароль   |
| ------------------ | -------- |
| `user@example.com` | `qwerty` |

---

## API

| Метод  | URL                 | Access         | Payload               | Ответ                               |
| ------ | ------------------- | -------------- | --------------------- | ----------------------------------- |
| `POST` | `/api/login`        | публичный      | `{ email, password }` | `{ token }`                         |
| `POST` | `/api/check-domain` | `auth:sanctum` | `{ domain }`          | `{ domain, available, expires_at }` |

### Пример `curl`

```bash
curl -X POST http://127.0.0.1:8000/api/check-domain \
     -H "Authorization: Bearer <TOKEN>" \
     -H "Accept: application/json" \
     -d "domain=example.com"
```

---

## Структура проекта

```
├─ app/Console/Commands/
│  └─ DbCreate.php              # artisan db:create
├─ app/Http/Controllers/
│  ├─ AuthController.php        # login/logout
│  └─ DomainCheckController.php # проверка домена
├─ database/seeders/
│  └─ TestUserSeeder.php        # создаёт тест‑юзера
├─ resources/js/components/
│  ├─ App.vue                   # переключение авторизация/чекер
│  ├─ Login.vue                 # форма входа
│  └─ DomainChecker.vue         # ввод + результаты
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