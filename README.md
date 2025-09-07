# Demo Empresa & Ventas (PHP MVC)

Aplicación de ejemplo en **PHP 8+** con arquitectura **MVC** y **autoload PSR‑4** (Composer). Cubre:

* Gestión de **empleados** (promedios salariales por departamento, top por promedio, empleados sobre el promedio de su depto).
* Gestión de **ventas** (conteo total, cliente que más gastó, producto más vendido).
* **Herramientas matemáticas**: interés compuesto, salario neto (CO simplificado), conversión de unidades.
* **Subida y procesamiento de imágenes** con `intervention/image` (resize, calidad).
* **Envío de correos** con `symfony/mailer` (configurable por DSN, ideal para Mailtrap).
* UI con **Bootstrap 5**.

---

## Tabla de contenidos

1. [Requisitos](#requisitos)
2. [Estructura del proyecto](#estructura-del-proyecto)
3. [Instalación](#instalación)
4. [Configuración de entorno (.env)](#configuración-de-entorno-env)
5. [Ejecución](#ejecución)
6. [Uso rápido](#uso-rápido)
7. [Capturas de pantalla](#capturas-de-pantalla)
8. [Correo de prueba con Mailtrap](#correo-de-prueba-con-mailtrap)
9. [Notas y buenas prácticas](#notas-y-buenas-prácticas)
10. [Solución de problemas](#solución-de-problemas)
11. [Extensiones y tareas sugeridas](#extensiones-y-tareas-sugeridas)
12. [Licencia](#licencia)

---

## Requisitos

* **PHP 8.1+** con extensiones: `openssl`, `mbstring`, `json`, **GD** (para `intervention/image`).
* **Composer** 2.x.
* Acceso a internet para instalar dependencias.
* Opcional: **XAMPP/WAMP** (o el servidor embebido de PHP).

## Estructura del proyecto

```
├─ composer.json
├─ config/
│  └─ config.php
├─ public/                 # DocumentRoot
│  ├─ index.php            # Front controller
│  └─ assets/
│     └─ uploads/          # Carpeta escribible
├─ src/
│  ├─ Controller/
│  │  └─ MainController.php
│  ├─ Model/
│  │  ├─ EmployeeModel.php
│  │  └─ SalesModel.php
│  ├─ Service/
│  │  ├─ FinanceService.php
│  │  └─ UnitConverterService.php
│  └─ View/
│     ├─ layout.php
│     ├─ home.php
│     └─ results.php
├─ docs/
│  └─ images/              
└─ .env.example            # ejemplo de variables de entorno
```

## Instalación

1. Clonar el repositorio y entrar al directorio:

   ```bash
   git clone https://github.com/leonardomrios/Taller-PHP-Avanzado
   cd app-empresa-ventas
   ```
2. Instalar dependencias:

   ```bash
   composer install
   ```

> Si se trabaja en Windows/XAMPP, asegurarse de tener habilitado `extension=openssl` y `extension=gd` en tu `php.ini`. Reiniciar Apache/o la terminal si se realizan cambios.

## Configuración de entorno (.env)

Este proyecto utiliza variables de entorno para no exponer secretos. Se proporciona un **`.env.example`**.

1. Copia el archivo de ejemplo:

   ```bash
   cp .env.example .env
   ```
2. Edita `.env` y completa tus valores (especialmente **MAILER\_DSN** y **MAILER\_FROM**). Ejemplo con **Mailtrap**:

   ```dotenv
   APP_NAME="Demo Empresa & Ventas"

   # Mailtrap – Email Testing (reemplaza USER y PASS por los de tu inbox)
   MAILER_DSN="smtp://USER:PASS@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login"
   MAILER_FROM="Demo <no-reply@example.test>"

   # Carpeta de subidas
   UPLOAD_DIR="./public/assets/uploads"
   ```

> También puedes definir `SMTP_DSN`/`MAILER_DSN` como **variable de entorno del sistema** en lugar de usar `.env`.

## Ejecución

Opción A (recomendada para probar): servidor embebido de PHP con `public/` como docroot.

```bash
php -S localhost:8000 -t public
```

Opción B (Apache/XAMPP): configura **DocumentRoot** a `.../public` o crea un VirtualHost apuntando a esa carpeta.

Abre [http://localhost:8000](http://localhost:8000).



* **Home / Formularios**
  ![Home](docs/images/home.png)
* **Resultados Empleados**
  ![Resultados Empleados](docs/images/results_employees.png)
* **Resultados Ventas**
  ![Resultados Ventas](docs/images/results_sales.png)
* **Herramientas Matemáticas**
  ![Math Tools](docs/images/results_math.png)
* **Imagen procesada**
  ![Imagen procesada](docs/images/image_processed.png)
* **Correo en Mailtrap**
  ![Mailtrap Inbox](docs/images/mailtrap_inbox.png)

## Correo de prueba con Mailtrap

1. Crea una cuenta en **Mailtrap** ➜ **Email Testing** ➜ crea un **Inbox**.
2. Copia `Username` y `Password` del SMTP del Inbox.
3. Ajusta `.env` con tu DSN, por ejemplo:

   ```dotenv
   MAILER_DSN="smtp://USER:PASS@smtp.mailtrap.io:2525?encryption=tls&auth_mode=login"
   MAILER_FROM="Demo <no-reply@example.test>"
   ```
4. Inicia la app y usa el formulario **Enviar correo**. El mensaje se verá en el Inbox de Mailtrap.

> Si tu proveedor usa **TLS implícito (465)**, cambia a `smtps://` o `?encryption=ssl`.

## Notas y buenas prácticas

* **PSR‑4**: Autoload definido en `composer.json` con namespace `App\\` mapeado a `src/`.
* **Seguridad al subir archivos**: se sanea el nombre y se publica bajo `public/assets/uploads/`.
* **Intervention Image v3**: usa driver **GD** y evita agrandar imágenes (`keepAspectRatio`, `preventUpsizing`).
* **Salario neto (CO)**: el cálculo es **simplificado** (4% salud + 4% pensión).
* **Rutas Windows**: se generan URLs públicas relativas (`/assets/uploads/...`) evitando `file:///C:/...`.

## Solución de problemas

* **La imagen no se muestra y veo "Not allowed to load local resource"**: estás intentando cargar una ruta del sistema (p. ej. `C:\...`). Asegúrate de que el `src` del `<img>` empiece por `/assets/...` (ruta web) y no por `file:///`.
* **Mailer falla con TLS**: habilita `openssl` en `php.ini` y usa el DSN correcto. Revisa puerto `2525` en Mailtrap.
* **No se redimensiona la imagen**: habilita **GD** (`extension=gd`) y verifica permisos de `public/assets/uploads/`.
* **Error al enviar correo (Expected response code 250)**: usuario/clave incorrectos, o el servidor requiere `from` del mismo dominio.

