# 🧿 Saphix

Sistema de gestión empresarial desarrollado con PHP puro bajo arquitectura MVC personalizada. Diseñado para administrar de forma eficiente los procesos internos de una empresa: ventas, compras, inventario, clientes, proveedores y usuarios.

---

## 🚀 Características

- 📦 Gestión de productos y categorías
- 🛒 Módulo de ventas y compras
- 👥 Administración de clientes y proveedores
- 👤 Sistema de usuarios con roles y permisos
- 📊 Dashboard con resumen general
- 🔐 Control de acceso basado en permisos (`Permission::can()`)

---

## 🛠️ Tecnologías

- **Backend:** PHP 8+ (MVC personalizado)
- **Base de datos:** MySQL
- **Frontend:** Tailwind CSS
- **Dependencias:** Composer

---

## ⚙️ Instalación

1. Clona el repositorio:
```bash
git clone https://github.com/iimcriiss/Saphix.git
```

2. Instala las dependencias:
```bash
composer install
```

3. Crea el archivo de configuración de base de datos:
```bash
cp config/database.example.php config/database.php
```

4. Edita `config/database.php` con tus credenciales de MySQL.

5. Importa la base de datos desde el archivo `.sql` incluido en el proyecto.

6. Configura tu servidor local (Apache/Nginx) apuntando a la carpeta `/public`.

---

## 📁 Estructura del proyecto

```
Saphix/
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
├── config/
├── core/
├── public/
└── vendor/
```

---

## 👨‍💻 Autor

Desarrollado por **Cristopher** — [@iimcriiss](https://github.com/iimcriiss)
