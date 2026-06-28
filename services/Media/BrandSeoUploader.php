<?php

require_once _PS_MODULE_DIR_.'brandseo/classes/BrandSeoMedia.php';

class BrandSeoUploader
{
    private $allowedMimeTypes = array(
        'image/jpeg',
        'image/png',
        'image/webp',
    );

    public function uploadHeroImage($fileInputName, $idLanding, $idLang)
    {
        if (empty($_FILES[$fileInputName]) || empty($_FILES[$fileInputName]['tmp_name'])) {
            return array(false, 'No se recibió ninguna imagen.');
        }

        $file = $_FILES[$fileInputName];

        if (!empty($file['error'])) {
            return array(false, 'Error al subir la imagen.');
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            return array(false, 'Archivo no válido.');
        }

        $mime = function_exists('mime_content_type') ? mime_content_type($file['tmp_name']) : $file['type'];

        if (!in_array($mime, $this->allowedMimeTypes)) {
            return array(false, 'Formato no permitido. Usa JPG, PNG o WebP.');
        }

        $imageInfo = @getimagesize($file['tmp_name']);

        if (!$imageInfo) {
            return array(false, 'La imagen no es válida.');
        }

        $extension = $this->getExtensionFromMime($mime);
        $fileName = 'hero_'.(int)$idLanding.'_'.date('YmdHis').'_'.mt_rand(1000, 9999).'.'.$extension;

        $relativePath = 'uploads/hero/'.$fileName;
        $absolutePath = _PS_MODULE_DIR_.'brandseo/'.$relativePath;

        if (!move_uploaded_file($file['tmp_name'], $absolutePath)) {
            return array(false, 'No se pudo guardar la imagen.');
        }

        $media = new BrandSeoMedia();
        $media->id_brandseo_landing = (int) $idLanding;
        $media->block = 'hero';
        $media->type = 'image';
        $media->path = $relativePath;
        $media->mime = $mime;
        $media->width = (int) $imageInfo[0];
        $media->height = (int) $imageInfo[1];
        $media->filesize = (int) filesize($absolutePath);
        $media->position = 0;
        $media->active = 1;

        foreach (Language::getLanguages(true) as $lang) {
            $langId = (int) $lang['id_lang'];
            $media->title[$langId] = '';
            $media->alt[$langId] = '';
            $media->description[$langId] = '';
        }

        if (!$media->add()) {
            @unlink($absolutePath);
            return array(false, 'No se pudo registrar la imagen.');
        }

        return array(true, 'Imagen Hero subida correctamente.');
    }

    private function getExtensionFromMime($mime)
    {
        if ($mime === 'image/png') {
            return 'png';
        }

        if ($mime === 'image/webp') {
            return 'webp';
        }

        return 'jpg';
    }
}
