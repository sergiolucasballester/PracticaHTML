# Práctica DAW - Modificación de ejercicios anteriores

## Objetivos

1. Leer ficheros con JavaScript.
2. Insertar contenido de varios ficheros en la misma página.
3. Alterar partes del DOM insertadas de forma dinámica.

## Enunciado

Este ejercicio es una modificación sobre las prácticas realizadas con anterioridad en esta asignatura.

### Barra superior de navegación (navbar)

1. Crear un archivo `nav.html` que contenga el navbar desarrollado en la práctica 1 de HTML.
2. Crear un archivo JavaScript `nav.js` que sea capaz de leer el archivo `nav.html` e insertarlo en el DOM en el momento de carga de la página.
3. Sustituir el navbar de cada página realizada en la práctica de HTML por un `<script>` a `nav.js` de forma que se inserte el navbar en cada página.
4. `nav.js` debe ser capaz de identificar la ruta actual y aplicar un estilo CSS distinto al navitem correspondiente.

### Tabla de usuarios

1. En la tabla de usuarios desarrollada en la práctica anterior se añadirá un botón junto al de borrar que permitirá modificar un registro.
2. Cuando se pulse el botón editar, se debe mostrar un formulario relleno con los datos del usuario en cuestión.
3. También se deberá mostrar un botón que permita guardar los datos.
4. Al pulsar el botón de guardar se deberá actualizar el objeto usuario en JS y actualizar los datos en la tabla.

> TODO EL EJERCICIO SE HA DE REALIZAR EN JAVASCRIPT PURO, SIN NINGUNA LIBRERÍA ADICIONAL

## Pistas

- Ejemplo básico de cómo quedaría la barra superior, con el icono correspondiente a la ruta resaltado con CSS:
  - Si se está en la ruta `home.html`, se muestra el navitem “Home” en otro color.
- Ejemplo de cómo quedaría la tabla con el nuevo botón “Modificar”.
- Métodos y clases recomendados:
  1. `window.onload()`
  2. `XMLHttpRequest`
- Formulario al pulsar botón: puede añadirse al DOM o mostrarse mediante CSS. Todas las soluciones que cumplan el requisito son válidas.

## Se valorará

1. El correcto uso de las instrucciones de JavaScript.
2. Limpieza y correcta estructuración del código.
   - Se pueden utilizar linters, por ejemplo:
     - [ESLint](https://eslint.org/docs/rules/)
     - [Lenguaje JS - ESLint](https://lenguajejs.com/javascript/caracteristicas/eslint/)
