# Sistema de Roles y Permisos - Guía de Pruebas

## Usuarios Creados

Se han creado los siguientes usuarios para probar el sistema de roles:

### 1. **Administrador Principal**
- **Email:** admin@empresa.com
- **Contraseña:** admin123
- **Rol:** Administrador
- **Permisos:** Acceso completo a todas las funcionalidades

### 2. **María Secretaria**
- **Email:** secretario@empresa.com  
- **Contraseña:** secre123
- **Rol:** Secretario
- **Permisos:** Ver dashboard, gestionar clientes, ver reportes, ver usuarios

### 3. **Carlos Bodeguero**
- **Email:** bodega@empresa.com
- **Contraseña:** bodega123
- **Rol:** Bodega
- **Permisos:** Ver dashboard, gestionar productos

### 4. **Ana Vendedora**
- **Email:** ventas@empresa.com
- **Contraseña:** ventas123
- **Rol:** Ventas
- **Permisos:** Ver dashboard, crear/gestionar facturas, ver clientes, ver productos

### 5. **Luis Supervisor** (Múltiples Roles)
- **Email:** supervisor@empresa.com
- **Contraseña:** super123
- **Roles:** Bodega + Ventas
- **Permisos:** Combina permisos de ambos roles

### 6. **Juan Admin**
- **Email:** juan.admin@empresa.com
- **Contraseña:** admin456
- **Rol:** Administrador
- **Permisos:** Acceso completo a todas las funcionalidades

## Menú del Sidebar Según Roles

### **Dashboard**
- Visible para: **TODOS** los usuarios autenticados

### **Facturas**
- Visible para: **Ventas** y **Administrador**
- Identificación: Badge verde "Ventas" para usuarios con rol Ventas

### **Clientes**
- Visible para: **Secretario**, **Ventas** y **Administrador**  
- Identificación: Badge azul "Secretario" para usuarios con rol Secretario

### **Productos**
- Visible para: **Bodega** y **Administrador**
- Identificación: Badge amarillo "Bodega" para usuarios con rol Bodega

### **Reportes**
- Visible para: **Secretario** y **Administrador**

### **Administración** (Usuarios y Actividades)
- Visible para: **Solo Administrador**
- Identificación: Badge rojo "Admin"
- **Usuarios**: Gestión completa de usuarios del sistema
- **Auditorías**: Registro de actividades y cambios en el sistema

### **Mi Perfil**
- Visible para: **TODOS** los usuarios autenticados

## Información del Usuario en Sidebar

En la parte inferior del sidebar se muestra:
- **Nombre del usuario**
- **Rol(es) asignado(s)**
- **Badges de colores** para usuarios con múltiples roles:
  - 🔴 Administrador (rojo)
  - 🔵 Secretario (azul)  
  - 🟡 Bodega (amarillo)
  - 🟢 Ventas (verde)

## Cómo Probar

1. **Inicia sesión** con cualquiera de los usuarios listados arriba
2. **Observa el sidebar** - solo verás las opciones permitidas para tu rol
3. **Cambia de usuario** para ver cómo cambia el menú según el rol
4. **Prueba con Luis Supervisor** para ver cómo funciona con múltiples roles

## Funcionalidades por Rol

### **Administrador**
- ✅ Dashboard
- ✅ Facturas (ver todas, crear, editar, eliminar)
- ✅ Clientes (ver todos, crear, editar, eliminar)
- ✅ Productos (ver todos, crear, editar, eliminar)
- ✅ Reportes
- ✅ Gestión de Usuarios
- ✅ Auditorías del Sistema

### **Secretario**
- ✅ Dashboard
- ✅ Clientes (ver todos, crear, editar, eliminar)
- ✅ Reportes
- ✅ Ver usuarios (sin gestionar)

### **Bodega**
- ✅ Dashboard
- ✅ Productos (ver todos, crear, editar, eliminar)

### **Ventas**
- ✅ Dashboard
- ✅ Facturas (crear, ver, editar, eliminar)
- ✅ Clientes (ver todos, crear, editar)
- ✅ Productos (solo visualización para crear facturas)

### **Usuario Multi-Rol (Bodega + Ventas)**
- ✅ Dashboard
- ✅ Facturas (crear, ver, editar, eliminar)
- ✅ Clientes (ver todos, crear, editar)
- ✅ Productos (ver todos, crear, editar, eliminar)

## Comandos Ejecutados

Para recrear los usuarios, ejecuta:

```bash
# Recrear base de datos y seeders
php artisan migrate:fresh

# Ejecutar seeder de roles y permisos
php artisan db:seed --class=RolesAndPermissionsSeeder

# Ejecutar seeder de usuarios con roles
php artisan db:seed --class=UsersWithRolesSeeder
```

## Notas Técnicas

- Se utiliza **Spatie Laravel Permission** para la gestión de roles y permisos
- Las directivas Blade utilizadas: `@hasrole()`, `@hasanyrole()`, `@endhasrole`, `@endhasanyrole`
- Los usuarios pueden tener **múltiples roles** simultáneamente
- El sistema muestra **badges identificativos** según el rol del usuario
- La interfaz se adapta dinámicamente según los permisos del usuario autenticado
