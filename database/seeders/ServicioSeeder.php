<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('servicios')->insert([
            [
                'nombre' => 'ARMADO Y EMBALAJE DE PALLET CON ZUNCHO',
                'descripcion' => 'ARMADO Y EMBALAJE DE PALLET CON ZUNCHO',
                'produccionHora' => 5,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ARMAR CAJAS CONTENEDORAS CON CINTA DEL CLIENTE',
                'descripcion' => 'ARMAR CAJAS CONTENEDORAS CON CINTA DEL CLIENTE',
                'produccionHora' => 72,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ARMAR CAJAS CONTENEDORAS CON CINTA TRANSPARENTE',
                'descripcion' => 'ARMAR CAJAS CONTENEDORAS CON CINTA TRANSPARENTE',
                'produccionHora' => 72,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO BT -  FRASCO (UNA LINEA)',
                'descripcion' => 'BORRADO BT -  FRASCO (UNA LINEA)',
                'produccionHora' => 108,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO BT -  GALON (UNA LINEA)',
                'descripcion' => 'BORRADO BT -  GALON (UNA LINEA)',
                'produccionHora' => 48,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO BT -  CANECA (UNA LINEA)',
                'descripcion' => 'BORRADO BT -  CANECA (UNA LINEA)',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO BT -  TAMBOR (UNA LINEA)',
                'descripcion' => 'BORRADO BT -  TAMBOR (UNA LINEA)',
                'produccionHora' => 21,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO BT -  FUNDA (UNA LINEA)',
                'descripcion' => 'BORRADO BT -  FUNDA (UNA LINEA)',
                'produccionHora' => 108,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CS -  FRASCO',
                'descripcion' => 'BORRADO CS -  FRASCO',
                'produccionHora' => 58,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CS -  GALON',
                'descripcion' => 'BORRADO CS -  GALON',
                'produccionHora' => 48,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CS -  CANECA',
                'descripcion' => 'BORRADO CS -  CANECA',
                'produccionHora' => 48,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CS -  FUNDAS',
                'descripcion' => 'BORRADO CS -  FUNDAS',
                'produccionHora' => 48,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CS -  TAPA',
                'descripcion' => 'BORRADO CS -  TAPA',
                'produccionHora' => 48,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CS -  TAMBOR',
                'descripcion' => 'BORRADO CS -  TAMBOR',
                'produccionHora' => 36,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CS -  CAJA CONTENEDORA',
                'descripcion' => 'BORRADO CS -  CAJA CONTENEDORA',
                'produccionHora' => 48,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE COLLARINES ',
                'descripcion' => 'RETIRO DE COLLARINES ',
                'produccionHora' => 150,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'GILLOTINADO DE ETIQUETA PEQUEÑA',
                'descripcion' => 'GILLOTINADO DE ETIQUETA PEQUEÑA',
                'produccionHora' => 150,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'COLOCACION DE COLLARINES ',
                'descripcion' => 'COLOCACION DE COLLARINES ',
                'produccionHora' => 150,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO HOJAS INFORMATIVAS',
                'descripcion' => 'RETIRO HOJAS INFORMATIVAS',
                'produccionHora' => 250,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE EMPAQUE PLASTICO',
                'descripcion' => 'RETIRO DE EMPAQUE PLASTICO',
                'produccionHora' => 250,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ACCESORIO PLASTICO',
                'descripcion' => 'RETIRO DE ACCESORIO PLASTICO',
                'produccionHora' => 250,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'DOBLAR Y COLOCAR HOJAS INFORMATIVAS',
                'descripcion' => 'DOBLAR Y COLOCAR HOJAS INFORMATIVAS',
                'produccionHora' => 250,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'GESTIÓN Y DISPOSICIÓN FINAL DE DESECHOS',
                'descripcion' => 'GESTIÓN Y DISPOSICIÓN FINAL DE DESECHOS',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'GESTIÓN Y DISPOSICIÓN FINAL DE ENVASES/CARTONES (KILO)',
                'descripcion' => 'GESTIÓN Y DISPOSICIÓN FINAL DE ENVASES/CARTONES (KILO)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACION DE ETIQUETA TR.10.2X7.6.K1.R500.TQ',
                'descripcion' => 'IMPRESIÓN Y COLOCACION DE ETIQUETA TR.10.2X7.6.K1.R500.TQ',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACION DE ETIQUETA TR.4X5.K1.R1000.TQ.1F',
                'descripcion' => 'IMPRESIÓN Y COLOCACION DE ETIQUETA TR.4X5.K1.R1000.TQ.1F',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIAR CANECAS CON PAÑO MICROFIBRA',
                'descripcion' => 'LIMPIAR CANECAS CON PAÑO MICROFIBRA',
                'produccionHora' => 100,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIEZA DE CAJAS CONTENEDORAS CON PAÑO MICROFIBRA',
                'descripcion' => 'LIMPIEZA DE CAJAS CONTENEDORAS CON PAÑO MICROFIBRA',
                'produccionHora' => 100,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIAR RESIDUO DE GOMA CON DILUYENTE EN FRASCO',
                'descripcion' => 'LIMPIAR RESIDUO DE GOMA CON DILUYENTE EN FRASCO',
                'produccionHora' => 200,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIEZA DE RESIDUO DE GOMA CON DILUYENTE EN FUNDAS',
                'descripcion' => 'LIMPIEZA DE RESIDUO DE GOMA CON DILUYENTE EN FUNDAS',
                'produccionHora' => 150,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIZA DE RESIDUO DE GOMA CON DILUYENTE EN FRASCO',
                'descripcion' => 'LIMPIZA DE RESIDUO DE GOMA CON DILUYENTE EN FRASCO',
                'produccionHora' => 150,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA  FUNDA 1000GR',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA  FUNDA 1000GR',
                'produccionHora' => 86,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA CANECA',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA CANECA',
                'produccionHora' => 48,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA EN TAPAS',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA EN TAPAS',
                'produccionHora' => 82,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA CAJAS INDIVIDUALES',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA CAJAS INDIVIDUALES',
                'produccionHora' => 92,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FRASCO 0-500ML',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FRASCO 0-500ML',
                'produccionHora' => 92,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FRASCO 0-500ML (MAS DE 15000)',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FRASCO 0-500ML (MAS DE 15000)',
                'produccionHora' => 92,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FRASCO 500-1000ML',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FRASCO 500-1000ML',
                'produccionHora' => 55,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FUNDA 2000GR',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FUNDA 2000GR',
                'produccionHora' => 84,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FUNDA 500GR',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FUNDA 500GR',
                'produccionHora' => 86,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FUNDA 250GR',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA FUNDA 250GR',
                'produccionHora' => 86,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA GALON',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA GALON',
                'produccionHora' => 80,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA CAJAS CONTENEDORAS ',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA CAJAS CONTENEDORAS ',
                'produccionHora' => 67,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA SOLO ETIQUETAS',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA SOLO ETIQUETAS',
                'produccionHora' => 55,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA SACOS',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA SACOS',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA SACOS',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA SACOS',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA CAJAS CONTENEDORAS ',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA CAJAS CONTENEDORAS ',
                'produccionHora' => 67,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA CAJA INDIVIDUAL',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA CAJA INDIVIDUAL',
                'produccionHora' => 67,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA CANECA',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA CANECA',
                'produccionHora' => 88,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA EN TAPAS',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA EN TAPAS',
                'produccionHora' => 208,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA FRASCO 0-500ML',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA FRASCO 0-500ML',
                'produccionHora' => 90,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA FRASCO 500-1000ML',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA FRASCO 500-1000ML',
                'produccionHora' => 90,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA FUNDA 1000GR',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA FUNDA 1000GR',
                'produccionHora' => 88,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA FUNDA 2000GR',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA FUNDA 2000GR',
                'produccionHora' => 86,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA FUNDA 500GR',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA FUNDA 500GR',
                'produccionHora' => 88,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA FUNDA 250GR',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA FUNDA 250GR',
                'produccionHora' => 88,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA GALON',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA GALON',
                'produccionHora' => 82,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA SOLO ETIQUETAS',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA SOLO ETIQUETAS',
                'produccionHora' => 61,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA (MANUAL)',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA (MANUAL)',
                'produccionHora' => 61,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A CAJAS CONTENEDORAS ',
                'descripcion' => 'PEGAR ETIQUETAS A CAJAS CONTENEDORAS ',
                'produccionHora' => 86,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A CAJAS CONTENEDORAS LADO A Y B',
                'descripcion' => 'PEGAR ETIQUETAS A CAJAS CONTENEDORAS LADO A Y B',
                'produccionHora' => 86,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A CANECAS',
                'descripcion' => 'PEGAR ETIQUETAS A CANECAS',
                'produccionHora' => 55,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A FRASCOS',
                'descripcion' => 'PEGAR ETIQUETAS A FRASCOS',
                'produccionHora' => 260,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A FUNDAS',
                'descripcion' => 'PEGAR ETIQUETAS A FUNDAS',
                'produccionHora' => 260,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A SACOS',
                'descripcion' => 'PEGAR ETIQUETAS A SACOS',
                'produccionHora' => 260,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A GALONES',
                'descripcion' => 'PEGAR ETIQUETAS A GALONES',
                'produccionHora' => 260,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A TAMBOR',
                'descripcion' => 'PEGAR ETIQUETAS A TAMBOR',
                'produccionHora' => 260,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A SOBRE',
                'descripcion' => 'PEGAR ETIQUETAS A SOBRE',
                'produccionHora' => 260,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A CONTENEDOR DGD',
                'descripcion' => 'PEGAR ETIQUETAS A CONTENEDOR DGD',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS PEQUEÑAS ',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS PEQUEÑAS ',
                'produccionHora' => 120,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - FRASCO',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - FRASCO',
                'produccionHora' => 120,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - GALON',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - GALON',
                'produccionHora' => 240,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - CANECA',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - CANECA',
                'produccionHora' => 240,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - FUNDAS',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - FUNDAS',
                'produccionHora' => 240,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - SACOS',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - SACOS',
                'produccionHora' => 240,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - TAMBOR',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - TAMBOR',
                'produccionHora' => 240,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - IBC',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - IBC',
                'produccionHora' => 25,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - SOBRE',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - SOBRE',
                'produccionHora' => 8,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA CON PC - CAJAS CONTENEDORAS',
                'descripcion' => 'RETIRO DE ETIQUETA CON PC - CAJAS CONTENEDORAS',
                'produccionHora' => 36,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO DE INFORMACION DE ETIQUETA SOBRE CON SOLVENTE ',
                'descripcion' => 'BORRADO DE INFORMACION DE ETIQUETA SOBRE CON SOLVENTE ',
                'produccionHora' => 180,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA SYR - FRASCO',
                'descripcion' => 'RETIRO DE ETIQUETA SYR - FRASCO',
                'produccionHora' => 240,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA SYR - GALON',
                'descripcion' => 'RETIRO DE ETIQUETA SYR - GALON',
                'produccionHora' => 18,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA SYR - CANECA',
                'descripcion' => 'RETIRO DE ETIQUETA SYR - CANECA',
                'produccionHora' => 14,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA SYR - TAMBOR',
                'descripcion' => 'RETIRO DE ETIQUETA SYR - TAMBOR',
                'produccionHora' => 10,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A IBC 700KG',
                'descripcion' => 'TRASVASE DE TAMBOR A IBC 700KG',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE CANECA A TAMBOR 250KG',
                'descripcion' => 'TRASVASE DE CANECA A TAMBOR 250KG',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE IBC A TAMBOR',
                'descripcion' => 'TRASVASE IBC A TAMBOR',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA TAMBOR',
                'descripcion' => 'MARCACIÓN DE DATOS MAYOR A UNA LINEA TAMBOR',
                'produccionHora' => 36,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA TAMBOR',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA TAMBOR',
                'produccionHora' => 36,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TOMA DE MUESTRAS',
                'descripcion' => 'TOMA DE MUESTRAS',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TOMA DE MUESTRAS (Fundas Ziploc 1 Lb)',
                'descripcion' => 'TOMA DE MUESTRAS (Fundas Ziploc 1 Lb)',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M -  FRASCO',
                'descripcion' => 'RETIRO DE ETIQUETA M -  FRASCO',
                'produccionHora' => 125,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M -  GALON',
                'descripcion' => 'RETIRO DE ETIQUETA M -  GALON',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M -  CANECA',
                'descripcion' => 'RETIRO DE ETIQUETA M -  CANECA',
                'produccionHora' => 45,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M -  FUNDAS',
                'descripcion' => 'RETIRO DE ETIQUETA M -  FUNDAS',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M -  TAMBOR',
                'descripcion' => 'RETIRO DE ETIQUETA M -  TAMBOR',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETAS A CAJAS CONTENEDORAS',
                'descripcion' => 'RETIRO DE ETIQUETAS A CAJAS CONTENEDORAS',
                'produccionHora' => 36,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETAS A CAJAS CONTENEDORAS LADO A Y B',
                'descripcion' => 'RETIRO DE ETIQUETAS A CAJAS CONTENEDORAS LADO A Y B',
                'produccionHora' => 36,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CON BT -  FRASCO (MAS DE UNA LINEA)',
                'descripcion' => 'BORRADO CON BT -  FRASCO (MAS DE UNA LINEA)',
                'produccionHora' => 54,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CON BT -  GALON (MAS DE UNA LINEA)',
                'descripcion' => 'BORRADO CON BT -  GALON (MAS DE UNA LINEA)',
                'produccionHora' => 64,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CON BT -  CANECA (MAS DE UNA LINEA)',
                'descripcion' => 'BORRADO CON BT -  CANECA (MAS DE UNA LINEA)',
                'produccionHora' => 44,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CON BT -  FUNDAS (MAS DE UNA LINEA)',
                'descripcion' => 'BORRADO CON BT -  FUNDAS (MAS DE UNA LINEA)',
                'produccionHora' => 64,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CON BT -  TAMBOR (MAS DE UNA LINEA)',
                'descripcion' => 'BORRADO CON BT -  TAMBOR (MAS DE UNA LINEA)',
                'produccionHora' => 32,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CON BT -  CAJA CONTENEDORA (MAS DE UNA LINEA)',
                'descripcion' => 'BORRADO CON BT -  CAJA CONTENEDORA (MAS DE UNA LINEA)',
                'produccionHora' => 32,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A TAMBOR',
                'descripcion' => 'TRASVASE DE TAMBOR A TAMBOR',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE CANECA A CANECA',
                'descripcion' => 'TRASVASE DE CANECA A CANECA',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TULA A SACO',
                'descripcion' => 'TRASVASE DE TULA A SACO',
                'produccionHora' => 17,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE SACO A CANECA',
                'descripcion' => 'TRASVASE DE SACO A CANECA',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A FRASCOS CON GOMA',
                'descripcion' => 'PEGAR ETIQUETAS A FRASCOS CON GOMA',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RECORTE DE SACO EN FORMA DE ETIQUETA',
                'descripcion' => 'RECORTE DE SACO EN FORMA DE ETIQUETA',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR PARCHE A SACO CON GOMA',
                'descripcion' => 'PEGAR PARCHE A SACO CON GOMA',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'USO DE COSEDORA EN RESPIRADEROS (SACOS)  C/U',
                'descripcion' => 'USO DE COSEDORA EN RESPIRADEROS (SACOS)  C/U',
                'produccionHora' => 25,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE ENTRE SACOS HASTA 25 KG',
                'descripcion' => 'TRASVASE ENTRE SACOS HASTA 25 KG',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A CANECA',
                'descripcion' => 'TRASVASE DE TAMBOR A CANECA',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE IBC A CANECA',
                'descripcion' => 'TRASVASE DE IBC A CANECA',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE IBC A GALON',
                'descripcion' => 'TRASVASE DE IBC A GALON',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE CANECA A IBC ',
                'descripcion' => 'TRASVASE DE CANECA A IBC ',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'EMPACADO EN CAJA CONTENEDORA',
                'descripcion' => 'EMPACADO EN CAJA CONTENEDORA',
                'produccionHora' => 150,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'EMPACADO EN NUEVA CAJA CONTENEDORA',
                'descripcion' => 'EMPACADO EN NUEVA CAJA CONTENEDORA',
                'produccionHora' => 150,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE IBC A IBC',
                'descripcion' => 'TRASVASE DE IBC A IBC',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A IBC (VISCOSIDAD)',
                'descripcion' => 'TRASVASE DE TAMBOR A IBC (VISCOSIDAD)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN ESTADO DE PRODUCTO (FRASCO) - AGRITOP',
                'descripcion' => 'REVISIÓN ESTADO DE PRODUCTO (FRASCO) - AGRITOP',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN ESTADO DE PRODUCTO (FUNDA) - AGRITOP',
                'descripcion' => 'REVISIÓN ESTADO DE PRODUCTO (FUNDA) - AGRITOP',
                'produccionHora' => 120,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN ESTADO DE PRODUCTO (CAJA) - AGRITOP',
                'descripcion' => 'REVISIÓN ESTADO DE PRODUCTO (CAJA) - AGRITOP',
                'produccionHora' => 120,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN ESTADO DE PRODUCTO (CAJA)',
                'descripcion' => 'REVISIÓN ESTADO DE PRODUCTO (CAJA)',
                'produccionHora' => 120,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN ESTADO DE PRODUCTO (SOBRES)',
                'descripcion' => 'REVISIÓN ESTADO DE PRODUCTO (SOBRES)',
                'produccionHora' => 1200,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN ESTADO DE CAJA CONTENEDORA',
                'descripcion' => 'REVISIÓN ESTADO DE CAJA CONTENEDORA',
                'produccionHora' => 90,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN DE PRODUCTO (POR CAJA DE 12 A 50 UND)',
                'descripcion' => 'REVISIÓN DE PRODUCTO (POR CAJA DE 12 A 50 UND)',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN ESTADO DE PRODUCTO (FUNDA HASTA 25 KG)',
                'descripcion' => 'REVISIÓN ESTADO DE PRODUCTO (FUNDA HASTA 25 KG)',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN P.V.P DE PRODUCTO',
                'descripcion' => 'REVISIÓN P.V.P DE PRODUCTO',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN LOTE DE PRODUCTO',
                'descripcion' => 'REVISIÓN LOTE DE PRODUCTO',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN P.V.P DE PRODUCTO (FRASCO)',
                'descripcion' => 'REVISIÓN P.V.P DE PRODUCTO (FRASCO)',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN P.V.P DE PRODUCTO (POR CAJA DE 12 A 50 UND)',
                'descripcion' => 'REVISIÓN P.V.P DE PRODUCTO (POR CAJA DE 12 A 50 UND)',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN LOTE-FECHA DE CADUCIDAD Y CANTIDADES DE PRODUCTO (POR CAJA MAX 50 UND)',
                'descripcion' => 'REVISIÓN LOTE-FECHA DE CADUCIDAD Y CANTIDADES DE PRODUCTO (POR CAJA MAX 50 UND)',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN LOTE-FECHA DE CADUCIDAD Y CANTIDADES DE PRODUCTO (POR CAJA MIN 51 UND)',
                'descripcion' => 'REVISIÓN LOTE-FECHA DE CADUCIDAD Y CANTIDADES DE PRODUCTO (POR CAJA MIN 51 UND)',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN POR MUESTREO DE P.V.P (TAMAÑO DE LA MUESTRA 5)',
                'descripcion' => 'REVISIÓN POR MUESTREO DE P.V.P (TAMAÑO DE LA MUESTRA 5)',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'APERTURA DE CAJAS PEQUEÑAS',
                'descripcion' => 'APERTURA DE CAJAS PEQUEÑAS',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'FRAGMENTACION DE SACOS DE 10K A 250KG',
                'descripcion' => 'FRAGMENTACION DE SACOS DE 10K A 250KG',
                'produccionHora' => 40,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA (1)',
                'descripcion' => 'HORA EXTRA (1)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA (2)',
                'descripcion' => 'HORA EXTRA (2)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA (3)',
                'descripcion' => 'HORA EXTRA (3)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA (4)',
                'descripcion' => 'HORA EXTRA (4)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'DIA LABORAL BODEGUERO - MONTACARGUISTA 8 HORAS',
                'descripcion' => 'DIA LABORAL BODEGUERO - MONTACARGUISTA 8 HORAS',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA LABORAL BODEGUERO MINIMO 4 HORAS O FRACCIÓN ENTRE SEMANA (1)',
                'descripcion' => 'HORA LABORAL BODEGUERO MINIMO 4 HORAS O FRACCIÓN ENTRE SEMANA (1)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA LABORAL BODEGUERO MINIMO 4 HORAS O FRACCIÓN ENTRE SEMANA (2)',
                'descripcion' => 'HORA LABORAL BODEGUERO MINIMO 4 HORAS O FRACCIÓN ENTRE SEMANA (2)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'DIA LABORAL BODEGUERO 8 HORAS',
                'descripcion' => 'DIA LABORAL BODEGUERO 8 HORAS',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA LABORAL BODEGUERO MINIMO 4 HORAS O FRACCIÓN FIN SEMANA Y FERIADOS (1)',
                'descripcion' => 'HORA LABORAL BODEGUERO MINIMO 4 HORAS O FRACCIÓN FIN SEMANA Y FERIADOS (1)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'DIA LABORAL BODEGUERO 8 HORAS FIN SEMANA Y FERIADOS',
                'descripcion' => 'DIA LABORAL BODEGUERO 8 HORAS FIN SEMANA Y FERIADOS',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISIÓN ESTADO DE PRODUCTO (FRASCO)',
                'descripcion' => 'REVISIÓN ESTADO DE PRODUCTO (FRASCO)',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REESTIBA DE PALLET (SACOS)',
                'descripcion' => 'REESTIBA DE PALLET (SACOS)',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA (FIN DE SEMANA O FERIADO (1))',
                'descripcion' => 'HORA EXTRA (FIN DE SEMANA O FERIADO (1))',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA (FIN DE SEMANA O FERIADO (2))',
                'descripcion' => 'HORA EXTRA (FIN DE SEMANA O FERIADO (2))',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'AYUDANTE DE TRANSPORTE (1)',
                'descripcion' => 'AYUDANTE DE TRANSPORTE (1)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'AYUDANTE DE TRANSPORTE (2)',
                'descripcion' => 'AYUDANTE DE TRANSPORTE (2)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBADOR/BODEGUERO DIA',
                'descripcion' => 'ESTIBADOR/BODEGUERO DIA',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBADOR',
                'descripcion' => 'ESTIBADOR',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBADOR (ADAMA)',
                'descripcion' => 'ESTIBADOR (ADAMA)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CARGA SUELTA(1)',
                'descripcion' => 'ESTIBA CARGA SUELTA(1)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CARGA SUELTA(2)',
                'descripcion' => 'ESTIBA CARGA SUELTA(2)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CARGA SUELTA(3)',
                'descripcion' => 'ESTIBA CARGA SUELTA(3)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CARGA SUELTA(4)',
                'descripcion' => 'ESTIBA CARGA SUELTA(4)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CARGA CLIENTE (GRANEL)',
                'descripcion' => 'ESTIBA CARGA CLIENTE (GRANEL)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CONTENEDOR 20 PIES',
                'descripcion' => 'ESTIBA CONTENEDOR 20 PIES',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CONTENEDOR DE 20 PIES',
                'descripcion' => 'ESTIBA CONTENEDOR DE 20 PIES',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CONTENEDOR 40 PIES (1)',
                'descripcion' => 'ESTIBA CONTENEDOR 40 PIES (1)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA CONTENEDOR 40 PIES (2)',
                'descripcion' => 'ESTIBA CONTENEDOR 40 PIES (2)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'COLOCACIÒN DE ETIQUETAS ROUTER Y COLOCACIÒN DE REVISTA IMÀN.',
                'descripcion' => 'COLOCACIÒN DE ETIQUETAS ROUTER Y COLOCACIÒN DE REVISTA IMÀN.',
                'produccionHora' => 55,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIEZA DE DERRAMES (USO DE ASERRIN)',
                'descripcion' => 'LIMPIEZA DE DERRAMES (USO DE ASERRIN)',
                'produccionHora' => 4,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'EMBALAJE DE PALLET CON STRETCH FILM 1m x 1-2m x 1-10m',
                'descripcion' => 'EMBALAJE DE PALLET CON STRETCH FILM 1m x 1-2m x 1-10m',
                'produccionHora' => 8,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'EMBALAJE DE PALLET CON STRETCH FILM 1m x 1-2m x 1-50m',
                'descripcion' => 'EMBALAJE DE PALLET CON STRETCH FILM 1m x 1-2m x 1-50m',
                'produccionHora' => 8,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE ELABORACIÓN DE RESPIRADEROS DE CANECA',
                'descripcion' => 'SERVICIO DE ELABORACIÓN DE RESPIRADEROS DE CANECA',
                'produccionHora' => 360,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TROQUELADO DE ETIQUETAS ',
                'descripcion' => 'TROQUELADO DE ETIQUETAS ',
                'produccionHora' => 75,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TROQUELADO DE ETIQUETAS 3 CM ',
                'descripcion' => 'TROQUELADO DE ETIQUETAS 3 CM ',
                'produccionHora' => 75,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO PRODUCTO PARA EXPORTACIÒN',
                'descripcion' => 'ACONDICIONAMIENTO PRODUCTO PARA EXPORTACIÒN',
                'produccionHora' => 3,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO TAPA DE FRASCOS',
                'descripcion' => 'ACONDICIONAMIENTO TAPA DE FRASCOS',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIEZA TAPAS DE 60MM',
                'descripcion' => 'LIMPIEZA TAPAS DE 60MM',
                'produccionHora' => 200,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE ALQUILER DE MONTACARGAS DENTRO DE CRIPADA (HORA O FRACCIÓN)',
                'descripcion' => 'SERVICIO DE ALQUILER DE MONTACARGAS DENTRO DE CRIPADA (HORA O FRACCIÓN)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE ALQUILER DE MONTACARGAS POR DIA DENTRO DE CRIPADA (MAXIMO 8 HORA LABORABLES )',
                'descripcion' => 'SERVICIO DE ALQUILER DE MONTACARGAS POR DIA DENTRO DE CRIPADA (MAXIMO 8 HORA LABORABLES )',
                'produccionHora' => 8,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE ALQUILER DE MONTACARGAS (HORA O FRACCIÓN)',
                'descripcion' => 'SERVICIO DE ALQUILER DE MONTACARGAS (HORA O FRACCIÓN)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'COLOCACION DE SELLO DE SEGURIDAD EN CONTENEDOR',
                'descripcion' => 'COLOCACION DE SELLO DE SEGURIDAD EN CONTENEDOR',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'COLOCACION DE SELLO DE SEGURIDAD METALICO EN CONTENEDOR',
                'descripcion' => 'COLOCACION DE SELLO DE SEGURIDAD METALICO EN CONTENEDOR',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE RETIRO DE STICKER DEL CONTENEDOR',
                'descripcion' => 'SERVICIO DE RETIRO DE STICKER DEL CONTENEDOR',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PRUEBA DE BORRADO ',
                'descripcion' => 'PRUEBA DE BORRADO ',
                'produccionHora' => 58,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PRUEBA DE MARCACIÓN DE DATOS ',
                'descripcion' => 'PRUEBA DE MARCACIÓN DE DATOS ',
                'produccionHora' => 88,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'FRACCIONAMIENTO DE TAMBOR A 250 ML',
                'descripcion' => 'FRACCIONAMIENTO DE TAMBOR A 250 ML',
                'produccionHora' => 40,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'FRACCIONAMIENTO DE TAMBOR A 500 ML',
                'descripcion' => 'FRACCIONAMIENTO DE TAMBOR A 500 ML',
                'produccionHora' => 40,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE 400 ML A TAMBOR ',
                'descripcion' => 'TRASVASE DE 400 ML A TAMBOR ',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'FRACCIONAMIENTO DE TAMBOR A 1 LITRO',
                'descripcion' => 'FRACCIONAMIENTO DE TAMBOR A 1 LITRO',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'FRACCIONAMIENTO DE TAMBOR A 5 LITROS',
                'descripcion' => 'FRACCIONAMIENTO DE TAMBOR A 5 LITROS',
                'produccionHora' => 20,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'FRACCIONAMIENTO DE SACO DE 25 KG A 2.5 KG',
                'descripcion' => 'FRACCIONAMIENTO DE SACO DE 25 KG A 2.5 KG',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE ESTABILIZACION CARGA CONTENEDOR (INCLUYE ACCESORIO)',
                'descripcion' => 'SERVICIO DE ESTABILIZACION CARGA CONTENEDOR (INCLUYE ACCESORIO)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO TANQUES ALIVIO DE PRESIÓN Y VACIO',
                'descripcion' => 'ACONDICIONAMIENTO TANQUES ALIVIO DE PRESIÓN Y VACIO',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO CANECAS ALIVIO DE PRESIÓN Y VACIO',
                'descripcion' => 'ACONDICIONAMIENTO CANECAS ALIVIO DE PRESIÓN Y VACIO',
                'produccionHora' => 4,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A COLOR',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A COLOR',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'FUMIGACIÓN DE EQUIPOS HUGUES (DENTRO DEL FURGÓN)',
                'descripcion' => 'FUMIGACIÓN DE EQUIPOS HUGUES (DENTRO DEL FURGÓN)',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ALMACENAMIENTO DE PRODUCTOS ( POR KILOGRAMOS )',
                'descripcion' => 'ALMACENAMIENTO DE PRODUCTOS ( POR KILOGRAMOS )',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PICKING ( POR UNIDAD )',
                'descripcion' => 'PICKING ( POR UNIDAD )',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO TANQUES INVERTIR PRODUCTO (7 HORAS)',
                'descripcion' => 'ACONDICIONAMIENTO TANQUES INVERTIR PRODUCTO (7 HORAS)',
                'produccionHora' => 3,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISION FUGA Y SELLADO DE PRODUCTO (FUNDA)',
                'descripcion' => 'REVISION FUGA Y SELLADO DE PRODUCTO (FUNDA)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISION FUGA Y SELLADO DE PRODUCTO + ETIQUETA (FUNDA)',
                'descripcion' => 'REVISION FUGA Y SELLADO DE PRODUCTO + ETIQUETA (FUNDA)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO PRODUCTO SOLIDIFICADO DE SACOS.',
                'descripcion' => 'ACONDICIONAMIENTO PRODUCTO SOLIDIFICADO DE SACOS.',
                'produccionHora' => 1800,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REMOVER CONTENIDO DE IBC',
                'descripcion' => 'REMOVER CONTENIDO DE IBC',
                'produccionHora' => 12,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'UNIDAD DE PALLET  1m x 1-2m x 1-10m',
                'descripcion' => 'UNIDAD DE PALLET  1m x 1-2m x 1-10m',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'UNIDAD PALLET (cuadrado 1.15 X 1.15 )',
                'descripcion' => 'UNIDAD PALLET (cuadrado 1.15 X 1.15 )',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'UNIDAD PALLET',
                'descripcion' => 'UNIDAD PALLET',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'UNIDAD PALLET CD GYE',
                'descripcion' => 'UNIDAD PALLET CD GYE',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'COLOCACION DE PROTECCION ESQUINAS DE PALLETS',
                'descripcion' => 'COLOCACION DE PROTECCION ESQUINAS DE PALLETS',
                'produccionHora' => 5,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'EMBARQUE DE CARGA SUELTA CONTENEDOR',
                'descripcion' => 'EMBARQUE DE CARGA SUELTA CONTENEDOR',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => '( CSA ) FRACCIONAMIENTO DE CANECA DE 20 LITROS A 1 LITRO  ',
                'descripcion' => '( CSA ) FRACCIONAMIENTO DE CANECA DE 20 LITROS A 1 LITRO  ',
                'produccionHora' => 20,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'R001 - PRODUCTO (POR CAJA DE 12 A 50 UND)',
                'descripcion' => 'R001 - PRODUCTO (POR CAJA DE 12 A 50 UND)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'F001 - PRODUCTO (FRASCOS 1l A FRASCOS 100 ml)',
                'descripcion' => 'F001 - PRODUCTO (FRASCOS 1l A FRASCOS 100 ml)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'F002 - PRODUCTO (FRASCOS 1l A FRASCOS 250 ml)',
                'descripcion' => 'F002 - PRODUCTO (FRASCOS 1l A FRASCOS 250 ml)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'REVISION AL 100% ESTADO DE PRODUCTOS',
                'descripcion' => 'REVISION AL 100% ESTADO DE PRODUCTOS',
                'produccionHora' => 16,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE FRASCOS A UN LITRO',
                'descripcion' => 'TRASVASE FRASCOS A UN LITRO',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE SOBRES DE 200 GRAMOS A UN KG',
                'descripcion' => 'TRASVASE SOBRES DE 200 GRAMOS A UN KG',
                'produccionHora' => 180,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE SOBRES DE 200 GRAMOS A 15 KG',
                'descripcion' => 'TRASVASE SOBRES DE 200 GRAMOS A 15 KG',
                'produccionHora' => 186,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE SOBRES DE 200 GRAMOS A 25 KG',
                'descripcion' => 'TRASVASE SOBRES DE 200 GRAMOS A 25 KG',
                'produccionHora' => 192,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE SOBRES DE 200 GRAMOS A 50 KG',
                'descripcion' => 'TRASVASE SOBRES DE 200 GRAMOS A 50 KG',
                'produccionHora' => 205,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE SOBRES DE 200 GRAMOS A 100 KG',
                'descripcion' => 'TRASVASE SOBRES DE 200 GRAMOS A 100 KG',
                'produccionHora' => 230,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TERMO SELLADO DE FUNDAS',
                'descripcion' => 'TERMO SELLADO DE FUNDAS',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SELLADO DE CAJA CONTENEDORA',
                'descripcion' => 'SELLADO DE CAJA CONTENEDORA',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CAMBIO DE TAPAS',
                'descripcion' => 'CAMBIO DE TAPAS',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ALIVIO DE PRESION Y SELLADO DE PRODUCTO (FUNDA)',
                'descripcion' => 'ALIVIO DE PRESION Y SELLADO DE PRODUCTO (FUNDA)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ARMADO Y EMBALAJE DE PALLET',
                'descripcion' => 'ARMADO Y EMBALAJE DE PALLET',
                'produccionHora' => 5,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SELLADO DE SEGURIDAD LINERS',
                'descripcion' => 'SELLADO DE SEGURIDAD LINERS',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ROLLO DE STRECH FILM',
                'descripcion' => 'ROLLO DE STRECH FILM',
                'produccionHora' => 300,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGADO ETIQUETA A SACOS DE SEMILLA HASTA 25 KG',
                'descripcion' => 'PEGADO ETIQUETA A SACOS DE SEMILLA HASTA 25 KG',
                'produccionHora' => 80,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO Y PEGADO DE ETIQUETA TANQUES',
                'descripcion' => 'RETIRO Y PEGADO DE ETIQUETA TANQUES',
                'produccionHora' => 11,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'FRACCIONAMIENTO DE CANECA DE 10 LITROS A 1 LITRO',
                'descripcion' => 'FRACCIONAMIENTO DE CANECA DE 10 LITROS A 1 LITRO',
                'produccionHora' => 20,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SELLADO DE SEGURIDAD LINERS',
                'descripcion' => 'SELLADO DE SEGURIDAD LINERS',
                'produccionHora' => 90,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACION DE DATOS',
                'descripcion' => 'MARCACION DE DATOS',
                'produccionHora' => 90,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'COSTO POR DESPACHO (PALLET)',
                'descripcion' => 'COSTO POR DESPACHO (PALLET)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CONTENEDOR (CONTENIDO PALETIZADO)',
                'descripcion' => 'CONTENEDOR (CONTENIDO PALETIZADO)',
                'produccionHora' => 100,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN ETIQUETA EQUIPOS / QUIMICOS (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN ETIQUETA EQUIPOS / QUIMICOS (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS PEQUEÑAS (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS PEQUEÑAS (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS ARCSA HASTA 1L (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS ARCSA HASTA 1L (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS ARCSA DESDE 1L (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS ARCSA DESDE 1L (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS FAVORITA PEQUEÑA (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS FAVORITA PEQUEÑA (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS FAVORITA GRANDE (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS FAVORITA GRANDE (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PALLET FAVORITA  (ECOLAB)',
                'descripcion' => 'PALLET FAVORITA  (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS HOLANDESA PEQUEÑA (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS HOLANDESA PEQUEÑA (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS  PRODUCTOS NALCO-ARCA (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS  PRODUCTOS NALCO-ARCA (ECOLAB)',
                'produccionHora' => 113,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIEZA DE CANECAS CON PAÑO MICROFIBRA (ECOLAB)',
                'descripcion' => 'LIMPIEZA DE CANECAS CON PAÑO MICROFIBRA (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIEZA DE TAMBOR CON PAÑO MICROFIBRA (ECOLAB)',
                'descripcion' => 'LIMPIEZA DE TAMBOR CON PAÑO MICROFIBRA (ECOLAB)',
                'produccionHora' => 25,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'LIMPIEZA DE IBC CON PAÑO MICROFIBRA (ECOLAB)',
                'descripcion' => 'LIMPIEZA DE IBC CON PAÑO MICROFIBRA (ECOLAB)',
                'produccionHora' => 8,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO 4XLA 15 GALONES (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO 4XLA 15 GALONES (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO 4XLA 55 GALONES (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO 4XLA 55 GALONES (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO 4XLA 5 GALONES (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO 4XLA 5 GALONES (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO WHYSPER CANECA (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO WHYSPER CANECA (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN Y COLOCACIÓN DE ETIQUETA EN  IBC (ECOLAB)',
                'descripcion' => 'MARCACIÓN Y COLOCACIÓN DE ETIQUETA EN  IBC (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A IBC (ECOLAB)',
                'descripcion' => 'TRASVASE DE TAMBOR A IBC (ECOLAB)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE CANECA A TAMBOR (ECOLAB)',
                'descripcion' => 'TRASVASE DE CANECA A TAMBOR (ECOLAB)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE IBC A TAMBOR (ECOLAB)',
                'descripcion' => 'TRASVASE DE IBC A TAMBOR (ECOLAB)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A TAMBOR (ECOLAB)',
                'descripcion' => 'TRASVASE DE TAMBOR A TAMBOR (ECOLAB)',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE CANECA A CANECA (ECOLAB)',
                'descripcion' => 'TRASVASE DE CANECA A CANECA (ECOLAB)',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE IBC A CANECA (ECOLAB)',
                'descripcion' => 'TRASVASE DE IBC A CANECA (ECOLAB)',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A CANECA (ECOLAB)',
                'descripcion' => 'TRASVASE DE TAMBOR A CANECA (ECOLAB)',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A GALON  (ECOLAB)',
                'descripcion' => 'TRASVASE DE TAMBOR A GALON  (ECOLAB)',
                'produccionHora' => 20,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE TAMBOR A CANECA - URG  (ECOLAB)',
                'descripcion' => 'TRASVASE DE TAMBOR A CANECA - URG  (ECOLAB)',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CAMBIO DE ETIQUETA EN CANECA (NO INCLUYE MARCADO) (ECOLAB)',
                'descripcion' => 'CAMBIO DE ETIQUETA EN CANECA (NO INCLUYE MARCADO) (ECOLAB)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CAMBIO DE ETIQUETA EN TAMBOR (NO INCLUYE MARCADO) (ECOLAB)',
                'descripcion' => 'CAMBIO DE ETIQUETA EN TAMBOR (NO INCLUYE MARCADO) (ECOLAB)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CAMBIO DE ETIQUETA EN IBC (NO INCLUYE MARCADO) (ECOLAB)',
                'descripcion' => 'CAMBIO DE ETIQUETA EN IBC (NO INCLUYE MARCADO) (ECOLAB)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CAMBIO DE ETIQUETA(NO INCLUYE MARCADO) (ECOLAB) - CD',
                'descripcion' => 'CAMBIO DE ETIQUETA(NO INCLUYE MARCADO) (ECOLAB) - CD',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TOMA DE MUESTRAS (ECOLAB)',
                'descripcion' => 'TOMA DE MUESTRAS (ECOLAB)',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE ENVASADO HASTA 1LT (ECOLAB)',
                'descripcion' => 'SERVICIO DE ENVASADO HASTA 1LT (ECOLAB)',
                'produccionHora' => 6,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CAMBIO DE TAPAS (ECOLAB)',
                'descripcion' => 'CAMBIO DE TAPAS (ECOLAB)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CON SOLVENTE CANECAS (ECOLAB)',
                'descripcion' => 'BORRADO CON SOLVENTE CANECAS (ECOLAB)',
                'produccionHora' => 40,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'BORRADO CON BORRADOR DE TINTA GALON (UNA LINEA)(ECOLAB)',
                'descripcion' => 'BORRADO CON BORRADOR DE TINTA GALON (UNA LINEA)(ECOLAB)',
                'produccionHora' => 40,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A B/N (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A B/N (ECOLAB)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN DE ETIQUETAS F. A4 A COLOR (ECOLAB)',
                'descripcion' => 'IMPRESIÓN DE ETIQUETAS F. A4 A COLOR (ECOLAB)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A COLOR (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A COLOR (ECOLAB)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ARMADO Y EMBALAJE DE PALLET CON ZUNCHO (ECOLAB)',
                'descripcion' => 'ARMADO Y EMBALAJE DE PALLET CON ZUNCHO (ECOLAB)',
                'produccionHora' => 5,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ARMADO Y EMBALAJE DE PALLET (ECOLAB)',
                'descripcion' => 'ARMADO Y EMBALAJE DE PALLET (ECOLAB)',
                'produccionHora' => 5,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ENZUNCHADO DE PALLET (ECOLAB)',
                'descripcion' => 'ENZUNCHADO DE PALLET (ECOLAB)',
                'produccionHora' => 5,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PALLET PLASTICO (ECOLAB)',
                'descripcion' => 'PALLET PLASTICO (ECOLAB)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACION EN TINTA INJECK ULTRASIL 67',
                'descripcion' => 'MARCACION EN TINTA INJECK ULTRASIL 67',
                'produccionHora' => 88,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACION EN TINTA INJECK (ECOLAB)',
                'descripcion' => 'MARCACION EN TINTA INJECK (ECOLAB)',
                'produccionHora' => 88,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE TRANSPORTE (RETIRO)',
                'descripcion' => 'SERVICIO DE TRANSPORTE (RETIRO)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE TRANSPORTE (ENTREGA)',
                'descripcion' => 'SERVICIO DE TRANSPORTE (ENTREGA)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA SOLO ETIQUETAS (ECOLAB)',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA SOLO ETIQUETAS (ECOLAB)',
                'produccionHora' => 65,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA PC - GALON (ECOLAB)',
                'descripcion' => 'RETIRO DE ETIQUETA PC - GALON (ECOLAB)',
                'produccionHora' => 40,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA PC - CANECAS (ECOLAB)',
                'descripcion' => 'RETIRO DE ETIQUETA PC - CANECAS (ECOLAB)',
                'produccionHora' => 40,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO Y PEGADO DE ETIQUETA PH ASH  (ECOLAB)',
                'descripcion' => 'RETIRO Y PEGADO DE ETIQUETA PH ASH  (ECOLAB)',
                'produccionHora' => 11,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M - SACOS (ECOLAB)',
                'descripcion' => 'RETIRO DE ETIQUETA M - SACOS (ECOLAB)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M - CANECA (ECOLAB)',
                'descripcion' => 'RETIRO DE ETIQUETA M - CANECA (ECOLAB)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M - TAMBOR (ECOLAB)',
                'descripcion' => 'RETIRO DE ETIQUETA M - TAMBOR (ECOLAB)',
                'produccionHora' => 11,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE ETIQUETA M - IBC (ECOLAB)',
                'descripcion' => 'RETIRO DE ETIQUETA M - IBC (ECOLAB)',
                'produccionHora' => 11,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE FRASCO A FRASCO (INSPEXX 200 X 2 KG)(ECOLAB)',
                'descripcion' => 'TRASVASE DE FRASCO A FRASCO (INSPEXX 200 X 2 KG)(ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RETIRO DE COLLARINES A CANECAS (ECOLAB)',
                'descripcion' => 'RETIRO DE COLLARINES A CANECAS (ECOLAB)',
                'produccionHora' => 150,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'USO DE COSEDORA EN RESPIRADEROS (SACOS)  C/U (ECOLAB)',
                'descripcion' => 'USO DE COSEDORA EN RESPIRADEROS (SACOS)  C/U (ECOLAB)',
                'produccionHora' => 25,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE ENTRE SACOS HASTA 25 KG  (ECOLAB)',
                'descripcion' => 'TRASVASE ENTRE SACOS HASTA 25 KG  (ECOLAB)',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'RECORTE DE SACO EN FORMA DE ETIQUETA (ECOLAB)',
                'descripcion' => 'RECORTE DE SACO EN FORMA DE ETIQUETA (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A CANECAS (ECOLAB)',
                'descripcion' => 'PEGAR ETIQUETAS A CANECAS (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A TAMBOR (ECOLAB)',
                'descripcion' => 'PEGAR ETIQUETAS A TAMBOR (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A SACOS (ECOLAB)',
                'descripcion' => 'PEGAR ETIQUETAS A SACOS (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS EN IBC (ECOLAB)',
                'descripcion' => 'PEGAR ETIQUETAS EN IBC (ECOLAB)',
                'produccionHora' => 500,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR PARCHES A SACOS (ECOLAB)',
                'descripcion' => 'PEGAR PARCHES A SACOS (ECOLAB)',
                'produccionHora' => 24,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PEGAR ETIQUETAS A CAJAS CONTENEDORAS (ECOLAB)',
                'descripcion' => 'PEGAR ETIQUETAS A CAJAS CONTENEDORAS (ECOLAB)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE SACOS HASTA 25 KG  (ECOLAB)',
                'descripcion' => 'TRASVASE DE SACOS HASTA 25 KG  (ECOLAB)',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA (LUNES A VIERNES ECOLAB)',
                'descripcion' => 'HORA EXTRA (LUNES A VIERNES ECOLAB)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA (FIN DE SEMANA Y FERIADO ECOLAB)',
                'descripcion' => 'HORA EXTRA (FIN DE SEMANA Y FERIADO ECOLAB)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'DIA LABORAL EJECUTIVO 8 HORAS O FRACCIÓN ENTRE SEMANA (ECOLAB)',
                'descripcion' => 'DIA LABORAL EJECUTIVO 8 HORAS O FRACCIÓN ENTRE SEMANA (ECOLAB)',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'DIA LABORAL EJECUTIVO 8 HORAS O FRACCIÓN FIN SEMANA Y FERIADOS (ECOLAB)',
                'descripcion' => 'DIA LABORAL EJECUTIVO 8 HORAS O FRACCIÓN FIN SEMANA Y FERIADOS (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA LABORAL BODEGUERO MAXIMO 4 HORAS O FRACCIÓN ENTRE SEMANA (ECOLAB)',
                'descripcion' => 'HORA LABORAL BODEGUERO MAXIMO 4 HORAS O FRACCIÓN ENTRE SEMANA (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'DIA LABORAL BODEGUERO 8 HORAS (ECOLAB)',
                'descripcion' => 'DIA LABORAL BODEGUERO 8 HORAS (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA LABORAL BODEGUERO MAXIMO 4 HORAS O FRACCIÓN FIN SEMANA Y FERIADOS (ECOLAB)',
                'descripcion' => 'HORA LABORAL BODEGUERO MAXIMO 4 HORAS O FRACCIÓN FIN SEMANA Y FERIADOS (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'DIA LABORAL BODEGUERO 8 HORAS FIN SEMANA Y FERIADOS (ECOLAB)',
                'descripcion' => 'DIA LABORAL BODEGUERO 8 HORAS FIN SEMANA Y FERIADOS (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'AYUDANTE DE TRANSPORTE (ECOLAB)',
                'descripcion' => 'AYUDANTE DE TRANSPORTE (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'AYUDANTE DE TRANSPORTE PU (ECOLAB)',
                'descripcion' => 'AYUDANTE DE TRANSPORTE PU (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TRASVASE DE SACO A CANECA  (ECOLAB)',
                'descripcion' => 'TRASVASE DE SACO A CANECA  (ECOLAB)',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO DE BIDON CONTENEDOR SANI-STEP (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO DE BIDON CONTENEDOR SANI-STEP (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO TANQUES ALIVIO DE PRESIÓN Y VACIO (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO TANQUES ALIVIO DE PRESIÓN Y VACIO (ECOLAB)',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO IBC ALIVIO DE PRESIÓN Y VACIO (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO IBC ALIVIO DE PRESIÓN Y VACIO (ECOLAB)',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO CANECAS ALIVIO DE PRESIÓN Y VACIO (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO CANECAS ALIVIO DE PRESIÓN Y VACIO (ECOLAB)',
                'produccionHora' => 4,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'SERVICIO DE EMPAQUE GRANEL DE CANECA POR UNIDAD ',
                'descripcion' => 'SERVICIO DE EMPAQUE GRANEL DE CANECA POR UNIDAD ',
                'produccionHora' => 750,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CAMBIO DE TAPA DE PRODUCTO CON TEFLÓN (ECOLAB)',
                'descripcion' => 'CAMBIO DE TAPA DE PRODUCTO CON TEFLÓN (ECOLAB)',
                'produccionHora' => 30,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ALISTAMIENTO DE PRODUCTOS',
                'descripcion' => 'ALISTAMIENTO DE PRODUCTOS',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'GESTIÓN Y DISPOSICIÓN FINAL DE DESECHOS TULA 2-5 KG',
                'descripcion' => 'GESTIÓN Y DISPOSICIÓN FINAL DE DESECHOS TULA 2-5 KG',
                'produccionHora' => 1800,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'CAMBIO DE ETIQUETA PLASTICA (ECOLAB)',
                'descripcion' => 'CAMBIO DE ETIQUETA PLASTICA (ECOLAB)',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ACONDICIONAMIENTO EN EL PUNTO DE ENTREGA (ECOLAB)',
                'descripcion' => 'ACONDICIONAMIENTO EN EL PUNTO DE ENTREGA (ECOLAB)',
                'produccionHora' => 12,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'COLOCACION DE SELLO DE SEGURIDAD CANECAS',
                'descripcion' => 'COLOCACION DE SELLO DE SEGURIDAD CANECAS',
                'produccionHora' => 12,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN DE ETIQUETA PB',
                'descripcion' => 'IMPRESIÓN DE ETIQUETA PB',
                'produccionHora' => 60,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS EN EL SITIO (ECOLAB)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS EN EL SITIO (ECOLAB)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'S001 - ACONDICIONAMIENTO (IBC A TANQUES) (ECOLAB)',
                'descripcion' => 'S001 - ACONDICIONAMIENTO (IBC A TANQUES) (ECOLAB)',
                'produccionHora' => 4,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'S002 - PALETIZADO (ECOLAB)',
                'descripcion' => 'S002 - PALETIZADO (ECOLAB)',
                'produccionHora' => 4,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'PINTURA ESTRUCTURA METALICA IBC (ECOLAB)',
                'descripcion' => 'PINTURA ESTRUCTURA METALICA IBC (ECOLAB)',
                'produccionHora' => 2,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'GESTIÓN ADMINISTRATIVA (ECOLAB)',
                'descripcion' => 'GESTIÓN ADMINISTRATIVA (ECOLAB)',
                'produccionHora' => 15,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ALQUILER DE PALLET JACK',
                'descripcion' => 'ALQUILER DE PALLET JACK',
                'produccionHora' => 20,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'EMBALAJE DE CANECAS (ECOLAB)',
                'descripcion' => 'EMBALAJE DE CANECAS (ECOLAB)',
                'produccionHora' => 80,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'MARCACIÓN DE DATOS UNA LINEA FRASCO 500-1000ML (ADAMA)',
                'descripcion' => 'MARCACIÓN DE DATOS UNA LINEA FRASCO 500-1000ML (ADAMA)',
                'produccionHora' => 90,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA O FRACCIÓN ENTRE SEMANA  (ADAMA)',
                'descripcion' => 'HORA EXTRA O FRACCIÓN ENTRE SEMANA  (ADAMA)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'HORA EXTRA O FRACCIÓN FIN SEMANA Y FERIADOS  (ADAMA)',
                'descripcion' => 'HORA EXTRA O FRACCIÓN FIN SEMANA Y FERIADOS  (ADAMA)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A B/N (SUNMIAGRO)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A B/N (SUNMIAGRO)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A COLOR (SUNMIAGRO)',
                'descripcion' => 'IMPRESIÓN Y COLOCACIÓN DE ETIQUETAS F. A4 A COLOR (SUNMIAGRO)',
                'produccionHora' => 50,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ESTIBA Y/O DESCARGUE CARGA SUELTA (hasta 15 ton.) (REDBARNGROUP)',
                'descripcion' => 'ESTIBA Y/O DESCARGUE CARGA SUELTA (hasta 15 ton.) (REDBARNGROUP)',
                'produccionHora' => 1,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TARIFA DE RECEPCIÓN DE TANQUES/TAMBOR- MATERIAL EMPAQUE (POR LITRO) (REDBARNGROUP)',
                'descripcion' => 'TARIFA DE RECEPCIÓN DE TANQUES/TAMBOR- MATERIAL EMPAQUE (POR LITRO) (REDBARNGROUP)',
                'produccionHora' => 1367,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TARIFA DE DESPACHO DE TANQUES/TAMBOR (SALDOS)- PALLETS Y CAJAS CERRADA. (POR LITRO) (REDBARNGROUP)',
                'descripcion' => 'TARIFA DE DESPACHO DE TANQUES/TAMBOR (SALDOS)- PALLETS Y CAJAS CERRADA. (POR LITRO) (REDBARNGROUP)',
                'produccionHora' => 2105,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TARIFA POR USO DE ESPACIO ACTIVIDAD DE ENVASADO (POR DIA) (REDBARNGROUP)',
                'descripcion' => 'TARIFA POR USO DE ESPACIO ACTIVIDAD DE ENVASADO (POR DIA) (REDBARNGROUP)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TARIFA DE ALMACENAMIENTO DIARIO POR PALLET SEA DE MATERIA PRIMA- PRODUCTO TERMINADO O MATERIAL DE EMPAQUE. (POR PALLET POR DIA) (REDBARNGROUP)',
                'descripcion' => 'TARIFA DE ALMACENAMIENTO DIARIO POR PALLET SEA DE MATERIA PRIMA- PRODUCTO TERMINADO O MATERIAL DE EMPAQUE. (POR PALLET POR DIA) (REDBARNGROUP)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'ALMACENAMIENTO Y GESTION (REDBARNGROUP)',
                'descripcion' => 'ALMACENAMIENTO Y GESTION (REDBARNGROUP)',
                'produccionHora' => 3472,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TARIFA POR ENVASADO (POR LITRO) (REDBARNGROUP)',
                'descripcion' => 'TARIFA POR ENVASADO (POR LITRO) (REDBARNGROUP)',
                'produccionHora' => 38,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TARIFA POR ETIQUETADO. (REDBARNGROUP)',
                'descripcion' => 'TARIFA POR ETIQUETADO. (REDBARNGROUP)',
                'produccionHora' => 100,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TARIFA POR EMPACADO DE PRODUCTO. (REDBARNGROUP)',
                'descripcion' => 'TARIFA POR EMPACADO DE PRODUCTO. (REDBARNGROUP)',
                'produccionHora' => 20,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'TARIFA POR EMPACADO DE PRODUCTO POR UNIDAD. (REDBARNGROUP)',
                'descripcion' => 'TARIFA POR EMPACADO DE PRODUCTO POR UNIDAD. (REDBARNGROUP)',
                'produccionHora' => 90,
                'idcategoria'=>1,
                'estado' => true
            ],
            [
                'nombre' => 'COSTOS POR GESTIÓN DE DESECHOS O INSUMOS. (REDBARNGROUP)',
                'descripcion' => 'COSTOS POR GESTIÓN DE DESECHOS O INSUMOS. (REDBARNGROUP)',
                'produccionHora' => 0,
                'idcategoria'=>1,
                'estado' => true
            ],

        ]);
    }
}
