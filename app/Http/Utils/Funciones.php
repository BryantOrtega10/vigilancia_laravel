<?php

namespace App\Http\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class Funciones
{
    public static function resizeImage($directorio, $nombre, $prefijo, $ancho, $alto)
    {
        $rutaImagenOriginal = $directorio.$nombre;
        /*
        $stream = Storage::disk('backblaze')->get($rutaImagenOriginal);
        // Guardar temporalmente en el sistema de archivos local
        $file = tmpfile();
        fwrite($file, "writing to tempfile");
        $path = stream_get_meta_data($file)['uri']; // eg: /tmp/phpFx0513a
        // Escribir el stream en un archivo temporal
        file_put_contents($path, $stream);
        $rutaImagenOriginal = $path;*/

        
        $rutaImagenOriginal = Storage::disk('public')->path($rutaImagenOriginal);
        $tamanio = getimagesize($rutaImagenOriginal);
        $width_gen = $tamanio[0];
        $height_gen = $tamanio[1];

        if ($width_gen >= $height_gen) {
            $alto = ($ancho / $width_gen) * $height_gen;
        } else {
            $ancho = ($alto / $height_gen) * $width_gen;
        }

        $image_type = mime_content_type($rutaImagenOriginal);
        if ($image_type == "image/gif") {
            $img_original = imagecreatefromgif($rutaImagenOriginal);
            imagealphablending($img_original, false);
            imagesavealpha($img_original, true);
        }
        if ($image_type == "image/jpeg") {
            $img_original = imagecreatefromjpeg($rutaImagenOriginal);
        }
        if ($image_type == "image/png") {
            $img_original = imagecreatefrompng($rutaImagenOriginal);
            imagealphablending($img_original, false);
            imagesavealpha($img_original, true);
        }

        $max_ancho = $ancho;
        $max_alto = $alto;
        list($ancho, $alto) = getimagesize($rutaImagenOriginal);
        $x_ratio = $max_ancho / $ancho;
        $y_ratio = $max_alto / $alto;
        if (($ancho <= $max_ancho) && ($alto <= $max_alto)) { //Si ancho
            $ancho_final = $ancho;
            $alto_final = $alto;
        } elseif (($x_ratio * $alto) < $max_alto) {
            $alto_final = ceil($x_ratio * $alto);
            $ancho_final = $max_ancho;
        } else {
            $ancho_final = ceil($y_ratio * $ancho);
            $alto_final = $max_alto;
        }
        $tmp = imagecreatetruecolor($ancho_final, $alto_final);
        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        imagecopyresampled($tmp, $img_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
        imagecolortransparent($tmp);
        imagedestroy($img_original);

        $nRuta = $directorio.$prefijo."_".$nombre;
        $nRuta = Storage::disk('public')->path($nRuta);
        imagepng($tmp, $nRuta, 9);
        
        // Crear un "stream" en memoria para almacenar la imagen PNG
        // ob_start();
        // imagepng($tmp);
        // $imageData = ob_get_clean();
        // // Destruir el recurso de imagen para liberar memoria
        // imagedestroy($tmp);

        // fclose($file);


        // Storage::disk('backblaze')->put($nRuta,$imageData);

        return $nRuta;
    }

    public static function subirBase64($base64_string, $output_file)
    {
        $base64_string = str_replace(' ', '+', $base64_string);
        if (strpos($base64_string, ",") !== false) {
            $base64 = explode(',', $base64_string);
            $base64_string = $base64[1];
        }
        
        Storage::disk('public')->put($output_file, base64_decode($base64_string));
        return $output_file;
    }

    public static function sendFailedResponse($errors)
    {
        throw ValidationException::withMessages($errors);
    }
}
