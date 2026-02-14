# Ventajas y desventajas: librerías en local vs CDN

## Introducción

Al añadir dependencias front-end (SweetAlert2, jQuery, Bootstrap, etc.) podemos importarlas descargándolas localmente en el proyecto o usando un CDN. A continuación se resumen ventajas y desventajas de cada enfoque.

## Importar en local (archivo dentro del proyecto)

- Ventajas:
  - Control total de la versión usada; evita roturas por cambios externos.
  - Funciona offline en entornos locales o intranet.
  - No dependes de terceros para disponibilidad (más predecible en entornos cerrados).
  - Compatible con políticas de seguridad estrictas (CSP) si se sirve desde el mismo origen.
- Desventajas:
  - Aumenta el tamaño del repositorio y del despliegue.
  - El navegador no podrá reutilizar archivos cacheados de otros sitios.
  - Necesitas encargarte de actualizaciones y parches.

## Usar CDN (Content Delivery Network)

- Ventajas:
  - Mejor caché compartida: si el usuario ya cargó la librería desde el mismo CDN en otro sitio, no necesita descargarla de nuevo.
  - Distribución geográfica optimizada, puede reducir latencia y acelerar la carga.
  - Sin necesidad de almacenar/servir el archivo en tu servidor.
  - Fácil de incluir y cambiar versiones rápidamente.
- Desventajas:
  - Dependencia de terceros: si el CDN falla el recurso no estará disponible.
  - Riesgos de seguridad si no se controlan integridades (usar `integrity` y `crossorigin` ayuda).
  - Políticas de privacidad/compliance: envía peticiones a dominios externos.
  - Algunos entornos corporativos bloquean CDNs.

## Recomendaciones prácticas

- Para producción crítica: usar un CDN con `subresource integrity (SRI)` y fallback local.
- Para entornos internos/offline: preferir paquetes locales o un CDN privado.
- Mantener un proceso de actualización y pruebas de dependencias.
- Considerar tooling (npm/yarn, bundlers) para gestionar versiones y disminuir carga en producción.

## Ejemplo de patrón híbrido (recomendado)

1. Intentar cargar desde CDN con SRI.
2. Si falla, cargar la copia local como fallback usando JavaScript.

---

Este documento ayuda a decidir la estrategia de inclusión de librerías según requisitos de disponibilidad, seguridad y rendimiento.
