# 🛒 Tienda Online - Ciclomotores

**Creado por [Gregory Pimentel](https://github.com/ZGrengo)**

Sistema de tienda online desarrollado en PHP para la venta de productos de ciclomotores, motocicletas y bicicletas. Incluye carrito de compras, integración con PayPal, panel de administración y sistema de notificaciones por correo electrónico.

-   [Características](#-características)
-   [Imagenes de muestra](#-imágenes-de-muestra)
-   [Stack Tecnológico](#%EF%B8%8F-stack-tecnológico)
-   [Requisitos Previos](#-requisitos-previos)
-   [Inicio Rápido](#-inicio-rápido)
-   [Dominios de Imágenes Soportados](#%EF%B8%8F-dominios-de-imágenes-soportados)
-   [Estructura del Proyecto](#-estructura-del-proyecto)
-   [Uso](#-uso)
-   [Seguridad](#-seguridad)
-   [Scripts Disponibles](#-scripts-disponibles)
-   [Contribuir](#-contribuir)
-   [Licencia](#-licencia)

## 📋 Características

-   ✅ **Catálogo de productos** con filtrado por categorías
-   ✅ **Carrito de compras** con gestión de cantidades
-   ✅ **Integración con PayPal** para pagos en línea
-   ✅ **Panel de administración** para gestionar productos
-   ✅ **Diseño responsive** adaptado para móviles y tablets
-   ✅ **Sistema de notificaciones** por correo electrónico (PHPMailer)
-   ✅ **Autenticación HTTP Basic** para el área de administración
-   ✅ **Interfaz moderna** con Bootstrap 5 y diseño oscuro

## 📸 Imágenes de Muestra

### Vista Desktop

<table>
  <tr>
    <td align="center">
      <img width="460" alt="TiendaDesktop2" src="https://github.com/user-attachments/assets/f042931f-7813-4f3d-b28e-29cf34460946" />
      <br />
      <strong>Página Principal</strong>
    </td>
    <td align="center">
      <img width="460" alt="PagarDesktop2" src="https://github.com/user-attachments/assets/3bad302f-11e1-413f-9961-74533ad45dc7" />
      <br />
      <strong>Proceso de Pago</strong>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <img width="460" alt="AdminPageDesktop2" src="https://github.com/user-attachments/assets/94337e87-e748-43b0-8e1f-2b03cdda1654" />
      <br />
      <strong>Panel de Administración</strong>
    </td>
  </tr>
</table>

### Vista Mobile

<table>
  <tr>
    <td align="center">
      <img width="431" height="934" alt="CarritoMovil1" src="https://github.com/user-attachments/assets/1577c990-e085-4ad0-b720-77dea53a0582" />
      <br />
      <strong>Carrito de Compras</strong>
    </td>
    <td align="center">
      <img width="432" height="764" alt="PagoFinalMovil" src="https://github.com/user-attachments/assets/4c0bf81f-5b44-4261-84ea-0465492c8458" />
      <br />
      <strong>Pago Final</strong>
    </td>
  </tr>
</table>

## 🛠️ Stack Tecnológico

-   **Backend:** PHP 8.2+
-   **Base de Datos:** MySQL/MariaDB
-   **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
-   **Librerías:**
    -   PHPMailer 6.8+ (para envío de correos)
    -   PayPal SDK (para procesamiento de pagos)
    -   Bootstrap Icons y Font Awesome

## 📦 Requisitos Previos

-   PHP 8.2 o superior
-   MySQL 5.7+ o MariaDB 10.3+
-   Apache con mod_rewrite y mod_auth_basic habilitados
-   Composer (para gestionar dependencias)
-   Extensiones PHP requeridas:
    -   PDO
    -   PDO_MySQL
    -   OpenSSL
    -   mbstring

## 🚀 Inicio Rápido

### 1. Clonar o descargar el proyecto

```bash
git clone [url-del-repositorio]
cd tienda
```

### 2. Instalar dependencias con Composer

```bash
composer install
```

### 3. Configurar la base de datos

#### Crear la base de datos:

```sql
CREATE DATABASE IF NOT EXISTS tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Crear las tablas:

**Tabla: `tblproductos`**

```sql
CREATE TABLE `tblproductos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Descripcion` text,
  `Imagen` varchar(255) NOT NULL,
  `Categoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Tabla: `tblventas`**

```sql
CREATE TABLE `tblventas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ClaveTransaccion` varchar(100) NOT NULL,
  `PaypalDatos` text,
  `Fecha` datetime NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'pendiente',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**Tabla: `tbldetalleventa`**

```sql
CREATE TABLE `tbldetalleventa` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IDVenta` int(11) NOT NULL,
  `IDProducto` int(11) NOT NULL,
  `PrecioUnitario` decimal(10,2) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `IDVenta` (`IDVenta`),
  KEY `IDProducto` (`IDProducto`),
  FOREIGN KEY (`IDVenta`) REFERENCES `tblventas` (`ID`) ON DELETE CASCADE,
  FOREIGN KEY (`IDProducto`) REFERENCES `tblproductos` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 4. Configurar el archivo de configuración

Copia el archivo de ejemplo y configura tus credenciales:

```bash
cp global/config.php.example global/config.php
```

Edita `global/config.php` con tus datos:

```php
<?php
// Configuración de Base de Datos
define("SERVIDOR", "localhost");
define("USUARIO", "tu_usuario");
define("PASSWORD", "tu_contraseña");
define("BD", "tienda");

// Configuración de Encriptación
define("KEY", "tu_clave_secreta_aqui"); // Cambia esto por una clave segura
define("COD", "AES-128-ECB");

// Configuración de PayPal (Sandbox para pruebas)
define("CLIENT_ID", "tu_client_id_paypal");
define("SECRET", "tu_secret_paypal");
define("PAYPAL_KEY", "tu_client_id_paypal");
define("PAYPAL_LIVE_KEY", "tu_secret_paypal_live"); // Para producción

// Configuración SMTP (Email)
define('SMTP_HOST', 'smtp.tu-servidor.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu_email@dominio.com');
define('SMTP_PASSWORD', 'tu_contraseña_smtp');
define('SMTP_SECURE', 'tls');
define('SMTP_FROM', 'tu_email@dominio.com');
define('SMTP_FROM_NAME', 'Nombre de tu Tienda');
?>
```

### 5. Configurar autenticación del panel de administración

El panel de administración está protegido con autenticación HTTP Basic. Para configurarlo:

1. Genera un hash de contraseña usando un generador online o el comando `htpasswd`
2. Edita `admin/.htpasswd` con el formato:

    ```
    admin:$apr1$hash_aqui
    ```

3. Asegúrate de que `admin/.htaccess` tenga la ruta correcta al archivo `.htpasswd`

### 6. Configurar permisos de archivos

Asegúrate de que la carpeta de imágenes tenga permisos de escritura:

```bash
chmod 755 archivos/img/productos/
```

## 🖼️ Dominios de Imágenes Soportados

El sistema acepta imágenes desde diferentes fuentes:

-   **Rutas relativas locales:** `archivos/img/productos/nombre-imagen.jpg`
-   **URLs absolutas:** `https://ejemplo.com/imagen.jpg`
-   **CDNs:** Cualquier servicio de CDN que proporcione URLs públicas
-   **Servicios de almacenamiento:** Imgur, Cloudinary, AWS S3, etc.

**Recomendación:** Para producción, se recomienda usar un servicio de CDN o almacenamiento en la nube para mejorar el rendimiento.

## 📁 Estructura del Proyecto

```
tienda/
├── admin/                    # Panel de administración
│   ├── administrar.php      # Gestión de productos
│   ├── nuevoProducto.php    # Agregar nuevo producto
│   ├── editar.php           # Editar productos
│   ├── .htaccess            # Autenticación HTTP Basic
│   └── .htpasswd            # Credenciales de admin
├── archivos/
│   └── img/
│       └── productos/       # Imágenes de productos
├── global/
│   ├── config.php           # Configuración (no versionar)
│   ├── config.php.example   # Ejemplo de configuración
│   ├── conexion.php          # Conexión a la base de datos
│   ├── init.php              # Inicialización
│   └── styles.css            # Estilos globales
├── templates/
│   ├── cabecera.php          # Header del sitio
│   └── pie.php               # Footer del sitio
├── vendor/                   # Dependencias de Composer
├── carrito.php               # Lógica del carrito
├── completado.php            # Página de confirmación de pago
├── contacto.php              # Página de contacto
├── index.php                 # Página principal (catálogo)
├── landing.php               # Página de inicio
├── mostrarCarrito.php        # Vista del carrito
├── pagar.php                 # Proceso de pago
├── procesar_pago.php         # Procesamiento de PayPal
├── composer.json             # Dependencias de Composer
└── README.md                 # Este archivo
```

## 🎯 Uso

### Acceso al Sitio

-   **Página principal:** `http://localhost/tienda/` o `http://localhost/tienda/index.php`
-   **Página de inicio:** `http://localhost/tienda/landing.php`
-   **Carrito de compras:** `http://localhost/tienda/mostrarCarrito.php`

### Panel de Administración

-   **URL:** `http://localhost/tienda/admin/administrar.php`
-   **Usuario:** `admin` (configurado en `.htpasswd`)
-   **Contraseña:** (la que configuraste en `.htpasswd`)

### Agregar Productos

1. Accede al panel de administración
2. Haz clic en "Agregar Producto"
3. Completa el formulario:
    - Nombre del producto
    - Categoría (Coche, Motocicleta, Bicicleta)
    - Precio
    - Cantidad en stock
    - Descripción
    - URL de la imagen (ej: `archivos/img/productos/nombre.jpg`)

### Proceso de Compra

1. El cliente navega por los productos
2. Agrega productos al carrito
3. Revisa el carrito y proporciona su correo electrónico
4. Procede al pago con PayPal
5. Recibe confirmación por correo electrónico

## 🔒 Seguridad

-   ✅ Autenticación HTTP Basic para el panel de administración
-   ✅ Encriptación de datos sensibles con OpenSSL
-   ✅ Prepared statements para prevenir SQL injection
-   ✅ Validación de datos de entrada
-   ✅ Protección CSRF (implementar si es necesario)

**Importante:**

-   No subas `global/config.php` ni `admin/.htpasswd` al repositorio
-   Cambia las claves de encriptación en producción
-   Usa claves de PayPal en modo Live para producción
-   Configura HTTPS en producción

## 📜 Scripts Disponibles

### Composer

```bash
# Instalar dependencias
composer install

# Actualizar dependencias
composer update

# Instalar solo producción (sin dev)
composer install --no-dev --optimize-autoloader
```

### Base de Datos

```bash
# Exportar base de datos
mysqldump -u usuario -p tienda > tienda_backup.sql

# Importar base de datos
mysql -u usuario -p tienda < tienda_backup.sql
```

### Permisos (Linux/Mac)

```bash
# Dar permisos a carpeta de imágenes
chmod 755 archivos/img/productos/

# Dar permisos de escritura si es necesario
chmod 775 archivos/img/productos/
```

## 👥 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto es de código abierto y está disponible para uso personal y comercial.
